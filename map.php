<?php
include_once("hardlogger.php");

try
{
    $hl = new Hardlogger();

    $hl->selectEvent((isset($_GET['event_id']) && !empty($_GET['event_id'])) ? $_GET['event_id'] : null);
    $event_id = $hl->currEvent();
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

$currpage = "map";
include("header.php");
echo "<div>GREEN: Sections that have been hit THIS time. --- GREY: Sections that have been hit previously. --- RED: Sections that have NEVER been hit</div>
<div><img src=\"map_image.php?event_id=" . $event_id . "\" alt=\"Section Map\" class=\"map\"></div>";
include("footer.php");
?>
