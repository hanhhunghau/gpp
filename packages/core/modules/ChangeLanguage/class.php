<?php
class ChangeLanguage extends Module
{
	function ChangeLanguage($row)
	{
		Module::Module($row);
		if(Url::get('language_id')){
			if($item = DB::fetch('SELECT id FROM language WHERE id = '.Url::iget('language_id'))){
				DB::update('session_user',array('language_id'=>Url::iget('language_id')),'user_id = \''.Session::get('user_id').'\'');
				if(URL::get('href'))
				{
					URL::redirect_url(urldecode(Url::get('href')));	
				}
				else
				{
					URL::redirect('room_map');
				}
			}
		}

	}
}
?>
