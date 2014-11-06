<?php
include_once("config.php");
if(isset($_GET['id']) && !empty($_GET['id']))
{
    mysql_query("UPDATE qsos SET Status=2 WHERE id=" . mysql_real_escape_string($_GET['id']) . ";");
    echo "200";
}
else
{
    echo "500";
}
?>