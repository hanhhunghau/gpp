<?php
class ListModuleAdminForm extends Form
{
	function ListModuleAdminForm()
	{
		Form::Form('ListModuleAdminForm');
		$this->link_css(PageSetting::template('core').'/css/admin.css');
		$this->link_css(PageSetting::template('core').'/css/category.css');
	}
	function on_submit()
	{
		if(URL::get('confirm'))
		{
			foreach(URL::get('selected_ids') as $id)
			{
			}
			require_once 'detail.php';
			foreach(URL::get('selected_ids') as $id)
			{
				ModuleAdminForm::delete($this,$id);
				if($this->is_error())
				{
					return;
				}
			}
			Url::redirect_current(array('package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'', 
	'name'=>isset($_GET['name'])?$_GET['name']:'',  
	  ));
		}
	}
	function draw()
	{
		$languages = DB::select_all('language');
		$cond = ' 1 >0 '
			.(!URL::get('type')?'':' and module.TYPE=\''.URL::get('type').'\'')
			.(URL::get('name')?' and module.NAME LIKE \'%'.URL::get('name').'%\'':'')  
			.((URL::get('cmd')=='delete' and is_array(URL::get('selected_ids')))?' and module.ID in ('.join(URL::get('selected_ids'),',').')':'')
		;
		$item_per_page = 50;
		$count = DB::fetch('
			SELECT 
				count(*) AS ACOUNT
			FROM 
				module
				join package on package.id=module.PACKAGE_ID
			WHERE
			 '.$cond.'
			'.(URL::get('order_by')?'ORDER BY '.URL::get('order_by').(URL::get('order_dir')?' '.URL::get('order_dir'):''):'').'
			
		','acount');
		
		$items = DB::fetch_all('
		   select 
				module.id
				,module.name
				,module.title_'.PageSetting::language().' as title ,module.description_'.PageSetting::language().' as description
				,package.name as package_id 
			from 
			 	module
				join package on package.id=module.package_id
			where 
				'.$cond.'  
			'.(URL::get('order_by')?'order by '.URL::get('order_by').(URL::get('order_dir')?' '.URL::get('order_dir'):''):' order by module.id desc').'');
		
		$packages = DB::fetch_all('
			select
				id,name as name
				,structure_id
			from
				package
			order by 
				structure_id');
		$i=1;
		foreach ($items as $key=>$value)
		{
			$items[$key]['i']=$i++;
			if (Url::check('page_id'))
			{
				$items[$key]['href']=Url::build('edit_page',array('module_id'=>$value['id'],'id'=>$_REQUEST['page_id'],'region','after','replace','href','container_id'));
			}
			else 
			{
				$items[$key]['href']=Url::build_current(array('cmd'=>'edit','package_id','name','id'=>$value['id']));
			}
			$items[$key]['page_name'] = $item = DB::fetch('
				select 
					page.id,
					page.name 
				from 
					block,page 
				where 
					module_id=\''.$items[$key]['id'].'\'
					and page.id = block.page_id
				','name');
		}
		$just_edited_id['just_edited_ids'] = array();
		if (UrL::get('selected_ids'))
		{
			if(is_string(UrL::get('selected_ids')))
			{
				if (strstr(UrL::get('selected_ids'),','))
				{
					$just_edited_id['just_edited_ids']=explode(',',UrL::get('selected_ids'));
				}
				else
				{
					$just_edited_id['just_edited_ids']=array('0'=>UrL::get('selected_ids'));
				}
			}
		}
		$this->parse_layout('list',$just_edited_id+
			array(
				'items'=>$items,
				'packages'=>$packages, 
			)
		);
	}
}
?>