<head><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="src/jquery.easydropdown.js" type="text/javascript"></script>
<link rel="stylesheet" href="dimmer.css" type="text/css">
<link rel="stylesheet" type="text/css" href="themes/easydropdown.metro.css"/>
<link rel="stylesheet" href="brandingstyle.css" type="text/css">

<title>Introduction to Blub Dimmer Test Results</title>
</head>
<body>



<!-- UD HEADER - DO NOT MODIFY THIS AREA -->

<div class="UDStandardHeader">
<div class="UDStandardHeader_LayoutContainer"> <a href="http://www.udel.edu" target="_blank"><img src="images/university-of-delaware.jpg" border="0"/></a>



  <div class="UDStandardHeader_Toolbar">

          <!-- GOOGLE SEARCH - TO CUSTOMIZE THIS SEARCH PLEASE REFER TO http://www.udel.edu/ideacenter/howto/search/searchtools.html-->
            <div class="UDStandardHeader_GSA">



              <form method="get" action="http://gsa1.udel.edu/search" name="search">
                <input class="UDSearchButton" src="images/search.png" alt="Search" value="Search" type="image" align="middle" border="0">
                <input class="UDSearchField" name="q" size="24" maxlength="256" value="Powered by Google" onFocus="UDGSAFormFieldFocus(this)" onBlur="UDGSAFormFieldBlur(this)" type="text">
                <input type="hidden" name="site" value="UDel" />
        <input type="hidden" name="client" value="default_frontend" />
        <input type="hidden" name="output" value="xml_no_dtd" />
        <input type="hidden" name="proxystylesheet" value="default_frontend" />
        <input type="hidden" name="sitesearch" value="canr.udel.edu" />

              </form>

        </div>
             <!-- END GOOGLE SEARCH -->

            <div class="UDStandardHeader_MenuTier">
              <ul class="UDStandardHeader_MenuList">
                <li><a href="http://www.udel.edu/peoplesearch/">People</a></li>
                <li><a href="http://www.udel.edu/maps/">Maps</a></li>
                <li><a href="http://www.udel.edu/findit/a-z.html">A-Z Index</a></li>
                <li><a href="http://canr.udel.edu/about-us/staff-resources/">Staff Resources</a></li>
              </ul>
            </div>
    </div>
  </div></div>
        <!-- END HEADER -->
         <div id="pagecontainer">
        	            <div class="sub-header">
            	<a href="http://canr.udel.edu"><h1>COLLEGE OF AGRICULTURE <span>&amp;</span> NATURAL RESOURCES</h1></a>            </div>

		</header><!-- #masthead -->


<div class="content">
        <div id="abclogo"><img src="images/abc-logo.jpg" width="250" height="125" alt="Avian Biosciences Center"></div>

  <div id="menutab">
        <div class="tabchoice"><a href="intro.php">Introduction</a></div>
        <div class="tabchoice"><a href="glossary.php">Glossary</a></div>
        <div class="tabchoice"><a href="dimmer.php">Dimmer</a></div>
        <div class="tabchoice"><a href="led.php">LED</a></div>
        </div>


<div style="clear: left;"></div>
    <h1>Bulb-Dimmer Interactions</h1>
    <p>Choose from the drop-down menu below.</p>

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
            $led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
            echo $led;
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
            $led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
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
    <div style="clear: both;">&nbsp;</div>

     <div class="disclaimer"><strong>Disclaimer</strong>-
   Information provided on this website relating to goods and services offered by third parties is provided solely for information purposes and is not intended as an endorsement or expression of support by the University of Delaware or its agents and employees. By providing this information, the University of Delaware assumes no financial or other responsibility for any relationship established by and between any company or organization listed on this website and any other individual. Any issues related to transactions that take place as a result of information provided are between the individual and the organization providing the discount.</div>
   <div style="clear: both;"></div>




   </div>

       <!--START UD FOOTER BRANDING-->
   <div style="clear: both;"></div>

   <div class="UDStandardFooter2"><div class="UDStandardFooter_LayoutContainer">
     <div class="mobile-footer"><a href="http://www.udel.edu"><img src="images/udlogo-footer.png" alt="Dare to be first. University of Delaware" name="UDStandardFooter_Logo" class="UDStandardFooter_Logo" border="0" /></a>

       <ul class="UDStandardFooter_Address">
         <li>College of Agriculture & Natural Resources&nbsp;&nbsp;&bull;&nbsp;&nbsp;
   531 South College Ave.&nbsp;&nbsp;&bull;&nbsp;&nbsp;
   Newark, DE 19716<!--&nbsp;&nbsp;&bull;&nbsp;&nbsp;
   USA--><br/>
   Phone:&nbsp;302-831-2501<!--&nbsp;&nbsp;&bull;&nbsp;&nbsp;
   E-mail:&nbsp;xxxxx@udel.edu-->

         </li>
       </ul>
       <div style="clear: both;"></div>
     <div class="footer-links-hold">
     <ul class="UDStandardFooter_Links">

       <li class="last"><a href="http://www.udel.edu/aboutus/legalnotices.html">Legal Notices</a></li>
     </ul>
     </div>
      <br class="udclearfloat" />
   </div>
   </div>
   </div>

    <!--END UD FOOTER BRANDING-->

   </body>
