<?php
include_once("hlconn.php");
try
{
    $hl->loadEvent();

    $event = $hl->getEvent();

    $stats = $hl->getStats();

    $maxbreak = $hl->getMaximumBreak();

    $twentymincnt = $hl->countQsos(array(0 => 'LoggedAt > (UTC_TIMESTAMP() - INTERVAL 20 MINUTE) AND EventID=' . $hl->currEvent()));

    $sixtymincnt = $hl->countQsos(array(0 => 'LoggedAt > (UTC_TIMESTAMP() - INTERVAL 60 MINUTE) AND EventID=' . $hl->currEvent()));
}
catch(HardloggerException $e)
{
    $e->handleHTTP();
}

$currpage = "summary";
include("header.php");
?>
<table>
<tr><td>Event Name:</td><td><?php echo $event['event_name'] ?></td></tr>
<tr><td>Event ID:</td><td><?php echo $event['id'] ?></td></tr>
<tr><td>Total QSOs:</td><td><?php echo $stats['count'] ?></td></tr>
<tr><td>Sections Hit:</td><td><?php echo $stats['sections'] ?>/83</td></tr>
<tr><td>First QSO:</td><td><?php echo $stats['first'] ?></td></tr>
<tr><td>Most Recent QSO:</td><td><?php echo $stats['last'] ?></td></tr>
<tr><td>Longest Break:</td><td><?php echo $maxbreak == '' ? '' : $maxbreak . ' hrs'  ?></td></tr>
<tr><td>20 Minute Rate:</td><td><?php echo $twentymincnt * 3 ?> QSOs/hr</td></tr>
<tr><td>60 Minute Rate:</td><td><?php echo $sixtymincnt ?> QSOs/hr</td></tr>
<tr><td>Current Score:</td><td><?php echo ((2 * $stats['count']) *  $stats['sections']) ?></td></tr>

</table>
<?php
include("footer.php");
?>
