<?php
include_once("hlconn.php");
try
{
    $hl->loadEvent();

    $event = $hl->getEvent();

    $stats = $hl->getStats();

    $maxbreak = $hl->getMaximumBreak();

    $tenminavg = $hl->countQsos(array(0 => 'LoggedAt > (UTC_TIMESTAMP() - INTERVAL 10 MINUTE) AND EventID=' . $hl->currEvent()));
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
<tr><td>LongestBreak:</td><td><?php echo $maxbreak == '' ? '' : $maxbreak . ' hrs'  ?></td></tr>
<tr><td>10 Minute Average:</td><td><?php echo $tenminavg * 6 ?> QSOs/hr</td></tr>
<tr><td>Current Score:</td><td><?php echo ((2 * $stats['count']) *  $stats['sections']) ?></td></tr>

</table>
<?php
include("footer.php");
?>
