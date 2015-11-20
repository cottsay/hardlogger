<?php
$currpage = "config";
include("header.php");

try
{
    $event = $hl->getEvent();
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

?>
<form action="editevent.php?event_id=<?php echo $hl->currEvent() ?>" method="post">
<table>
<tr><td colspan="3">Insert Event Selector Here - Insert Create new Event Button Here</td></tr>
<tr><td><input type="submit" value="Save Event"></td><td><input type="button" value="Download Cabrillo Log" onclick="location.href='cabrillo.php?event_id=<?php echo $hl->currEvent() ?>#/<?php echo $event['callsign'] ?>.log'"></td><td><input type="button" value="View Cabrillo Log" onclick="location.href='cabrillo.php?view&event_id=<?php echo $hl->currEvent() ?>#/<?php echo $event['callsign'] ?>.log'"></td></tr>
</table>
</form>
<?php
include("footer.php");
?>
