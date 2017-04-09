<?php 
$title = (URL::get('cmd')=='delete')?PageSetting::language('delete_title'):PageSetting::language('list_title');
$action = (URL::get('cmd')=='delete')?'delete':'list';?>
<div class="form_bound">
<table cellpadding="10" width="100%">
	<tr valign="bottom">
    	<td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td><?php 
	if(URL::get('cmd')=='delete'){?><td width="1%" nowrap="nowrap" class="form_title_button"><a  onclick="ListPackageAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" style="text-align:center" alt=""/><br />[[.Delete.]]</a></td>
	<td class="form_title_button" width="1%" nowrap="nowrap"><a href="<?php echo URL::build_current(array('name'=>isset($_GET['name'])?$_GET['name']:''));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif" style="text-align:center" alt=""/><br />[[.back.]]</a></td><?php }
	else{ {?><td width="1%" nowrap="nowrap" class="form_title_button"><a href="<?php echo URL::build_current(array(	'name'=>isset($_GET['name'])?$_GET['name']:'')+array('cmd'=>'add'));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>add_button.gif" style="text-align:center" alt=""/><br />[[.Add.]]</a></td><?php }?><?php 
	{?><td width="1%" nowrap="nowrap" class="form_title_button"><a href="<?php echo URL::build_current(array('cmd'=>'make_library_cache'));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>make_cache_button.gif" style="text-align:center"/><br />[[.make_cache.]]</a></td>
	<td width="1%" nowrap="nowrap" class="form_title_button"><a href="<?php echo URL::build_current(array('cmd'=>'delete_cache'));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_cache_button.gif" style="text-align:center"/><br />[[.delete_module_cache.]]</a></td><?php }?><?php 
	{?><td width="1%" nowrap="nowrap" class="form_title_button">
				<a  onclick="ListPackageAdminForm.cmd.value='delete';ListPackageAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" alt=""/><br />[[.Delete.]]</a></td><?php }}?>
				<td width="1%" nowrap="nowrap" class="form_title_button">
				<a  href="<?php echo URL::build('default');?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>frontpage.gif" alt=""/><br />Trang ch&#7911;</a></td></tr></table>
		
	<table cellspacing="0" width="100%">
	<tr bgcolor="#EFEFEF" valign="top">
		<td width="100%">
			<table bgcolor="#EFEFEF" cellspacing="0" width="100%">
			<tr>
				<td width="100%">
					<form method="post" name="SearchPackageAdminForm" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
					<table>
						<tr><td align="right" nowrap style="font-weight:bold">[[.name.]]</td>
						<td>:</td>
						<td nowrap>
							<input type="hidden" name="page_no" value="1" />
							<input name="name" type="text" id="name" style="width:200"><input type="submit" value="   [[.search.]]   ">
						</td></tr>
					</table>
					</form>
					<form name="ListPackageAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
					<a name="top_anchor"></a>
					<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
					
						<tr valign="middle" bgcolor="#EFEFEF" style="line-height:20px">
							<th width="1%" title="[[.check_all.]]"><input type="checkbox" value="1" id="PackageAdmin_all_checkbox" onclick="select_all_checkbox(this.form, 'PackageAdmin',this.checked,'#FFFFEC','white');"<?php if(URL::get('cmd')=='delete') echo ' checked';?>></th>
							<th nowrap align="left" >
								<a href="<?php echo URL::build_current(((URL::get('order_by')=='package.name' and URL::get('order_dir')!='desc')?array('order_dir'=>'desc'):array())+array('order_by'=>'package.name'));?>" title="[[.sort.]]">
								<?php if(URL::get('order_by')=='package.name') echo '<img src="'.PageSetting::template('core').'/images/buttons/'.((URL::get('order_dir')!='desc')?'down':'up').'_arrow.gif" alt="">';?>								[[.name.]]
								</a>
							</th><th nowrap align="left">
								<a title="[[.sort.]]" href="<?php echo URL::build_current(((URL::get('order_by')=='package.title_'.PageSetting::language() and URL::get('order_dir')!='desc')?array('order_dir'=>'desc'):array())+array('order_by'=>'package.title_'.PageSetting::language()));?>" >
								<?php if(URL::get('order_by')=='package.title_'.PageSetting::language()) echo '<img src="'.PageSetting::template('core').'/images/buttons/'.((URL::get('order_dir')!='desc')?'down':'up').'_arrow.gif" alt="">';?>								[[.title.]]
								</a>
							</th>
							<th>&nbsp;</th>
							<?php 
							{
							?><th>&nbsp;</th><?php
							}?>							<?php 
							{?>							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<?php }?>						</tr>
						<!--LIST:items-->
						<tr bgcolor="<?php if((URL::get('just_edited_id',0)==[[=items.id=]]) or (is_numeric(array_search(MAP['items']['current']['id'],MAP['just_edited_ids'])))){ echo '#EFFFDF';} else {echo 'white';}?>" valign="middle" <?php Draw::hover('#E2F1DF');?> style="cursor:pointer;" id="PackageAdmin_tr_[[|items.id|]]">
							<td><input name="selected_ids[]" type="checkbox" value="[[|items.id|]]" onclick="select_checkbox(this.form,'PackageAdmin',this,'#FFFFEC','white');" <?php if(URL::get('cmd')=='delete') echo 'checked';?>></td>
							<td nowrap align="left" onclick="location='<?php echo URL::build_current();?>&cmd=edit&id=[[|items.id|]]';">
									
									<span class="page_indent">&nbsp;</span>
									[[|items.name|]]
								</td>
							<td nowrap align="left" onclick="location='<?php echo URL::build_current();?>&cmd=edit&id=[[|items.id|]]';">
									[[|items.title|]]
								</td>
								<td nowrap align="left" onclick="location='<?php echo URL::build_current();?>&cmd=edit&id=[[|items.id|]]';">
									[[|items.type|]]
								</td>
							    <?php 
							
							{
							?>	<td width="24px" align="center">
								<a href=" <?php echo Url::build_current(array(
	'name'=>isset($_GET['name'])?$_GET['name']:'', 
	  )+array('cmd'=>'edit','id'=>[[=items.id=]])); ?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit.gif" alt="[[.Edit.]]" width="12" height="12" border="0"></a></td>
							<?php
							}
							?>							<td width="24px" align="center"></td>
							<td width="24px" align="center"></td>
						</tr>
						<!--/LIST:items-->
					</table>
					
					<input type="hidden" name="cmd" value="delete"/>
<input type="hidden" name="page_no" value="1"/>
<!--IF:delete(URL::get('cmd')=='delete')-->
					<input type="hidden" name="confirm" value="1" />
					<!--/IF:delete-->
					</form>
				</td>
			</tr>
			</table>
			<table width="100%"><tr>
			<td width="100%">
				[[.select.]]:&nbsp;
				<a  onclick="select_all_checkbox(document.ListPackageAdminForm,'PackageAdmin',true,'#FFFFEC','white');">[[.select_all.]]</a>&nbsp;
				<a  onclick="select_all_checkbox(document.ListPackageAdminForm,'PackageAdmin',false,'#FFFFEC','white');">[[.select_none.]]</a>
				<a  onclick="select_all_checkbox(document.ListPackageAdminForm,'PackageAdmin',-1,'#FFFFEC','white');">[[.select_invert.]]</a>
			</td>
			<td>
				<a name="bottom_anchor" javascript:void(0)><img src="<?php echo PageSetting::template('core');?>/images/top.gif" title="[[.top.]]" border="0" alt="[[.top.]]"></a>
			</td>
			</tr></table>
			
		</td>
</tr>
	</table>	
</div>