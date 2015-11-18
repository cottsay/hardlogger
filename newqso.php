<?php
include_once("hlconn.php");

try
{
    if (!isset($_POST['status']))
    {
        throw new HardloggerException("No supplied status value");
    }

    $vals = array('Status' => $_POST['status']);

    if (isset($_POST['num']))
    {
        $vals['ContactNumber'] = $_POST['num'];
    }

    if (isset($_POST['check']))
    {
        $vals['CheckNum'] = $_POST['check'];
    }

    if (isset($_POST['serial']))
    {
        $vals['Serial'] = $_POST['serial'];
    }

    if (isset($_POST['call']))
    {
        $vals['Callsign'] = strtoupper($_POST['call']);
    }

    if (isset($_POST['freq']))
    {
        $vals['Frequency'] = $_POST['freq'];
    }

    if (isset($_POST['stamp']))
    {
        $vals['LoggedAt'] = strtoupper($_POST['stamp']);
    }

    if (isset($_POST['prec']))
    {
        $vals['Precedence'] = strtoupper($_POST['prec']);
    }

    if (isset($_POST['section']))
    {
        $vals['Section'] = strtoupper($_POST['section']);
    }

    if (isset($_POST['original_id']) && !empty($_POST['original_id']))
    {
        $hl->editQSO($_POST['original_id'], $vals);
    }
    else
    {
        $hl->newQSO($vals);
    }
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}
?>
