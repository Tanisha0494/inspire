<?php
//convert datetime format to human-friendly format
function convert_date($dateR){
	$engMon=array('January','February','March','April','May','June','July','August','September','October','November','December',' ');
	$l_months='January:February:March:April:May:June:July:August:September:October:November:December';
	$dateFormat='F j, Y';
	$months=explode (':', $l_months);
	$months[]='&nbsp;';
	$dfval=strtotime($dateR);
	$dateR=date($dateFormat,$dfval);
	$dateR=str_replace($engMon,$months,$dateR);
	return $dateR;
}

//Count the number of comments on ANY post!
function count_comments( $post_id, $long_content = true ){
	//use the $db variable that we created in a different file
	global $db;
	$query_count = "SELECT COUNT(*) AS total
					FROM comments
					WHERE post_id = $post_id";
	$result_count = $db->query($query_count);
	//no looping because COUNT only returns ONE row
	$row_count = $result_count->fetch_assoc();

	//if the parameter is set to show long content, show it in english, otherwise use numbers
	if( $long_content ){
		//grammar!
		if($row_count['total'] == 0){
			echo 'No comments yet.';
		}elseif($row_count['total'] == 1){
			echo 'One comment.';
		}else{
			echo $row_count['total'] . ' comments';
		}
	}else{ //short content
		echo '(' . $row_count['total'] . ')';
	}
}


//sanitize form input for DB
function clean_input( $input ){
	global $db;
	return mysqli_real_escape_string( $db, strip_tags(trim($input)) );
}

//convert mysql datetime to RFC-822 date for RSS
function convTimestamp($date){
	$year   = substr($date,0,4);
	$month  = substr($date,5,2);
	$day    = substr($date,8,2);
	$hour   = substr($date,11,2);
	$minute = substr($date,14,2);
	$second = substr($date,17,2);
	$stamp =  date('D, d M Y H:i:s O', mktime($hour, $min, $sec, $month, $day, $year));
	return $stamp;
}

//shorten a long piece of content, preserving words
function shorten($str, $length, $minword = 3){
    $sub = '';
    $len = 0;   
    foreach (explode(' ', $str) as $word){
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);       
        if (strlen($word) > $minword && strlen($sub) >= $length){
            break;
        }
    }   
    return $sub . (($len < strlen($str)) ? '<span class="ellipses">&hellip;</span>' : '');
}


//simplify sticky checkboxes
function checked($value, $expected){
	if($value == $expected){
		echo 'checked="checked"';
	}
}

//show any user avatar
function show_avatar($user_id){
	global $db;
	$query = "SELECT profile_pic AS avatar FROM users
			  WHERE user_id = $user_id
			  LIMIT 1";
	$result= $db->query($query);
	//check to make sure one row was found
	if ( $result->num_rows == 1 ) {
		$row = $result->fetch_assoc();
		//make sure avatar is not blank
		if($row['avatar'] == ''){
			echo 'images/dprofilepic.jpg';
		}else{
			echo $row['avatar'];
		}
	}
}

//show username 
function show_username($user_id){
	global $db;
	$query="SELECT username FROM users
	             WHERE user_id = $user_id
	             LIMIT 1";
	$result= $db->query($query);
	if ( $result->num_rows == 1 ) {
		$row = $result->fetch_assoc();
		echo $row['username'];
	}
}
//no close php!