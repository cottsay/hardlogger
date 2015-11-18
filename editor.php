<?php
include_once("hlconn.php");
?>
<div id="editor">
<form action="editqso.php?event_id=<?php echo $hl->currEvent() ?>" method="post" class="qsoform">
<table>
<caption>Edit QSO</caption>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td>Contact Number:</td><td><input type="text" name="num"></td></tr>
<tr><td>Frequency:</td><td><input type="text" name="freq"></td></tr>
<tr><td>Serial:</td><td><input type="text" name="serial"></td></tr>
<tr><td>Precedence:</td><td><input type="text" name="prec" class="caps"></td></tr>
<tr><td>Callsign:</td><td><input type="text" name="call" class="caps"></td></tr>
<tr><td>Check:</td><td><input type="text" name="check"></td></tr>
<tr><td>Section:</td><td><input type="text" name="section" class="caps"></td></tr>
<tr><td>Timestamp:</td><td><input type="text" name="stamp" class="caps"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><input type="checkbox" name="validation_override">Override Validation</td></tr>
<tr><td colspan="2"><input type="hidden" name="qso_id"><input type="submit" value="Save Changes"></td></tr>
</table>
</form>
</div>
<div id="editresult">
<table>
<caption>Edit QSO</caption>
<tr><td>&nbsp;</td></tr>
<tr><td id="editresulttd"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><input type="button" value="OK" id="editresultclose"></td></tr>
</table>
</div>
<script type="text/javascript" src="editor.js"></script>
<?php include_once("validator.php"); ?>
