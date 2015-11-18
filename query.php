<?php

include_once("hlconn.php");

$cols = array();
$conds = array();
$order = null;
$rev = false;
$max = null;

if (isset($_GET['get_id']))
{
    $cols[] = 'id';
}

if (isset($_GET['get_freq']))
{
    $cols[] = 'Frequency';
}

if (isset($_GET['get_serial']))
{
    $cols[] = 'Serial';
}

if (isset($_GET['get_prec']))
{
    $cols[] = 'Precedence';
}

if (isset($_GET['get_call']))
{
    $cols[] = 'Callsign';
}

if (isset($_GET['get_check']))
{
    $cols[] = 'CheckNum';
}

if (isset($_GET['get_section']))
{
    $cols[] = 'Section';
}

if (isset($_GET['get_created']))
{
    $cols[] = 'CreatedAt';
}

if (isset($_GET['get_logged']))
{
    $cols[] = 'LoggedAt';
}

if (isset($_GET['get_status']))
{
    $cols[] = 'Status';
}

if (isset($_GET['get_num']))
{
    $cols[] = 'ContactNumber';
}

if (isset($_GET['get_event']))
{
    $cols[] = 'EventID';
}

if (!isset($_GET['all_events']))
{
    try
    {
        $curr_event = $hl->currEvent();
    }
    catch (HardloggerException $e)
    {
        $e->handleHTTP();
    }

    $conds[] = "(EventID=" . $curr_event . ")";
}

if (isset($_GET['no_void']))
{
    $conds[] = "(Status != 2)";
}

if (isset($_GET['logged']))
{
    $conds[] = "(Status = 1)";
}

if (isset($_GET['queued']))
{
    $conds[] = "(Status = 0)";
}

if (isset($_GET['no_queued']))
{
    $conds[] = "(Status != 0)";
}

if (isset($_GET['qso_id']))
{
    $conds[] = "(id='" . mysql_real_escape_string($_GET['qso_id']) . "')";
}
else if (isset($_GET['call']))
{
    $conds[] = "(Callsign = '" . $_GET['call'] . "')";
}
else if (isset($_GET['search']))
{
    $search = "%" . mysql_real_escape_string($_GET['search']) . "%";
    $conds[] = "(Callsign LIKE '" . $search . "' OR Frequency LIKE '" . $search . "' OR Section LIKE '" . $search . "')";
}

if (isset($_GET['order']))
{
    switch ($_GET['order'])
    {
    case 'id':
        $order = "id";
        break;
    case 'freq':
        $order = "Frequency";
        break;
    case 'serial':
        $order = "Serial";
        break;
    case 'prec':
        $order = "Precedence";
        break;
    case 'call':
        $order = "Callsign";
        break;
    case 'check':
        $order = "CheckNum";
        break;
    case 'section':
        $order = "Section";
        break;
    case 'created':
        $order = "CreatedAt";
        break;
    case 'logged':
        $order = "LoggedAt";
        break;
    case 'status':
        $order = "Status";
        break;
    case 'num':
        $order = "ContactNumber";
        break;
    case 'event':
        $order = "EventID";
        break;
    default:
        $e = new HardloggerException("Invalid 'order' value '" . $_GET['order'] . "'");
        $e->handleHTTP();
        break;
    }
}

if (isset($_GET['rev']))
{
    $rev = true;
}

if (isset($_GET['max']))
{
    $max = $_GET['max'];
}

try
{
    $qsos = $hl->queryQSOs($cols, $conds, $order, $rev, $max);
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

echo json_encode($qsos);

?>
