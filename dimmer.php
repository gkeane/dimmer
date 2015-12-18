            
<body>

    <form method="get" action="dimmer.php">
        
        <select id="dimmer" name="dimmer">
        
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
            $dimmer= htmlspecialchars(pg_escape_string($dim));;
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
            echo "</select><input type=\"submit\" value=\"Submit\"></form>";
            $dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
            $dimmer= htmlspecialchars(pg_escape_string($dim));;
            $sql = "SELECT lamp,b.actual,refire_scale, calc_50, calc_20, lumen_watt, total FROM dimmer inner join led_names b on b.led=dimmer.lamp where dimmer='".$dimmer."'";
            //echo $sql;
            $result = mysql_query($sql) or die ("Query to get data from dimmer failed: ".mysql_error());
            echo "<table>";
            echo "<tr><td>Lamp</td><td>Lamp Actual</td><td>refire_scale</td><td>calc_50</td><td>calc_20</td><td>lumen_watt</td><td>total</td></tr>";
                // output data of each row
                while($row = mysql_fetch_array($result)) {
                    echo "<tr><td>" . $row["lamp"]. "</td><td>" . $row["actual"]. "</td><td>" . $row["refire_scale"]. "</td><td>". $row["calc_50"]. "</td><td>" . $row["calc_20"]. "</td><td>". $row["lumen_watt"]. "</td><td>". $row["total"]. "</td><td></tr>";
                }
            echo "</table>";
            $conn->close();
            ?>
    
        </select>
        
    </form>
    
</body>     