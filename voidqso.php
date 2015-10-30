<?php
include_once("hlconn.php");

try
{
    if (!isset($_POST['qso_id']))
    {
        throw new HardloggerException("No supplied qso_id value");
    }

    $hl->editQSO($_POST['qso_id'], array('Status' => 2));
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}
?>
