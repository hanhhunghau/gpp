<?php
if(!function_exists('category_indent') && !function_exists('set_ul_structure') && !function_exists('get_ul_structure') && !function_exists('make_structure_id_from_level_array') && !function_exists('make_jquery_tree')){
function category_indent(
	&$items, 
	$move = true,
	$space = '<img src="packages/core/skins/default/images/spacer.gif" width="15"/>',
	$level0 = -1,
	$tree_last = -1,
	$tree_next = -1
)
{
	if($level0==-1)
	{
		$level0 = '<img src="'.PageSetting::template('core').'/images/node.gif">';
	}
	if($tree_last == -1)
	{
		$tree_last = '<img src="'.PageSetting::template('core').'/images/tree_last.gif">';
	}
	if($tree_next == -1)
	{
		$tree_next = '<img src="'.PageSetting::template('core').'/images/tree_next.gif">';
	}
	$last_id = 1;
	$last=false;
	foreach($items as $key=>$item)
	{
		$level = IDStructure::level($item['structure_id']);
		$items[$key]['indent']='';
		$items[$key]['_grouping']=0;
		$items[$key]['level']=$level;
		for($i=1;$i<$level;$i++)
		{
			$items[$key]['indent'].=$space;
		}
		if($level==0)
		{
			$items[$key]['indent_image']=$level0;
			$items[$key]['_grouping']=1;
			$items[$key]['indent']='<img src="'.PageSetting::template('core').'/images/spacer.gif" width="8"/>';
		}
		else
		{
			/*if($last['code'] =='133111')
			{
				echo IDStructure::level($last['structure_id']).' '.$level.' '.$item['structure_id'].' '.$last['structure_id'].'<br>';
			}*/
			if(IDStructure::level($last['structure_id'])!=0 and IDStructure::level($last['structure_id'])!=$level)
			{
				$last['indent_image']=$tree_last;
				$last['_grouping']=$level-IDStructure::level($last['structure_id']);
			}
			else
			{
				$last['indent_image']=$tree_next;
			}
			$last = &$items[$key];
		}
		
		if($move)
		{
			if ($level==0)
			{
				$items[$key]['move_up']='';
				$items[$key]['move_down']='&nbsp;';
			}
			else
			{
				$items[$key]['move_up']='<a href="'.Url::build_current(array('cmd'=>'move_up','id'=>$item['id'])).'"><img src="'.PageSetting::template('core').'/images/buttons/up_arrow.gif" alt="Move up"></a>';
				$items[$key]['move_down']='<a href="'.Url::build_current(array('cmd'=>'move_down','id'=>$item['id'])).'"><img src="'.PageSetting::template('core').'/images/buttons/down_arrow.gif" alt="Move down"></a>';
			}
		}
		else
		{
			$items[$key]['move_up']='<img src="'.PageSetting::template('core').'/images/buttons/up_arrow.gif" alt="Move up">';
			$items[$key]['move_down']='<img src="'.PageSetting::template('core').'/images/buttons/down_arrow.gif" alt="Move down">';
		}
	}
	if($last)
	{
		$last['_grouping']=1-IDStructure::level($last['structure_id']);
		$last['indent_image']=$tree_last;
	}
	
}

function set_ul_structure($arr,$type=false,$block_id=false,$level=false)
{
	$st = '';
	if($level==false)
	{
		$level = 1;
	}
	foreach($arr as $value)
	{
		$sub_level = $level+1;
		if(isset($value['URL']) and $value['URL'])
		{
			$href = $value['URL'];
		}
		else
		if(isset($value['HREF']) and $value['HREF'])
		{
			$href = $value['HREF'];
		}
		else if(Module::get_setting('url'))
		{
			if(Module::get_setting('type_params'))
			{
				$href = Url::build(Module::get_setting('url'),array(Module::get_setting('category_id_param','category_id')=>$value['id'],Module::get_setting('type_params')=>$value['TYPE'],'name'=>$value['NAME']),REWRITE);
			}
			else
			{
				$href = Url::build(Module::get_setting('url'),array(Module::get_setting('category_id_param','category_id')=>$value['id'],'name'=>$value['NAME']),REWRITE);
			}
		}
		else
		{
			if(isset($value['URL']) and $value['URL'])
			{
				$href = $value['URL'];
			}
			else
			if(isset($value['HREF']) and $value['HREF'])
			{
				$href = $value['HREF'];
			}
			else
			{
				if($type=='ajax')
				{
					$href = '#';
				}
				else if(isset($value['TYPE']))				
				{
					//$href = Url::build('test',array(Module::get_setting('category_id_param','category_id')=>$value['id']));
					$href = Url::build(strtolower($value['TYPE']),array(Module::get_setting('category_id_param','category_id')=>$value['id'],'name'=>$value['NAME']),REWRITE);
				}
				else
				{
					$href = Url::build_current(array(Module::get_setting('category_id_param','category_id')=>$value['id'],'name'=>$value['NAME']),REWRITE);
				}
			}
		}
		if(Module::get_setting('extra_param'))
		{
			$href.= '&amp;'.Module::get_setting('extra_param');
		}
		if(isset($value['level']))
		{
			$st .= '<LI><a '.(($level==1)?'class="level_'.$value['LEVEL'].'"':'').' href="'.$href.'" '.(($type=='ajax')?' onclick="ItemList.blockId = '.$block_id.';Object.extend(ItemList.params,{\'category_id\':'.$value['id'].'});ItemList.GetContent();return false;"':'').'><span>'.strip_tags($value['NAME']).'</span></a>';
		}
		else if(Module::get_setting('category_type')=='vertical')
		{
			$st .= '<LI><a '.(($level==1)?'class="level_1"':'').' href="'.$href.'" '.(($type=='ajax')?' onclick="ItemList.blockId = '.$block_id.';Object.extend(ItemList.params,{\'category_id\':'.$value['id'].'});ItemList.GetContent();return false;"':'').'><span>'.strip_tags($value['NAME']).'</span></a>';		
		}
		else
		{
			$st .= '<LI><a '.(($level==1)?'class="head_'.Module::get_setting('category_type').'"':'').' href="'.$href.'" '.(($type=='ajax')?' onclick="ItemList.blockId = '.$block_id.';Object.extend(ItemList.params,{\'category_id\':'.$value['id'].'});ItemList.GetContent();return false;"':'').'><span>'.strip_tags($value['NAME']).'</span></a>';
		}
		if(isset($value['CHILDS']))
		{
			if($childs = $value['CHILDS'])
			{
				$st  .= '<UL>';
				$st .= set_ul_structure($childs,$type,$block_id,$sub_level);
				$st  .= '</UL>';				
			}
		}
		$st  .= '</LI>';
	}
	return $st ;
}
function get_ul_structure()
{	
	$file  = fopen('cache/category.php','r');
}
function make_structure_id_from_level_array(&$items, $level=1, $structure_id=false)
{
	if(!$structure_id)
	{
		$structure_id = number_format(ID_ROOT + ID_ROOT/100,0,'','');
	}
	while($current = current($items))
	{
		if($current['LEVEL'] == $level)
		{
			$items[$current['id']]['structure_id'] = $structure_id;
			next($items);
			make_structure_id_from_level_array($items, $level+1, number_format($structure_id+$structure_id/100,0,'',''));
			$structure_id = IDStructure::next($structure_id);
		}
		else
		{
			break;
		}
	}
}
function make_jquery_tree($category,$path,$type=false,$block_id=false,$level=false)
{
	$st = '';
	if($level==false)
	{
		$level = 1;
	}
	if($category)
	{
		foreach($category as $key=>$value)
		{
			$sub_level = $level+1;
			if(isset($path[$key]))
			{
				$st.= '<li><span class="folder"><a href="'.Url::build('manage_content',array('category_id'=>$key,'type'=>$value['TYPE'],'cmd'=>'list')).'" >'.$value['NAME'].'</a></span>';
			}
			else
			{
				$st.= '<li class="closed"><span class="folder"><a href="'.Url::build('manage_content',array('category_id'=>$key,'type'=>$value['TYPE'],'cmd'=>'list')).'" >'.$value['NAME'].'</a></span>';
			}
			if(isset($value['CHILDS']))
			{
				if($childs = $value['CHILDS'])
				{
					$st .= '<UL>';
					$st .= make_jquery_tree($childs,$type,$block_id,$sub_level);
					$st .= '</UL>';				
				}
			}
			$st  .= '</LI>';			
		}
		return $st ;
	}
}
}
// minhduc
?>