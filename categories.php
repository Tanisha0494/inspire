<?php 
$page = 'categories';
require_once('includes/header.php'); 
$user_id = $_SESSION['user_id'];

?>

<section class="user clear">
	<article>
	<a href="profile.php"><img src="<?php show_avatar($user_id); ?>"></a>
	<h1> <?php show_username($user_id) ?> </h1>
	</article>
</section>
<main class="cf">

<h1>Choose your inspiration</h1>

<h2>Pick one of our categories below to view the gallery</h2>
<?php 
$query = "SELECT name, category_id
		  FROM categories";
$result= $db->query($query);

while ( $row = $result->fetch_assoc() ){
?>
<a href="category.php?catid=<?php echo $row['category_id']; ?>">
<figure class="<?php echo $row['name']; ?>">

</figure>
</a>
<?php } ?>



</main>

<?php include('includes/footer.php') ?>