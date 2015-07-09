<?php 
$page = 'single';
$masterpiece= $_GET['mastid'];
require_once('includes/header.php');
include('includes/parse-comment.php'); 
$user_id = $_SESSION['user_id'];
$query = "SELECT m.*, c.*
		  FROM masterpieces AS m, categories AS c , masterpieces_categories AS m_c
		  WHERE m.master_id = $masterpiece
		  AND m.master_id = m_c.master_id
		  AND c.category_id = m_c.category_id
		  LIMIT 1";
$result= $db->query($query);
$row = $result->fetch_assoc();
?>

<section class="user cf">
	<article>
	<a href="profile.php"><img src="<?php show_avatar($user_id); ?>"></a>
	<h1> <?php show_username($user_id); ?> </h1>
	</article>
</section>
<main class="cf">
<h1><?php echo $row['title']; ?></h1>
<h2><a href="category.php?catid=<?php echo $row['category_id']; ?>"> &lt; Back to <?php echo $row['name'];  ?></a></h2>

<a href="single.php?mastid=<?php echo $row['master_id']; ?>">
<img src="<?php echo $row['images']; ?>">
</a>
<p><?php echo $row['description']; ?></p>
<ul class="sinfo">
	<?php $query_cat="SELECT c.name , c.category_id
						FROM categories AS c, masterpieces_categories AS m_c
						WHERE m_c.master_id = $masterpiece
						AND c.category_id = m_c.category_id";
		  $result_cat= $db->query($query_cat);
		   ?>
<li>Category:<?php while( $row_cat = $result_cat->fetch_assoc() ){ ?>

	<a href="category.php?catid=<?php echo $row_cat['category_id']; ?>">
	
	<?php echo $row_cat['name']; ?></a>

	<?php }//end while loop ?>

</li>

<li>Posted:<?php echo convert_date($row['date']); ?></li>
</ul>

<section class="comments">

<?php //get all the comments about this post 
		$query_comments = "SELECT comments.* ,users.username
							FROM comments, users
							WHERE comments.master_id = $masterpiece
							AND users.user_id = comments.user_id
							ORDER BY comments.date ASC";
		//run it!
		$result_comments = $db->query($query_comments);
		//check to see if any comments found
		if( $result_comments->num_rows >= 1 ){
		?>

	<?php while( $row_comments = $result_comments->fetch_assoc() ){?>
	<figure class="comment">
<h3><?php echo $row_comments['username']; ?>:</h3>

<p><?php echo $row_comments['body']; ?></p>

<ul class="date cf">

<li><?php echo convert_date($row['date']); ?></li>

</ul>

</figure>

<?php }//end while
}//end if comments were found 
else{
	echo 'There are no comments yet. Leave one!';
}
 ?>


<?php //show feedback message if it exists
 if ($_SESSION['logged_in']) {	
 	if( isset($message) ){ 
 ?>		
				<div class="<?php echo $status; ?> message">
					<?php 
					echo $message;
					//check to see if there were validation errors
					if(isset($errors)){ ?>
					<ul id ="errors">
						<?php foreach( $errors as $error ){ ?>
							<li><?php echo $error; ?></li>
						<?php } ?>
					</ul>
					<?php } //end if validation errors exist ?>
				</div>
			<?php }//end if message exists ?>

<form action="#leavecomment" method="post">

<label for="body">Leave a comment:</label>
<textarea name="body" id="body"></textarea>

<input type="submit" value="Submit Comment">
<input type="hidden" name="did_comment" value="true">
</form><?php }else{
	echo 'You must be logged in to leave a comment.';
} ?>
</section>


</main>

<?php include('includes/footer.php'); ?>