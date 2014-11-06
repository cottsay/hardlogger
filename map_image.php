<?php
include_once("config.php");
header('Content-Type: image/jpeg');
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//$im = imagecreatefromjpeg("./map.jpg");
$im = imagecreatefromgif("./map.gif");

$sections = array(  'CT' => array(1420=>425,1410=>425,1404=>425,1402=>432),
                    'EMA' => array(1431=>414,1432=>420,1442=>423),
                    'ME' => array(1450=>380),
                    'NH' => array(1430=>400),
                    'RI' => array(1427=>424),
                    'VT' => array(1410=>400),
                    'WMA' => array(1415=>415),
                    'ENY' => array(1400=>420),
                    'NLI' => array(1410=>435,1400=>437),
                    'NNJ' => array(1385=>435),
                    'NNY' => array(1390=>400,1375=>400),
                    'SNJ' => array(1390=>450),
                    'WNY' => array(1375=>408),
                    'DE' => array(1375=>464,1379=>463),
                    'EPA' => array(1366=>434,1374=>435,1372=>425,1386=>443),
                    'MDC' => array(1326=>453,1336=>452,1358=>454,1375=>469,1357=>466),
                    'WPA' => array(1336=>434,1333=>432,1341=>433),
                    'AL' => array(1226=>543,1216=>552),
                    'GA' => array(1279=>556,1274=>542),
                    'KY' => array(1229=>483),
                    'NC' => array(1319=>499,1370=>502,1360=>514),
                    'NFL' => array(1289=>594),
                    'SC' => array(1303=>533),
                    'SFL' => array(1301=>635,1308=>617),
                    'WCF' => array(1295=>611),
                    'TN' => array(1213=>501),
                    'VA' => array(1342=>471,1326=>482,1362=>484),
                    'PR' => array(1427=>641),
                    'VI' => array(1503=>640),
                    'AR' => array(1154=>515,1161=>514,1146=>495),
                    'LA' => array(1155=>550,1164=>544,1163=>582,1194=>587),
                    'MS' => array(1195=>521),
                    'NM' => array(951=>503),
                    'NTX' => array(1080=>541),
                    'OK' => array(1072=>510,1068=>493),
                    'STX' => array(1109=>571),
                    'WTX' => array(1027=>534),
                    'EB' => array(768=>470),
                    'LAX' => array(819=>517),
                    'ORG' => array(830=>509,839=>507,844=>519),
                    'SB' => array(787=>510),
                    'SCV' => array(777=>495),
                    'SDG' => array(830=>537,845=>537,849=>531,859=>537,849=>534),
                    'SF' => array(749=>459),
                    'SJV' => array(778=>478),
                    'SV' => array(781=>458),
                    'PAC' => array(297=>455,281=>434,269=>434,270=>427,263=>427,247=>418,216=>407),
                    'AZ' => array(883=>531,910=>509),
                    'EWA' => array(815=>343,803=>358),
                    'ID' => array(843=>399,868=>405),
                    'MT' => array(913=>361),
                    'NV' => array(814=>450),
                    'OR' => array(750=>400,775=>390,785=>387),
                    'UT' => array(900=>450),
                    'WWA' => array(767=>357,771=>339,759=>355,741=>357),
                    'WY' => array(931=>399),
                    'AK' => array(323=>101,354=>215,185=>185,130=>138,139=>142,404=>120),
                    'MI' => array(1250=>400,1208=>351,1210=>364,1222=>375,217=>253,241=>243),
                    'OH' => array(1278=>437,1265=>439),
                    'WV' => array(1300=>472,1342=>454),
                    'IL' => array(1190=>433),
                    'IN' => array(1236=>436),
                    'WI' => array(1200=>403),
                    'CO' => array(985=>461,950=>454),
                    'IA' => array(1143=>410,1132=>427),
                    'KS' => array(1052=>458),
                    'MN' => array(1125=>348),
                    'MO' => array(1155=>455,1150=>469),
                    'NE' => array(1028=>418),
                    'ND' => array(1032=>346,1054=>349),
                    'SD' => array(1056=>387,1028=>391),
                    'NL' => array(1550=>244,1622=>331,1669=>354),
                    'QC' => array(1400=>200,1382=>246,1328=>293,1361=>233,1417=>159,1453=>172,1500=>201,1472=>179,1528=>279,1540=>322,1520=>330,1522=>332,1362=>356),
                    'ONN' => array(1120=>300,1180=>290,1275=>360,1300=>275),
                    'ONE' => array(1360=>380,1337=>380,1353=>393,1330=>370),
                    'ONS' => array(1300=>400,1298=>380,1327=>389),
                    'GTA' => array(1320=>400),
                    'MB' => array(1096=>240,1097=>244,1112=>258),
		    'MAR' => array(1498=>355,1499=>359,1465=>351,1511=>365,1540=>378,1523=>358,1526=>361,1539=>365,1567=>368,1528=>387,1468=>350,1516=>376),
                    'SK' => array(960=>276),
                    'AB' => array(852=>257,860=>255,861=>259,825=>250),
                    'BC' => array(708=>322,714=>318,717=>237,718=>233,727=>235,628=>264,631=>267,629=>273,636=>275,633=>276,634=>277,637=>277),
                    'NT' => array(630=>163,680=>88,836=>88,760=>20,849=>25,963=>46,983=>10,1029=>17,1064=>17,1089=>65,1150=>9,1124=>47,1271=>31,1329=>11,1254=>126,1277=>150,960=>73,1229=>79,1371=>79,1319=>158,1343=>142,1392=>81)
          );

foreach($sections as $sec=>$pts)
{
    $result = mysql_query("SELECT (SELECT COUNT(id) FROM qsos WHERE Status=1 AND Section='" . $sec . "'), (SELECT COUNT(id) FROM qsos WHERE Status=1 AND Section='" . $sec . "' AND EventID=" . $this_event .");");
    $row = mysql_fetch_array($result, MYSQL_NUM);
    if($row[1])
        $color = imagecolorallocate($im,0,255,0);
    elseif($row[0])
        $color = imagecolorallocate($im,200,200,200);
        //$color = imagecolorallocate($im,255,150,150);
    else
        $color = imagecolorallocate($im,255,0,0);
    foreach($pts as $yval => $xval)
        imagefill($im,$yval,$xval,$color);
}

imagegif($im);
imagedestroy($im);
?>
