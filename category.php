<?php 
$page = 'category';
$category= $_GET['catid'];
require_once('includes/header.php'); 
$user_id = $_SESSION['user_id'];
$query = "SELECT name, category_id
		  FROM categories
		  WHERE category_id = $category
		  LIMIT 1";
$result= $db->query($query);
$row = $result->fetch_assoc();
?>

<section class="user cf">
	<article>

	<a href="profile.php"><img src="<?php show_avatar($user_id); ?>"></a>

	<h1> <?php show_username($user_id) ?> </h1>

	</article>
</section>
<main class="cf">
<h1><?php echo $row['name'] ?></h1>
<h2><a href="categories.php"> &lt; Back to Categories </a></h2>

<section id="container">
<?php 
$query = "SELECT m.title, m.images, m.master_id
		  FROM masterpieces AS m, masterpieces_categories AS m_c
		  WHERE m.master_id = m_c.master_id
		  AND m_c.category_id = $category
		  ORDER BY m.date DESC";
$result= $db->query($query);
if ($result->num_rows >= 1) {

while ( $row = $result->fetch_assoc() ){
?>
<a href="single.php?mastid=<?php echo $row['master_id']; ?>">
	<figure class="hfig">
	<img src="<?php echo $row['images']; ?>">
	</figure>
</a>
<?php }//end while
}//end if 
else{
	echo 'There are no masterpieces in this category name';
} ?>

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