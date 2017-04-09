<?php 
$title = (URL::get('cmd')=='delete')?PageSetting::language('delete_title'):PageSetting::language('list_title');
$action = (URL::get('cmd')=='delete')?'delete':'list';?>
<div id="title_region"></div>
<div class="form_bound">
<table cellpadding="10" width="100%">
	<tr>
    	<td class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td>
		<?php if(URL::get('cmd')=='delete'){?><td width="1%" nowrap="nowrap" class="form_title_button"><a  onclick="ListpageAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" style="text-align:center" width="24px" height="24px" alt=""/><br /><?php echo PageSetting::language('Delete');?></a></td>
        <td width="1%" nowrap="nowrap" class="form_title_button"><a href="<?php echo URL::build_current(array('package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'', 'name'=>isset($_GET['name'])?$_GET['name']:''));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif" style="text-align:center" alt=""/><br /><?php echo PageSetting::language('back');?></a></td><?php }else{ 
		 
		{?><td width="1%" nowrap="nowrap" class="form_title_button"><a href="<?php echo URL::build_current(array('package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'', 'name'=>isset($_GET['name'])?$_GET['name']:'')+array('cmd'=>'add'));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>add_button.gif" style="text-align:center"  width="24px" height="24px" alt=""/><br /><?php echo PageSetting::language('Add');?></a></td>
        <?php }?>
		<?php {?><td width="1%" nowrap="nowrap" class="form_title_button">
				<a  onclick="ListpageAdminForm.cmd.value='delete';ListpageAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" width="24px" height="24px" alt=""/><br /><?php echo PageSetting::language('Delete');?></a></td><?php }}?>
				</tr></table>
	<div class="form_content">
	<table cellspacing="0" width="100%">
	<tr bgcolor="#EFEFEF" valign="top">
		<td nowrap bgcolor="#EFEFEF">
			<table width="100%" cellpadding="0" cellspacing="0" class="home-item-category-tree">
			<?php if(isset($this->map['packages'])  and  is_array($this->map['packages'])){ foreach($this->map['packages'] as $key1=>&$item1){if($key1!='current'){$this->map['packages']['current'] = &$item1;?>
			<tr>
			  <td nowrap>
				<a href="<?php echo URL::build_current();?>&package_id=<?php echo $this->map['packages']['current']['id'];?>" ><?php echo $this->map['packages']['current']['name'];?></a>
			</td>
			</tr>
			<?php }}unset($this->map['packages']['current']);} ?>
			</table>
			<a target="_blank" href="<?php echo Url::build('package');?>" class="category_level1"><?php echo PageSetting::language('packages/admin');?></a>  
		</td>
		<td width="100%">
			<table bgcolor="#EFEFEF" cellspacing="0" width="100%">
			<tr>
				<td width="100%">
					<form method="post" name="SearchpageAdminForm" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
					<?php echo PageSetting::language('name');?>: <input  name="name" id="name" style="width:200" type ="text" value="<?php echo String::html_normalize(URL::get('name'));?>"> <?php echo PageSetting::language('portal');?>: <input  name="portal_id" id="portal_id" style="width:120" type ="text" value="<?php echo String::html_normalize(URL::get('portal_id'));?>">  <input type="submit" value="<?php echo PageSetting::language('search');?>">
					<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
					<form name="ListpageAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
					<a name="top_anchor"></a>
					<div style="border:2px solid #FFFFFF;">
					<table width="99%" cellpadding="2" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#CCCCCC">
					
						<tr valign="middle" bgcolor="#EFEFEF" style="line-height:20px">
							<th width="1%" title="<?php echo PageSetting::language('check_all');?>"><input type="checkbox" value="1" id="pageAdmin_all_checkbox" onclick="select_all_checkbox(this.form, 'pageAdmin',this.checked,'#FFFFEC','white');"<?php if(URL::get('cmd')=='delete') echo ' checked';?>></th>
							<th>&nbsp;</th>
							<th nowrap align="left" >
								<a href="<?php echo URL::build_current(((URL::get('order_by')=='page.name' and URL::get('order_dir')!='desc')?array('order_dir'=>'desc'):array())+array('order_by'=>'page.name'));?>" title="<?php echo PageSetting::language('sort');?>">
								<?php if(URL::get('order_by')=='page.name') echo '<img src="'.PageSetting::template('core').'/images/buttons/'.((URL::get('order_dir')!='desc')?'down':'up').'_arrow.gif" alt="">';?>								<?php echo PageSetting::language('name');?>
								</a>
							</th>
							<th nowrap align="left">
								<a title="<?php echo PageSetting::language('sort');?>" href="<?php echo URL::build_current(((URL::get('order_by')=='page.TITLE_'.PageSetting::language() and URL::get('order_dir')!='desc')?array('order_dir'=>'desc'):array())+array('order_by'=>'page.TITLE_'.PageSetting::language()));?>" >
								<?php if(URL::get('order_by')=='page.TITLE_'.PageSetting::language()) echo '<img src="'.PageSetting::template('core').'/images/buttons/'.((URL::get('order_dir')!='desc')?'down':'up').'_arrow.gif" alt="">';?>								<?php echo PageSetting::language('title');?>
								</a>
							</th>
							<th nowrap align="left">
								<a href="<?php echo URL::build_current(((URL::get('order_by')=='package_id' and URL::get('order_dir')!='desc')?array('order_dir'=>'desc'):array())+array('order_by'=>'package_id'));?>" title="<?php echo PageSetting::language('sort');?>">
								<?php if(URL::get('order_by')=='package_id') echo '<img src="'.PageSetting::template('core').'/images/buttons/'.((URL::get('order_dir')!='desc')?'down':'up').'_arrow.gif" alt="">';?>								<?php echo PageSetting::language('package_id');?>
								</a>
							</th>
							
							<?php 
							{
							?><th>&nbsp;</th><th>&nbsp;</th><?php
							}?>						</tr>
						<?php if(isset($this->map['items'])  and  is_array($this->map['items'])){ foreach($this->map['items'] as $key2=>&$item2){if($key2!='current'){$this->map['items']['current'] = &$item2;?>
						<tr bgcolor="<?php if((URL::get('just_edited_id',0)==$this->map['items']['current']['id']) or (is_numeric(array_search($this->map['items']['current']['id'],$this->map['just_edited_ids'])))){ echo '#EFFFDF';} else {echo $this->map['items']['current']['is_sibling']?'#FFFFDF':'white';}?>" valign="middle" style="cursor:pointer;" id="pageAdmin_tr_<?php echo $this->map['items']['current']['id'];?>">
							<td><input name="selected_ids[]" type="checkbox" value="<?php echo $this->map['items']['current']['id'];?>" onclick="select_checkbox(this.form,'pageAdmin',this,'#FFFFEC','white');" <?php if(URL::get('cmd')=='delete') echo 'checked';?>></td>
							<td><a target="_blank" href="<?php echo URL::build($this->map['items']['current']['name']);?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>select.jpg" /></a></td>
							<td nowrap align="left" onclick="location='<?php echo $this->map['items']['current']['href'];?>';">
									<?php echo $this->map['items']['current']['name'];?>
							</td>
							<td align="left" onclick="location='<?php echo $this->map['items']['current']['href'];?>';">
								<?php echo $this->map['items']['current']['name'];?>
							</td>
							<td nowrap align="left" onclick="location='<?php echo $this->map['items']['current']['href'];?>';">
								<?php echo $this->map['items']['current']['package_id'];?>
							</td>
							<?php 
							
							{
							?>							<td width="24px" align="center">
								<a href="<?php echo Url::build_current(array('package_id'=>isset($_GET['package_id'])?$_GET['package_id']:'',  
	'name'=>isset($_GET['name'])?$_GET['name']:'',    
	  )+array('cmd'=>'edit','id'=>$this->map['items']['current']['id'])); ?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit.gif" alt="<?php echo PageSetting::language('Edit');?>" width="12" height="12" border="0"></a></td>
	  						<td nowrap><a href="<?php echo Url::build_current(array('package_id', 'name')+array('cmd'=>'duplicate','id'=>$this->map['items']['current']['id'])); ?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>duplicate.gif" alt="<?php echo PageSetting::language('duplicate');?>" width="13" height="13" border="0"></a></td>
							<?php
							}
							?>						</tr>
						<?php }}unset($this->map['items']['current']);} ?>
					</table>
					
					<input type="hidden" name="cmd" value="delete"/>
<input type="hidden" name="page_no" value="1"/>
<?php  
                if((URL::get('cmd')=='delete')) 
                {?>
					<input type="hidden" name="confirm" value="1" />
					 
                <?php 
                } 
                ?>
					<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
				</td>
			</tr>
			</table>
			
			
		</td>
</tr>
	</table>	
	</div>
</div>
