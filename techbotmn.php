<?php 
include 'config.php';
$searchterms=array("#wordcampmsp", '@wordcampmsp');

foreach ($searchterms as $search)
{
	$curl=curl_init();
	$request="http://search.twitter.com/search.json?q={$search}&rpp=100";
	
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt ($curl, CURLOPT_URL,$request);

	$responseT = curl_exec ($curl);

	curl_close($curl);
	$oresponseT = json_decode($responseT);
	var_dump($oresponseT);
		
		foreach($oresponseT->results as $res)
		{
			$id=$res->id;
			$author=$res->from_user;
			$message=$res->text;
			$message_time=date('Y-m-d H:i:s', strtotime($res->created_at));
				
			$query = "SELECT * FROM `".$dbname."` WHERE  `message_id` = '".mysql_real_escape_string($id)."'";
			$res = mysql_query($query);
			if(mysql_num_rows($res) == 0)
			{	
		
				//MySQL insert
				$query = "INSERT INTO `".$dbname."` (message_id, author, message) VALUES ('".mysql_real_escape_string($id)."', '".mysql_real_escape_string($author)."', '".mysql_real_escape_string($message)."'`)";
				echo "New Tweet: {$message}\n";		
				mysql_query($query) or die("Insert failed \n");
				}		
		
		
		
		
		
		}
	
}



?>