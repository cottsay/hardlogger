<?php
include_once("hlconn.php");

try
{
    if (!isset($_POST['qso_id']))
    {
        throw new HardloggerException("No supplied qso_id value");
    }

    $vals = array();

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
        $vals['LoggedAt'] = $_POST['stamp'];
    }

    if (isset($_POST['prec']))
    {
        $vals['Precedence'] = strtoupper($_POST['prec']);
    }

    if (isset($_POST['section']))
    {
        $vals['Section'] = strtoupper($_POST['section']);
    }

    $hl->editQSO($_POST['qso_id'], $vals);
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}
?>
