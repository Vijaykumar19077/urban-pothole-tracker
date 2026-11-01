<?php
require_once __DIR__.'/includes/db.php'; require_once __DIR__.'/includes/functions.php';
if(is_logged_in()){header('Location: '.(is_admin()?'admin/dashboard.php':'dashboard.php'));exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $email=trim($_POST['email']??'');$password=$_POST['password']??'';
 $st=$pdo->prepare("SELECT * FROM users WHERE email=?");$st->execute([$email]);$user=$st->fetch();
 if($user && password_verify($password,$user['password'])){session_regenerate_id(true);$_SESSION['user_id']=$user['id'];$_SESSION['name']=$user['name'];$_SESSION['role']=$user['role'];set_flash('Welcome back, '.$user['name'].'!');header('Location: '.($user['role']==='admin'?'admin/dashboard.php':'dashboard.php'));exit;}
 $error='Incorrect email or password.';
}
$pageTitle='Login';require __DIR__.'/includes/header.php';
?>
<div class="auth-wrap"><section class="form-card auth-card"><span class="eyebrow">WELCOME BACK</span><h1>Log in</h1><p class="muted">Access your reports and community dashboard.</p><?php if($error):?><div class="flash flash-error"><?=e($error)?></div><?php endif;?>
<form method="post" class="stack-form"><label>Email address<input type="email" name="email" required></label><label>Password<input type="password" name="password" required></label><button class="btn btn-primary full">Log in →</button></form><p class="form-bottom">New here? <a href="register.php">Create an account</a></p></section></div>
<?php require __DIR__.'/includes/footer.php';?>