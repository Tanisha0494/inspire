<?php 
$page = 'home';
require_once('includes/header.php'); 
$masterpiece= $_GET['mastid'];
$query="SELECT masterpieces.images, master_id
		FROM  masterpieces
		ORDER BY date DESC";
$result=$db->query($query);
$user_id = $_SESSION['user_id'];

?>

<section class="user cf">
	<article>
	<a href="profile.php"><img src="<?php show_avatar($user_id); ?>" alt="profile picture"></a>
	<h1> Welcome <?php show_username($user_id) ?>!</h1>
	<h2>Click your profile picture to view your profile</h2>
	</article>
</section>
<main class="cf">

<h1>Welcome to Inspire!</h1>

<h2>Enjoy our latest inspirations</h2>

<h3>Latest Inspirations</h3>

<section id="container">

<?php while ( $row=$result->fetch_assoc() ) {
	?>
<a href="single.php?mastid=<?php echo $row['master_id']; ?>">
	<figure class = "hfig">
		<img src="<?php echo $row['images'] ?>">
	</figure>
</a>


<?php } ?>

</section>

</main>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="js/freewall.js"></script>
<!-- <script src="js/jquery.balanced-gallery.js"></script> -->

<script type="text/javascript">
		$(function(){
			var wall = new freewall("#container");
			wall.reset({
				selector: '.hfig',
				animate: true,
				cellW: 300,
				cellH: 'auto',
				onResize: function() {
					wall.fitWidth();
				}
			});
			
			wall.container.find('.hfig img').load(function() {
				wall.fitWidth();
			});
		});
</script>

<?php include('includes/footer.php') ?>