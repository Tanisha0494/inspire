<?php
//create new connection to the DB 
// db host, username, pass, db name
$db = new mysqli('localhost', 'tr_inspire_admin', 'Day04year', 'tr_inspire'); 
// $db = new mysqli('localhost', 'trose04_admin', 'w?6SI=yC@CbN', 'trose04_inspire'); 
//live setup

//handle error
if($db -> connect_errno > 0){
	//stop the rest of the page from loading, and show a message instead
	die('Unable to connect to Database. Come back later.');
}

//do not close PHP
