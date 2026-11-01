<?php
require_once __DIR__.'/../includes/db.php';require_once __DIR__.'/../includes/functions.php';require_admin();
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: reports.php');exit;}
$id=(int)($_POST['report_id']??0);$team=($_POST['team_id']??'')===''?null:(int)$_POST['team_id'];
if($team!==null){$check=$pdo->prepare("SELECT id FROM teams WHERE id=?");$check->execute([$team]);if(!$check->fetch()){set_flash('Selected team does not exist.','error');header('Location: reports.php');exit;}}
$st=$pdo->prepare("UPDATE reports SET assigned_team_id=? WHERE id=?");$st->execute([$team,$id]);set_flash('Maintenance team assignment saved.');header('Location: reports.php');exit;
