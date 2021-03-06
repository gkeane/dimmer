<?php include('header.html');?>
<script>
$(document).ready(function()
    {
        $("#myTable").tablesorter({
    headers: {
        // first column
        9: {
            sorter: false
        },
        8: {
            sorter: false
        }
    }
})
    }
);
</script>

<div style="clear: left;"></div>
    <h1>Bulb-Dimmer Interactions</h1>
    <p>Choose from the drop-down menu below.</p>

    <form method="get" action="dimmer.php">

        <select class="dropdown" name="dimmer" onchange=this.form.submit()>

            <?php
            include 'db.php';

            $link=new mysqli($mysqlserver, $mysqlusername, $mysqlpassword);
            /* check connection */
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            $dbname = 'dimmer';
            mysqli_select_db( $link,$dbname) or die ("Error selecting specified database on mysql server: ".mysqli_error());

            $cdquery="SELECT dimmer,actual FROM dimmer_names";
            $cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from dimmer failed: ".mysqli_error());
            $dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
            $dimmer= htmlspecialchars($dim);;
            while ($cdrow=mysqli_fetch_array($cdresult)) {
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
            echo "</select></form>\n";
            $dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
            if (strlen($dim)>6){echo "error"; exit();}
            $dimmer= htmlspecialchars($dim);
            //echo $dimmer;
            $sql = "SELECT lamp,b.actual,r2scale,refire_scale, calc_50, calc_20, lumen_watt, total FROM dimmer inner join led_names b on b.led=dimmer.lamp where dimmer=?";
            if ($stmt=$link->prepare($sql)){//ho $sql;
            $stmt->bind_param('s', $dimmer);
            $stmt->execute();
            $result=$stmt->get_result();
            //$result = mysqli_query($link,$sql) or die ("Query to get data from dimmer failed: ".mysqli_error());
            echo "<table id=\"myTable\" class=\"tablesorter\"> \n";
            echo "<thead><tr><th>Lamp ID  </th><th>Lamp Name</th><th>Linearity Score </th><th>Refire Score  </th><th>Medium performance scale</th><th>Low performance scale</th><th>Light output efficiency</th><th>Total Score  </th><th data-sorder=\"false\">Chart   </th><th data-sorder=\"false\">Spectral Distribution   </th></tr></thead>\n";
            echo "<tbody>";  // output data of each row
                while($row = mysqli_fetch_array($result)) {
                    $href="<a href=chart.php?dimmer=".$dimmer."&led=".$row["lamp"].">Chart</a>";
                    $href2="<a href=chart3.php?dimmer=".$dimmer."&led=".$row["lamp"].">Chart</a>";
                    echo "<tr><td>" . $row["lamp"]. "</td><td>" . $row["actual"]. "</td><td>" . $row["r2scale"]."</td><td>" . $row["refire_scale"]. "</td><td>". round($row["calc_50"],2). "</td><td>" . round($row["calc_20"],2). "</td><td>". $row["lumen_watt"]. "</td><td>". round($row["total"],2)."<td>".$href. "</td><td align=center>".$href2. "</td></tr>\n";
                }
            echo "</tbody></table>";
            $stmt->close();
          }
          $link->close();
            ?>

        </select>

    </form>
    <div style="clear: both;">&nbsp;</div>

     <div class="disclaimer"><strong>Disclaimer</strong>-
   Information provided on this website relating to goods and services offered by third parties is provided solely for information purposes and is not intended as an endorsement or expression of support by the University of Delaware or its agents and employees. By providing this information, the University of Delaware assumes no financial or other responsibility for any relationship established by and between any company or organization listed on this website and any other individual. Any issues related to transactions that take place as a result of information provided are between the individual and the organization.</div>
   <div style="clear: both;"></div>




   </div>

<?php include('footer.html');?>
