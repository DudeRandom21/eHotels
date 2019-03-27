<?php

	function createTable($query, $buttonText, $buttonLocation, $method = "get") {

		$db_connection = pg_connect("host=localhost dbname=csi2132_project user=web password=webapp");

		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		echo '<div class="table-wrapper-scroll-y my-custom-scrollbar">';
		echo '<table class="table table-bordered table-striped mb-0">';
		// TODO: add table headers if possible (simple)
		echo '<tbody>';
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		    echo "\t<tr>\n";
		    foreach ($line as $key => $col_value) {
		        echo "\t\t<td>$col_value</td>\n";
		    }

		    //TODO: clean this up if you have time it's a little gross
		    if ($method == "get") {
			    echo '<td>
			    		<a href="' . $buttonLocation . http_build_query(array('line' => $line)) . '" class="btn btn-primary">' . $buttonText . '</a>
					</td>
				</tr>';		    	
		    }
		    if ($method == "post")
		    	echo '<td>
		    			<form action="' . $buttonLocation . '" method="post">
		    				<input type="hidden" name="line" value="' . htmlentities(serialize($line)) . '">
		    				<input type="submit" class="btn btn-primary" name="submit" value="' . $buttonText . '">
		    			</form>
					</td>
				</tr>';		    	
		}
		echo "</table>\n";
		echo "</div>\n";		
	}


?>