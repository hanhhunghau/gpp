<?php
class PageSetting {
	static $current=false;
	static $extra_header='';
	static $extra_css='';
	static $extra_js='';
	static $footer_js='';
	static $page_gen_time=0;
	static $page=false;
	static $meta_keywords='';
	static $meta_description='';
	static $document_title='';
	function PageSetting() {
	}
	static function register_module($row_or_id,&$module) {
		if(is_numeric($row_or_id)) {
			$id=$row_or_id;
		}
		elseif(isset($row_or_id['id'])) {
			$id=$row_or_id['id'];
		}
		else {
			System::end_conn();
		}
		if(is_numeric($row_or_id)) {
			DB::query('
					SELECT
						ID, NAME, PACKAGE_ID
					FROM
						MODULE
					where
						ID = '.$row_or_id);
			$row=DB::fetch();
			if(!$row) {
				System::end_conn();
			}
		}
		else {
			$row=$row_or_id;
		}
		require_once 'packages/core/includes/pagesetting/package.php';
		$class_fn=get_package_path($row['package_id']).'module_'.$row['name'].'/class.php';
		require_once $class_fn;
		$module=new $row['name']($row);
		$module->package=&$GLOBALS['packages'][$row['package_id']];
	}
	static function run() {  
		{			
			if($services=PageSetting::get_setting('services')) {
				PageSetting::$current->services=array_flip(explode(',',$services));
			}
			else {
				PageSetting::$current->services=array();
			}
			if(isset($_REQUEST['page'])) {
				$page_name=strtolower($_REQUEST['page']);
			}
			else {
				header('Location:?page=sign_in');
				exit();
			}     
			$pages=DB::select_all('page','name=\''.addslashes($page_name).'\'');
			foreach($pages as $page) 
			{				
					PageSetting::run_page($page,$page_name,false);
			}
		}   
		Session::end();
		DB::close();
	}
	static function run_page($row,$page_name,$params=false) {   
		$postfix=$params?'.'.$params:'';
		$page_file=ROOT_PATH.'cache/page_layouts/'.$page_name.$postfix.'.cache.php';
		if(file_exists($page_file) and false) {   
			require_once $page_file;
		}
		else {         
			require_once 'packages/core/includes/pagesetting/generate_page.php';      
			$generate_page=new Generatepage($row);
			$generate_page->generate();
			$page_name=$row['name'];     
		}
	}
	static function template($package_name) {
		return 'packages/'.$package_name.'/skins/'.PageSetting::get_setting($package_name.'_template','default');
	}
	static function service($service_name) {
		$services=PageSetting::get_setting('registered_services');
		return isset($services[$service_name]);
	}
	static function language($name=false) {
		if($name) {
			if(isset($GLOBALS['all_words']['[[.'.$name.'.]]'])) {
				return $GLOBALS['all_words']['[[.'.$name.'.]]'];
			}
			else {
				$languages=DB::select_all('language');
				$row=array();
				foreach($languages as $language) {
					$row['value_'.$language['id']]=ucfirst(str_replace('_',' ',$name));
				}
				if(!DB::exists('select id,package_id from word where id=\''.$name.'\'  and  package_id=\''.Module::$current->data['module']['package_id'].'\'')) {
					System::debug($row);
					DB::insert('word',$row+array('id'=>$name,'package_id'=>Module::$current->data['module']['package_id']));
				}
				PageSetting::make_word_cache();
				return $name;
			}
		}
		if($session_user=DB::fetch('SELECT id,language_id FROM session_user WHERE user_id = \''.Session::get('user_id').'\'')) {
			return $session_user['language_id'];
		}
		else {
			return 1;
		}
	}
	static function get_setting($name,$default=false,$user_id=false) {
		if(!$user_id) {
			if(isset(User::$current->settings[$name])) {
				if(User::$current->settings[$name]=='@VERY_LARGE_INFORMATION') {
					if($setting=DB::select('account_setting','SETTING_ID=\''.DB::escape($name).'\'  and  account_ID=\''.User::id().'\'')) {
						return $setting['value'];
					}
				}
				else {
					return User::$current->settings[$name];
				}
			}
			elseif(isset(PageSetting::$current->settings[$name])) {
				if(PageSetting::$current->settings[$name]=='@VERY_LARGE_INFORMATION') {
					if($setting=DB::select('account_setting','SETTING_ID=\''.DB::escape($name).'\'')) {
						return $setting['value'];
					}
				}
				else {
					return PageSetting::$current->settings[$name];
				}
			}
		}
		else {
			if($setting=DB::select('account_setting','SETTING_ID=\''.DB::escape($name).'\'  and  account_ID=\''.DB::escape($user_id).'\'')) {
				return $setting['value'];
			}
			return $default;
		}
		if(isset($GLOBALS['default_settings'][$name])) {
			if($GLOBALS['default_settings'][$name]=='@VERY_LARGE_INFORMATION') {
				if($setting=DB::select('account_setting','SETTING_ID=\''.DB::escape($name).'\'')) {
					return $setting['value'];
				}
			}
			else {
				return $GLOBALS['default_settings'][$name];
			}
		}
		return $default;
	}
	static function use_service($name) {
		return isset(PageSetting::$current->services[$name]);
	}
	static function set_setting($name,$value,$user_id=false) {
		if($setting=DB::select('setting','ID=\''.$name.'\'')) {
			if($user_id==false) {
				if($setting['account_type']=='USER') {
					$account_id=Session::get('user_id');
				}
			}
			else {
				$account_id=$user_id;
			}
			if(DB::select('account_setting','account_ID=\''.addslashes($account_id).'\'  and  SETTING_ID=\''.addslashes($name).'\'')) {
				DB::update('account_setting',array('value'=>$value),'account_ID=\''.addslashes($account_id).'\'  and  SETTING_ID=\''.addslashes($name).'\'');
			}
			else {
				DB::insert('account_setting',array('account_ID'=>$account_id,'SETTING_ID'=>$name,'value'=>$value));
			}
			DB::update('account',array('cache_setting'=>''),'ID=\''.$account_id.'\'');
		}
	}
	static function make_word_cache() {
		$languages=DB::select_all('language');
		foreach($languages as $language_id=>$row) {
			$all_words=DB::fetch_all('
					SELECT 
						ID, value_'.$language_id.' as VALUE 
					FROM
						word 
				');
			$language_convert=array();
			foreach($all_words as $language) {
				$language_convert=$language_convert+array('[[.'.$language['id'].'.]]'=>$language['value']);
			}
			if($language_id==PageSetting::language()) {
				$GLOBALS['all_words']=$language_convert;
			}
			$st='<?php
				if(!isset($GLOBALS[\'all_words\']))
				{
					$GLOBALS[\'all_words\'] = '.var_export($language_convert,1).';
				}
				?>';    
			$f=fopen('cache/language_'.$language_id.'.php','w+');
			fwrite($f,$st);
			fclose($f);
		}
	}	
}
require_once 'cache/language_1.php';
PageSetting::$current=new PageSetting();
?>