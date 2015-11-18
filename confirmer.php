<?php
include_once("hlconn.php");

try
{
    $event = $hl->getEvent();
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

?>
<table class="unittable">
    <tr>
        <td class="unittd"><h3>New QSO</h3></td>
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
                    <td class="resulttd"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="unittd" id="newqso_confirmed">
            <form class="qsoform" action="newqso.php?event_id=<?php echo $hl->currEvent() ?>" method="post">
                <table class="headertable">
                    <tr>
                        <td class="resulttd freq_cell"><input name="local_freq" type="text" class="local_newqso" readonly></td>
                        <td class="resulttd serial_cell"><input name="num" type="text" class="local_newqso" readonly></td>
                        <td class="resulttd prec_cell"><input name="local_prec" type="text" class="local_newqso" readonly value="<?php echo $event['precedence'] ?>"></td>
                        <td class="resulttd call_cell"><input name="local_call" type="text" class="local_newqso" readonly value="<?php echo $event['callsign'] ?>"></td>
                        <td class="resulttd check_cell"><input name="local_check" type="text" class="local_newqso" readonly value="<?php echo $event['chk'] ?>"></td>
                        <td class="resulttd section_cell"><input name="local_section" type="text" class="local_newqso" readonly value="<?php echo $event['location'] ?>"></td>
                        <td class="resulttd dupe_message_display"></td>
                    </tr>
                    <tr>
                        <td class="resulttd freq_cell"><input name="freq" type="text" class="newqso"></td>
                        <td class="resulttd serial_cell"><input name="serial" type="text" class="newqso"></td>
                        <td class="resulttd prec_cell"><input name="prec" type="text" class="newqso"></td>
                        <td class="resulttd call_cell"><input name="call" type="text" class="newqso"></td>
                        <td class="resulttd check_cell"><input name="check" type="text" class="newqso"></td>
                        <td class="resulttd section_cell"><input name="section" type="text" class="newqso"></td>
                        <td class="resulttd"><input name="status" type="hidden" value="1"><input name="stamp" type="hidden" value="NOW()"><input name="original_id" type="hidden"><input type="submit" value="Confirm QSO"> <input name="clear" type="button" value="Clear"> <input type="checkbox" name="validation_override">Override Validation</td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td class="unittd"><div id="selectable_queue"></div></td>
    </tr>
</table>
<script type="text/javascript" src="confirmer.js"></script>
<script type="text/javascript" src="queue.js"></script>
<?php
include_once("voider.php");
include_once("editor.php");
include_once("adder.php");
?>
