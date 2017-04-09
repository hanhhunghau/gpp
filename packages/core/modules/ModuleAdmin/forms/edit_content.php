<?php
class EditModuleContentAdminForm extends Form
{
	function EditModuleContentAdminForm()
	{
		Form::Form('EditModuleContentAdminForm');
		$this->add('id',new IDType(true,'object_not_exists','module'));
		$this->add('path',new TextType(true,'invalid_path',0,2550000)); 
		$this->add('content',new TextType(true,'invalid_content',0,2550000)); 
	}
	function on_submit()
	{
		if($this->check() and URL::get('confirm_edit'))
		{
			if(Url::get('create_file')){
				$path = Url::get('file');
				if(preg_match('/.php$/',$path)){
					if(!file_exists($path)){
						$content =  'Empty file';
						$f = fopen($path,'w+');
						fwrite($f,$content);
						fclose($f);
					}
					Url::redirect_current(array('id','cmd','path'=>$path));
				}else{
					if (!mkdir($path, 0, true)) {
						die('Failed to create folders...');
					}
					Url::redirect_current(array('id','cmd','path'=>'index.php'));
				}
			}elseif(Url::get('upload_file')){
				$to_folder = Url::get('to_folder');
				if(is_dir($to_folder)){
					$temp = preg_split('/[\/\\\\]+/', $_FILES['from_file']['name']);
					$file_name = $temp[0];
					$ext = substr($file_name,strrpos($file_name,'.')+1);
					move_uploaded_file($_FILES['from_file']['tmp_name'],$to_folder.'/'.$file_name);
					if($ext == 'php'){
						Url::redirect_current(array('id','cmd','path'=>$to_folder.'/'.$file_name));				
					}else{
						Url::redirect_current(array('id','cmd','path'=>'index.php'));	
					}
				}
			}elseif(Url::get('execute_sql')){
				$sql = Url::get('sql_statement');
				if(DB::query($sql)){
					echo '<script>alert("Thuc hien SQL thanh cong");</script>';
				}
			}else{
				$path = Url::get('path');
				$content =  Url::get('content');
				$f = fopen($path,'w+');
				fwrite($f,$content);
				fclose($f);
				Url::redirect_current(array('id','cmd','path'));
			}
		}
	}	
	function draw()
	{	
		if($row=DB::select('module',URL::sget('id')))
		{
			if(!isset($_REQUEST['path']) or $_REQUEST['path']==''){
				$_REQUEST['path'] = 'index.php';
			}
			if(file_exists(Url::get('path'))){
				$content = file_get_contents(Url::get('path'));
			}else{
				$content = 'file does not exists';
			}
			$row['content'] = $content;
			$this->parse_layout('edit_content',$row);
		}
	}
}
?>