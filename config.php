<?php
$currpage = "config";
include("header.php");
?>
<form action="editevent.php" method="post">
<table>
<tr><td colspan="2">Insert Event Selector Here - Insert Create new Event Button Here</td></tr>
<tr><td><input type="submit" value="Save Event"></td><td><input type="button" value="Download Cabrillo Log" onclick="location.href='cabrillo.php?event_id=' + HLEventID"></td></tr>
</table>
</form>
<?php
include("footer.php");
?>
