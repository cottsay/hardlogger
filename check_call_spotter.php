<?php
include_once("config.php");
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(isset($_GET['call']) && !empty($_GET['call']))
{
    $result = mysql_query("SELECT * FROM qsos WHERE Callsign='" . mysql_real_escape_string($_GET['call']) . "' AND ( status=0 OR status=1 ) AND EventID=" . $this_event);
    if(mysql_num_rows($result) > 0)
        echo 1;
    else
        echo '';
}
?>
