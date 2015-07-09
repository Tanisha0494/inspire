<?php 
$page = 'upload';
require_once('includes/header.php'); 
$user_id = $_SESSION['user_id'];

//parse the image uploader
if ($_POST['did_submit']) {
	

	//file uploading stuff begins
	
	$target_path = "db_images/";
	
	//list of image sizes to generate. make sure a column name in your DB matches up with a key for each size
	$sizes = array(
		'images' => 300
	);	
	
	

		
	// This is the temporary file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	// Capture the original size of the uploaded image
	list($width,$height) = getimagesize($uploadedfile);
	
	//make sure the width and height exist, otherwise, this is not a valid image
	if($width > 0 AND $height > 0){
	
	//what kind of image is it
	$filetype = $_FILES['uploadedfile']['type'];
	
	switch($filetype){
		case 'image/gif':
			// Create an Image from it so we can do the resize
			$src = imagecreatefromgif($uploadedfile);
		break;
		
		case 'image/pjpeg':
		case 'image/jpg':
		case 'image/jpeg': 
			// Create an Image from it so we can do the resize
			$src = imagecreatefromjpeg($uploadedfile);
		break;
	
		case 'image/png':
			// Create an Image from it so we can do the resize
			$required_memory = Round($width * $height * $size['bits']);
			$new_limit=memory_get_usage() + $required_memory;
			ini_set("memory_limit", $new_limit);
			$src = imagecreatefrompng($uploadedfile);
			ini_restore ("memory_limit");
		break;
		
			
	}
	//for filename
	$randomsha = sha1(microtime());
	
	//do it!  resize images
	foreach($sizes as $size_name => $size_width){
		if($width >=  $size_width){
		$newwidth = $size_width;
		$newheight=($height/$width) * $newwidth;
		}else{
			$newwidth=$width;
			$newheight=$height;
		}
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
		$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';
		$didcreate = imagejpeg($tmp,$filename,70);
		imagedestroy($tmp);

			//update the user info in the DB
			if($didcreate){

				$title =clean_input($_POST['title']);

				$description =clean_input($_POST['description']);

				if(strlen($title)==0){
					$valid = false;
					$statusmsg .= "You must fill in the title";
				}

				if(strlen($description)< 4){
					$valid=false;
					$statusmsg .= "Please provide a vaild description";
				}




				$query_img = "INSERT INTO masterpieces
				(images, date,title, description, user_id)
				VALUES
				('$filename', now(),'$title','$description', '$user_id')";

				$result_img = $db->query($query_img);


				//find the id of the masterpiece that's been added

				$mid = $db->insert_id;

				//figure out the check boxes checked

				$categories = $_POST['category'];

				foreach($categories AS $cat){
						$query="INSERT INTO masterpieces_categories
						(category_id, master_id)
						VALUES
						($cat, $mid)";

						$result=$db->query($query);
				}//end foreach

				$statusmsg .=  "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded <br />";
				
						}//end if didcreate
				
				
				imagedestroy($src);

				if($valid){

					}
				}
	
		
	}else{//width and height not greater than 0
		$didcreate = false;
		$statusmsg .= "There was an error uploading the file, please try again!<br />";
	}


}//end parser





?>

<section class="user">

	<article>
		<a href="profile.php"><img src="<?php show_avatar($user_id); ?>"></a>

		<h1><?php show_username($user_id) ?></h1>

	</article>

</section>

<main class="clear">

<h1>Upload Your Inspiration</h1>

<h2>
<?php 
		if (isset($statusmsg)) {		
		 	echo "<div class ='message'>$statusmsg</div>";
		 } ?>
</h2>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

<label for="uploadedfile">Choose a File</label>

<input type="file" name="uploadedfile" id="uploadedfile">

<label for="title">Title:</label>

<input type="text" name="title" id="title">


<label for="description">Description:</label>
<textarea name="description" id="description"></textarea>

<label for="category">Choose the categories that apply:</label>

<?php 
$query = "SELECT name, category_id
		  FROM categories";
$result= $db->query($query);

while ( $row = $result->fetch_assoc() ){
 ?>

<label for="<?php echo $row['name'];?>"><input type="checkbox" name="category[]" id="<?php echo $row['name'];?>" value="<?php echo $row['category_id']; ?>"><?php echo $row['name'];?></label>

<?php } ?>

<input type="submit" value="Submit">

<input type="hidden" name="did_submit" value="1">

</form>

</main>
<?php include('includes/footer.php') ?>