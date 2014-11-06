<?php
include_once("config.php");
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(!isset($_GET['qso_num']) || ($_GET['qso_num'] != $event['next_qso']) || !isset($_GET['qso_frequency']) || !isset($_GET['qso_callsign']) || !isset($_GET['qso_serial']) || !isset($_GET['qso_check']) || !isset($_GET['qso_section']) || !isset($_GET['qso_precedence']))
{
    echo "500";
}
else
{
    if(isset($_GET['qso_id']) && !empty($_GET['qso_id']))
    {
        mysql_query("UPDATE qsos SET Frequency='" . mysql_real_escape_string($_GET['qso_frequency']) . "', Serial=" . mysql_real_escape_string($_GET['qso_serial']) . ", Precedence='" . mysql_real_escape_string($_GET['qso_precedence']) . "', Callsign='" . mysql_real_escape_string($_GET['qso_callsign']) . "', CheckNum=" . mysql_real_escape_string($_GET['qso_check']) . ", Section='" . mysql_real_escape_string($_GET['qso_section']) . "', LoggedAt=UTC_TIMESTAMP, Status=1, ContactNumber=" . mysql_real_escape_string($_GET['qso_num']) . " WHERE id=" . mysql_real_escape_string($_GET['qso_id']));
    }
    else
    {
        mysql_query("INSERT INTO qsos(Frequency,Serial,Precedence,Callsign,CheckNum,Section,CreatedAt,LoggedAt,Status,ContactNumber,EventID) VALUES('" . mysql_real_escape_string($_GET['qso_frequency']) . "'," . mysql_real_escape_string($_GET['qso_serial']) . ",'" . mysql_real_escape_string($_GET['qso_precedence']) . "','" . mysql_real_escape_string($_GET['qso_callsign']) . "'," . mysql_real_escape_string($_GET['qso_check']) . ",'" . mysql_real_escape_string($_GET['qso_section']) . "',UTC_TIMESTAMP(),UTC_TIMESTAMP(),1," . mysql_real_escape_string($_GET['qso_num']) . "," . $this_event . ");");
    }
    echo "200";
}
?>