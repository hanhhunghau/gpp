<?php
function get_dir($dir)
{
	if(is_dir(ROOT_PATH.$dir))
	{
		return $dir;
	}
	else
	{
		$new_dir = mkdir(ROOT_PATH.$dir);
		return $dir;
	}
}
function make_dir($name)
{
	if(!is_dir($name))
	{
		@mkdir($name);
	}
	return $name;
}
function write_file($filename,$content){	
	if(is_writable($filename)){
	   if(!$handle = fopen($filename, 'w')){
			echo "Cannot open file ($filename)";
			exit;
	   }
	   if(fwrite($handle, $content) === FALSE){
		   echo "Cannot write to file ($filename)";
		   exit;
	   }
	   fclose($handle);	
	}else{
	   echo "The file $filename is not writable";
	}
}
function update_upload_file($field, $dir,$old_file=false,$new_width=false,$new_height=false, $constraint=false)
{
	if(isset($_FILES[$field]) and $_FILES[$field]['name'])
	{
		if($old_file and file_exists($old_file))
		{
			$_REQUEST[$field] = $old_file;
		}
		else
		{
			if(file_exists('resources/'.$dir.'/'.$_FILES[$field]['name']))
			{
				$new_name = 'resources/'.$dir.'/'.time().'_'.$_FILES[$field]['name'];
			}
			else
			{
				$new_name = 'resources/'.$dir.'/'.$_FILES[$field]['name'];
			}
			$_REQUEST[$field] = $new_name;
		}
		if(move_uploaded_file($_FILES[$field]['tmp_name'],$_REQUEST[$field]))
		{
			if($new_width and $new_height)
			{
				create_thumb($_REQUEST[$field],$_REQUEST[$field],$new_width,$new_height, $constraint);
			}
		}
		else
		{
			$_REQUEST[$field] = '';
		}
		return $new_name;
	}
}
//upload excel pdf
function update_upload_doc($field,$dir,$allowedExts=array(),$old_file=false,$new_width=false,$new_height=false, $constraint=false)
{
    //$allowedExts = array("jpg", "jpeg", "gif", "png");
    $ref = explode(".", $_FILES[$field]["name"]);
    $extension = end($ref);
    if (in_array($extension, $allowedExts))
    {
        if(isset($_FILES[$field]) and $_FILES[$field]['name'])
        {
    		if($old_file and file_exists($old_file))
    		{
    			$_REQUEST[$field] = $old_file;
    		}
    		else
    		{
    			if(file_exists('resources/'.$dir.'/'.$_FILES[$field]['name']))
    			{
    				$new_name = 'resources/'.$dir.'/'.time().'_'.$_FILES[$field]['name'];
    			}
    			else
    			{
    				$new_name = 'resources/'.$dir.'/'.$_FILES[$field]['name'];
    			}
    			$_REQUEST[$field] = $new_name;
    		}
    		if(move_uploaded_file($_FILES[$field]['tmp_name'],$_REQUEST[$field]))
    		{
    			if($new_width and $new_height)
    			{
    				create_thumb($_REQUEST[$field],$_REQUEST[$field],$new_width,$new_height, $constraint);
    			}
            }
    		else
    		{
    			$_REQUEST[$field] = '';
    		}
    		return $new_name;
	   }
    }
    else
    {
        return false;
    }
}
function update_mi_upload_file($table, $field, $dir)
{
	if(isset($_REQUEST['mi_'.$table]))
	{
		foreach($_REQUEST['mi_'.$table] as $key=>$record)
		{
			if(isset($_FILES['mi_'.$table.'_'.$field.'_'.$key]) and $_FILES['mi_'.$table.'_'.$field.'_'.$key]['name'])
			{
				$_REQUEST['mi_'.$table][$key][$field] = 'images/'.$dir.'/'.time().$_FILES['mi_'.$table.'_'.$field.'_'.$key]['name'];
				move_uploaded_file($_FILES['mi_'.$table.'_'.$field.'_'.$key]['tmp_name'],$_REQUEST['mi_'.$table][$key][$field]);
				
			}
		}
	}
}
function image_open($image_url)
{
	if(!($image = @imagecreatefromgif($image_url)))
	{
		if(!($image = @imagecreatefromjpeg($image_url)))
		{
			if(!($image = @imagecreatefrompng($image_url)))
			{
				if(!($image = @imagecreatefromwbmp($image_url)))
				{
					return false;
				}
			}
		}
	}
	return $image;
}
function create_thumb($image,$new_image,$new_width,$new_height, $constraint=false)
{

	$new_image;
	$source = image_open($image);
	$width=imagesx($source);
	$height=imagesy($source);
	// Load
	if($constraint)
	{
		$y1 = 0;
		$y2 = $height;
		$x1 = 0;
		$x2 = $width;
		if($width/$new_width>$height/$new_height)
		{
			$new_width = $width*$new_height/$height;
		}
		else
		{
			$new_height = $height*$new_width/$width;
		}
	}
	$thumb = imagecreatetruecolor($new_width, $new_height);
	imagefill($thumb,1,1,ImageColorAllocate( $thumb, 255, 255, 255 ) );
	if(!$constraint)
	{
		if($width/$new_width>$height/$new_height)
		{
			$y1 = 0;
			$y2 = $height;
			$x1 = ($width-($new_width*$height/$new_height))/2;
			$x2 = $width-2*$x1;
		}
		else
		{
			$x1 = 0;
			$x2 = $height;
			$y1 = ($height-($new_height*$width/$new_width))/2;
			$y2 = $height-2*$y1;
		}
	}
	// Resize
	imagecopyresized($thumb, $source, 0, 0, $x1, $y1, $new_width, $new_height, $x2-$x1, $y2-$y1);
	// Output
	if(file_exists($new_image))
	{
		@unlink($new_image);
	}
	imagejpeg($thumb,$new_image,100);
}


//ham xu ly upload anh? - 7A
function update_upload_image($field, $dir, $iname, $old_file=false,$new_width=false,$new_height=false, $constraint=false)
{
	if(isset($_FILES['file_'.$field]) and $_FILES['file_'.$field]['name'])
	{
		//kiem tra dung luong
		if ($_FILES['file_'.$field]['size'] > 1024*1024)
		{
			//thong bao loi
			return 'K&#237;ch th&#432;&#7899;c file upload kh&#244;ng h&#7907;p l&#7879;!';
		}
		//kiem tra dinh dang anh
		$temp = preg_split('/[\/\\\\]+/', $_FILES['file_'.$field]['name']);
		$filename = $temp[count($temp)-1];
		if (!preg_match('/\.(gif|jpg)$/i',$filename))
		{
			//thong bao loi
			return '&#272;&#7883;nh d&#7841;ng file upload kh&#244;ng ph&#7843;i l&#224; GIF ho&#7863;c JPG!';
		}

		if($old_file and file_exists($old_file))
		{
			$_REQUEST[$field] = $old_file;
		}
		else
		{
			$new_name = $dir.'/'.$iname;
			$_REQUEST[$field] = $new_name;
		}
		if(move_uploaded_file($_FILES['file_'.$field]['tmp_name'],$_REQUEST[$field]))
		{
			return '0';
			if($new_width and $new_height)
			{
				create_thumb($_REQUEST[$field],$_REQUEST[$field],$new_width,$new_height, $constraint);
			}
		}
		else
		{
			return 'Kh&#244;ng upload &#273;&#432;&#7907;c file';
			$_REQUEST[$field] = '';
		}
	}
	return '0';
}

/**
 * Upload ảnh trong mi
 * $table: tên mi_..
 * $xxxx: mi thứ bao nhiều
 * $field tên của mi (có type = file)
 * $dir : thư mục chứa ảnh
 * $separator_folder : mỗi ảnh có lưu vào 1 folder ko?
 * $field_folder_name : tên của mi dùng để lấy dữ liệu làm tên folder ví dụ id => record['id'] lấy làm tên folder
 * $repalce_image : trùng tên thì xóa ảnh, nếu ko thì thêm biến time()
 * $new_width, $new_height : cỡ ảnh mới
 * $constraint = true: giữ ng tỉ lệ ảnh
 */
function update_mi_upload_image($table, $xxxx, $field, $dir,$separator_folder=false, $field_folder_name=false,$repalce_image=true,$new_width=false,$new_height=false, $constraint=true)
{
	if(isset($_REQUEST['mi_'.$table]))
	{
		if(isset($_FILES['mi_'.$table]['name'][$xxxx][$field]) and $_FILES['mi_'.$table]['name'][$xxxx][$field] )
		{
            if($separator_folder && isset( $_REQUEST['mi_'.$table][$xxxx][$field_folder_name] ))
            {
                $separator_dir = $dir.'/'.strtoupper($_REQUEST['mi_'.$table][$xxxx][$field_folder_name]);
            }
            else
            {
                $separator_dir = $dir;
            }
            make_dir($separator_dir);
            //System::debug('mi_'.$table.'_'.$field.'_'.$key);
            if($repalce_image)
            {
                //Tên mới
                $new_url = $separator_dir.'/'.$_FILES['mi_'.$table]['name'][$xxxx][$field];
                //Nếu tồn tại thì xóa ảnh cũ
                @unlink($new_url);
            }
            else
            {
                $new_url = $separator_dir.'/'.time().'_'.$_FILES['mi_'.$table]['name'][$xxxx][$field];    
            }
			
			move_uploaded_file($_FILES['mi_'.$table]['tmp_name'][$xxxx][$field],$new_url);
            
            if($new_width and $new_height)
			{
				create_thumb($new_url,$new_url,$new_width,$new_height, $constraint);
			}
            return $new_url;
			
		}
        
	}
}
?>