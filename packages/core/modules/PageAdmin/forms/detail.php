<?php
class pageAdminForm extends Form
{
	function pageAdminForm()
	{
		Form::Form("pageAdminForm");
		$this->add('id',new IDType(false,'object_not_exists','page'));
		$this->link_css(PageSetting::template('core').'/css/admin.css');
		$this->link_css(PageSetting::template('core').'/css/category.css');
	}
	function on_submit()
	{
		if(URL::get('confirm'))
		{
			$this->delete($this,$_REQUEST['id']);
			Url::redirect_current(array('NAME','package_id'=>isset($_GET['package_id'])?$_GET['package_id']:''));
		}
	}
	function draw()
	{
		$languages = DB::select_all('language');
		DB::query('
			SELECT 
				page.ID
				,page.NAME ,page.CACHABLE,page.CACHE_PARAM,page.PARAMS
				,page.TITLE_'.PageSetting::language().' as TITLE 
				,page.DESCRIPTION_'.PageSetting::language().' as DESCRIPTION
				,package.NAME as package_id 
			FROM 
			 	page,package
			WHERE
				page.ID = \''.URL::sget('id').'\'
				AND  package.ID=page.package_id
				');
		if($row = DB::fetch())
		{
		}
		$languages = DB::select_all('language');
		DB::query('
			SELECT 
				module.* 
			FROM 
				module ,
				block
			WHERE 
				1>0 and page_ID = '.$row['id'].'
				AND block.MODULE_ID=module.ID
		');
		$row['module_related_fields'] = DB::fetch_all(); 
		$this->parse_layout('detail',$row+array('languages'=>$languages));
	}
	function delete(&$form,$id)
	{
		$row = DB::select('page',$id);
		$blocks = DB::select_all('block','page_ID='.$id);
		foreach ($blocks as $key=>$value)
		{
			// DB::delete('BLOCK_SETTING', 'BLOCK_ID='.$value['id']); 
		}
		DB::delete('block', 'page_ID='.$id); 
		DB::delete_id('page', $id);		
	}
}
?>