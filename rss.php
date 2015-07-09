<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; 
require('includes/db-connect.php');
include_once('includes/functions.php');
?>

<rss version="2.0">
	<channel>
		<title>Inspire</title>
		<link>http://localhost/tanisha_rose/inspire/home.php</link>
		<description>All the inspiration you could need</description>
		<language>en-us</language>
		
		<?php //get the latest 10 published posts
		$query = "SELECT m.images, m.title, users.username, users.email, c.name, m.date
				FROM masterpieces AS m, users, categories AS c, masterpieces_categories AS m_c
				WHERE m.user_id = users.user_id
				AND m.master_id = m_c.master_id
				AND c.category_id = m_c.category_id
				ORDER BY date DESC
				LIMIT 10";
		$result = $db->query($query);
		while( $row = $result->fetch_assoc() ){ ?>
		<item>
			<title><?php echo $row['title'] ?></title>
			<link>http://localhost/inspire/home.php</link>
			
			<author><?php echo $row['username'] ?></author>
			<description><![CDATA[<img src="<?php echo $row['images'] ?>">]]></description>
		</item>
		<?php } ?>

	</channel>
</rss>