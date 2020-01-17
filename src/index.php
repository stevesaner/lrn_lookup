<?php

session_start();

$results = array();
if (isset($_SESSION['results'])) { $results = $_SESSION['results']; }

?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <title>LRN Lookup</title>
  <link rel='stylesheet' href='site.css'>
 </head>
 <body>
  <div id="main">
   <form name="lrnlookup" action="lookup.php">
    <div class="group">  
     <div>
      <label for="dids">Enter DIDs</label>
     </div>
     <div>
      <textarea id="dids" name="dids" cols="20" rows="20"></textarea>
     </div>
    </div>
    <div class="group">
     <input type="checkbox" name="caller" value="1">
     Include Caller Name
    </div>
    <div class="group">
     <button type="submit" value="Lookup">Lookup</button>
     <button type="reset" value="Clear">Clear</button>
    </div>
   </form>
<?php
if (isset($_SESSION['error'])) {
    echo("<div class=\"group\">\n");
    echo($_SESSION['error'] . "\n");
    echo("</div>\n");
    unset($_SESSION['error']);
}
else if (! empty($results)) {
    echo("<div class=\"group\">\n");
    echo("<table>\n");
    foreach ($results as $row) {
        echo("<tr>\n");
        echo("<td class=\"col\">" . $row[0] . "</td>\n");
        echo("<td class=\"col\">" . $row[1] . "</td>\n");
        echo("<td class=\"col\">" . $row[2] . "</td>\n");
        if (isset($row[3])) {
            echo("<td class=\"col\">" . $row[3] . "</td>\n");
        }

        echo("</tr>\n");
    }
    echo("</table>\n");
    echo("</div>\n");
    echo("<form name=\"lrnlookup\" action=\"download.php\">\n");
    echo("<div class=\"group\">\n");
    echo("<button type=\"submit\" value=\"Download Results\">Download Results</button>\n");
    echo("</div>\n");
    echo("</form>\n"); 
}
?>
  </div>
 </body>
</html>
