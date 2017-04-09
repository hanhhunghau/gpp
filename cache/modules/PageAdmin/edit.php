<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<span style="display:none">
</span>
<?php 
$title = (URL::get('cmd')=='edit')?PageSetting::language('edit_title'):PageSetting::language('add_title');
$action = (URL::get('cmd')=='edit')?'edit':'add';?><div class="form_bound">
<table cellpadding="10" width="100%">
	<tr>
    	<td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td>
        <td class="form_title_button" width="1%" nowrap="nowrap"><a href="javascript:void(0)" onclick="EditpageAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br /><?php echo PageSetting::language('save');?></a></td>
		<td class="form_title_button" width="1%" nowrap="nowrap">
			<a href="javascript:void(0)" onclick="location='<?php echo URL::build_current(array('package_id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br /><?php echo PageSetting::language('back');?></a></td>
		<?php if($action=='edit'){?><td class="form_title_button" width="1%" nowrap="nowrap">
			<a href="javascript:void(0)" onclick="location='<?php echo URL::build_current(array('package_id','cmd'=>'delete','id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" alt=""/><br /><?php echo PageSetting::language('Delete');?></a></td><?php }?>
		</tr></table>
	<div class="form_content">
<?php if(Form::$current->is_error())
		{
		?>		<strong>B&#225;o l&#7895;i</strong><br>
		<?php echo Form::$current->error_messages();?><br>
		<?php
		}
		?>		
	<form name="EditpageAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
	<table cellspacing="0" width="100%"><tr><td>
				<div class="tab-pane-1" id="tab-pane-page">
				<?php if(isset($this->map['languages'])  and  is_array($this->map['languages'])){ foreach($this->map['languages'] as $key1=>&$item1){if($key1!='current'){$this->map['languages']['current'] = &$item1;?>
				<div class="tab-page" id="tab-page-page-<?php echo $this->map['languages']['current']['id'];?>">
					<h2 class="tab"><?php echo $this->map['languages']['current']['name'];?></h2>
					<div class="form_input_label"><?php echo PageSetting::language('title');?>:</div>
					<div class="form_input">
							<input  name="title_<?php echo $this->map['languages']['current']['id'];?>" id="title_<?php echo $this->map['languages']['current']['id'];?>" style="width:400" type ="text" value="<?php echo String::html_normalize(URL::get('title_'.$this->map['languages']['current']['id']));?>">
					</div><div class="form_input_label"><?php echo PageSetting::language('description');?>:</div>
					<div class="form_input">
							<textarea  name="description_<?php echo $this->map['languages']['current']['id'];?>" id="description_<?php echo $this->map['languages']['current']['id'];?>" style="width:100%" rows="10"><?php echo String::html_normalize(URL::get('description_'.$this->map['languages']['current']['id'],''));?></textarea><br />
					</div>
				</div>
				<?php }}unset($this->map['languages']['current']);} ?>
				</div>
				</td></tr></table>
		<div class="form_input_label"><?php echo PageSetting::language('name');?>:</div>
		<div class="form_input">
			<input  name="name" id="name" style="width:300" type ="text" value="<?php echo String::html_normalize(URL::get('name'));?>">
		<div class="form_input_label"><?php echo PageSetting::language('package_id');?>:</div>
		<div class="form_input">
			<select  name="package_id" id="package_id"><?php 
                    if(isset($this->map['package_id_list'])) 
                    { 
                        foreach($this->map['package_id_list'] as $key=>$value) 
                        { 
                            echo '<option value="'.$key.'"'; 
                            echo '>'.$value.'</option>'; 
                             
                        } 
                    } 
                    ?><script>$('package_id').value = "<?php echo addslashes(URL::get('package_id',isset($this->map['package_id'])?$this->map['package_id']:''));?>";</script> 
    </select>
		</div><div class="form_input_label"><?php echo PageSetting::language('layout');?>:</div>
		<div class="form_input">
			<select  name="layout" id="layout"><?php 
                    if(isset($this->map['layout_list'])) 
                    { 
                        foreach($this->map['layout_list'] as $key=>$value) 
                        { 
                            echo '<option value="'.$key.'"'; 
                            echo '>'.$value.'</option>'; 
                             
                        } 
                    } 
                    ?><script>$('layout').value = "<?php echo addslashes(URL::get('layout',isset($this->map['layout'])?$this->map['layout']:''));?>";</script> 
    </select>
		</div>        
		<input type="hidden" value="1" name="confirm_edit"/>
	<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
	</div>
</div>
