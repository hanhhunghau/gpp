<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<script src="packages/core/modules/ModuleAdmin/edit_module.js" type="text/javascript"></script>
<script src="packages/core/includes/js/editor/wysiwyg/wysiwyg.js" type="text/javascript"></script>

<script src="packages/core/includes/js/multi_items.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit_code')?PageSetting::language('edit_code_title'):PageSetting::language('edit_code_title');
$action = (URL::get('cmd')=='edit_code')?'edit':'add';
?><div class="form_bound">
	<table cellpadding="0" width="100%"><tr><td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?> module <?php echo $this->map['name'];?></td><td class="form_title_button"><a  onclick="EditModuleCodeAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br /><?php echo PageSetting::language('save');?></a></td><td>&nbsp;</td>
		<td class="form_title_button">
			<a  onclick="location=\'<?php echo URL::build_current();?>\';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br /><?php echo PageSetting::language('back');?></a></td>
		<?php if($action=='edit'){?><td class="form_title_button">
			<a  onclick="location=\'<?php echo URL::build_current(array('cmd'=>'edit','id'));?>\';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit_button.gif"/><br /><?php echo PageSetting::language('Edit');?></a></td><?php }?>
		<td class="form_title_button">
			<a target="_blank" href="<?php echo URL::build('help',array('id'=>Module::$current->data['module_id'],'href'=>'?'.$_SERVER['QUERY_STRING']));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>frontpage.gif" alt=""/><br />Trang ch&#7911;</a></td></tr></table>
	<div class="form_content">
<?php if(Form::$current->is_error())
		{
		?>		<strong>B&#225;o l&#7895;i</strong><br>
		<?php echo Form::$current->error_messages();?><br>
		<?php
		}
		?>		
		<form name="EditModuleCodeAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
		<table cellspacing="0" width="100%"><tr><td>
			<div class="tab-pane-1" id="tab-pane-dir">
				<?php if(isset($this->map['dirs'])  and  is_array($this->map['dirs'])){ foreach($this->map['dirs'] as $key1=>&$item1){if($key1!='current'){$this->map['dirs']['current'] = &$item1;?>
				<div class="tab-page" id="tab-page-dir-<?php echo $this->map['dirs']['current']['name'];?>">
					<h2 class="tab"><?php echo $this->map['dirs']['current']['name'];?></h2>
					<div class="tab-pane-1" id="tab-pane-file">
						<?php if(isset($this->map['dirs']['current']['files'])  and  is_array($this->map['dirs']['current']['files'])){ foreach($this->map['dirs']['current']['files'] as $key2=>&$item2){if($key2!='current'){$this->map['dirs']['current']['files']['current'] = &$item2;?>
						<div class="tab-page" id="tab-page-file-<?php echo $this->map['dirs']['current']['files']['current']['id'];?>">
							<h2 class="tab"><?php echo $this->map['dirs']['current']['files']['current']['name'];?></h2>
							<textarea  name="files[<?php echo $this->map['dirs']['current']['files']['current']['path'];?>]" id="file_[<?php echo $this->map['dirs']['current']['files']['current']['id'];?>]" style="width:100%;font-family:'Courier New', Courier, monospace;font-size:16px" rows="24" onkeydown="if(edit_code_keypress(this)){ if(document.all)event.returnValue=false;else return false;}"><?php echo $this->map['dirs']['current']['files']['current']['content'];?></textarea>
						</div>
						<?php }}unset($this->map['dirs']['current']['files']['current']);} ?>
					</div>
				</div>
				<?php }}unset($this->map['dirs']['current']);} ?>
			</div>
		</td></tr></table>
		<input type="hidden" value="1" name="confirm_edit"/>
	<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
	</div>
</div>