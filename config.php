<?php
//Initialize DB
mysql_connect("localhost", "hardlogger", "asdf1234");
mysql_select_db("hardlogger");

//Get Settings
$settings = array();
$result = mysql_query("SELECT * FROM settings");
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
    $settings[$row['var']] = $row['val'];
}

$this_event = (isset($_GET['event_id'])) ? $_GET['event_id'] : $settings['event'];

//Get Current Event Info
$result = mysql_query("SELECT * FROM events WHERE id=" . $this_event);
$event = mysql_fetch_array($result, MYSQL_ASSOC);
$result = mysql_query("SELECT COUNT(*),COUNT(DISTINCT Section),MIN(LoggedAt),MAX(LoggedAt) FROM qsos WHERE EventID=" . $this_event . " AND status=1");
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$event['qsos'] = $row['COUNT(*)'];
$event['sections'] = $row['COUNT(DISTINCT Section)'];
$event['first_qso'] = $row['MIN(LoggedAt)'];
$event['last_qso'] = $row['MAX(LoggedAt)'];
$result = mysql_query("SELECT MAX(ContactNumber) FROM qsos WHERE EventID=" . $this_event);
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$event['next_qso'] = ($row['MAX(ContactNumber)']) ? $row['MAX(ContactNumber)'] + 1 : 1;
$mode = (isset($_GET['mode'])) ? $_GET['mode'] : 'summary';
?>