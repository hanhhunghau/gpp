<?php
class DeleteBlockForm extends Form
{
	function DeleteBlockForm()
	{
		//khoi tao form
		Form::Form('deleteBlock');
		$this->add('ID',new IDType(true,false,'BLOCK'));
	}
	//ham thuc hien viec submit cua form
	function on_submit()
	{
		//thuc hien hanh dong xoa block
		if($this->check())
		{
			require_once 'packages/core/includes/pagesetting/update_page.php';
			$block=DB::select('BLOCK',$_REQUEST['id']);
			DB::delete_id('BLOCK',$_REQUEST['id']);
			update_page($block['page_id']);
			if(URL::check('href'))
			{
				URL::redirect_url(URL::get('href'));
			}
			else
			{
				Url::redirect_current(array('id'=>$block['page_id'],'container_id'=>$block['container_id']));
			}
		}
	}
	//ve form hien thi hanh dong them block moi
	function draw()
	{
		$block = DB::select('BLOCK',$_REQUEST['id']);
		$module = DB::select('MODULE',$block['module_id']);
		$page = DB::select('page',$block['page_id']);
		$this->parse_layout('delete_block',
			$block+
			array(
			'name'=>$module['name'],
			'page_name'=>$page['name']
			));
		
	}
}//end class

?>