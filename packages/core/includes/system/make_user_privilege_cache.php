<?php
function get_value($value)
{
	if($value!=1)
	{
		return 0;
	}
	return $value;
}
function make_user_privilege_cache($id)
{
    $actions = array();
    $groups = array();
    $check_group = DB::fetch('SELECT id,group_id FROM account_related WHERE child_id=\''.$id.'\'');
	$sql = '	
		SELECT
            privilege_module.id,
            privilege_module.privilege_id,
			privilege_module.module_id,
			category.structure_id,
			privilege_module.can_view,
			privilege_module.can_view_detail,
			privilege_module.can_add,
			privilege_module.can_edit,
			privilege_module.can_delete,
			privilege_module.can_special,
			privilege_module.can_admin,
			privilege_module.can_reserve,
			category.name_1
			
		FROM
			privilege_module
            inner join account_privilege on account_privilege.privilege_id = privilege_module.privilege_id
            inner join privilege on privilege_module.privilege_id = privilege.id
             
            inner join category on account_privilege.category_id = category.id
		WHERE 
			category.status<>\'HIDE\' and category_id <> 0 
			AND account_privilege.account_id=\''.$check_group['group_id'].'\'
		
	';
	$user_actions = DB::fetch_all($sql);
    
	foreach($user_actions as $user_action)
	{
	    if($byte_cache = bindec(get_value($user_action['can_view']).get_value($user_action['can_view_detail']).get_value($user_action['can_add']).get_value($user_action['can_edit']).get_value($user_action['can_delete']).get_value($user_action['can_special']).get_value($user_action['can_reserve']).get_value($user_action['can_admin'])))
        {
            $actions[0][$user_action['module_id']][$user_action['structure_id']]=$byte_cache;
        }	
	  
	}
    $sql = '	
		SELECT
			privilege_module.id,
			privilege_module.module_id,
			category.structure_id,
			privilege_module.can_view,
			privilege_module.can_view_detail,
			privilege_module.can_add,
			privilege_module.can_edit,
			privilege_module.can_delete,
			privilege_module.can_special,
			privilege_module.can_admin,
			privilege_module.can_reserve,
			category.name_1
			
		FROM
			privilege_module
            inner join account_privilege on account_privilege.privilege_id = privilege_module.privilege_id 
            inner join category on account_privilege.category_id = category.id 
		WHERE 
			category_id <> 0 and category.status<>\'HIDE\'
		
			AND (account_privilege.account_id=\''.$id.'\' or account_privilege.account_id=\'guest\')
		
	';
	$user_actions = DB::fetch_all($sql);
    
	foreach($user_actions as $user_action)
	{
        if(isset($actions[0][$user_action['module_id']][$user_action['structure_id']])){
            
            $check = str_split(decbin($actions[0][$user_action['module_id']][$user_action['structure_id']]));
        if($user_action['can_view']==1 || $check[0]==1){$privilege_module['can_view'] = 1;}else{$privilege_module['can_view'] = 0;}
        if($user_action['can_view_detail']==1 || $check[1]==1){$privilege_module['can_view_detail'] = 1;}else{$privilege_module['can_view_detail'] = 0;}
        if($user_action['can_add']==1 || $check[2]==1){$privilege_module['can_add'] = 1;}else{$privilege_module['can_add'] = 0;}
        if($user_action['can_edit']==1 || $check[3]==1){$privilege_module['can_edit'] = 1;}else{$privilege_module['can_edit'] = 0;}
        if($user_action['can_delete']==1 || $check[4]==1){$privilege_module['can_delete'] = 1;}else{$privilege_module['can_delete'] = 0;}
        if($user_action['can_reserve']==1 || $check[5]==1){$privilege_module['can_reserve'] = 1;}else{$privilege_module['can_reserve'] = 0;}
        if($user_action['can_special']==1 || $check[6]==1){$privilege_module['can_special'] = 1;}else{$privilege_module['can_special'] = 0;}
        if($user_action['can_admin']==1 || $check[7]==1){$privilege_module['can_admin'] = 1;}else{$privilege_module['can_admin'] = 0;}
        if($byte_cache = bindec(get_value($privilege_module['can_view']).get_value($privilege_module['can_view_detail']).get_value($privilege_module['can_add']).get_value($privilege_module['can_edit']).get_value($privilege_module['can_delete']).get_value($privilege_module['can_special']).get_value($privilege_module['can_reserve']).get_value($privilege_module['can_admin'])))
		{
			$actions[0][$user_action['module_id']][$user_action['structure_id']]=$byte_cache;
		}	
        }else{
            if($byte_cache = bindec(get_value($user_action['can_view']).get_value($user_action['can_view_detail']).get_value($user_action['can_add']).get_value($user_action['can_edit']).get_value($user_action['can_delete']).get_value($user_action['can_special']).get_value($user_action['can_reserve']).get_value($user_action['can_admin'])))
		      {
			     $actions[0][$user_action['module_id']][$user_action['structure_id']]=$byte_cache;
		      }	
        }
       	
	}
	$groups = DB::fetch_all('
		SELECT
			parent_id as id
		FROM
			account_related
		WHERE	
			child_id=\''.$id.'\'
	');
	$code = '$this->groups='.str_replace("'",'"',var_export($groups,true)).';'.
		'$this->actions='.str_replace("'",'"',var_export($actions,true)).';';
	$file_path = 'cache/user/'.$id.'.php';
	$file = fopen($file_path,'w+');
	fwrite($file,$code);
	fclose($file);
	DB::update('account_related',array('check_group'=>1),'child_id = \''.$id.'\'');
	return $code;
}
?>