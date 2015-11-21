<?php
include_once("hlconn.php");

try
{
    $vals = array();

    if (isset($_POST['event']))
    {
        $vals['event'] = $_POST['event'];
    }

    $hl->editSettings($vals);
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}
?>
