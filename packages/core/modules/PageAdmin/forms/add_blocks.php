<?php
class AddBlockspageAdminForm extends Form
{
	function AddBlockspageAdminForm()
	{
		Form::Form('addBlockspageAdminForm');
		$this->add('module_id',new IDType(true,false,'module'));
		$this->add('page_name',new NameType(true,'missing_name'));
		$this->add('block_name',new TextType(true,'missing_name',0,255));
		$this->add('container_id',new IDType(false,false,'module'));
		$this->add('region',new NameType(true,'missing_name'));
		$this->add('position',new IntType(false,'missing_position'));
		$this->add('copy_setting_id',new IDType(false,false,'block'));
	}
	/// thuc hien cac hanh dong submit form
	function on_submit()
	{
		if($this->check())
		{
			if($pages = pageAdminDB::find_pages(URL::get('page_name')))
			{
				foreach($pages as $page)
				{
					if(URL::get('confirm_delete'))
					{
						pageAdminDB::delete_block(URL::get('module_id'),$page['id'],URL::get('container_id'),URL::get('region'),URL::get('position'),URL::get('block_name'));
					}
					else
					{
						$block_id = pageAdminDB::add_block(URL::get('module_id'),$page['id'],URL::get('container_id'),URL::get('region'),URL::get('position'),URL::get('block_name'));
						if(URL::get('copy_setting_id'))
						{
							pageAdminDB::copy_block_setting($block_id, URL::get('copy_setting_id'));
						}
					}
					require_once 'packages/core/includes/pagesetting/update_page.php';
					update_page($page['id']);
				}
			}
		}
	}
	
	
	// hien thi form sua doi thong tin cua page
	function draw()
	{	
		$module_id_list = System::array2list(pageAdminDB::get_module_list());
		$page_name_list = System::array2list(pageAdminDB::get_page_name_list());
		$container_id_list = array(''=>'')+System::array2list(pageAdminDB::get_container_list());
		$region_list = System::array2list(pageAdminDB::get_region_list());
		$copy_setting_id_list = array(''=>'')+System::array2list(pageAdminDB::get_copy_setting_id_list(URL::get('module_id')));
		$position_list = array(''=>'');
		for($i=1;$i<=10;$i++)
		{
			$position_list[$i] = $i;
		}
		$this->parse_layout('add_blocks',array(
			'module_id_list'=>$module_id_list,
			'page_name_list'=>$page_name_list,
			'container_id_list'=>$container_id_list,
			'copy_setting_id_list'=>$copy_setting_id_list,
			'region_list'=>$region_list,
			'position_list'=>$position_list
		));
	}
}//end class
?>