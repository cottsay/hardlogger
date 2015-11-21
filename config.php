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
                <option value="ARRL-SS-SSB"<?php if ($event['contest'] == "ARRL-SS-SSB") echo " selected" ?>>ARRL-SS-SSB</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Operator:</td><td><select name="cat_operator">
                <option value="MULTI-OP"<?php if ($event['cat_operator'] == "MULTI-OP") echo " selected" ?>>MULTI-OP</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Assisted:</td><td><select name="cat_assist">
                <option value="ASSISTED"<?php if ($event['cat_assist'] == "ASSISTED") echo " selected" ?>>ASSISTED</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Band:</td><td><select name="cat_band">
                <option value="ALL"<?php if ($event['cat_band'] == "ALL") echo " selected" ?>>ALL</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Power:</td><td><select name="cat_power">
                <option value="HIGH"<?php if ($event['cat_power'] == "HIGH") echo " selected" ?>>HIGH</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Mode:</td><td><select name="cat_mode">
                <option value="CW"<?php if ($event['cat_mode_cat'] == "CW") echo " selected" ?>>CW</option>
                <option value="SSB"<?php if ($event['cat_mode_cat'] == "SSB") echo " selected" ?>>SSB</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Station:</td><td><select name="cat_station">
                <option value="SCHOOL"<?php if ($event['cat_station'] == "SCHOOL") echo " selected" ?>>SCHOOL</option>
            </select></td>
        </tr>
        <tr>
            <td>Category Transmitter:</td><td><select name="cat_transmitter">
                <option value="ONE"<?php if ($event['cat_transmitter'] == "ONE") echo " selected" ?>>ONE</option>
            </select></td>
        </tr>
        <tr>
            <td>Mode:</td><td><select name="mode">
                <option value="PH"<?php if ($event['cat_mode'] == "PH") echo " selected" ?>>PH</option>
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
            <td>Operators:</td><td><input name="operators" type="text" value="<?php echo $event['operators'] ?>"></td>
        </tr>
        <tr>
            <td>Soapbox:</td><td><textarea name="operators" rows="4" cols="25"><?php echo $event['soapbox'] ?></textarea></td>
        </tr>
        <tr>
            <td><input type="submit" value="Save Event"></td>
        </tr>
        <tr>
            <td><input type="button" value="Download Cabrillo Log" onclick="location.href='cabrillo.php?event_id=<?php echo $hl->currEvent() ?>#/<?php echo $event['callsign'] ?>.log'"></td><td><input type="button" value="View Cabrillo Log" onclick="location.href='cabrillo.php?view&amp;event_id=<?php echo $hl->currEvent() ?>#/<?php echo $event['callsign'] ?>.log'"></td>
        </tr>
        </table>
    </form></td>
</tr>
</table>
<?php
include("footer.php");
?>
