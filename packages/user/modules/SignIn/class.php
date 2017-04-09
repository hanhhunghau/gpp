<?php
class SignIn extends Module
{	
	function SignIn($row)
	{        
		Module::Module($row);        
		if(User::is_login())
		{		     
			if($data = Session::get('user_data') and $data['home_page'])
			{
				Url::redirect_url($data['home_page']);
			}
			else
			{
				Url::redirect('home');
			}
		}
		else
		{
		   	if (Session::is_set('user_id'))
        	{
        		$id=Session::get('user_id');
        		DB::update('account',array('last_online_time'=>time()),'id=\''.$id.'\'');
        		setcookie('user_id',"",time()-3600);
        		Session::destroy('user_id');
        	}
            require_once 'forms/sign_in.php';
			$this->add_form(new SignInForm);
		}

		
	}
}
?>