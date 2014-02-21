<?

include 'dbConfig.php';

$filepath = 'NetIDs.csv';
$csvLength = 8192;

// opens csv file to read
if (($file = fopen($filepath, "r")) !== FALSE) {
	// reads data into array
    if (($data = fgetcsv($file, $csvLength, "\r")) !== FALSE) {
        $length = count($data);
        // parse array
        for ($row=0; $row < $length; $row++) {
        	$tokens = explode(",", $data[$row]);
        	if ($tokens[0] != null && 
        		$tokens[1] != null && 
        		$tokens[0] != 'NetID' && 
        		$tokens[1] != '???') { 
        		// searches for uid using the username (NetID)
            	$query = sprintf("SELECT uid
            					  FROM users 
							      WHERE name='%s'",
							      mysql_real_escape_string($tokens[0]));
            	$searchResult = mysql_query($query);
            	if ($searchResult && $item = mysql_fetch_assoc($searchResult)) {
            		$query = sprintf("INSERT INTO profile_values 
            						  (uid, value) VALUES 
            						  ('%s', '%s')",
									  mysql_real_escape_string($item['uid']),
									  mysql_real_escape_string($tokens[1]));
            		$insertResult = mysql_query($query);
            		if ($insertResult) {
						echo "Inserted ".$tokens[1]." with ID ".$item['uid']."<br/>";
            		}
            	}
        	}
        }
    }
    fclose($file);
}

mysql_close($con);

?>