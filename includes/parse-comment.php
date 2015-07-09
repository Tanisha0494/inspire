<?php

$user_id = $_SESSION['user_id'];
//parse the comment form submission
if( $_POST['did_comment'] ){
	//extract and sanitize the form data
	$body = clean_input($_POST['body']);
	

	//validate!
	$valid = true;

	//error: body is blank
	if( strlen($body) == 0 ){
		$valid = false;
		$errors['body'] = 'Please fill in the comment body';
	}

	//if the data passed validation, add the comment to the DB
	if( $valid ){
		//set up query
		$query_insert = "INSERT INTO comments
						(user_id, body, date, master_id)
						VALUES
						('$user_id', '$body', now(), $masterpiece)";
		//run it
		$result_insert = $db->query($query_insert);		

	} //end if valid

	//check to see if the query ran and worked
	if( $db->affected_rows == 1 ){
		$status = 'success';  
		$message = 'Thanks for posting a comment, it will appear immediately.';
	}
	else{
		$status = 'error';
		$message = 'Your comment could not be added. Please fix any errors below and try again.';
	}

}//end comment parse