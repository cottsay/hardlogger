<?php
include_once("hlconn.php");
?>
<div id="voider">
<form action="voidqso.php?event_id=<?php echo $hl->currEvent() ?>" method="post" id="voidform">
<table>
<caption>Void QSO</caption>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">Are you sure you want to void the QSO?</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td><input type="hidden" name="qso_id"><input type="submit" value="Confirm"></td><td><input type="button" value="Cancel" id="cancelvoid"></td><td>&nbsp;</td></tr>
</table>
</form>
</div>
<div id="voidresult">
<table>
<caption>Void QSO</caption>
<tr><td>&nbsp;</td></tr>
<tr><td id="voidresulttd"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><input type="button" value="OK" id="voidresultclose"></td></tr>
</table>
</div>
<script type="text/javascript" src="voider.js"></script>
