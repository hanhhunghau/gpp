<script type="text/javascript" src="packages/core/includes/js/table_multi_items.js">
</script>
<script src="packages/core/includes/js/ajax.js" type="text/javascript">
</script>
<script src="packages/core/includes/js/resize.js" type="text/javascript">
</script>
<script language="javascript">
table_fields = 
	{'':''
	,'id':''<!--LIST:languages-->
		,'value_[[|languages.id|]]':'text'
		<!--/LIST:languages-->,'package_id':'suggest','time':'time'
	};
field_error_messages = {};
define_select_fields = {
'':''
}
define_suggest_fields = {
'':''
,'package_id':{
'':''
<!--LIST:packages-->
,'<?php echo addslashes([[=packages.id=]]);?>':'<?php echo addslashes([[=packages.name=]]);?>'
<!--/LIST:packages-->
} 
}
define_field_actions = {
'':''
}
function update_row(index)
{
}
</script>
<?php 
$title = (URL::get('cmd')=='delete')?PageSetting::language('delete_title'):PageSetting::language('list_title');
$action = (URL::get('cmd')=='delete')?'delete':'list';
System::set_page_title(COMPANY.' - '.$title);?>
<table cellpadding="2" width="100%">
	<tr><td>
		<img alt="" src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle"/>
	</td>
	<td class="form_title" nowrap="nowrap">
		<?php echo $title;?>
	</td>
	<td width="100%">
		<table width="100%"><tr><td align="center" width="100%" nowrap="nowrap">
		[[|paging|]]
		</td></tr></table>
	</td>
	<?php 
	if(User::can_edit()and User::can_add()){?>
	<td class="form_title_button" nowrap="nowrap">
		<a  onclick="ListPackageWordForm.submit();">
			<img alt="" src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif"/>
			<br />[[.Save.]]
		</a>
	</td>
	<?php }
	if(User::can_delete()){?>
	<td class="form_title_button" nowrap="nowrap">
		<a  onclick="if(confirm('[[.delete_confirm_question.]]?')){ListPackageWordForm.cmd.value='delete';ListPackageWordForm.submit();}"><img alt="" src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" width="25" /><br />[[.Delete.]]</a></td><?php }
	?>
	</tr>
	</table>

<div class="form_bound">
	<?php if(URL::get('module_id')){
	?>
	<p>
	<a javascript:void(0)><font size="+1"><b>[[.module_words_of.]] [[|module_name|]]</b></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo URL::build_current();?>"><font size="+1">[[.all_words.]]</font></a>
	</p>
	<?php
	}?>
	<div class="form_content">
		<a name="top_anchor"></a>
		<div style="border:2px solid #FFFFFF;">
		<form name="ListPackageWordForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
		<table width="99%" cellpadding="1" cellspacing="0" border="1" bordercolor="#CCCCCC" id="main_table">
			<thead>
			<tr valign="middle" bgcolor="#EFEFEF" style="line-height:20px">
				<td width="1%" title="[[.check_all.]]">
					<input type="checkbox" value="1" id="PackageWord_all_checkbox" onclick="select_all_checkbox(this.form,'PackageWord',this.checked,'#FFFFEC','white');"<?php if(URL::get('cmd')=='delete') echo ' checked';?>></td>
				<td nowrap width="200">
					<?php Draw::title_label('id',PageSetting::language('id'));?>
				das</td>
				<!--LIST:languages-->
				<td nowrap>
					<?php Draw::title_label('value_'.[[=languages.id=]],PageSetting::language('value').'('.[[=languages.code=]].')');?>
				</td>
				<!--/LIST:languages--><td>
					<?php Draw::title_label('package_id',PageSetting::language('package_id'));?>
				</td><td nowrap width="50">
					<?php Draw::title_label('time',PageSetting::language('time'));?>
				</td>
			</tr>
			</thead>
			<tbody>
			<!--LIST:items-->
			<tr valign="middle" id="PackageWord_tr_[[|items.id|]]" onclick="edit_row(this,'[[|items.id|]]');">
				<td><input name="selected_ids[]" type="checkbox" value="[[|items.id|]]" title="[[|items.i|]]" onclick="select_checkbox(this.form,'PackageWord',this,'#FFFFEC','white');" <?php if(URL::get('cmd')=='delete') echo 'checked';?>></td>
				<td>
					<div id="id_[[|items.id|]]">[[|items.id|]]</div></td>
					<!--LIST:languages-->
					<td>
						<div class="normal_input_text" id="value_[[|languages.id|]]_[[|items.id|]]"><?php echo [[=items=]]['current']['value_'.[[=languages.id=]]];?></div>
					</td>
					<!--/LIST:languages--><td align="left"><div class="normal_input_text" id="package_id_[[|items.id|]]">[[|items.package_id|]]</div></td><td nowrap ><div class="normal_input_text" id="time_[[|items.id|]]"><?php echo date('m-d-Y',[[=items.time=]]);?></div></td>
			</tr>
			<!--/LIST:items-->
			</tbody>
		</table>
		<input type="hidden" name="edit_ids" value="0<?php foreach([[=items=]] as $id=>$item)echo ','.$id;?>"/>
		<script language="javascript">
			init_search_row();
			$('search_by_id').value = '<?php echo String::string2js(URL::get('search_by_id'));?>';
			<!--LIST:languages-->
			$('search_by_value_[[|languages.id|]]').value = '<?php echo String::string2js(URL::get('search_by_value_'.[[=languages.id=]]));?>';
			<!--/LIST:languages-->
			$('search_by_package_id').value = '<?php echo String::string2js(URL::get('search_by_package_id'));?>';
			$('search_by_time').value = '<?php echo String::string2js(URL::get('search_by_time'));?>';
		</script>
		<input type="button" value="  [[.Add.]]  " onclick="add_row();">
		</div>
		<table width="100%"><tr>
		<td width="100%">
			[[.select.]]:&nbsp;
			<a  onclick="select_all_checkbox(document.ListPackageWordForm,'PackageWord',true,'#FFFFEC','white');">[[.select_all.]]</a>&nbsp;
			<a  onclick="select_all_checkbox(document.ListPackageWordForm,'PackageWord',false,'#FFFFEC','white');">[[.select_none.]]</a>
			<a  onclick="select_all_checkbox(document.ListPackageWordForm,'PackageWord',-1,'#FFFFEC','white');">[[.select_invert.]]</a>
		</td>
		<td>
			<a name="bottom_anchor" javascript:void(0)><img src="<?php echo PageSetting::template('core');?>/images/top.gif" title="[[.top.]]" border="0" alt="[[.top.]]"></a>
		</td>
		</tr></table>
		<input type="hidden" name="cmd" value=""/>
		<input type="hidden" name="page_no" value="<?php echo URL::get('page_no');?>"/>
		<!--IF:delete(URL::get('cmd')=='delete')-->
		<input type="hidden" name="confirm" value="1" />
		<!--/IF:delete-->
		<input type="hidden" name="page_no" value="1"/>
		</form>
	</div>
</div>
<div id="suggest_box" style="position:absolute; border:1px solid black;background-color:white;display:none;"></div>
<script type="text/javascript">
document.body.onkeydown = function(evt){
	if(!evt)evt=event;
	if(default_onkeydown(evt))
	{
		if(document.all)evt.returnValue=false;
		else return false;
	}
};
function check_error()
{
	var tr = $('main_table').firstChild.nextSibling.firstChild;
	while(tr)
	{
		var div = tr.childNodes[1];
		if(div.firstChild.firstChild&&div.firstChild.firstChild.tagname)
		{
			for(var i in table_fields)
			{
				if(i)
				{
					var value = div.firstChild.firstChild.value;
					if(value!='')
					{
						if(!field_check_error(i,value,table_fields[i]))
						{
							div.firstChild.firstChild.focus();
							if(field_error_messages[i])
							{
								alert(field_error_messages[i]);
							}
							else
							{
								alert('Invalid '+i);
							}
							return false;
						}
					}
					div = div.nextSibling;
				}
			}
		}
		tr = tr.nextSibling;
	}
	return true;
}
<?php 
foreach([[=new_items=]] as $item)
{
echo 'add_row('.String::array2js(array_values($item)).');
';
}
?>
</script>