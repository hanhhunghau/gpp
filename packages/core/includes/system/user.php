<?php
define('CURRENT_CATEGORY',1);
define('ANY_CATEGORY',2);
class User{
	var $groups = array();
	var $privilege = array();
	var $actions = array();
	var $settings = array();
	static $current=true;
	function User($id=false){
		if(!$id){		
			if(!Session::is_set('user_id'))
			{
				Session::set('user_id','guest');
			}
			if($this->data=DB::fetch('SELECT * FROM account WHERE ID=\''.Session::get('user_id').'\''))
			{
				$check_group = DB::fetch('SELECT id,check_group FROM account_related WHERE child_id=\''.Session::get('user_id').'\'');
				if(!file_exists('cache/user/'.$this->data['id'].'.php') || $check_group['check_group']==0)
                {
					require_once 'packages/core/includes/system/make_user_privilege_cache.php';
					eval(make_user_privilege_cache(Session::get('user_id')));
				}
				else
				{
					$file_path = 'cache/user/'.$this->data['id'].'.php';
					$privilege_user_file_content = file_get_contents($file_path);
					eval($privilege_user_file_content);
				}				
				if(!$this->data['cache_setting'])
				{
					
				}
				else
				{
					
				}
			}
		}
	}
	static function is_login(){
		if((Session::is_set('user_id') and DB::exists_id('account',Session::get('user_id')) and DB::exists('SELECT id FROM session_user WHERE user_id = \''.Session::get('user_id').'\'') and Session::get('user_id')!='guest')){
			return true;
		}else{
			return false;
		}
	}
	function is_online($id){
		$row=DB::select('account', 'ID=\''.$id.'\' and LAST_ONLINE_TIME>'.(time()-600));
		if ($row)
		{
			return true;
		}
		return false;
	}
	static function encode_password($password){
		return md5($password.'htnq');
	}
	function is_in_group($user_id,$group_id){
		$row=DB::select('USER_GROUP',' USER_ID=\''.$user_id.'\' and GROUP_ID=\''.$group_id.'\'');
		if ($row or User::is_admin())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function groups(){	
		return $this->groups;
	}
	function home_page(){
		if(User::$current and User::$current->groups)
		{
			$group = reset(User::$current->groups);
			if($group['home_page']=='')
			{
				$group['home_page'] = URL::build('home');
			}
			return $group['home_page'];
		}
		return URL::build('home');
	}
	function is_admin_user(){
		if($this->data['id']=='admin'
			|| strtolower($this->data['id'])=='administrator'
		){	      
           return true;
		}       
		return isset($this->groups[5]);
	}
	static function is_admin()	{  
		if(isset(User::$current))
		{
			return User::$current->is_admin_user();
		}
	}	
}
User::$current = new User();
if(!Session::is_set('user_id') and isset($_COOKIE['user_id'])and $_COOKIE['user_id'])
{
	setcookie('user_id',"",time()-3600);
}
?>