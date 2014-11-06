<?php
include_once("config.php");
echo "<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv=\"content-type\" content=\"text/html;charset=UTF-8\">
<title>Logger</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"ddtabmenufiles/chromemenu.css\">
<script type=\"text/javascript\">
function searchFor()
{
scriteria=document.getElementById(\"searchcriteria\");
sbox=document.getElementById(\"searchbox\");
scriteria.value=scriteria.value.toUpperCase();
if(scriteria.value.length == 0)
{
    sbox.innerHTML='Search Ready.';
    scriteria.style.backgroundColor='#FFFFFF';
    return;
}
else if(scriteria.value.length < 2)
{
    sbox.innerHTML='Search Ready.';
    scriteria.style.backgroundColor='#FFFF00';
    return;
}
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  sboxxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  sboxxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
sboxxmlhttp.onreadystatechange=function()
  {
  if (sboxxmlhttp.readyState==4 && qboxxmlhttp.status==200)
    {
    if(sboxxmlhttp.responseText)
    {
        scriteria.style.backgroundColor='#00FF00';
        sbox.innerHTML=sboxxmlhttp.responseText;
    }
    else
    {
        scriteria.style.backgroundColor='#FF0000';
        sbox.innerHTML='No Results.';
    }
    }
  }
sboxxmlhttp.open(\"GET\",\"search.php?event_id=" . $this_event . "&criteria=\"+scriteria.value,true);
sboxxmlhttp.send();
}

function updateQueue()
{
if(document.getElementById(\"qso_id\").value)
{
    selectedqso='&selected='+document.getElementById(\"qso_id\").value;
}
else
{
    selectedqso='';
}

qbox=document.getElementById(\"queuebox\");
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  qboxxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  qboxxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
qboxxmlhttp.onreadystatechange=function()
  {
  if (qboxxmlhttp.readyState==4 && qboxxmlhttp.status==200)
    {
    qbox.innerHTML=qboxxmlhttp.responseText;
    }
  }
qboxxmlhttp.open(\"GET\",\"queue.php?event_id=" . $this_event . (($mode == 'spotter') ? "&noclick=1" : "") . "\"+selectedqso,true);
qboxxmlhttp.send();
" . (($mode == 'entry') ? "nextQso();" : "") . "
}

function nextQso()
{
nqbox=document.getElementById(\"nextqsobox\");
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  nqboxxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  nqboxxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
nqboxxmlhttp.onreadystatechange=function()
  {
  if (nqboxxmlhttp.readyState==4 && nqboxxmlhttp.status==200)
    {
    nqbox.value=nqboxxmlhttp.responseText;
    document.getElementById(\"nextqso\").value=nqboxxmlhttp.responseText;
    }
  }
nqboxxmlhttp.open(\"GET\",\"next_qso.php?event_id=" . $this_event . "\",true);
nqboxxmlhttp.send();
}

function gotCall()
{
qsocallsign = document.getElementById(\"qso_callsign\");

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  gcxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  gcxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
gcxmlhttp.onreadystatechange=function()
  {
  if (gcxmlhttp.readyState==4 && gcxmlhttp.status==200)
    {
        if(gcxmlhttp.responseText && qsocallsign.value.length > 0)
        {
            qsocallsign.style.backgroundColor='#FFFF00';
            " . (($mode == 'entry') ? "document.getElementById(\"qso_confirm\").disabled='disabled';" : "") . "
        }
    }
  }
gcxmlhttp.open(\"GET\",\"check_call.php?event_id=" . $this_event . "&call=\"+qsocallsign.value,true);
gcxmlhttp.send();
}

function gotCallSpotter()
{
qsocallsign = document.getElementById(\"qso_callsign\");

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  gcxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  gcxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
gcxmlhttp.onreadystatechange=function()
  {
  if (gcxmlhttp.readyState==4 && gcxmlhttp.status==200)
    {
        if(gcxmlhttp.responseText && qsocallsign.value.length > 0)
        {
            qsocallsign.style.backgroundColor='#FFFF00';
            " . (($mode == 'entry') ? "document.getElementById(\"qso_confirm\").disabled='disabled';" : "") . "
        }
    }
  }
gcxmlhttp.open(\"GET\",\"check_call_spotter.php?event_id=" . $this_event . "&call=\"+qsocallsign.value,true);
gcxmlhttp.send();
}

function clearQso()
{
    document.getElementById(\"qso_frequency\").value='';
    document.getElementById(\"qso_callsign\").value='';
    document.getElementById(\"qso_serial\").value='';
    document.getElementById(\"qso_check\").value='';
    document.getElementById(\"qso_section\").value='';
    document.getElementById(\"qso_precedence\").value='';
    document.getElementById(\"qso_id\").value='';
    
    checkQso();
    document.getElementById(\"qso_frequency\").focus();
}

function confirmQso()
{
    if (!checkQso())
    {
        alert('You have an error in your QSO.');
        return false;
    }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  qsoxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  qsoxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
qsoxmlhttp.onreadystatechange=function()
  {
  if (qsoxmlhttp.readyState==4 && qsoxmlhttp.status==200)
    {
        if(qsoxmlhttp.responseText == '200')
        {
            alert('QSO Confirmed.');
            clearQso();
            searchFor();
            return true;
        }
        else if(qsoxmlhttp.responseText == '500')
        {
            alert('ERROR: Internal Server Error!');
            clearQso();
            return true;
        }
        else
        {
            alert('ERROR: Could not confirm QSO for unknown reason!');
            return false;
        }
    }
  }
qsoxmlhttp.open(\"GET\",\"confirm_qso.php?event_id=" . $this_event . "&qso_num=\"+document.getElementById(\"nextqso\").value+\"&qso_id=\"+document.getElementById(\"qso_id\").value+\"&qso_frequency=\"+document.getElementById(\"qso_frequency\").value+\"&qso_callsign=\"+document.getElementById(\"qso_callsign\").value+\"&qso_serial=\"+document.getElementById(\"qso_serial\").value+\"&qso_check=\"+document.getElementById(\"qso_check\").value+\"&qso_section=\"+document.getElementById(\"qso_section\").value+\"&qso_precedence=\"+document.getElementById(\"qso_precedence\").value,true);
qsoxmlhttp.send();
}

function queueQso()
{
if(!document.getElementById(\"qso_frequency\").value)
{
    alert('You must enter a frequency!');
    return false;
}
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  qsoxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  qsoxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
qsoxmlhttp.onreadystatechange=function()
  {
  if (qsoxmlhttp.readyState==4 && qsoxmlhttp.status==200)
    {
        if(qsoxmlhttp.responseText == '200')
        {
            alert('QSO Queued.');
            clearQso();
            searchFor();
            return true;
        }
        else if(qsoxmlhttp.responseText == '500')
        {
            alert('ERROR: Internal Server Error!');
            clearQso();
            return true;
        }
        else
        {
            alert('ERROR: Could not confirm QSO for unknown reason!');
            return false;
        }
    }
  }
qsoxmlhttp.open(\"GET\",\"queue_qso.php?event_id=" . $this_event . "&qso_id=\"+document.getElementById(\"qso_id\").value+\"&qso_frequency=\"+document.getElementById(\"qso_frequency\").value+\"&qso_callsign=\"+document.getElementById(\"qso_callsign\").value+\"&qso_serial=\"+document.getElementById(\"qso_serial\").value+\"&qso_check=\"+document.getElementById(\"qso_check\").value+\"&qso_section=\"+document.getElementById(\"qso_section\").value+\"&qso_precedence=\"+document.getElementById(\"qso_precedence\").value,true);
qsoxmlhttp.send();
}

function checkQso()
{
    qsofrequency=document.getElementById(\"qso_frequency\");
    qsocallsign = document.getElementById(\"qso_callsign\");
    qsoserial = document.getElementById(\"qso_serial\");
    qsocheck = document.getElementById(\"qso_check\");
    qsosection = document.getElementById(\"qso_section\");
    qsoconfirm = document.getElementById(\"qso_confirm\");
    qsoprecedence = document.getElementById(\"qso_precedence\");
    g2g = true;

    if(qsofrequency.value.length == 0)
    {
        qsofrequency.style.backgroundColor='#FFFFFF';
        g2g = false;
    }
    else if(/^[\\d]{1,5}$/.test(qsofrequency.value))
    {
        qsofrequency.style.backgroundColor='#00FF00';
    }
    else
    {
        qsofrequency.style.backgroundColor='#FF0000';
        g2g = false;
    }
    
    qsocallsign.value = qsocallsign.value.toUpperCase();
    if(qsocallsign.value.length == 0)
    {
        qsocallsign.style.backgroundColor='#FFFFFF';
        g2g = false;
    }
    else if(
    /^[KNW]\\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{2}$/.test(qsocallsign.value) ||                                  //Group A (1x2)
    /^[KNW]\\d[ABCDEFGHIJKLMNOPQRSTUVWYZ]$/.test(qsocallsign.value) ||                                      //Event (1x1)
    /^[A][ABCDEFGHIJKL]\\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{1,2}$/.test(qsocallsign.value) ||                    //Group A (2x1, 2x2) (beginning with A)
    /^[KNW][ABCDEFGHIJKLMNOPQRSTUVWXYZ]\\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{1,2}$/.test(qsocallsign.value) ||    //Group A (2x1) (beginning with K,N,W), Group B (2x2)
    /^[KNW]\\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{3}$/.test(qsocallsign.value) ||                                  //Group C (1x3)
    /^[KW][ABCDEFGHIJKLMNOPQRSTUVWXYZ]\\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{3}$/.test(qsocallsign.value) ||          //Group D (2x3)
    /^(CB||CF||CH||CI||CJ||CK||V[ABCDEFG]||VO||VX||VY||X[JKLMNO])\\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{2,3}$/.test(qsocallsign.value)          //Canada
    )
    {
        qsocallsign.style.backgroundColor='#00FF00';
    }
    else
    {
        qsocallsign.style.backgroundColor='#FF0000';
        g2g = false;
    }
    gotCall();
    
    if(qsoserial.value.length == 0)
    {
        qsoserial.style.backgroundColor='#FFFFFF';
        g2g = false;
    }
    else if(/^[\\d]{1,12}$/.test(qsoserial.value))
    {
        qsoserial.style.backgroundColor='#00FF00';
    }
    else
    {
        qsoserial.style.backgroundColor='#FF0000';
        g2g = false;
    }
    
    if(qsocheck.value.length == 0)
    {
        qsocheck.style.backgroundColor='#FFFFFF';
        g2g = false;
    }
    else if(/^[\\d]{2}$/.test(qsocheck.value))
    {
        qsocheck.style.backgroundColor='#00FF00';
    }
    else
    {
        qsocheck.style.backgroundColor='#FF0000';
        g2g = false;
    }
    
    qsosection.value = qsosection.value.toUpperCase();
    if(qsosection.value.length == 0)
    {
        qsosection.style.backgroundColor='#FFFFFF';
        g2g = false;
    }
    else if(/^(CT||EMA||ME||NH||RI||VT||WMA||ENY||NLI||NNJ||NNY||SNJ||WNY||DE||EPA||MDC||WPA||AL||GA||KY||NC||NFL||SC||SFL||WCF||TN||VA||PR||VI||AR||LA||MS||NM||NTX||OK||STX||WTX||EB||LAX||ORG||SB||SCV||SDG||SF||SJV||SV||PAC||AZ||EWA||ID||MT||NV||OR||UT||WWA||WY||AK||MI||OH||WV||IL||IN||WI||CO||IA||KS||MN||MO||NE||ND||SD||MAR||NL||QC||GTA||ONE||ONN||ONS||MB||SK||AB||BC||NT)$/.test(qsosection.value))
    {
	// NOTE: 'ON' was Ontario, but was split into 4 sections in 2012: ONN, ONS, ONE, and GTA
        qsosection.style.backgroundColor='#00FF00';
    }
    else
    {
        qsosection.style.backgroundColor='#FF0000';
        g2g = false;
    }
    
    qsoprecedence.value = qsoprecedence.value.toUpperCase();
    if(qsoprecedence.value.length == 0)
    {
        qsoprecedence.style.backgroundColor='#FFFFFF';
        g2g = false;
    }
    else if(/^[ABMQSU]$/.test(qsoprecedence.value))
    {
        qsoprecedence.style.backgroundColor='#00FF00';
    }
    else
    {
        qsoprecedence.style.backgroundColor='#FF0000';
        g2g = false;
    }    
    
    " . (($mode == 'entry') ? "
    
    if(g2g)
    {
        qsoconfirm.removeAttribute('disabled',0);
    }
    else
    {
        qsoconfirm.disabled='disabled';
    }
    " : "") . "
    return g2g;
}

function checkEnter(keyStroke)
{
    keyCode = (keyStroke.which) ? keyStroke.which : event.keyCode;

    if(keyCode == 13)
    {
        return true;
    }
    return false;
}

function deQue(id,frequency,precedence,callsign,check,section)
{
    if (id == -1 || id == document.getElementById(\"qso_id\").value)
    {
        if(document.getElementById(\"qso_id\").value)
        {
            document.getElementById(\"queue_\"+document.getElementById(\"qso_id\").value).backgroundColor='#FFFFFF';
        }
        clearQso();
    }
    else
    {
        if(document.getElementById(\"qso_id\").value)
        {
            document.getElementById(\"queue_\"+document.getElementById(\"qso_id\").value).backgroundColor='#FFFFFF';
        }
        document.getElementById(\"queue_\"+id).style.backgroundColor='#00FF00';
        document.getElementById(\"qso_frequency\").value=frequency;
        document.getElementById(\"qso_callsign\").value=callsign;
        document.getElementById(\"qso_serial\").value='';
        document.getElementById(\"qso_check\").value='';
        if(check < 10 && check)
            document.getElementById(\"qso_check\").value='0';
        document.getElementById(\"qso_check\").value+=check.toString();
        document.getElementById(\"qso_section\").value=section;
        document.getElementById(\"qso_precedence\").value=precedence;
        document.getElementById(\"qso_id\").value=id;
        updateQueue();
        checkQso();
        document.getElementById(\"qso_serial\").focus();
    }
}

function voidQso(id)
{
    if(!confirm('Are you sure you want to void this QSO?'))
    {
        return false;
    }
        deQue(-1);
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  vqxmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  vqxmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
vqxmlhttp.onreadystatechange=function()
  {
  if (vqxmlhttp.readyState==4 && vqxmlhttp.status==200)
    {
        if(vqxmlhttp.responseText == '200')
        {
            alert('QSO Voided Successfully.');
            updateQueue();
            return true;
        }
        else if(vqxmlhttp.responseText == '500')
        {
            alert('ERROR: Internal Server Error!');
            updateQueue();
            return true;
        }
        else
        {
            alert('ERROR: Could not void QSO for unknown reason!');
            return false;
        }
    }
  }
vqxmlhttp.open(\"GET\",\"void_qso.php?event_id=" . $this_event . "&id=\"+id,true);
vqxmlhttp.send();
}

" . (($mode == 'entry' || $mode == 'spotter') ? "setInterval(\"updateQueue()\", 5000);" : "") . "
</script>
<script type=\"text/javascript\" src=\"ddtabmenufiles/ddtabmenu.js\">
/***********************************************
* DD Tab Menu script-Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type=\"text/javascript\">
ddtabmenu.definemenu(\"ddtabs5\", ";
switch ($mode)
{
    case 'map':
        echo 1;
        break;
    case 'entry':
        echo 2;
        break;
    case 'spotter':
        echo 3;
        break;
    case 'config':
        echo 4;
        break;
    case '':
    case 'summary':
        echo 0;
        break;
    default:
        echo -1;
        break;
}
echo ");
</script>
</head> 
<body" . (($mode == 'entry' || $mode == 'spotter') ? " onload=\"updateQueue();checkQso();searchFor();\"" : "") . ">
<h1>HardLogger 2.0";
switch ($mode)
{
    case 'map':
        echo " - Map";
        break;
    case 'entry':
        echo " - Operator Mode";
        break;
    case 'spotter':
        echo " - Spotter Mode";
        break;
    case 'config':
        echo " - Configuration";
        break;
}
echo "</h1>
<div id=\"ddtabs5\" class=\"chromemenu\">
<ul>
<li><a href=\"?mode=summary&event_id=" . $this_event . "\">Summary</a></li>
<li><a href=\"?mode=map&event_id=" . $this_event . "\">Map</a></li>
<li><a href=\"?mode=entry&event_id=" . $this_event . "\">Operator</a></li>
<li><a href=\"?mode=spotter&event_id=" . $this_event . "\">Spotter</a></li>
<li><a href=\"?mode=config&event_id=" . $this_event . "\">Config</a></li>
</ul>
</div>
<div>\n";

switch($mode)
{
    case '':
    case 'summary':
        echo "<br>\n<table>\n<tr><td>Event Name:</td><td>" . $event['event_name'] . "</td></tr>
<tr><td>Event ID:</td><td>" . $event['id'] . "</td></tr>
<tr><td>Total QSOs:</td><td>" . $event['qsos'] . "</td></tr>
<tr><td>Sections Hit:</td><td>" . $event['sections'] . "/83</td></tr>
<tr><td>First QSO:</td><td>" . $event['first_qso'] . "</td></tr>
<tr><td>Most Recent QSO:</td><td>" . $event['last_qso'] . "</td></tr>\n</table>";
        break;
    case 'map':
        echo "GREEN: Sections that have been hit THIS time. --- GREY: Sections that have been hit previously. --- RED: Sections that have NEVER been hit\n<br><img src=\"map_image.php?event_id=" . $this_event . "\" alt=\"Section Map\" style=\"width:99%;margin:1px\">";
        break;
    case 'entry':
        echo "<br>\n<b>Search:</b><br>
<input id=\"searchcriteria\" type=\"text\" style=\"width:99%;padding-right:8px;border:2px solid\" onKeyUp=\"searchFor();\"><br>
<div id=\"searchbox\" style=\"height:175px; width:99%; overflow:auto; border:2px solid; padding:4px;margin-top:2px;\"></div>
<br>\n<b>New QSO:</b> <input style=\"border:2px solid #00FF00; width:40px\" type=\"text\" id=\"nextqsobox\" disabled=\"disabled\" value=\"" . $event['next_qso'] . "\"> <input style=\"border:2px solid #00FF00; width:40px\" type=\"text\" id=\"precedencebox\" disabled=\"disabled\" value=\"" . $event['precidence'] . "\"> <input style=\"border:2px solid #00FF00; width:70px\" type=\"text\" id=\"callsignbox\" disabled=\"disabled\" value=\"" . $event['callsign'] . "\"> <input style=\"border:2px solid #00FF00; width:40px\" type=\"text\" id=\"chkbox\" disabled=\"disabled\" value=\"" . $event['chk'] . "\"> <input style=\"border:2px solid #00FF00; width:40px\" type=\"text\" id=\"locationbox\" disabled=\"disabled\" value=\"" . $event['location'] . "\"><br>
<table><tr><td style=\"width:140px;\">Frequency:<input type=\"text\" size=\"5\" style=\"border:2px solid\" id=\"qso_frequency\" onKeyDown=\"if(checkEnter(event)){confirmQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"width:120px;\">Serial:<input size=\"6\" type=\"text\" style=\"border:2px solid\" id=\"qso_serial\" onKeyDown=\"if(checkEnter(event)){confirmQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"width:130px;\">Precedence:<input size=\"2\" type=\"text\" style=\"border:2px solid\" id=\"qso_precedence\" onKeyDown=\"if(checkEnter(event)){confirmQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"width:130px;\">Callsign:<input size=\"6\" type=\"text\" style=\"border:2px solid\" id=\"qso_callsign\" onKeyDown=\"if(checkEnter(event)){confirmQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"min-width:100px;\">Check:<input size=\"2\" type=\"text\" style=\"border:2px solid\" id=\"qso_check\" onKeyDown=\"if(checkEnter(event)){confirmQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"min-width:100px;\">Section:<input size=\"3\" type=\"text\" style=\"border:2px solid\" id=\"qso_section\" onKeyDown=\"if(checkEnter(event)){confirmQso();}\" onKeyUp=\"checkQso();\"> <input type=\"hidden\" id=\"qso_id\"></td><td style=\"min-width:100px;\"><input type=\"button\" value=\"Confirm QSO\" disabled=\"disabled\" onClick=\"confirmQso();\" id=\"qso_confirm\"> <input type=\"button\" value=\"Clear\" onClick=\"deQue(-1);\"><input type=\"hidden\" id=\"nextqso\" value=\"" . $event['next_qso'] . "\"></td></tr></table>
<div id=\"queuebox\" style=\"height:175px; width:99%; overflow:auto; border:2px solid; padding:4px;margin-top:1px\" onMouseOver=\"updateQueue();\">Queue Loading...</div>";
        break;
    case 'spotter':
        echo "<br>\n<b>Search:</b><br>
<input id=\"searchcriteria\" type=\"text\" style=\"width:99%;padding-right:8px;border:2px solid\" onKeyUp=\"searchFor();\"><br>
<div id=\"searchbox\" style=\"height:175px; width:99%; overflow:auto; border:2px solid; padding:4px;margin-top:2px;\"></div>
<br>\n<b>New Queued QSO:</b><br>
<table><tr><td style=\"width:140px;\">Frequency:<input type=\"text\" size=\"5\" style=\"border:2px solid\" id=\"qso_frequency\" onKeyDown=\"if(checkEnter(event)){queueQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"width:120px;\">Serial:<input disabled=\"disabled\" size=\"6\" type=\"text\" style=\"border:2px solid\" id=\"qso_serial\" onKeyDown=\"if(checkEnter(event)){queueQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"width:130px;\">Precedence:<input size=\"2\" type=\"text\" style=\"border:2px solid\" id=\"qso_precedence\" onKeyDown=\"if(checkEnter(event)){queueQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"width:130px;\">Callsign:<input size=\"6\" type=\"text\" style=\"border:2px solid\" id=\"qso_callsign\" onKeyDown=\"if(checkEnter(event)){queueQso();gotCallSpotter();}\" onKeyUp=\"checkQso();gotCallSpotter();\"></td><td style=\"min-width:100px;\">Check:<input size=\"2\" type=\"text\" style=\"border:2px solid\" id=\"qso_check\" onKeyDown=\"if(checkEnter(event)){queueQso();}\" onKeyUp=\"checkQso();\"></td><td style=\"min-width:100px;\">Section:<input size=\"3\" type=\"text\" style=\"border:2px solid\" id=\"qso_section\" onKeyDown=\"if(checkEnter(event)){queueQso();}\" onKeyUp=\"checkQso();\"> <input type=\"hidden\" id=\"qso_id\"></td><td style=\"min-width:100px;\"><input type=\"button\" value=\"Queue QSO\" onClick=\"queueQso();\" id=\"qso_confirm\"> <input type=\"button\" value=\"Clear\" onClick=\"deQue(-1);\"></td></tr></table>
<div id=\"queuebox\" style=\"height:175px; width:99%; overflow:auto; border:2px solid; padding:4px;margin-top:1px\" onMouseOver=\"updateQueue();\">Queue Loading...</div>";
        break;
    default:
        echo "500 - Internal Server Error";
        break;
}

echo "\n</div>\n</body>
</html>";
?>
