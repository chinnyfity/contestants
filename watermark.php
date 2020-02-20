<?php
/*
 * This script places a watermark on a given jpeg, png or gif image.
 *
 * Use the script as follows in your HTML code:
 * <img src="watermark.php?image=image.jpg&watermark=watermark.png" />
 */

/*
  // loads a png, jpeg or gif image from the given file name
  function imagecreatefromfile($image_path) {
    list($width, $height, $image_type) = getimagesize($image_path);

    switch ($image_type)
    {
      case IMAGETYPE_GIF: return imagecreatefromgif($image_path); break;
      case IMAGETYPE_JPEG: return imagecreatefromjpeg($image_path); break;
      case IMAGETYPE_PNG: return imagecreatefrompng($image_path); break;
      default: return ''; break;
    }
  }

  $image = imagecreatefromfile($_GET['image']);
  if (!$image) die('Unable to open image');

  $watermark = imagecreatefromfile($_GET['watermark']);
  if (!$image) die('Unable to open watermark');

  // calculate the position of the watermark in the output image (the
  // watermark shall be placed in the lower right corner)
// $watermark_pos_x = imagesx($image) - imagesx($watermark) - 660;
// $watermark_pos_y = imagesy($image) - imagesy($watermark) - 950;

$watermark_pos_x = imagesx($image) - imagesx($watermark) - 0;
$watermark_pos_y = imagesy($image) - imagesy($watermark) - 90;

  imagecopy($image, $watermark,  $watermark_pos_x, $watermark_pos_y, 0, 0,
  imagesx($watermark), imagesy($watermark));

  header('Content-Type: image/jpeg');
  imagejpeg($image, NULL, 100);  // use best image quality (100)

  imagedestroy($image);
  imagedestroy($watermark);


*/


header('content-type: image/jpeg');

$src = $_GET['src'];
$path = pathinfo($src);
$watermark = imagecreatefrompng('http://rwbuildingmaterials.com/celebs/images/watermrk.png'); 
$watermark_width = imagesx($watermark); 
$watermark_height = imagesy($watermark); 
$image = imagecreatetruecolor($watermark_width, $watermark_height); 
if ($path['extension']=='png') 
$image = imagecreatefrompng($src); 
else if ($path['extension']=='jpg'||$path['extension']=='jpeg') 
$image = imagecreatefromjpeg($src); 
$size = getimagesize($_GET['src']); 
$dest_x = $size[0] - $watermark_width-10; 
$dest_y = $size[1] - $watermark_height-10; 
imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 50); 
imagejpeg($image); 
imagedestroy($image); 
imagedestroy($watermark); 


?>