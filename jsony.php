<?php
header("Content-type: text/html");
// connect to the database
$mysqlserver="localhost";
$mysqlusername="dimmer";
$mysqlpassword="8Jx43c8JMnvY7e9Z";
$db=mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysqli_error());

$dbname = 'dimmer';
$tablename = "graph";
$val=0.0;


mysqli_select_db( $db,$dbname) or die ("Error selecting specified database on mysql server: ".mysqli_error());
/*
if (is_numeric($_GET["loc"])){
 $loc = $_GET["loc"];
}
else
$loc = 0;
if (is_numeric($_GET["trap"])){
 $trap = $_GET["trap"];
}
else
$year = 0;
if (is_numeric($_GET["year"])){
 $year = $_GET["year"];
}
else

$year = 0; */
$led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
$led= htmlspecialchars($led);
$dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
$dimmer= htmlspecialchars($dim);
//$dimmer='A1';
//$led='LED1';


$SQL = "SELECT setting, lumen FROM $tablename WHERE dimmer=\"$dimmer\" and led=\"$led\" ORDER BY setting DESC";
//echo $SQL;
$result = mysqli_query($db,$SQL) or die ("Query to get data from dimmer failed: ".mysqli_error($db));
//$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from dimmer failed: ".mysqli_error());
$rows=array();
$rows['name'] = 'lumen';
while($r = mysqli_fetch_array($result)) {
    $rows['data'][] = $r['lumen'];
}
$SQL2 = "SELECT setting, lumen_watts as efficiency FROM $tablename WHERE dimmer=\"$dimmer\" and  led=\"$led\" ORDER BY setting DESC";
$result2 = mysqli_query( $db,$SQL2 ) or die("Couldn?t execute query.".mysqli_error($db));
$rows2=array();
$rows2['name'] = 'efficiency';
while($rr = mysqli_fetch_array($result2)) {
    $rows2['data'][] = $rr['efficiency'];
}

$result = array();
array_push($result,$rows);
array_push($result,$rows2);
print json_encode($result, JSON_NUMERIC_CHECK);


;
?>
