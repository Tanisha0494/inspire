<?php 
session_start();
require('includes/db-connect.php');
include_once('includes/functions.php');
//parse the form if user submitted the correct information 
if ($_POST['did_signup']) {
	//clean the data
	$username = clean_input($_POST['username']);
	$email = clean_input($_POST['email']);
	$password = clean_input($_POST['password']);
	$policy = clean_input($_POST['policy']);

	$hashed_password = sha1($password);

	$valid = true;
	//usename too short
	if ( strlen($username) <= 6 OR strlen($username) > 50 ) {
		$valid = false;
		$errors['username'] = 'Your username must be between 6 - 50 characters';
	}else{
		$query_user="SELECT username FROM users
			   		WHERE username = '$username'
			   		LIMIT 1";
		$result_user= $db->query($query_user);
		if ( $result_user->num_rows >= 1 ) {
			$valid = false;
			$errors['username'] = 'Sorry but that username is already taken. Please choose another.';
		}
	}//end username check

	//invalid email address
	if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$valid = false;
		$errors['email'] = 'Please provide a valid email address like name@mail.com';
	}else{
		$query_email = "SELECT email FROM users
					    WHERE email = '$email'
					    LIMIT 1";
		$result_email = $db->query($query_email);

		if ( $result_email->num_rows >= 1 ) {
			$valid = false;
			$errors['email'] = 'Your email address is already taken. Do you want to login?';
		}
	}//end email check 
	if ( strlen($password) <= 8 OR strlen($password) > 40 ) {
		$errors['password'] = 'Your password must be between 8 - 40 characters';
	}//end password check
	if ( $policy != 1 ) {
		$valid = false;
		$errors['policy'] = 'You must agree to the Terms of Service and Privacy Policy.';
	}

	///add the user to DB if it's valid
	if ($valid) {
		echo $query_adduser = "INSERT INTO users
						(username, password, email, join_date)
						VALUES 
						('$username', '$hashed_password', '$email', now())";
		$result_adduser = $db->query ($query_adduser);

		if ($db->affected_rows == 1) {
			$_SESSION['logged_in'] = true;
			setcookie('logged_in', true, time() + 60 * 60 * 24 * 30 );

			$logged_in_user_id = $db->insert_id;

			$_SESSION['user_id'] = $logged_in_user_id;
			setcookie('user_id', $logged_in_user_id, time() + 60 * 60 * 24 *30 );

			header('Location:home.php');
		}//end if user added to DB
		else{
			$errors['db'] = 'Something went wrong during account creation. We\'re sorry, try again later.';
		}//end if valid
	}

}//end parse form
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inspire - Join Us</title>
	<link rel="icon" type="image/ico" href="images/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/normalize.min.css">
	<link rel="stylesheet" type="text/css" href="css/format.css">
</head>
<body class="join">

<main>
<a href="index.php"><figure>
<img src="images/index-logo.png" width="228" height="162"> 
</figure>
</a>
<section class="jsect">
<h2>Become an inspiration and sign-up below</h2>
	<?php 
	if( isset($errors) ){
		echo '<ul class="error message">';
		foreach( $errors as $message ){
			echo "<li>$message</li>";
		}
		echo '</ul>';
	}
	 ?>

<form class="join_us" action="#" method="post">

<label for="username">Create Username:</label>
<input type="text" name="username" id="username" value="<?php echo $username; ?>"><span class="hint"> 
Choose a unique username that is between 6-50 characters long </span>

<label for="email">Email Address:</label>
<input type="email" name="email" id="email" value="<?php echo $email; ?>">

<label for="password">Create a Password:</label>
<input type="password" name="password" id="password" value="<?php echo $password; ?>"><span class="hint">
Choose a unique password that is between 8-40 characters long </span>
<label>
<input type="checkbox" name="policy" value="1" id="policy" <?php checked($policy, 1); ?>>
		I agree to the <a href="terms.php" target="_blank">Terms of Service and Privacy Policy</a>
		</label>
<input type="submit" value="Sign Me Up!" class="actionbutton"> 
<input type="hidden" name="did_signup" value="true">

</form>
</section>

</main>
</body>
</html>