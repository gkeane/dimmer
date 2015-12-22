<link rel="stylesheet" href="dimmer.css" type="text/css">
<body>

    <form method="get" action="dimmer.php">
        
        <select class="dimmer" name="dimmer">
        
            <?php
            
            $mysqlserver="localhost";
            $mysqlusername="dimmer";
            $mysqlpassword="8Jx43c8JMnvY7e9Z";
            $link=mysql_connect(localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());
            
            $dbname = 'dimmer';
            mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());
            
            $cdquery="SELECT dimmer,actual FROM dimmer_names";
            $cdresult=mysql_query($cdquery) or die ("Query to get data from dimmer failed: ".mysql_error());
            $dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
            $dimmer= htmlspecialchars($dim);;
            while ($cdrow=mysql_fetch_array($cdresult)) {
            $cdVal=$cdrow["dimmer"];
            $cdAct=$cdrow["actual"];
            $sel="";
            //echo " values---- $dimmer - $cdVal";
            if ($dimmer==$cdVal){
                //echo "someadfjldaf selected";
                $sel="selected";
            }
                echo "<option value=\"$cdVal\"  $sel>
                    $cdAct - $cdVal
                </option>";
            
            }
            echo "</select><input type=\"submit\" value=\"Submit\"></form>\n";
            $dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
            $dimmer= htmlspecialchars($dim);;
            $sql = "SELECT lamp,b.actual,refire_scale, calc_50, calc_20, lumen_watt, total FROM dimmer inner join led_names b on b.led=dimmer.lamp where dimmer='".$dimmer."'";
            //echo $sql;
            $result = mysql_query($sql) or die ("Query to get data from dimmer failed: ".mysql_error());
            echo "<div class=\"rTable\">\n";
            echo "<div class=\"rTableRow\"><div class=\"rTableHead\">Lamp</div><div class=\"rTableHead\">Lamp Actual</div><div class=\"rTableHead\">refire_scale</div><div class=\"rTableHead\">calc_50</div><div class=\"rTableHead\">calc_20</div><div class=\"rTableHead\">lumen_watt</div><div class=\"rTableHead\">total</div></div>\n";
                // output data of each row
                while($row = mysql_fetch_array($result)) {
                    echo "<div class=\"rTableRow\"><div class=\"rTableCell\">" . $row["lamp"]. "</div><div class=\"rTableCell\">" . $row["actual"]. "</div><div class=\"rTableCell\">" . $row["refire_scale"]. "</div><div class=\"rTableCell\">". $row["calc_50"]. "</div><div class=\"rTableCell\">" . $row["calc_20"]. "</div><div class=\"rTableCell\">". $row["lumen_watt"]. "</div><div class=\"rTableCell\">". $row["total"]. "</div></div>\n";
                }
            echo "</table>";
            $conn->close();
            ?>
    
        </select>
        
    </form>
    
</body>     