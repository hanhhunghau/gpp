<?php 
$title = PageSetting::language('function_list');
?>
<form method="post" name="SearchCategoryForm" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
<table cellpadding="0" cellspacing="0" width="100%" border="0" bordercolor="#CCCCCC" class="table-bound">
	<tr height="40">
		<td width="90%" class="form-title"><?php echo $title;?></td>
		
		<?php 
		if(URL::get('cmd')=='delete'){?>
		<td width="1%"><a onclick="$('cmd').cmd='delete';ListCategoryForm.submit();"  class="button-medium-delete"><?php echo PageSetting::language('Delete');?></a></td>
		<td width="1%"><a href="<?php echo URL::build('category',Module::$current->redirect_parameters);?>"  class="button-medium-back"><?php echo PageSetting::language('back');?></a></td>
		<td width="1%">&nbsp;</td>
		<?php 
		}else{ 
		//if(User::can_add(false,ANY_CATEGORY))
		{?>
		
		<td width="1%"><a href="<?php echo URL::build('category',Module::$current->redirect_parameters+array('cmd'=>'add'));?>"  class="button-medium-add"><?php echo PageSetting::language('Add');?></a></td>
		<?php }?>
		<?php //if(User::can_delete(false,ANY_CATEGORY))
		{?>
		<td width="1%"><a href="javascript:void(0)" onclick="if(confirm('<?php echo PageSetting::language('are_you_sure');?>?')){ListCategoryForm.cmd.value='delete';ListCategoryForm.submit();}"  class="button-medium-delete"><?php echo PageSetting::language('Delete');?></a></td>
		<?php }
		}?>
	</tr>
</table>
<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            	<br />
<form name="ListCategoryForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
	<a name="top_anchor"></a>		
	<table cellpadding="0" cellspacing="0" width="100%" border="1" bordercolor="#CCCCCC">
		<thead>
			<tr class="table-header">
				<th width="1%" title="<?php echo PageSetting::language('check_all');?>"><input type="checkbox" value="1" id="Category_all_checkbox" onclick="select_all_checkbox(this.form,'Category',this.checked,'<?php echo PageSetting::get_setting('crud_list_item_selected_bgcolor','#FFFFEC');?>','<?php echo PageSetting::get_setting('crud_item_bgcolor','white');?>');"<?php if(URL::get('cmd')=='delete') echo ' checked';?>></th>
				<th nowrap align="left">&nbsp;</th>
				<th nowrap align="left"><?php echo PageSetting::language('name');?></th>
                <th align="left" nowrap="nowrap"><?php echo PageSetting::language('module');?></th>
                <th width="10%" nowrap align="left"><?php echo PageSetting::language('type');?></th>
				<th width="5%"><?php echo PageSetting::language('status');?></th>
				<?php// if(User::can_edit(false,ANY_CATEGORY))
				?>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<?php ?>
			</tr>
		</thead>
		<tbody>
			<?php $i=0;?>
			<?php if(isset($this->map['items'])  and  is_array($this->map['items'])){ foreach($this->map['items'] as $key1=>&$item1){if($key1!='current'){$this->map['items']['current'] = &$item1;?>
			<?php $onclick = 'location=\''.URL::build_current().'&cmd=edit&id='.urlencode($this->map['items']['current']['id']).'\';';?>
			<tr <?php echo ($this->map['items']['current']['status']!='SHOW')?'style="color:#333333;text-decoration:line-through;background:#CCCCCC;"':'';?> valign="middle" style="cursor:pointer;" id="Category_tr_<?php echo $this->map['items']['current']['id'];?>" onmouseover="this.bgColor='#FFCCCC'" onmouseout="this.bgColor='#FFFFFF'">
				<td width="1%" align="center"><input name="selected_ids[]" type="checkbox" value="<?php echo $this->map['items']['current']['id'];?>" onclick="select_checkbox(this.form,'Category',this,'<?php echo PageSetting::get_setting('crud_list_item_selected_bgcolor','#FFFFEC');?>','<?php echo PageSetting::get_setting('crud_item_bgcolor','white');?>');" id="Category_checkbox" <?php if(URL::get('cmd')=='delete') echo 'checked';?>></td>
				<td align="left"  onclick="window.location='<?php echo Url::build_current().'&cmd=edit&id='.$this->map['items']['current']['id'];?>'"><?php  
                if(($this->map['items']['current']['icon_url'])) 
                {?><img src="<?php echo $this->map['items']['current']['icon_url'];?>" width="20"> 
                <?php 
                } 
                ?></td>
				<td align="left"  onclick="window.location='<?php echo Url::build_current().'&cmd=edit&id='.$this->map['items']['current']['id'];?>'">
				<?php echo $this->map['items']['current']['indent'];?><a name="a<?php echo $this->map['items']['current']['id'];?>"></a>
				<?php echo $this->map['items']['current']['indent_image'];?>
				<span class="page_indent">&nbsp;</span>
				<?php echo $this->map['items']['current']['name'];?></td>
				
				<td width="120px" align="left" nowrap="nowrap"><input  name="module_<?php echo $this->map['items']['current']['id'];?>" type="text" id="module_<?php echo $this->map['items']['current']['id'];?>" value="<?php echo $this->map['items']['current']['module_name'];?>" style="width:120px;font-size:11px;"></td>
				
				<td align="center"  onclick="<?php echo $onclick;?>"><?php echo $this->map['items']['current']['type'];?></td>
				<td width="24px" align="center"><input  name="status_<?php echo $this->map['items']['current']['id'];?>" type="text" id="status_<?php echo $this->map['items']['current']['id'];?>" value="<?php echo $this->map['items']['current']['status'];?>" style="width:50px;font-size:11px;"></td>
				<td width="24px" align="center" onclick="move_up('<?php echo $this->map['items']['current']['id'];?>')" ><?php echo $this->map['items']['current']['move_up'];?></td>
				<td width="24px" align="center" onclick="move_down(<?php echo $this->map['items']['current']['id'];?>)"><?php echo $this->map['items']['current']['move_down'];?></td>
			</tr>
			<?php }}unset($this->map['items']['current']);} ?>
		</tbody>
	</table>	
	<input type="hidden" name="cmd" value="" id="cmd"/>
	<?php  
                if((URL::get('cmd')=='delete')) 
                {?>
	<input type="hidden" name="confirm" value="1" />
	 
                <?php 
                } 
                ?>
<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
<script type="text/javascript">
function move_up(id)
{
	jQuery.ajax({
		  url: "form.php?block_id=<?php echo Module::$current->data['id'];?>",
		  type: "POST",
		  data: ({id : id,cmd:'move_up'}),
		  beforeSend: function(){
		  	jQuery('#loading-layer').fadeIn(100);
		  },
		  success: function(msg){
			//jQuery('#printer').html(msg);
			$('printer').innerHTML =''
			$('printer').innerHTML = msg;
		  },
		  complete:function(){
		  	jQuery('#loading-layer').fadeOut(100);
		  }
	});
}
function move_down(id)
{
	jQuery.ajax({
		  url: "form.php?block_id=<?php echo Module::$current->data['id'];?>",
		  type: "POST",
		  data: ({id : id,cmd:'move_down'}),
		  dataType: "html",
		  beforeSend: function(){
		  	jQuery('#loading-layer').fadeIn(100);
		  },
		  success: function(msg){
			 //jQuery('#printer').html(msg);
		 	 $('printer').innerHTML = '';
			 $('printer').innerHTML = msg;
		  },
		  complete:function(){
		  	jQuery('#loading-layer').fadeOut(100);
		  }
	})
}
</script>