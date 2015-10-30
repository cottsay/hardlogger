<?php
include_once("hlconn.php");

if (!isset($currpage)) $currpage = ""
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Hardlogger::fancyBoxURL ?>/source/jquery.fancybox.css" media="screen">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <script type="text/javascript" src="<?php echo Hardlogger::jQueryURL ?>/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo Hardlogger::jQueryWatermarkURL ?>/jquery.watermark.min.js"></script>
    <script type="text/javascript" src="<?php echo Hardlogger::fancyBoxURL ?>/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="search.js"></script>
    <script type="text/javascript">
        var HLEventID = <?php echo $hl->currEvent() ?>;

        $(document).ready(function()
        {
            $(".fancybox").fancybox();
        });
    </script>
    <title>Hardlogger</title>
</head>
<body>
<h1>HardLogger</h1>
<div class="menu">
    <ul>
        <li<?php if ($currpage == "summary") echo " class=\"active\"" ?>><a href="summary.php?event_id=<?php echo $hl->currEvent() ?>">Summary</a></li>
        <li<?php if ($currpage == "map") echo " class=\"active\"" ?>><a href="map.php?event_id=<?php echo $hl->currEvent() ?>">Map</a></li>
        <li<?php if ($currpage == "operator") echo " class=\"active\"" ?>><a href="operator.php?event_id=<?php echo $hl->currEvent() ?>">Operator</a></li>
        <li<?php if ($currpage == "spotter") echo " class=\"active\"" ?>><a href="spotter.php?event_id=<?php echo $hl->currEvent() ?>">Spotter</a></li>
        <li<?php if ($currpage == "config") echo " class=\"active\"" ?>><a href="config.php?event_id=<?php echo $hl->currEvent() ?>">Config</a></li>
        <li<?php if ($currpage == "about") echo " class=\"active\"" ?>><a href="about.php?event_id=<?php echo $hl->currEvent() ?>">About</a></li>
    </ul>
</div>
