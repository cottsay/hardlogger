<?php
include_once("config.php");
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$criteria = mysql_real_escape_string($_GET['criteria']);
if(empty($criteria))
{
    echo "Search Ready.";
    exit; 
}
else
{
    $result = mysql_query("SELECT * FROM qsos WHERE Status!=2 AND Callsign LIKE '%" . $criteria . "%' OR Frequency LIKE '%" . $criteria . "%' ORDER BY LoggedAt DESC");
    if(mysql_num_rows($result) == 0)
    {
        echo "";
    } else {
        echo "<table width=\"100%\">\n";
        while($row = mysql_fetch_array($result, MYSQL_ASSOC))
        {
            echo "<tr" . (($row['EventID'] != $this_event) ? " style=\" color: #AAAAAA\"" : "") . "><td style=\"width:50px\">" . $row['Frequency'] . "</td><td style=\"width:150px\">" . $row['Callsign'] . " (" . $row['Serial'] . ")</td><td style=\"width:160px;\">" . $row['LoggedAt'] . "</td><td style=\"width:auto;\"><input " . (($row['EventID'] != $this_event) ? "disabled=\"disabled\" " : "") . "type=\"button\" value=\"Void\" onclick=\"voidQso(" . $row['id'] . ");searchFor();\"></td></tr>\n";
        }
        echo "</table>";
    }
}
?>