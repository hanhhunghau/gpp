<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<script src="packages/core/includes/js/multi_items.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit')?PageSetting::language('edit_title'):PageSetting::language('add_title');
$action = (URL::get('cmd')=='edit')?'edit':'add';
if(isset($this->map['type'])){echo $this->map['type'];}?>
<div class="form_bound">
<table cellpadding="10" width="100%">
	<tr>
    	<td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td>
        <td class="form_title_button" width="1%" nowrap="nowrap"><a href="javascript:void(0)" onclick="EditModuleAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br /><?php echo PageSetting::language('save');?></a></td>
		<?php if($action=='edit'){?>
			<td class="form_title_button"><a href="javascript:void(0)" onclick="location='<?php echo URL::build_current(array('cmd'=>($this->map['type']=='CONTENT')?'edit_content':(($this->map['type']=='HTML')?'edit_html':'edit_code'),'id'));?>';"><img width="30px" src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit_button.gif" style="text-align:center"/><br /><?php echo PageSetting::language('edit_code');?></a></td>
		<?php }?>
			<td class="form_title_button" width="1%" nowrap="nowrap">
				<a href="javascript:void(0)" onclick="location='<?php echo URL::build_current();?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br /><?php echo PageSetting::language('back');?></a>
			</td>
		<?php if($action=='edit'){?>
			<td class="form_title_button" width="1%" nowrap="nowrap">
				<a href="javascript:void(0)") onclick="location='<?php echo URL::build_current(array('cmd'=>'delete','id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" alt=""/><br /><?php echo PageSetting::language('Delete');?></a>
			</td>
		<?php }?>
	</tr>
</table>

<div class="form_content">
<form name="EditModuleAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
		<input  name="deleted_ids" id="deleted_ids" type="hidden" value="<?php echo URL::get('deleted_ids');?>">
		<table cellspacing="0" width="100%">
			<tr>
				<td>
					<div class="tab-pane-1" id="tab-pane-module">
						<?php if(isset($this->map['languages'])  and  is_array($this->map['languages'])){ foreach($this->map['languages'] as $key1=>&$item1){if($key1!='current'){$this->map['languages']['current'] = &$item1;?>
						<div class="tab-page" id="tab-page-module-<?php echo $this->map['languages']['current']['id'];?>">
							<h2 class="tab"><?php echo $this->map['languages']['current']['name'];?></h2>
							<div class="form_input_label"><?php echo PageSetting::language('title');?>:</div>
							<div class="form_input">
								<input  name="title_<?php echo $this->map['languages']['current']['id'];?>" id="title_<?php echo $this->map['languages']['current']['id'];?>" style="width:400" type ="text" value="<?php echo String::html_normalize(URL::get('title_'.$this->map['languages']['current']['id']));?>">
							</div>
							<div class="form_input_label"><?php echo PageSetting::language('description');?>:</div>
							<div class="form_input">
								<textarea  name="description_<?php echo $this->map['languages']['current']['id'];?>" id="description_<?php echo $this->map['languages']['current']['id'];?>" style="width:100%" rows="10"><?php echo String::html_normalize(URL::get('description_'.$this->map['languages']['current']['id'],''));?></textarea><br />
							</div>
						</div>
						<?php }}unset($this->map['languages']['current']);} ?>
					</div>
				</td>
			</tr>
		</table>
		<div class="form_input_label"><?php echo PageSetting::language('name');?>:</div>
		<div class="form_input">
			<input  name="name" id="name" style="width:150" type ="text" value="<?php echo String::html_normalize(URL::get('name'));?>">
		</div>
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
		</div>
	<input type="hidden" value="1" name="confirm_edit"/>
	<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
	</div>
</div>
