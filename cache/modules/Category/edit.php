<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit')?PageSetting::language('Edit'):PageSetting::language('Add');
$action = (URL::get('cmd')=='edit')?'edit':'add';
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0" bordercolor="#CCCCCC"  class="table-bound">
	<tr height="40">
		<td width="90" class="form-title"><?php echo $title;?></td>
		<td width="1%" align="right"><a class="button-medium-save" onclick="EditCategoryForm.submit();"><?php echo PageSetting::language('save');?></a></td>
        <td width="1%"><a class="button-medium-back" onclick="location='<?php echo URL::build_current();?>';"><?php echo PageSetting::language('back');?></a></td>
		<?php 
		//if($action=='edit' and User::can_delete(false,ANY_CATEGORY))
		//{
			?>
		<td width="1%"><a class="button-medium-delete" onclick="location='<?php echo URL::build_current(array('cmd'=>'delete','id'));?>';"><?php echo PageSetting::language('Delete');?></a></td>
		<?php// }?>
	</tr>
</table>
<table cellpadding="15" cellspacing="0" width="100%" border="0" bordercolor="#CCCCCC" class="table-bound">	
	<tr>
	<td style="width:100%" valign="top">
	<?php if(Form::$current->is_error()){?><?php echo Form::$current->error_messages();?><br><?php }?>
	<form name="EditCategoryForm" method="post" enctype="multipart/form-data" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
	<input type="hidden" name="confirm_edit" value="1" />
	<table cellspacing="0" width="100%"><tr><td>
	<div class="tab-pane-1" id="tab-pane-category">
	<?php if(isset($this->map['languages'])  and  is_array($this->map['languages'])){ foreach($this->map['languages'] as $key1=>&$item1){if($key1!='current'){$this->map['languages']['current'] = &$item1;?>
	<div class="tab-page" id="tab-page-category-<?php echo $this->map['languages']['current']['id'];?>">
	<h2 class="tab"><?php echo $this->map['languages']['current']['name'];?></h2>
	<div class="form-input-label"><?php echo PageSetting::language('name');?>:</div>
	<div class="form-input">
	<input  name="name_<?php echo $this->map['languages']['current']['id'];?>" id="name_<?php echo $this->map['languages']['current']['id'];?>" style="width:400px;" type ="text" value="<?php echo String::html_normalize(URL::get('name_'.$this->map['languages']['current']['id']));?>">
	</div>
	<div class="form-input-label"><?php echo PageSetting::language('description');?>:</div>
	<div class="form-input">
	<textarea  name="description_<?php echo $this->map['languages']['current']['id'];?>" id="description_<?php echo $this->map['languages']['current']['id'];?>" style="width:400px;" rows="2" ><?php echo String::html_normalize(URL::get('description_'.$this->map['languages']['current']['id'],''));?></textarea><br />
    <div class="form-input-label"><strong><?php echo PageSetting::language('group_name');?>:</strong></div>
	<div class="form-input">
	<input  name="group_name_<?php echo $this->map['languages']['current']['id'];?>" id="group_name_<?php echo $this->map['languages']['current']['id'];?>" style="width:400px;" type ="text" value="<?php echo String::html_normalize(URL::get('group_name_'.$this->map['languages']['current']['id']));?>">
	</div>
	</div>
	</div>
	<?php }}unset($this->map['languages']['current']);} ?>
	</div>
	</td></tr></table>
	
	<div class="form-input-label"><strong><?php echo PageSetting::language('parent_name');?>:</strong></div>
	<div class="form-input">
	<select  name="parent_id" id="parent_id"><?php 
                    if(isset($this->map['parent_id_list'])) 
                    { 
                        foreach($this->map['parent_id_list'] as $key=>$value) 
                        { 
                            echo '<option value="'.$key.'"'; 
                            echo '>'.$value.'</option>'; 
                             
                        } 
                    } 
                    ?><script>$('parent_id').value = "<?php echo addslashes(URL::get('parent_id',isset($this->map['parent_id'])?$this->map['parent_id']:''));?>";</script> 
    </select></div>
    <div class="form-input-label"><strong><?php echo PageSetting::language('module');?>:</strong></div>
	<div class="form-input">
	<select  name="module_id" id="module_id"><?php 
                    if(isset($this->map['module_id_list'])) 
                    { 
                        foreach($this->map['module_id_list'] as $key=>$value) 
                        { 
                            echo '<option value="'.$key.'"'; 
                            echo '>'.$value.'</option>'; 
                             
                        } 
                    } 
                    ?><script>$('module_id').value = "<?php echo addslashes(URL::get('module_id',isset($this->map['module_id'])?$this->map['module_id']:''));?>";</script> 
    </select></div>
	<div class="form-input-label"><strong><?php echo PageSetting::language('url');?>:</strong></div>
	<div class="form-input">
	<input  name="url" id="url" style="width:400px;" type ="text" value="<?php echo String::html_normalize(URL::get('url'));?>">
	</div>
	<div class="form-input-label"><strong><?php echo PageSetting::language('status');?>:</strong></div>
	<div class="form-input">
	<select  name="status" id="status"><?php 
                    if(isset($this->map['status_list'])) 
                    { 
                        foreach($this->map['status_list'] as $key=>$value) 
                        { 
                            echo '<option value="'.$key.'"'; 
                            echo '>'.$value.'</option>'; 
                             
                        } 
                    } 
                    ?><script>$('status').value = "<?php echo addslashes(URL::get('status',isset($this->map['status'])?$this->map['status']:''));?>";</script> 
    </select>
	</div>
	<div class="form-input-label"><strong><?php echo PageSetting::language('icon_url');?>:</strong></div>
	<div class="form-input">
	<img id="img_icon_url" src="<?php echo URL::get('icon_url')?URL::get('icon_url'):'packages/core/skins/default/images/no_image.gif';?>" width="50" border="0">
	<input  name="icon_url" id="icon_url" type ="hidden" value="<?php echo String::html_normalize(URL::get('icon_url'));?>">
	<input  name="file_icon_url" id="file_icon_url" onchange="$('img_icon_url').src='file:///'+this.value;"  type ="file" value="<?php echo String::html_normalize(URL::get('file_icon_url'));?>">
	<input type="image" src="<?php echo PageSetting::template('core');?>/images/buttons/delete.gif" onclick="$('icon_url').value = '';$('file_icon_url').value='';$('img_icon_url').src='<?php echo PageSetting::template('cms');?>/images/spacer.gif';event.returnValue=false;">
	</div>
	<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
	</td>
	<td valign="top">
	</td>
	</tr>
</table>
