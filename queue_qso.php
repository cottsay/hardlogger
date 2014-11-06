<?php
include_once("config.php");
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(!isset($_GET['qso_frequency']) || !isset($_GET['qso_callsign']) || !isset($_GET['qso_check']) || !isset($_GET['qso_section']) || !isset($_GET['qso_precedence']))
{
    echo "500";
}
else
{
    mysql_query("INSERT INTO qsos(Frequency,Precedence,Callsign,CheckNum,Section,CreatedAt,Status,ContactNumber,EventID) VALUES('" . mysql_real_escape_string($_GET['qso_frequency']) . "','" . mysql_real_escape_string($_GET['qso_precedence']) . "','" . mysql_real_escape_string($_GET['qso_callsign']) . "'," . ((empty($_GET['qso_check'])) ? "NULL" : mysql_real_escape_string($_GET['qso_check'])) . ",'" . mysql_real_escape_string($_GET['qso_section']) . "',UTC_TIMESTAMP(),0,0," . $this_event . ");");
    echo "200";
}
?>