<?php 
session_start();
require('includes/db-connect.php');
include_once('includes/functions.php');
$user_id = $_SESSION['user_id'];
//parse the form if user submitted it
if( $_POST['did_signin'] == true ){
	//sanitize
	$input_username = clean_input($_POST['username']);
	$input_password = clean_input($_POST['password']);

	$hashed_password = sha1($input_password);

	//validate
	if ( strlen($input_username) >= 6 AND strlen($input_username) < 50 AND strlen($input_password) >= 8 AND strlen($input_password) < 40) {
		
		//check database
		$query = "SELECT user_id
			      FROM users
			      WHERE username = '$input_username'
			      AND password = '$hashed_password'
			      LIMIT 1";
		$result = $db->query($query);

		//if one row is found
		if ( $result->num_rows == 1 ) {
			//log them in for a month
			$_SESSION['logged_in'] = true;
			setcookie('logged_in', true, time() + 60 * 60 * 24 * 30 );

			//who logged in 
			$row = $result->fetch_assoc();
			$logged_in_user_id = $row['user_id'];

			$_SESSION['user_id'] = $logged_in_user_id;
			setcookie('user_id', $logged_in_user_id, time() + 60 * 60 * 24 *30 );
			//redirect to home page
			header('Location:home.php');
		}//end if inputs match
		else{
			//no match
			$error = true;
			$message = 'Username and password combination is incorrect, try again.';
		}
	}//end if valid length
	else{
		$error = true;
		$message = 'Username and password combination is incorrect, try again';
	}
}//end if login 

//logout
if ($_GET['action'] == 'logout') {
	session_destroy();

	unset($_SESSION['logged_in']);
	setcookie('logged_in', '');

	unset($_SESSION['user_id']);
	setcookie('user_id', '');
}
//check to if user has an unexpired cookie if so log them and adirct them to the home page
elseif ($_COOKIE['logged_in'] == true) {
	//recreate the session var
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = $_COOKIE['user_id'];

	//send to homepage
	header('Location:home.php');
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inspire</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.min.css">
	<link rel="stylesheet" type="text/css" href="css/format.css">
</head>
<body class="signin">
<header class="cf">
<h1><a href="index.php">Inspire</a></h1>
</header>
<main>
<section class="login">
<h2>Get inspired and sign in</h2>

<?php //if user triggered error show message
if ( $error == true ) {	echo $message; } ?>

<form class="sign_in"action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<label for="username">Username:</label>
<input type="text" name="username" id="username" required>

<label for="password">Password:</label>
<input type="password" name="password" id="password" required>


<input type="submit" value="Sign In" class="actionbutton"> 
<input type="hidden" name="did_signin" value="true">

</form>

</section>
</main>
</body>
</html>