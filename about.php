<?php 
$page = 'about';
require_once('includes/header.php'); 
$user_id = $_SESSION['user_id'];
?>

<section class="user cf">
	<article>
	<a href="profile.php"><img src="<?php show_avatar($user_id); ?>"></a>
	<h1><?php show_username($user_id) ?></h1>
	</article>
</section>
<main class="cf">
<h1>About Us!</h1>
<h2>Our Team</h2>
<img src="images/ourteam.jpg" width="437" height="240" alt="ourteam">
<p>The Inspire team is made up of creative individuals that have come together to bring you the most inspiration website we can. All us understand how it is when you need inspiration and can't think of anything or find anything. Our goal is to help when this happens. Letting users and our team upload inspiring pictures from categories in the creative field that would help anyone that need it.</p>
</main>
<?php include('includes/footer.php'); ?>