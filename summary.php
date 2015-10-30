<?php
include_once("hlconn.php");
try
{
    $hl->loadEvent();
}
catch(HardloggerException $e)
{
    $e->handleHTTP();
}

$event = $hl->getEvent();

try
{
    $stats = $hl->getStats();
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
</table>
<?php
include("footer.php");
?>
