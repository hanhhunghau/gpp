<?php
class EditCategoryForm extends Form
{
	function EditCategoryForm()
	{
		Form::Form('EditCategoryForm');
		if(URL::get('cmd')=='edit')
		{
			$this->add('id',new IDType(true,'object_not_exists','category'));
		}
		$languages = DB::fetch_all('select * from language',false);
		foreach($languages as $language)
		{
			$this->add('name_'.$language['id'],new TextType(true,'invalid_name',0,2000)); 
			$this->add('description_'.$language['id'],new TextType(false,'invalid_description',0,200000)); 
		}
		$this->link_css(PageSetting::template('core').'/css/tabs/tabpane.css');
	}
	function on_submit()
	{
		require_once 'packages/core/includes/utils/upload_file.php';
		update_upload_file('file_icon_url','default');
		if($this->check() and URL::get('confirm_edit'))
		{
			if(URL::get('cmd')=='edit')
			{
				$this->old_value = DB::select('category','id=\''.addslashes($_REQUEST['id']).'\'');
			}
			$this->save_item();
			Url::redirect_current(Module::$current->redirect_parameters+array('just_edited_id'=>$this->id));
		}
	}	
	function draw()
	{
		$languages = DB::fetch_all('select * from language',false);
		$this->init_edit_mode();
		$this->get_parents();
		$modules = DB::fetch_all('SELECT id,name FROM module ORDER BY name');
		$this->map['module_id_list'] = array(''=>PageSetting::language('select')) + System::array2list($modules);
		$this->parse_layout('edit',
			($this->edit_mode?$this->init_value:array())+
			$this->map + array(
			'languages'=>$languages,
			'parent_id_list'=>System::array2list(CategoryDB::check_categories($this->parents)),
			'parent_id'=>($this->edit_mode?si_parent_id('category',$this->init_value['structure_id']):1),
			'type_list'=>array('FUNCTION'=>PageSetting::language('function'),'MODERATOR'=>PageSetting::language('use_for_moderation'),'HELP'=>PageSetting::language('use_for_help')),
			'status_list'=>array('SHOW'=>'SHOW','HIDE'=>'HIDE','HOME'=>'HOME')
			)
		);
	}
	function save_item()
	{
	       
            $duongdananh=(URL::get('file_icon_url')? URL::get('file_icon_url'):'');
            
			$extra = array();
			$languages = DB::fetch_all('select * from language',false);;
			foreach($languages as $language)
			{
				$extra=$extra+array('name_'.$language['id']=>Url::get('name_'.$language['id'],1)); 
				$extra=$extra+array('group_'.$language['id']=>Url::get('group_'.$language['id'],1)); 
				$extra=$extra+array('description_'.$language['id']=>Url::get('description_'.$language['id'],1)); 
			}
            
           
            if (strlen($duongdananh)==0){
                	$new_row = $extra+
            			array(
            				'type', 
            				'status','url',
            				'check_privilege'=>Url::check('check_privilege')?1:0,'is_visible'=>1,
            				'module_id'
            			);
                
            }
            else 
            {
                $new_row = $extra+
    			array(
    				'type', 
    				'status', 'icon_url'=>Url::get('file_icon_url'),'url',
    				'check_privilege'=>Url::check('check_privilege')?1:0,'is_visible'=>1,
    				'module_id'
    			);
            }
		
			require_once 'packages/core/includes/utils/vn_code.php';
			/*$name_id = convert_utf8_to_url_rewrite($new_row['name_1']); 			
			if(!DB::fetch('select name_id from category where name_id=\''.$name_id.'\''))
			{
				$new_row+=array('name_id'=>$name_id);
			}
			else
			{
				$new_row+=array('name_id'=>$name_id.'_'.date('i-h',time()));
			}*/
			
		if(URL::get('cmd')=='edit')
		{
			$this->id = $_REQUEST['id'];
			DB::update_id('category', $new_row,$this->id);
			DB::update('category',array('status'=>Url::get('status')),IDStructure::child_cond(DB::structure_id('category',$this->id)));
			if($this->old_value['structure_id']!=ID_ROOT)
			{
				if (Url::check(array('parent_id')))
				{
					$parent = DB::select('category','id='.$_REQUEST['parent_id'].'');					
					if($parent['structure_id']==$this->old_value['structure_id'])
					{
						$this->error('id','invalid_parent');
					}
					else
					{
						require_once 'packages/core/includes/system/si_database.php';
						if(!si_move('category',$this->old_value['structure_id'],$parent['structure_id']))
						{
							$this->error('id','invalid_parent');
						}
					}
				}
			}
		}
		else
		{
			require_once 'packages/core/includes/system/si_database.php';
			if(isset($_REQUEST['parent_id']))
			{	
				$this->id = DB::insert('category', $new_row+array('structure_id'=>si_child('category',structure_id('category',$_REQUEST['parent_id']))));			
			}
			else
			{
				$this->id = DB::insert('category', $new_row+array('structure_id'=>ID_ROOT));		
			}				
		}
	}
	function init_edit_mode()
	{
		if(URL::get('cmd')=='edit' and $this->init_value= DB::fetch('select * from category where id='.intval(URL::sget('id')).''))
		{		
			foreach($this->init_value as $key=>$value)
			{
				if(is_string($value) and !isset($_REQUEST[$key]))
				{
					$_REQUEST[$key] = $value;
				}
			}
			$this->edit_mode = true;
		}
		else
		{
			$this->edit_mode = false;
		}
	}
	function get_parents()
	{
		require_once 'packages/core/includes/system/si_database.php';
		$sql = '
			select 
				id,
				structure_id
				,name_'.PageSetting::language().' as name  
			from 
			 	category
			where 
				category.type!=\'PORTAL\'
			order by 
				structure_id
		';
		$this->parents = DB::fetch_all($sql,false);		
	}
}
?>