<head><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="src/jquery.easydropdown.js" type="text/javascript"></script>
<link rel="stylesheet" href="dimmer.css" type="text/css">
<link rel="stylesheet" type="text/css" href="themes/easydropdown.metro.css"/>
</head>
<body>

    <form method="get" action="led.php">

        <select class="dropdown" name="led" onchange=this.form.submit()>

            <?php

            $mysqlserver="localhost";
            $mysqlusername="dimmer";
            $mysqlpassword="8Jx43c8JMnvY7e9Z";
            $link=mysql_connect($mysqlserver, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());

            $dbname = 'dimmer';
            mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());

            $cdquery="SELECT led,actual FROM led_names";
            $cdresult=mysql_query($cdquery) or die ("Query to get data from dimmer failed: ".mysql_error());
            $led = isset($_GET['led']) ? $_GET['led'] : 'A1';
            $leds= htmlspecialchars($led);;
            while ($cdrow=mysql_fetch_array($cdresult)) {
            $cdVal=$cdrow["led"];
            $cdAct=$cdrow["actual"];
            $sel="";
            //echo " values---- $dimmer - $cdVal";
            if ($leds==$cdVal){
                //echo "someadfjldaf selected";
                $sel="selected";
            }
                echo "<option value=\"$cdVal\"  $sel>
                    $cdAct - $cdVal
                </option>";

            }
            echo "</select></form>\n";
            $led = isset($_GET['led']) ? $_GET['led'] : 'A1';
            $leds= htmlspecialchars($led);;
            $sql = "SELECT dimmer.dimmer,b.actual,r2,refire_scale, calc_50, calc_20, lumen_watt, total FROM dimmer inner join dimmer_names b on b.dimmer=dimmer.dimmer where lamp='".$leds."'";
            //echo $sql;
            $result = mysql_query($sql) or die ("Query to get data from dimmer failed: ".mysql_error());
            echo "<div class=\"rTable\">\n";
            echo "<div class=\"rTableHeading\"><div class=\"rTableHead\">Dimmer ID</div><div class=\"rTableHead\">Dimmer Name</div><div class=\"rTableHead\">Linearity Score</div><div class=\"rTableHead\">Refire Score</div><div class=\"rTableHead\">Medium dimmer performance scale</div><div class=\"rTableHead\">Low dimmer performance scale</div><div class=\"rTableHead\">Light output efficiency</div><div class=\"rTableHead\">Total Score</div></div>\n";
                // output data of each row
                while($row = mysql_fetch_array($result)) {
                    echo "<div class=\"rTableRow\"><div class=\"rTableCell\">" . $row["dimmer"]. "</div><div class=\"rTableCell\">" . $row["actual"]. "</div><div class=\"rTableCell\">" . $row["r2"]."</div><div class=\"rTableCell\">" . $row["refire_scale"]. "</div><div class=\"rTableCell\">". round($row["calc_50"],2). "</div><div class=\"rTableCell\">" . round($row["calc_20"],2). "</div><div class=\"rTableCell\">". $row["lumen_watt"]. "</div><div class=\"rTableCell\">". round($row["total"],2). "</div></div>\n";
                }
            echo "</table>";
            $link->close();
            ?>

        </select>

    </form>

</body>
