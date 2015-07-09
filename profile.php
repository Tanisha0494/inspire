<?php 
$page = 'profile';
require_once('includes/header.php'); 
$masterpiece= $_GET['mastid'];
$user_id = $_SESSION['user_id'];

?>

<section class="user cf">
	<article>
	<img src="<?php show_avatar($user_id); ?>">
	<h1> <?php show_username($user_id) ?></h1>
	<h2><a href="edit.php">Edit your profile</a></h2>
	</article>
</section>
<main class="cf">
<h1>About Me:</h1>


<?php 
$query = "SELECT body 
		  FROM about 
		  WHERE user_id = $user_id";
		  
$result =$db-> query($query);
 ?>

<?php while ( $row = $result->fetch_assoc() ){
 ?>

<p> <?php echo $row['body']; ?></p>

<?php } ?>

<h1>Uploads</h1>

<section id="container">

<?php

$queryup = "SELECT masterpieces.images, master_id
		FROM  masterpieces
		WHERE user_id = $user_id
		ORDER BY date DESC";
$resultup = $db->query($queryup); ?>

<?php while ( $row=$resultup->fetch_assoc() ) {
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