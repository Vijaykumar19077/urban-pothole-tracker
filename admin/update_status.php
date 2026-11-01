<?php
require_once __DIR__.'/../includes/db.php';require_once __DIR__.'/../includes/functions.php';require_admin();
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: reports.php');exit;}
$id=(int)($_POST['report_id']??0);$status=$_POST['status']??'';
if(!in_array($status,['Reported','Under Repair','Resolved'],true)){set_flash('Invalid repair status.','error');header('Location: reports.php');exit;}
$st=$pdo->prepare("UPDATE reports SET status=? WHERE id=?");$st->execute([$status,$id]);set_flash('Repair status updated.');header('Location: reports.php');exit;
