<?php 
session_start();
require('includes/db-connect.php');
include_once('includes/functions.php');
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inspire - <?php echo $page ?></title>
	<link rel="icon" type="image/ico" href="images/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/format.css">


</head>
<body class="<?php echo $page ?> cf">
<header class="cf">
	<h1 class="logo"><a href="home.php">Inspire</a></h1>
	<ul>
		<li class="join actionbutton"><a href="join.php">Join Us</a></li>
		<li><a href="sign-in.php?action=logout">Sign Out</a></li>
		<li class="rss"><a href="rss.php">RSS</a></li>
	</ul>
</header>
<section class="nav">
<article class="nav cf">
<nav class="cf">
	<ul class="cf">
		<li class="gprofile"><a href="profile.php">Profile</a></li>
		<li class="gcategories"><a href="categories.php">Categories</a></li>
		<li class="gabout"><a href="about.php">About Us</a></li>
		<li class="gupload"><a href="upload.php">Upload</a></li>
	</ul>
</nav>

<form id="searchform" action="search.php" method="get" value="<?php echo $_GET['phrase']; ?>">

	<input type="text" name="search" id="search" placeholder="search">

	<input type="submit" value=">">

</form>
</article>
</section>