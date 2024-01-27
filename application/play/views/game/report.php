
<html>
    <head>
        <meta http-equiv="Content-Language" content="en-us">
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

        <title> <?= company ?> REPORT</title>
        <link rel="stylesheet" href="assets/yatara/css/main.css" type="text/css">
    </head>

    <body bgcolor="#FFCCFF" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="7%" align=center><img class="img-board" src="<?= image ?>" border="5" align=middle></td>
                <td class="tdtitle" width="14%" valign="top">&nbsp;<?= company ?></td><td id="agentdet" class="tdtitle"></td>
                <td class="tdtitleright" valign="top"><a href="?r=gameboard" ><input type="button" value="Back" class="buttonback"></a>
                    <a href="?r=logout"><input type="button" class="buttonlogout" value="Logout"></a>
                </td>
            </tr>
        </table>
        <?php
        $rdata = json_decode($response, true);
        ?>
        <form method="POST" action="/?r=report" name="taxform" onsubmit="return funcrepvalid();">
            <div align="center">
                <h1>First Report</h1>
                <table border="0" cellpadding="2" id="table1" cellspacing="0" width="100%">
                    <tr>
                        <td align="center">
                            <table border="0" width="100%" id="table2">
                                <tr>
                                    <td align="center" nowrap>Show Report :&nbsp; <input type="date" id="fromdate" name="fromdate" autocomplete=off value="<?= $sdate ?>" max="<?= date("Y-m-d") ?>"> 
                                        To :&nbsp;
                                        <input type="date" id="todate" name="todate" autocomplete=off value="<?= $edate ?>" max="<?= date("Y-m-d") ?>">&nbsp;&nbsp;
                                        <button id="btnok" class="buttongreen">Show</button></td>
                                </tr>
                            </table>


                            <table border="0" width="100%" id="table1" cellspacing="1" cellpadding="2">
                                <tr><td align="center" class="tdseries"><?= $line ?></td></tr>
                                <tr>
                                    <td>
                                        <table align='center' width='40%'  border=2 bgcolor='#003366' bordercolor=white cellpadding=5>
                                            <tr><td align='right' width='60%' class='tdseries'>Play Point: </td><td align='right' width='40%'  class='tdseries'><?= number_format($rdata["totalNetPoint"]-$rdata["cancelPoint"], 2) ?></td></tr>
                                            <!--<tr style="background-color: red !important;"><td align='right' width='60%' class='tdseries2'>Cancelled Point: </td><td align='right' width='40%' class='tdseries2' ><?= $rdata["cancelPoint"] ?></td></tr>-->
                                            <tr><td align='right' width='60%' class='tdseries'>Commission Point: </td><td align='right' width='40%' class='tdseries'><?= number_format($rdata["totalPoint"], 2) ?></td></tr>
                                            <tr><td align='right' width='60%' class='tdseries'>Win Point: </td><td align='right' width='40%' class='tdseries'><?= number_format($rdata["winPoint"], 2) ?></td></tr>
                                            <tr><td align='right' width='60%' class='tdseries'>Net: </td><td align='right' width='40%' class='tdseries'><?= number_format($rdata["netPayble"], 2) ?></td></tr></table>				
                                    </td>
                                </tr>
                            </table>	
                        </td>
                    </tr>

                </table>
                <style>
                    .tdseries2 {
                        border-radius: 2px 2px 2px 2px;
                        color:#FFF;
                        font-family: Arial;
                        font-size: 15px;
                        font-weight: bold;
                        text-align: center;
                        border-style: solid;
                        border-color: maroon;
                        border-width: 1px;
                    }
                </style>
                <br>
                <a href="javascript:void(0)" class="btn buttongreen" onclick="return printPayedReport('<?= $rdata["totalNetPoint"] ?>', '<?= $rdata["totalPoint"] ?>', '<?= $rdata["winPoint"] ?>', '<?= $rdata["netPayble"] ?>', '<?= $rdata["cancelPoint"] ?>', '<?= $_SESSION["userid"] ?>', '<?= $line2 ?>')">Print</a>
            </div>
            <div align="center">
                <h1>Second Report</h1>
                <table border="0" cellpadding="2" id="table1" cellspacing="0" width="100%">
                    <tr>
                        <td align="center">

                            <table border="0" width="100%" id="table1" cellspacing="1" cellpadding="2">
                                <tr><td align="center" class="tdseries"><?= $line ?></td></tr>
                                <tr>
                                    <td>
                                        <table align='center' width='40%'  border=2 bgcolor='#003366' bordercolor=white cellpadding=5>
                                            <tr>
                                                <td align='right' width='60%' class='tdseries'>Play Point: </td>
                                                <td align='right' width='40%'  class='tdseries'><?= number_format($rdata["totalNetPoint"]-$rdata["cancelPoint"], 2) ?></td>
                                            </tr>
<!--                                            <tr>
                                                <td align='right' width='60%' class='tdseries'>Commission Point: </td>
                                                <td align='right' width='40%' class='tdseries'><?= number_format($rdata["totalPoint"], 2) ?></td>
                                            </tr>-->
                                            <tr>
                                                <td align='right' width='60%' class='tdseries'>Win Point: </td>
                                                <td align='right' width='40%' class='tdseries'><?= number_format($rdata["winPoint"], 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td align='right' width='60%' class='tdseries'>Net: </td>
                                                <?php
                                                $snap = ((float) $rdata["netPayble"] + (float) $rdata["totalPoint"]);
                                                ?>
                                                <td align='right' width='40%' class='tdseries'><?= number_format($snap, 2) ?></td>
                                            </tr>
                                        </table>				
                                    </td>
                                </tr>
                            </table>	
                        </td>
                    </tr>

                </table>
            </div>
        </form>	
        <script>
            var api_url = "<?= api_url ?>";
            var userid = "<?= $_SESSION["userid"] ?>";
            var id = "<?= $_SESSION["id"] ?>";
            var company = "<?= company ?>";
            var image = api_url + "<?= image ?>";
        </script>
        <script src="assets/yatara/main.js" type="text/javascript"></script>
        <script src="assets/yatara/render.js" type="text/javascript"></script>
    </body>

</html>