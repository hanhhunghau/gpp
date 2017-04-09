<?php
// Lop ListBlock hien thi danh sach block, su dung trong trang edit_page
// lien quan den cac luong du lieu cong viec sau:
// - Quan ly Block: AddBlock.php, EditBlock.php, ListModule.php

class Editpage extends Module
{
	function Editpage($row)
	{
		Module::Module($row);
		require_once 'db.php';
		require_once 'packages/core/includes/pagesetting/update_page.php';
		//if(User::can_admin())
		{
			require_once 'packages/core/includes/pagesetting/page_layout.php';
			if(Url::check(array('cmd'=>'change_layout','id','new_layout')))
			{
				EditpageDB::update_page_layout($_REQUEST['new_layout'],URL::get('id'));
				update_page(URL::get('id'));
				if(URL::check('href'))
				{
					URL::redirect_url(URL::get('href'));
				}
				else
				{
					Url::redirect_current(array('id'=>URL::get('id')));
				}
			}
			else
			if(Url::check(array('cmd'=>'delete','id')) and $block=DB::select('BLOCK',$_REQUEST['id']))
			{
				$this->delete_sub_blocks($_REQUEST['id']);
				update_page($block['page_id']);
				if(URL::check('href'))
				{
					URL::redirect_url(URL::get('href'));
				}
				else
				{
					Url::redirect_current(array('id'=>$block['page_id']));
				}
			}
			else
			if(Url::check(array('cmd'=>'move_block','id','block_id','region')) and DB::select('BLOCK',$_REQUEST['block_id']))
			{
				$page = DB::select('page',$_REQUEST['id']);
				if(URL::get('container_id') and $block = DB::select('BLOCK',URL::get('container_id')) and $module = DB::select('MODULE',$block['module_id']))
				{
					if($this->is_parent_block($_REQUEST['block_id'],$block))
					{
						Url::redirect_current(array('id'));
					}
					$layout='';
					$layout_text = $this->regions_to_layout_text(pageLayout::get_module_regions($module));
					
				}
				else
				{
					$layout=$page['layout'];
					$layout_text = false;
				}
				$layout = new pageLayout($layout, $layout_text);
				
				if($position = $layout->get_next_position('page','block', $_REQUEST['id'],$_REQUEST['region'],URL::get('container_id')?' and container_id='.$_REQUEST['container_id']:false))
				{
					EditpageDB::update_block($_REQUEST['region'], $position,URL::get('container_id'),$_REQUEST['block_id']);
					
					update_page($_REQUEST['id']);
				}
				Url::redirect_current(array('id'));
			}
			else
			if(Url::check(array('move','block_id')))
			{
				$block=DB::select('BLOCK',$_REQUEST['block_id']);
				pageLayout::move('page','block',$_REQUEST['block_id'],$_REQUEST['move'],URL::get('container_id')?' and container_id='.$_REQUEST['container_id']:false);
				update_page($block['page_id']);
				if(URL::check('href'))
				{
					URL::redirect_url(URL::get('href'));
				}
				else
				{
					Url::redirect_current(array('id'=>$block['page_id']));
				}
			}
			else
			{
				if(Url::check(array('module_id','region')))
				{
					$page = DB::select('page',$_REQUEST['id']);
					if(URL::get('container_id') and $block = DB::select('BLOCK',URL::get('container_id')) and $module = DB::select('MODULE',$block['module_id']))
					{
						$layout = '';
						$layout_text = $this->regions_to_layout_text(pageLayout::get_module_regions($module));
					}
					else
					{
						$layout=$page['layout'];
						$layout_text = false;
					}
		
					$layout = new pageLayout($layout, $layout_text);
					
					
					if(URL::check('after') and $after = DB::select('BLOCK',URL::get('after')))
					{
						EditpageDB::increment_all_after_block_position($after['page_id'],$after['region'],$after['position'],$after['container_id']);
						$position = $after['position']+1;
						if(URL::check('replace'))
						{
							DB::delete('BLOCK_SETTING', 'BLOCK_ID='.URL::get('after'));
							DB::delete_id('BLOCK',URL::get('after'));
						}
					}
					else
					{
						$position = $layout->get_next_position('page','BLOCK', $_REQUEST['id'],$_REQUEST['region'],URL::get('container_id')?' and CONTAINER_ID='.$_REQUEST['container_id']:false);
					}
					
					if($position)
					{
						DB::insert('BLOCK', array('REGION'=>$_REQUEST['region'], 'POSITION'=>$position,'page_ID'=>$_REQUEST['id'],'MODULE_ID'=>$_REQUEST['module_id'],'CONTAINER_ID'=>URL::get('container_id',0)));
						update_page($_REQUEST['id']);
					}
					if(URL::check('href'))
					{
						URL::redirect_url(URL::get('href'));
					}
					else
					{
						Url::redirect_current(array('id'));
					}
				}
				else
				{
					if(((URL::check(array('cmd'=>'delete')) or URL::check(array('cmd'=>'edit')) or URL::check(array('cmd'=>'add_setting'))or URL::check(array('cmd'=>'list_setting'))) and Url::check('id') and DB::select('BLOCK',$_REQUEST['id']))
						or
						((URL::check(array('cmd'=>'delete_setting')) or URL::check(array('cmd'=>'edit_setting'))) and Url::check('id') and DB::select('BLOCK_SETTING',$_REQUEST['id']))
						or
						(URL::check(array('cmd'=>'edit_layout','id')) and DB::select('BLOCK',$_REQUEST['id']))
						or (!Url::check(array('cmd')) and URL::check('id') and DB::select('page',URL::get('id')))
					)
					{
						
						switch(URL::get('cmd'))
						{
						case 'edit_layout':
							require_once 'forms/edit_container_layout.php';
							$this->add_form(new EditContainerLayoutForm());break;
						case 'delete':
							require_once 'forms/delete_block.php';
							$this->add_form(new DeleteBlockForm());break;
						default:
							require_once 'forms/page_content.php';
							$this->add_form(new pageContentForm());break;
						}
						if(in_array(URL::get('cmd'),array('edit_setting','delete_setting')))
						{
							if($setting = DB::select('BLOCK_SETTING',$_REQUEST['id']) and $block=DB::select('BLOCK',$setting['block_id']))
							{
								update_page($block['page_id']);
							}
						}
						else
						if(URL::get('cmd')=='add_setting' and $block=DB::select('BLOCK',$_REQUEST['id']))
						{
							update_page($block['page_id']);
						}
					}
					else
					{
						Url::redirect('admin_page');
					}
				}
			}
		}
		//else
		//{
			//Url::access_denied();
		//}
	}
	function regions_to_layout_text($regions)
	{
		$layout = '';
		foreach($regions as $region)
		{
			$layout .= '[[|'.$region.'|]]';
		}
		return $layout;
	}
	function delete_sub_blocks($id)
	{
		
		$blocks = EditpageDB::select_all_block_in_container($id);
		
		foreach($blocks as $block)
		{
			$this->delete_sub_blocks($block['id']);
		}
		DB::delete_id('BLOCK',$id);
	}
	function is_parent_block($block_id, $child)
	{
		if($child['id'] == $block_id)
		{
			return true;
		}
		if($child['container_id'])
		{
			return $this->is_parent_block($block_id, DB::select('BLOCK',$child['container_id']));
		}
	}
}			
			
?>