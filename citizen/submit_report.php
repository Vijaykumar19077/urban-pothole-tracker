<?php
require_once __DIR__.'/../includes/db.php';require_once __DIR__.'/../includes/functions.php';require_login();
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: report.php');exit;}
$title=trim($_POST['title']??'');$type=$_POST['issue_type']??'';$location=trim($_POST['location']??'');$severity=$_POST['severity']??'';$description=trim($_POST['description']??'');
$allowedTypes=['Pothole','Damaged Road','Broken Streetlight','Open Manhole','Other'];$allowedSeverity=['Low','Moderate','Critical'];
if($title===''||$location===''||$description===''||!in_array($type,$allowedTypes,true)||!in_array($severity,$allowedSeverity,true)){set_flash('Please complete all required fields correctly.','error');header('Location: report.php');exit;}
$photo=null;
if(isset($_FILES['photo'])&&$_FILES['photo']['error']!==UPLOAD_ERR_NO_FILE){
 $f=$_FILES['photo'];
 if($f['error']!==UPLOAD_ERR_OK||$f['size']>5*1024*1024){set_flash('Photo upload failed or file exceeds 5 MB.','error');header('Location: report.php');exit;}
 $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);$ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime]??null;
 if(!$ext){set_flash('Only JPG, PNG and WEBP images are allowed.','error');header('Location: report.php');exit;}
 $photo=bin2hex(random_bytes(16)).'.'.$ext;$target=__DIR__.'/../uploads/'.$photo;
 if(!move_uploaded_file($f['tmp_name'],$target)){set_flash('Could not save uploaded photo.','error');header('Location: report.php');exit;}
}
$st=$pdo->prepare("INSERT INTO reports (user_id,title,issue_type,location,severity,description,photo) VALUES (?,?,?,?,?,?,?)");
$st->execute([$_SESSION['user_id'],$title,$type,$location,$severity,$description,$photo]);
set_flash('Your road damage report has been submitted.');header('Location: my_reports.php');exit;
