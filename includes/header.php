<?php
if (!isset($pageTitle)) $pageTitle = 'Road Tracker';
$root = '/urban-pothole-tracker/';
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title><?= e($pageTitle) ?> | Urban Road Tracker</title><link rel="stylesheet" href="<?= $root ?>assets/css/style.css"></head><body>
<header class="site-header"><a class="brand" href="<?= $root ?>index.php"><span class="brand-mark">⌁</span><span>road<span class="brand-accent">watch</span><small>COMMUNITY INFRASTRUCTURE TRACKER</small></span></a>
<button class="mobile-toggle" type="button" aria-label="Toggle navigation">☰</button>
<nav class="main-nav"><a href="<?= $root ?>index.php">Home</a><a href="<?= $root ?>dashboard.php">Public reports</a><?php if (is_logged_in()): ?><a href="<?= $root ?>citizen/my_reports.php">My reports</a><?php if (is_admin()): ?><a href="<?= $root ?>admin/dashboard.php">Admin panel</a><?php else: ?><a href="<?= $root ?>citizen/report.php">Report issue</a><?php endif; ?><a class="nav-login" href="<?= $root ?>logout.php">Logout</a><?php else: ?><a href="<?= $root ?>login.php">Login</a><a class="nav-cta" href="<?= $root ?>register.php">Get started</a><?php endif; ?></nav></header>
<main class="container"><?php show_flash(); ?>
