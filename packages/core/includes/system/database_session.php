<?php 
class Session{
	static $name;
	static $vars;
	static $init_vars;
	static function getIP() {
		return session_id();
	}
	static function start(){
		Session::$init_vars = var_export(Session::$vars,true);
		if(!Session::$name){
			Session::$name = md5(Session::getIP());
		}
		$vars = DB::fetch('SELECT VARS FROM session_user WHERE SESSION_ID=\''.addslashes(Session::$name).'\'','vars');
		
		if($vars){
			eval('Session::$vars = '.$vars.';');
		}else{
			if(Session::is_set('user_id')){
				$id = Session::get('user_id');
				Session::delete('user_id');
			}
		}
		
	}
	static function name($name = false){
		if($name){
			Session::$name = $name;
		}
		return Session::$name;
	}
	static function get($name, $field=false){
       
		if(isset(Session::$vars[$name])){
			if($field){
				if(isset(Session::$vars[$name][$field])){
					return Session::$vars[$name][$field];
				}
				return false;
			}
			return Session::$vars[$name];
		}
	}
	static function set($name,$value){
		Session::$vars[$name] = $value;
	}
    
	static function is_set($name, $field=false){
		if($field){
			return isset(Session::$vars[$name]) and isset(Session::$vars[$name][$field]);
		}
		return isset(Session::$vars[$name]);
	}
	static function delete($name, $field=false){
		if($field){
			if(isset(Session::$vars[$name][$field])){
				unset(Session::$vars[$name][$field]);
			}
		}else{
			if(isset(Session::$vars[$name])){
				unset(Session::$vars[$name]);
			}
		}
		Session::destroy();//DB::delete('session_user','SESSION_ID = \''.Session::$name.'\''); //khoand sua
	}
	static function end(){
		/*DB::query('
			DELETE FROM
				session_user
			WHERE
				(last_active_time IS NULL OR last_active_time < '.(time()-(4*3600)).')
		');*/
		$vars = var_export(Session::$vars,1);
		if(Session::$init_vars != $vars){
			if($session=DB::select('session_user','SESSION_ID=\''.addslashes(Session::$name).'\'')){
				
			}
		}
	}
	static function destroy(){
		DB::delete('session_user','SESSION_ID=\''.addslashes(Session::$name).'\'');
		DB::delete('session_user','USER_ID=\''.Session::get('user_id').'\'');
	}
}
Session::start();
?>