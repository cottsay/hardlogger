<?php
include_once("config.php");
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$selected = (isset($_GET['selected']) && !empty($_GET['selected'])) ? mysql_real_escape_string($_GET['selected']) : -1;

$result = mysql_query("SELECT * FROM qsos WHERE EventID=" . $this_event . " AND status=0 ORDER BY CreatedAt ASC");
if(mysql_num_rows($result) == 0)
{
    echo "There are no queued QSOs.";
}
else
{
    echo "<table style=\"width:100%;\">";
    while($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
        $mouseup = (isset($_GET['noclick']) && ($_GET['noclick'])) ? "" : "onMouseUp=\"deQue(" . $row['id'] . "," . $row['Frequency'] . ",'" . $row['Precedence'] . "','" . $row['Callsign'] . "','" . $row['CheckNum'] . "','" . $row['Section'] . "');\" ";
        echo "<tr id=\"queue_" . $row['id'] . "\"" . (($row['id'] == $selected) ? " style=\"background-Color:#00FF00;\"" : "") . "><td " . $mouseup . "style=\"width:100px;text-align:right;padding-right:35px\">" . $row['Frequency'] . "</td><td " . $mouseup . "style=\"width:215px;text-align:right;padding-right:35px\">" . $row['Precedence'] . "</td><td " . $mouseup . "style=\"width:95px;text-align:right;padding-right:35px\">" . $row['Callsign'] . "</td><td " . $mouseup . " style=\"width:65px;text-align:right;padding-right:35px\">" . ((!empty($row['CheckNum'])) ? str_pad($row['CheckNum'],2,'0',STR_PAD_LEFT) : "") . "</td><td " . $mouseup . "style=\"width:65px;text-align:right;padding-right:35px\">" . $row['Section'] . "</td><td><input type=\"button\" value=\"Void\" onmouseup=\"voidQso(" . $row['id'] . ");\"></td></tr>\n";
    }
    echo "</table>";
}
?>
