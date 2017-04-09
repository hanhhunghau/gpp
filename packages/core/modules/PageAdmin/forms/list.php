<?php
class ListpageAdminForm extends Form
{
	function ListpageAdminForm()
	{
		Form::Form('ListpageAdminForm');
		$this->link_css(PageSetting::template('core').'/css/admin.css');
		$this->link_css(PageSetting::template('core').'/css/category.css');
	}
	function on_submit()
	{
		if(URL::get('confirm'))
		{
			require_once 'detail.php';
			foreach(URL::get('selected_ids') as $id)
			{
				pageAdminForm::delete($this,$id);
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
		$cond = ' 1>0'
				.(URL::get('name')?' and page.NAME LIKE \'%'.URL::get('name').'%\'':'')    
			.((URL::get('cmd')=='delete' and is_array(URL::get('selected_ids')))?' and page.ID in ('.join(URL::get('selected_ids'),',').')':'')
		;
		$item_per_page =30;
		$sql = '
			SELECT 
				count(*) as total
			FROM
				page,package
			WHERE '.$cond.'
				AND package.ID=page.package_id
		';
		$count = DB::fetch($sql,'total');
		
		$sql = 
		'SELECT * FROM
		(
		  SELECT 
		   page.ID,
		   page.NAME,
		   page.SHOW,
		   page.TITLE_'.PageSetting::language().' as TITLE,
		   page.DESCRIPTION_'.PageSetting::language().' as DESCRIPTION,
		   package.NAME as package_id,
		   count(page.NAME)-1 as is_sibling,
		   count(*) as TOTAL
		  FROM 
			page,package
		  WHERE 
		   '.$cond.'
		   AND page.package_id=package.ID
		  GROUP BY
		   page.NAME,
		   page.ID,
		   page.SHOW,
		   page.TITLE_'.PageSetting::language().',
		   page.DESCRIPTION_'.PageSetting::language().',
		   package.NAME
 			'.(URL::get('order_by')?' ORDER BY '.URL::get('order_by').(URL::get('order_dir')?' '.URL::get('order_dir'):''):' ORDER BY  page.NAME').'
		) as tb
		';
		DB::query($sql);				
		$items = DB::fetch_all();		
		foreach($items as $id=>$item)
		{
			if($item['is_sibling'])
			{
				$items[$id]['href'] = Url::build_current(array('cmd'=>'list_sibling','package_id','name'=>$item['NAME']));
			}
			else
			{
				$items[$id]['href'] = Url::build('edit_page',array('id'=>$item['id']));
			}
		}
		DB::query('
			SELECT
				ID,
				NAME
				,STRUCTURE_ID
			FROM
				package
			ORDER BY
				STRUCTURE_ID');
		$packages = DB::fetch_all();
		$i=1;
		foreach ($items as $key=>$value)
		{
			$items[$key]['i']=$i++;
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