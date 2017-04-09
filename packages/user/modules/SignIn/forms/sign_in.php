<?php 
class SignInForm extends Form{
	function SignInForm(){
		Form::Form('SignInForm');
	}
    
	function on_submit(){
		echo "ffffffffff";die();
	}
	
	function draw()
	{	  
	   $this->parse_layout('sign_in');
	}
} ?>