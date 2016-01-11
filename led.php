<?php include('header.html');?>
<script>
$(document).ready(function()
    {
        $("#myTable").tablesorter();
    }
);
</script>

<div style="clear: left;"></div>
    <h1>Bulb-Dimmer Interactions</h1>
    <p>Choose from the drop-down menu below.</p>

    <form method="get" action="led.php">

        <select class="dropdown" name="led" onchange=this.form.submit()>

            <?php

            $mysqlserver="localhost";
            $mysqlusername="dimmer";
            $mysqlpassword="8Jx43c8JMnvY7e9Z";
            $link=mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysqli_error());

            $dbname = 'dimmer';
            mysqli_select_db($link,$dbname) or die ("Error selecting specified database on mysql server: ".mysqli_error());

            $cdquery="SELECT led,actual FROM led_names";
            $cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from dimmer failed: ".mysqli_error());
            $led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
            echo $led;
            $leds= htmlspecialchars($led);;
            while ($cdrow=mysqli_fetch_array($cdresult)) {
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
            $led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
            $leds= htmlspecialchars($led);;
            $sql = "SELECT dimmer.dimmer,b.actual,r2scale,refire_scale, calc_50, calc_20, lumen_watt, total FROM dimmer inner join dimmer_names b on b.dimmer=dimmer.dimmer where lamp='".$leds."'";
            //echo $sql;
            $result = mysqli_query($link,$sql) or die ("Query to get data from dimmer failed: ".mysqli_error());
            echo "<table id=\"myTable\" class=\"tablesorter\"> \n";
            echo "<thead><tr><th>Dimmer ID</th><th>Dimmer Name</th><th>Linearity Score</th><th>Refire Score</th><th>Medium performance scale</th><th>Low performance scale</th><th>Light output efficiency</th><th>Total Score</th><th>Chart</th></tr></thead>\n";
            echo "<tbody>";  // output data of each row
                while($row = mysqli_fetch_array($result)) {
                    $href="<a href=chart.php?dimmer=".$row["dimmer"]."&led=".$leds.">Chart</a>";
                    echo "<tr><td>" . $row["dimmer"]. "</td><td>" . $row["actual"]. "</td><td>" . $row["r2scale"]."</td><td>" . $row["refire_scale"]. "</td><td>". round($row["calc_50"],2). "</td><td>" . round($row["calc_20"],2). "</td><td>". $row["lumen_watt"]. "</td><td>". round($row["total"],2). "</td><td>".$href."</td></tr>\n";
                }
            echo "</tbody></table>";
            mysqli_close($link);
            ?>

        </select>

    </form>
    <div style="clear: both;">&nbsp;</div>

     <div class="disclaimer"><strong>Disclaimer</strong>-
   Information provided on this website relating to goods and services offered by third parties is provided solely for information purposes and is not intended as an endorsement or expression of support by the University of Delaware or its agents and employees. By providing this information, the University of Delaware assumes no financial or other responsibility for any relationship established by and between any company or organization listed on this website and any other individual. Any issues related to transactions that take place as a result of information provided are between the individual and the organization.</div>
   <div style="clear: both;"></div>




   </div>

<?php include('footer.html');?>
