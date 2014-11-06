<?php
include_once("config.php");
header("Content-type: text/plain");
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
echo "START-OF-LOG: 3.0
CALLSIGN: " . $event['callsign'] . "
CONTEST: " . $event['contest'] . "
CATEGORY-OPERATOR: " . $event['cat_operator'] . "
CATEGORY-ASSISTED: " . $event['cat_assist'] . "
CATEGORY-BAND: " . $event['cat_band'] . "
CATEGORY-POWER: " . $event['cat_power'] . "
CATEGORY-MODE: " . $event['cat_mode_cat'] . "
CATEGORY-STATION: " . $event['cat_station'] . "
CATEGORY-TRANSMITTER: " . $event['cat_transmitter'] . "
CLAIMED-SCORE: " . ((2 * $event['qsos']) *  $event['sections']) . "
CLUB: " . $event['club'] . "
LOCATION: " . $event['location'] . "
CREATED-BY: HardLogger 2.0
NAME: " . $event['name'] . "
ADDRESS: " . $event['address'] . "
ADDRESS-CITY: " . $event['city'] . "
ADDRESS-STATE-PROVINCE: " . $event['state'] . "
ADDRESS-POSTALCODE: " . $event['postal'] . "
ADDRESS-COUNTRY: " . $event['country'] . "
OPERATORS: " . $event['operators'] . "\n";
$soapbox = explode("\n",$event['soapbox']);
foreach($soapbox as $box)
{
    echo "SOAPBOX: " . $box . "\n";
}
$result = mysql_query("SELECT * FROM qsos WHERE EventID=" . $this_event . " AND status=1 ORDER BY ContactNumber ASC");
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
    echo "QSO: " . str_pad($row['Frequency'],5,' ',STR_PAD_LEFT) . ' ' . $event['cat_mode'] . ' ' . date("Y-m-d", strtotime($row['LoggedAt'])) . ' ' . date("Hi", strtotime($row['LoggedAt'])) . ' ' . str_pad($event['callsign'],13) . ' ' . str_pad($row['ContactNumber'],4,' ',STR_PAD_LEFT) . ' ' . $event['precedence'] . ' ' . str_pad($event['chk'],2,'0',STR_PAD_LEFT) . ' ' . str_pad('SD',3) . ' ' . str_pad($row['Callsign'],13) . ' ' . str_pad($row['Serial'],4,' ', STR_PAD_LEFT) . ' ' . $row['Precedence'] . ' ' . str_pad($row['CheckNum'],2,'0',STR_PAD_LEFT) . ' ' . str_pad($row['Section'],3) . "\n";
}
echo "END-OF-LOG:";
?>
