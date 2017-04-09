 <?php
error_reporting(0); 

$session_id='1'; //$session id
define ("MAX_SIZE","2"); 
function getExtension($str)
{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}


$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
{
  // print_r($_FILES );//die();
	
    $uploaddir = "resources/interfaces/ava/"; //a directory inside
    foreach ($_FILES['photos']['name'] as $name => $value)
    { 
	
        $filename = stripslashes($_FILES['photos']['name'][$name]);
        $size=filesize($_FILES['photos']['size'][$name]);
        //get the extension of the file in a lower case format
        // echo getExtension($filename);
          $ext = getExtension($filename);
          $ext = strtolower($ext);
     	
         if(in_array($ext,$valid_formats))
         {
	       if ($size < (MAX_SIZE*1024))
	       {
		   $image_name=time().$filename;
		  
		   $newname=$uploaddir.$image_name;
           
           if (move_uploaded_file($_FILES['photos']['tmp_name'][$name] , $newname)) 
           {
             echo "".$uploaddir.$image_name."";
	       // $time=time();
	       // mysql_query("INSERT INTO user_uploads(image_name,user_id_fk,created) VALUES('$image_name','$session_id','$time')");
	       }
	       else
	       {
	        echo 2;
            }

	       }
		   else
		   {
			echo 2;
          
	       }
       
          }
          else
         { 
	     echo 3;
           
	     }
           
     }

}

?>