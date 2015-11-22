<?php
$currpage = "config";
include("header.php");

try
{
    $event = $hl->getEvent();
    $events = $hl->getEvents();
}
catch (HardloggerException $e)
{
    $e->handleHTTP();
}

?>
<table>
<tr>
    <td><form action="editsettings.php" method="post">
        <table>
        <tr>
            <td class="settings_first">Default Event:</td>
            <td class="settings_second"><select name="event" class="event_box">
<?php
foreach ($events as $this_event)
{
    echo "        <option value=\"" . $this_event['id'] . "\"";
    if ($this_event['id'] == $hl->currEvent())
    {
        echo " selected";
    }
    echo ">" . $this_event['event_name'] . " (" . $this_event['callsign'] . ")</option>\n";
}
?>
            </select></td>
            <td><input type="submit" value="Set As Default"></td>
        </tr>
        </table>
    </form></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><form action="newevent.php" method="post">
        <table>
        <tr>
            <td class="settings_first">New Event Title:</td>
            <td class="settings_second"><input type="text" class="event_box"></td>
            <td><input type="submit" value="Create Event"></td>
        </tr>
        </table>
    </form></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><form action="editevent.php?event_id=<?php echo $hl->currEvent() ?>" method="post">
        <table>
        <caption>Current Event Configuration</caption>
        <tr>
            <td>Event Name:</td><td><input name="event_name" type="text" value="<?php echo $event['event_name'] ?>"></td>
        </tr>
        <tr>
            <td>Callsign:</td><td><input name="callsign" type="text" value="<?php echo $event['callsign'] ?>"></td>
        </tr>
        <tr>
            <td>Check:</td><td><input name="check" type="text" value="<?php echo $event['chk'] ?>"></td>
        </tr>
        <tr>
            <td>Precedence:</td><td><input name="precedence" type="text" value="<?php echo $event['precedence'] ?>"></td>
        </tr>
        <tr>
            <td>Club:</td><td><input name="club" type="text" value="<?php echo $event['club'] ?>"></td>
        </tr>
        <tr>
            <td>Contest:</td><td><select name="contest">
                <option value="ARRL-SS-CW"<?php if ($event['contest'] == "ARRL-SS-CW") echo " selected" ?>>ARRL-SS-CW</option>
                <option value="ARRL-SS-SSB"<?php if ($event['contest'] == "ARRL-SS-SSB") echo " selected" ?>>ARRL-SS-SSB</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Operator:</td><td><select name="cat_operator">
                <option value="CHECKLOG"<?php if ($event['cat_operator'] == "CHECKLOG") echo " selected" ?>>CHECKLOG</option>
                <option value="MULTI-OP"<?php if ($event['cat_operator'] == "MULTI-OP") echo " selected" ?>>MULTI-OP</option>
                <option value="SINGLE-OP"<?php if ($event['cat_operator'] == "SINGLE-OP") echo " selected" ?>>SINGLE-OP</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Assisted:</td><td><select name="cat_assist">
                <option value="ASSISTED"<?php if ($event['cat_assist'] == "ASSISTED") echo " selected" ?>>ASSISTED</option>
                <option value="NON-ASSISTED"<?php if ($event['cat_assist'] == "NON-ASSISTED") echo " selected" ?>>NON-ASSISTED</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Band:</td><td><select name="cat_band">
                <option value="ALL"<?php if ($event['cat_band'] == "ALL") echo " selected" ?>>ALL</option>
                <option value="10M"<?php if ($event['cat_band'] == "10M") echo " selected" ?>>10M</option>
                <option value="15M"<?php if ($event['cat_band'] == "15M") echo " selected" ?>>15M</option>
                <option value="20M"<?php if ($event['cat_band'] == "20M") echo " selected" ?>>20M</option>
                <option value="40M"<?php if ($event['cat_band'] == "40M") echo " selected" ?>>40M</option>
                <option value="80M"<?php if ($event['cat_band'] == "80M") echo " selected" ?>>80M</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Power:</td><td><select name="cat_power">
                <option value="HIGH"<?php if ($event['cat_power'] == "HIGH") echo " selected" ?>>HIGH</option>
                <option value="LOW"<?php if ($event['cat_power'] == "LOW") echo " selected" ?>>LOW</option>
                <option value="QRP"<?php if ($event['cat_power'] == "QRP") echo " selected" ?>>QRP</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Mode:</td><td><select name="cat_mode">
                <option value="CW"<?php if ($event['cat_mode_cat'] == "CW") echo " selected" ?>>CW</option>
                <option value="MIXED"<?php if ($event['cat_mode_cat'] == "MIXED") echo " selected" ?>>MIXED</option>
                <option value="RTTY"<?php if ($event['cat_mode_cat'] == "RTTY") echo " selected" ?>>RTTY</option>
                <option value="SSB"<?php if ($event['cat_mode_cat'] == "SSB") echo " selected" ?>>SSB</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Station:</td><td><select name="cat_station">
                <option value="EXPEDITION"<?php if ($event['cat_station'] == "FIXED") echo " selected" ?>>EXPEDITION</option>
                <option value="FIXED"<?php if ($event['cat_station'] == "FIXED") echo " selected" ?>>FIXED</option>
                <option value="HQ"<?php if ($event['cat_station'] == "HQ") echo " selected" ?>>HQ</option>
                <option value="MOBILE"<?php if ($event['cat_station'] == "MOBILE") echo " selected" ?>>MOBILE</option>
                <option value="PORTABLE"<?php if ($event['cat_station'] == "PORTABLE") echo " selected" ?>>PORTABLE</option>
                <option value="ROVER"<?php if ($event['cat_station'] == "ROVER") echo " selected" ?>>ROVER</option>
                <option value="ROVER-LIMITED"<?php if ($event['cat_station'] == "ROVER-LIMITED") echo " selected" ?>>ROVER-LIMITED</option>
                <option value="ROVER-UNLIMITED"<?php if ($event['cat_station'] == "ROVER-UNLIMITED") echo " selected" ?>>ROVER-UNLIMITED</option>
                <option value="SCHOOL"<?php if ($event['cat_station'] == "SCHOOL") echo " selected" ?>>SCHOOL</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Transmitter:</td><td><select name="cat_transmitter">
                <option value="ONE"<?php if ($event['cat_transmitter'] == "ONE") echo " selected" ?>>ONE</option>
                <option value="TWO"<?php if ($event['cat_transmitter'] == "TWO") echo " selected" ?>>TWO</option>
                <option value="LIMITED"<?php if ($event['cat_transmitter'] == "LIMITED") echo " selected" ?>>LIMITED</option>
                <option value="UNLIMITED"<?php if ($event['cat_transmitter'] == "UNLIMITED") echo " selected" ?>>UNLIMITED</option>
                <option value="SWL"<?php if ($event['cat_transmitter'] == "SWL") echo " selected" ?>>SWL</option>
            </select></td>
        </tr>
        <tr>
            <td>Mode:</td><td><select name="mode">
                <option value="CW"<?php if ($event['cat_mode'] == "CW") echo " selected" ?>>CW</option>
                <option value="FM"<?php if ($event['cat_mode'] == "FM") echo " selected" ?>>FM</option>
                <option value="PH"<?php if ($event['cat_mode'] == "PH") echo " selected" ?>>PH</option>
                <option value="RY"<?php if ($event['cat_mode'] == "RY") echo " selected" ?>>RY</option>
            </select></td>
        </tr>
        <tr>
            <td>Location:</td><td><select name="location">
                <option value="SD"<?php if ($event['location'] == "SD") echo " selected" ?>>SD</option>
            </select></td>
        </tr>
        <tr>
            <td>Contact Name:</td><td><input name="name" type="text" value="<?php echo $event['name'] ?>"></td>
        </tr>
        <tr>
            <td>Contact Address:</td><td><input name="address" type="text" value="<?php echo $event['address'] ?>"></td>
        </tr>
        <tr>
            <td>Contact City:</td><td><input name="city" type="text" value="<?php echo $event['city'] ?>"></td>
        </tr>
        <tr>
            <td>Contact State:</td><td><input name="state" type="text" value="<?php echo $event['state'] ?>"></td>
        </tr>
        <tr>
            <td>Contact Postal:</td><td><input name="postal" type="text" value="<?php echo $event['postal'] ?>"></td>
        </tr>
        <tr>
            <td>Contact Country:</td><td><input name="country" type="text" value="<?php echo $event['country'] ?>"></td>
        </tr>
        <tr>
            <td>Contact Email:</td><td><input name="email" type="text" value="<?php echo 'N/A'/*$event['email']*/ ?>"></td>
        </tr>
        <tr>
            <td>Operators:</td><td><input name="operators" type="text" value="<?php echo $event['operators'] ?>"></td>
        </tr>
        <tr>
            <td>Soapbox:</td><td><textarea name="operators" rows="4" cols="25"><?php echo $event['soapbox'] ?></textarea></td>
        </tr>
        <tr>
            <td><input type="submit" value="Save Event"></td>
        </tr>
        <tr>
            <td><input type="button" value="Download Cabrillo Log" onclick="window.open('cabrillo.php?event_id=<?php echo $hl->currEvent() ?>#/<?php echo $event['callsign'] ?>.log', '_blank');"></td><td><input type="button" value="View Cabrillo Log" onclick="window.open('cabrillo.php?view&amp;event_id=<?php echo $hl->currEvent() ?>#/<?php echo $event['callsign'] ?>.log', '_blank');"></td>
        </tr>
        </table>
    </form></td>
</tr>
</table>
<?php
include("footer.php");
?>
