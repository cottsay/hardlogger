<?php
include_once("hlconn.php");

try
{
    $event = $hl->getEvent();
    $stats = $stats = $hl->getStats();
    $qsos = $hl->queryQSOs(['Frequency', 'LoggedAt', 'ContactNumber', 'Callsign', 'Serial', 'Precedence', 'CheckNum', 'Section'], ['(EventID=' . $event['id'] . ')', '(Status=1)'], 'ContactNumber', false, null);
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

$cabrillo = "START-OF-LOG: 3.0
CALLSIGN: " . $event['callsign'] . "
CONTEST: " . $event['contest'] . "
CATEGORY-OPERATOR: " . $event['cat_operator'] . "
CATEGORY-ASSISTED: " . $event['cat_assist'] . "
CATEGORY-BAND: " . $event['cat_band'] . "
CATEGORY-POWER: " . $event['cat_power'] . "
CATEGORY-MODE: " . $event['cat_mode_cat'] . "
CATEGORY-STATION: " . $event['cat_station'] . "
CATEGORY-TRANSMITTER: " . $event['cat_transmitter'] . "
CLAIMED-SCORE: " . ((2 * $stats['count']) *  $stats['sections']) . "
CLUB: " . $event['club'] . "
LOCATION: " . $event['location'] . "
CREATED-BY: Hardlogger " . Hardlogger::Version . "
NAME: " . $event['name'] . "
ADDRESS: " . $event['address'] . "
ADDRESS-CITY: " . $event['city'] . "
ADDRESS-STATE-PROVINCE: " . $event['state'] . "
ADDRESS-POSTALCODE: " . $event['postal'] . "
ADDRESS-COUNTRY: " . $event['country'] . "
OPERATORS: " . $event['operators'] . "\r\n";

$soapbox = explode("\r\n", $event['soapbox']);
foreach($soapbox as $box)
{
    $cabrillo .= "SOAPBOX: " . $box . "\r\n";
}

foreach ($qsos as $row)
{
    $cabrillo .= "QSO: " . str_pad($row['Frequency'],5,' ',STR_PAD_LEFT) . ' ' . $event['cat_mode'] . ' ' . date("Y-m-d", strtotime($row['LoggedAt'])) . ' ' . date("Hi", strtotime($row['LoggedAt'])) . ' ' . str_pad($event['callsign'],13) . ' ' . str_pad($row['ContactNumber'],4,' ',STR_PAD_LEFT) . ' ' . $event['precedence'] . ' ' . str_pad($event['chk'],2,'0',STR_PAD_LEFT) . ' ' . str_pad($event['location'] ,3) . ' ' . str_pad($row['Callsign'],13) . ' ' . str_pad($row['Serial'],4,' ', STR_PAD_LEFT) . ' ' . $row['Precedence'] . ' ' . str_pad($row['CheckNum'],2,'0',STR_PAD_LEFT) . ' ' . str_pad($row['Section'],3) . "\r\n";
}

$cabrillo .= "END-OF-LOG:\r\n";

header('Content-Description: File Transfer');
header("Content-type: text/plain");
header('Content-Disposition: attachment; filename="' . $event['callsign'] . '.log"');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header('Content-Length: ' . strlen($cabrillo));

echo $cabrillo;

?>
