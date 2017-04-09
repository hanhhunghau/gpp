<?php 
$title = (URL::get('cmd')=='delete')?PageSetting::language('delete_title'):PageSetting::language('list_title');
$action = (URL::get('cmd')=='delete')?'delete':'list';
?>
<style>
.module_tab
{
	font-size:16px;
	background-color:#DDDDDD;
}
.module_tab_select
{
	font-size:16px;
	background-color:#EFEFEF;
}
</style>
<div class="form_bound">
<table cellpadding="10" width="100%">
	<tr>
    	<td class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td>
		<?php 
			if(URL::get('cmd')=='delete'){
		?>
			<td class="form_title_button">
				<a  onclick="ListModuleAdminForm.submit();">
					<img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" style="text-align:center" alt=""/><br /><?php echo PageSetting::language('Delete');?></a>
			</td>
			<td width="1%" nowrap="nowrap" class="form_title_button">
				<a href="<?php echo URL::build_current(array('package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'','name'=>isset($_GET['name'])?$_GET['name']:''));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif" style="text-align:center" alt=""/><br /><?php echo PageSetting::language('back');?></a>
			</td>
			<?php }
			else{ 
			?>
			<td width="1%" nowrap="nowrap" class="form_title_button"><a href="<?php echo URL::build_current(array('type','package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'','name'=>isset($_GET['name'])?$_GET['name']:'')+array('cmd'=>'add'));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>add_button.gif" style="text-align:center" alt=""/><br /><?php echo PageSetting::language('Add');?></a></td>
			<td width="1%" nowrap="nowrap" class="form_title_button"><a  onclick="ListModuleAdminForm.cmd.value='delete';ListModuleAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" alt=""/><br />
			<?php echo PageSetting::language('Delete');?></a></td>
			<?php }?>
	</tr></table>
	<div id="title_region" style="display:block"></div>
	<table cellspacing="0" width="100%">
		<tr bgcolor="#EFEFEF" valign="top">
			<td nowrap bgcolor="white">
				<table width="100%" cellpadding="0" cellspacing="0">
				<?php if(isset($this->map['packages'])  and  is_array($this->map['packages'])){ foreach($this->map['packages'] as $key1=>&$item1){if($key1!='current'){$this->map['packages']['current'] = &$item1;?>
				<tr><td nowrap>
					<a href="<?php echo URL::build_current(array('page_id','region','after','replace','type'));?>&package_id=<?php echo $this->map['packages']['current']['id'];?>" ><?php echo $this->map['packages']['current']['name'];?></a>
				</td></tr>
				<?php }}unset($this->map['packages']['current']);} ?>
				</table>
				<a href="<?php echo Url::build('package');?>" class="category_level1"><?php echo PageSetting::language('packages/admin');?></a> 
			</td>
			<td width="100%">
				<table width="100%">			
					<tr>
						<td>
							<table bgcolor="#EFEFEF" cellspacing="0" width="100%">
								<tr>
									<td width="100%">									
										<form name="ListModuleAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
											<table width="99%" cellpadding="2" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#CCCCCC">
												<tr valign="middle" bgcolor="#EFEFEF" style="line-height:20px">
													<th width="1%" title="<?php echo PageSetting::language('check_all');?>"><input type="checkbox" value="1" id="ModuleAdmin_all_checkbox" onclick="select_all_checkbox(this.form,'ModuleAdmin',this.checked,'#FFFFEC','white');" <?php if(URL::get('cmd')=='delete') echo ' checked';?>></th>
													<th nowrap align="left" ><?php echo PageSetting::language('name');?></th>
													<th nowrap align="left"><?php echo PageSetting::language('package_id');?></th>
													<th nowrap align="left"><?php echo PageSetting::language('title');?></th>
													<th>&nbsp;</th><th>&nbsp;</th>
												</tr>
												<?php if(isset($this->map['items'])  and  is_array($this->map['items'])){ foreach($this->map['items'] as $key2=>&$item2){if($key2!='current'){$this->map['items']['current'] = &$item2;?>
													<tr valign="middle"  style="cursor:pointer;" id="ModuleAdmin_tr_<?php echo $this->map['items']['current']['id'];?>">
														<td><input name="selected_ids[]" type="checkbox" value="<?php echo $this->map['items']['current']['id'];?>" onclick="select_checkbox(this.form,'ModuleAdmin',this,'#FFFFEC','white');" <?php if(URL::get('cmd')=='delete') echo 'checked';?>></td>
														<td nowrap align="left" onclick="location='<?php echo $this->map['items']['current']['href'];?>';">
															<?php echo $this->map['items']['current']['name'];?>
														</td>
														<td nowrap align="left" onclick="location='<?php echo $this->map['items']['current']['href'];?>';">
															<?php echo $this->map['items']['current']['package_id'];?>
														</td>
														<td align="left" onclick="location='<?php echo $this->map['items']['current']['href'];?>';">
															<?php echo $this->map['items']['current']['title'];?>
														</td>
														<td width="24px" align="center">
															<a href="<?php echo Url::build_current(array('package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'', 
																'name'=>isset($_GET['name'])?$_GET['name']:'',  
																)+array('cmd'=>'edit','id'=>$this->map['items']['current']['id'])); ?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit.gif" alt="<?php echo PageSetting::language('Edit');?>" width="12" height="12" border="0">
															</a>
														</td>
														<td width="24px" align="center">
															<a href="<?php echo Url::build('module_setting',array('module_id'=>$this->map['items']['current']['id'])); ?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>information.png" alt="<?php echo PageSetting::language('Setting');?>" width="12" height="12" border="0">
															</a>
														</td>
													</tr>
												<?php }}unset($this->map['items']['current']);} ?>
											</table>
									</td>
								</tr>
							</table>
							<input type="hidden" name="cmd" value="delete"/>
							<input type="hidden" name="page_no" value="1"/>
							<input type="hidden" name="confirm" value="1" />
										<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
