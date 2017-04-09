<?php
class EditModuleAdminForm extends Form
{
	function EditModuleAdminForm()
	{
		Form::Form('EditModuleAdminForm');
		if(URL::get('cmd')=='edit')
		{
			$this->add('id',new IDType(true,'object_not_exists','module'));
		}
		$this->add('name',new TextType(true,'invalid_name',0,255)); 
		$this->add('package_id',new IDType(true,'invalid_package_id','package')); 
		$this->add('type',new TextType(false,'invalid_type',0,20)); 

		$languages = DB::select_all('language','id=1');
		foreach($languages as $language)
		{
			$this->add('title_'.$language['id'],new TextType(false,'invalid_title',0,2000)); 

			$this->add('description_'.$language['id'],new TextType(false,'invalid_description',0,200000)); 
		}


		$this->add('module_table.table',new TextType(true,'invalid_table',0,255)); 
		$this->link_css(PageSetting::template('core').'/css/admin.css');
		$this->link_css(PageSetting::template('core').'/css/tabs/tabpane.css');
	}
	function on_submit()
	{
		if(URL::get('cmd')=='edit')
		{
			$row = DB::select('module',$_REQUEST['id']);
		}
		if($this->check() and URL::get('confirm_edit'))
		{
			$extra = array();
			$languages = DB::select_all('language','id=1');
			foreach($languages as $language)
			{
				$extra=$extra+array('title_'.$language['id']=>Url::get('title_'.$language['id'],1));
				$extra=$extra+array('description_'.$language['id']=>Url::get('description_'.$language['id'],1)); 
			}
			require_once 'packages/core/includes/pagesetting/package.php';
			$new_row = $extra+
				array(
					'package_id',
					'name', 'type',
					'path'=>get_package_path(URL::get('package_id')).'modules/'.URL::get('name').'/'
				)+((URL::get('type')=='PLUGIN')?array('action'=>URL::get('action')):array())+((URL::get('type')=='WRAPPER')?array():array());
			if(Url::get('package_id') and $parent=IDStructure::parent(DB::structure_id('package',intval(Url::get('package_id')))) and $package=DB::fetch('select name as id from package where structure_id =\''.$parent.'\'') and $package['id']=='tcv')
			{
				$name_package=DB::fetch('select name as id from package where id ="'.URL::get('package_id').'"');
				$new_row['PATH']='packages/tcv/'.$name_package['id'].'/'.URL::get('name').'/';
			}
			if(URL::get('cmd')=='edit')
			{
				$id = $_REQUEST['id'];
				DB::update_id('module', $new_row,$id);
				require_once 'packages/core/includes/pagesetting/update_page.php';
				$pages = DB::fetch_all('select page_id as id from block where module_id=\''.$id.'\'');
				foreach($pages as $page_id=>$page)
				{
					update_page($page_id);
				}
			}
			else
			{
				require_once 'packages/core/includes/system/si_database.php';
				$id = DB::insert('module', $new_row);		
			}
			if(URl::get('deleted_ids'))
			{
				foreach(URl::get('deleted_ids') as $delete_id)
				{
					DB::delete_id('module_table',$delete_id);
				}
			}
			if(isset($_REQUEST['mi_module_table']))
			{
				foreach($_REQUEST['mi_module_table'] as $key=>$record)
				{
					$empty = true;
					foreach($record as $record_value)
					{
						if($record_value)
						{
							$empty = false;
						}
					}
					if(!$empty)
					{
						$record['module_id'] = $id;
						if($record['id'])
						{
							DB::update('module_table',$record,'id='.$record['id']);
						}
						else
						{
							unset($record['id']);
							DB::insert('module_table',$record);
						}
					}
				}
			} 
			if(URL::get('cmd')=='edit')
			{
				Url::redirect_current(array('package_id'=>URL::get('package_id'),'name'=>isset($_GET['name'])?$_GET['name']:'', 'just_edited_id'=>$id));
	  		}
			else
			{
				Url::redirect_current(array('package_id'=>URL::get('package_id'), 'type', 'name'=>isset($_GET['name'])?$_GET['name']:'','id'=>$id,'cmd'=>(URL::get('type')=='HTML')?'edit_html':((URL::get('type')=='CONTENT')?'edit_content':'list'),'just_edited_id'=>$id));
			}
		
		}
	}	
	function draw()
	{	
		require_once 'packages/core/includes/utils/mce_editor.php';
		$languages = DB::select_all('language');
		$edit_mode = false;
		if(URL::get('cmd')=='edit' and $row=DB::select('module',URL::sget('id')))
		{
			foreach($row as $key=>$value)
			{
				if(is_string($value) and !isset($_POST[$key]))
				{
					$_REQUEST[$key] = $value;
				}
			}
			$edit_mode = true;
		}
		if(!isset($_REQUEST['mi_module_table']) and $edit_mode)
		{
			DB::query('
				select
					module_table.*
				from
					module_table
				where
					module_table.module_id=\''.URL::iget('id').'\''
			);
			$mi_module_table = DB::fetch_all();
			$_REQUEST['mi_module_table'] = $mi_module_table;
		}
		$sql = '
			select
				package.id,package.name,package.structure_id
			from 
				package
			order by
				package.structure_id
		';
		$package_id_list = System::array2list(DB::fetch_all($sql));
		$this->parse_layout('edit',
			($edit_mode?$row:array('type'=>URL::get('type')))+
			array(
			'languages'=>$languages,
			'type_list'=>array(''=>'NORMAL','SERVICE'=>'SERVICE','CONTENT'=>'CONTENT','HTML'=>'HTML','PLUGIN'=>'PLUGIN','WRAPPER'=>'WRAPPER'),
			'action_list'=>array(''=>'','ONLOAD'=>'ONLOAD','ONENDLOAD'=>'ONENDLOAD','ONDRAW'=>'ONDRAW','ONENDDRAW'=>'ONENDDRAW','ONSUBMIT'=>'ONSUBMIT','ONINSERT'=>'ONINSERT','ONEDIT'=>'ONEDIT','ONDELETE'=>'ONDELETE','ONCREATE'=>'ONCREATE','ONDESTROY'=>'ONDESTROY'),
			'action_module_id_list'=>System::array2list(DB::fetch_all('select id, name from module order by name')),
			'package_id_list'=>$package_id_list, 
			'using_pages'=>DB::fetch_all('
				SELECT
					page.id, page.name
				FROM
					page,block
				WHERE
					module_id=\''.URL::sget('id').'\'
					AND block.page_id = page.id
				ORDER BY 
					page.name
			')
			)
		);
	}
}
?>