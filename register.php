<?php
require_once __DIR__.'/includes/db.php'; require_once __DIR__.'/includes/functions.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $phone=trim($_POST['phone']??''); $password=$_POST['password']??'';
    if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<8) $error='Enter a name, valid email and password of at least 8 characters.';
    else {
        try { $st=$pdo->prepare("INSERT INTO users (name,email,phone,password,role) VALUES (?,?,?,?, 'citizen')"); $st->execute([$name,$email,$phone,password_hash($password,PASSWORD_DEFAULT)]); set_flash('Account created. Please log in.'); header('Location: login.php'); exit; }
        catch(PDOException $ex) { $error=$ex->getCode()==='23000'?'That email is already registered.':'Could not create account. Please try again.'; }
    }
}
$pageTitle='Create account'; require __DIR__.'/includes/header.php';
?>
<div class="auth-wrap"><section class="form-card auth-card"><span class="eyebrow">JOIN YOUR COMMUNITY</span><h1>Create an account</h1><p class="muted">Register to report road problems and track repairs.</p><?php if($error): ?><div class="flash flash-error"><?=e($error)?></div><?php endif; ?>
<form method="post" class="stack-form"><label>Full name<input name="name" required maxlength="100" value="<?=e($_POST['name']??'')?>"></label><label>Email address<input type="email" name="email" required value="<?=e($_POST['email']??'')?>"></label><label>Phone number <span class="muted">(optional)</span><input name="phone" maxlength="20" value="<?=e($_POST['phone']??'')?>"></label><label>Password<input type="password" name="password" minlength="8" required></label><button class="btn btn-primary full" type="submit">Create account →</button></form><p class="form-bottom">Already registered? <a href="login.php">Log in</a></p></section></div>
<?php require __DIR__.'/includes/footer.php'; ?>