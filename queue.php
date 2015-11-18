<?php
include_once("hlconn.php");
?>
<table class="unittable">
    <tr>
        <td class="unittd"><h3>New Queued QSO</h3></td>
    </tr>
    <tr>
        <td class="unittd">
            <table class="headertable">
                <tr>
                    <td class="resulttd freq_cell">Frequency</td>
                    <td class="resulttd serial_cell">Serial</td>
                    <td class="resulttd prec_cell">Precedence</td>
                    <td class="resulttd call_cell">Callsign</td>
                    <td class="resulttd check_cell">Check</td>
                    <td class="resulttd section_cell">Section</td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="unittd" id="newqso_queued">
            <form class="qsoform" action="newqso.php?event_id=<?php echo $hl->currEvent() ?>" method="post">
                <table class="headertable">
                    <tr>
                        <td class="resulttd freq_cell"><input name="freq" type="text" class="newqso"></td>
                        <td class="resulttd serial_cell"><input name="serial" type="text" class="newqso" disabled="disabled"></td>
                        <td class="resulttd prec_cell"><input name="prec" type="text" class="newqso"></td>
                        <td class="resulttd call_cell"><input name="call" type="text" class="newqso"></td>
                        <td class="resulttd check_cell"><input name="check" type="text" class="newqso"></td>
                        <td class="resulttd section_cell"><input name="section" type="text" class="newqso"></td>
                        <td class="resulttd"><input name="status" type="hidden" value="0"><input type="submit" value="Queue QSO"> <input name="clear" type="button" value="Clear"> <input type="checkbox" name="validation_override">Override Validation</td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td class="unittd"><div id="queue"></div></td>
    </tr>
</table>
<script type="text/javascript" src="queue.js"></script>
<?php
include_once("voider.php");
include_once("editor.php");
include_once("adder.php");
?>
