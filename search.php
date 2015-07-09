<?php 
$page = 'search';
require_once('includes/header.php'); 
$masterpiece= $_GET['mastid'];
//pharse the user searched for 
$phrase = $_GET['search'];
$user_id = $_SESSION['user_id'];
?>

<section class="user cf">
	<article>
	<a href="profile.php"><img src="<?php show_avatar($user_id); ?>"></a>
	<h1><?php show_username($user_id) ?></h1>
	<h2><a href="profile.php"></a></h2>
	</article>
</section>
<main class="cf">
<?php 
$query= "SELECT DISTINCT images, title, description, date, master_id
		 FROM masterpieces
		 WHERE (title LIKE '%" . $phrase . "%' 
		 AND description LIKE '%".$phrase."%'
		 OR images LIKE '%".$phrase."%')
		 ORDER BY date DESC";
//run it
$result = $db->query($query);

$result->num_rows >= 1;

$error ="false";

$totalhits = $result->num_rows;
if ($totalhits == 0 ) {
	$error = true;
	$message = "No matches were found";
}
  ?>
<h1>Search Results for: <?php echo $phrase; ?></h1>

	<?php if ( $error == true ) {
		echo $message;
	} ?>
<div id="container">

	<?php while( $row = $result->fetch_assoc()){ ?>
	<figure class="hfig">
		<a href="single.php?mastid=<?php echo $row['master_id']; ?>"><img src="<?php echo $row['images']; ?>"></a>
	</figure>
	<?php } ?>

</div>


</main>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


<script>

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

<?php include('includes/footer.php'); ?>