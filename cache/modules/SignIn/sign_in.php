<!DOCTYPE html>
<html lang="en">
<body style="background-size: cover;">
    <div role="main" class="ui-content" style="color: #fff;text-shadow: 0 0px 0 #f3f3f3;height:415px;">
		<div style="display: block;margin-left: auto;margin-right: auto; width: 200px; margin-top: -10px;">
			<form id="login" method="post" data-ajax="false" >
				<input type="text" style="" placeholder="<?php echo PageSetting::language('user_name');?>" type="text" class="inputtext" name="user_id" id="user_id" value="" ><br />
				<input type="password" style="" placeholder="<?php echo PageSetting::language('password');?>" class="inputtext" name="password" id="password"><br />
				<input onclick="" style="margin-left: 65px; margin-top: 10px;" href="#transitionExample" data-transition="slidedown" data-rel="popup" type="submit"  id="" class="ui-btn " id="sign_in" value="<?php echo PageSetting::language('login');?>" />
			<input type="hidden" name="form_block_id" value="<?php echo isset(Module::$current->data)?Module::$current->data['id']:'';?>"> 
            </form > 
             
            
		</div>
	</div>
</body>
