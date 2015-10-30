<?php

include_once("hardlogger.php");

$hl = new Hardlogger();

try
{
    $hl->selectEvent((isset($_GET['event_id']) && !empty($_GET['event_id'])) ? $_GET['event_id'] : null);
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

?>
