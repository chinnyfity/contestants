<?php
@session_start();
$localhost='localhost';

$root_username = ($_SERVER['HTTP_HOST'] == "localhost")? "root":"antvt";
$root_password = ($_SERVER['HTTP_HOST'] == "localhost")? "":"@ntvt33_9r0up_!1";
$database_name = ($_SERVER['HTTP_HOST'] == "localhost")? "celebs":"brand_market";

$connections=mysqli_connect($localhost,$root_username,$root_password) or die('There is an error in the connection!');
$connect_to_dbase=mysqli_select_db($connections,$database_name)or die('Error in connecting to the database<br>'.mysqli_error($connections));

function compress($source, $destination, $quality) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);
    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);
    imagejpeg($image, $destination, $quality);
    return $destination;
}

$url_source = "fake_fols/";
$target_dir = "events_fols/";

$request = 1;
if(isset($_POST['request'])){
	$request = $_POST['request'];
}

$gen_num1=time();
$gen_num1=substr($gen_num1,5);

if($request == 1){
    
    $mediaid = $_SESSION['mediaid'];
    $msg = "";
    
    $files1 = $_FILES['file']['name'];
    $tmp_names = $_FILES['file']['tmp_name'];
    $cts=1;
    foreach($tmp_names as $key=>$tmp_name){
        $file_name=$_FILES["file"]["name"][$key];
        $file_tmp=$_FILES["file"]["tmp_name"][$key];
        $file_name = str_replace(" ", "_", $file_name);
        $file_name = strtolower($file_name);
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        $ext = strtolower($ext);
        $filename=basename($file_name,$ext);
        //$newFileName=(string)$filename.time().".".$ext;
        $newFileName=time()."$cts.$ext";
        $_SESSION['newFileName'] = $newFileName;

        if($ext=="jpg" || $ext=="png" || $ext=="gif" || $ext=="jpeg")
            $url_source1 = "fake_fols/";
        else
            $url_source1 = "events_fols/"; // for videos
        
        if (move_uploaded_file($file_tmp=$_FILES["file"]["tmp_name"][$key],$url_source1.$newFileName)  && ($mediaid != "" || $mediaid > 0)) {

            if($ext=="jpg" || $ext=="png" || $ext=="gif" || $ext=="jpeg")
                $d = compress($url_source.$newFileName, $target_dir.$newFileName, 70);
                
            mysqli_query($connections,"INSERT INTO events_media(event_id ,files) VALUES('$mediaid', '$newFileName')") or die(mysqli_error($connections));
            $msg = $gen_num1;
        }
        $in_folder1="fake_fols/".$newFileName; // delete the image in the fake folder
        if(is_readable($in_folder1)) @unlink($in_folder1);
        $cts++;
    }
	echo $msg;
}


if($request == 2){
    $filename = $target_dir.$gen_num1.$_FILES['file']['name']; 
	unlink($filename); exit;
}




?>