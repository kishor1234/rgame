<html>

    <head>
        <meta http-equiv="Content-Language" content="en-us">
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title> <?= company ?> RESULTS</title>
        <link rel="stylesheet" href="assets/yatara/css/main.css" type="text/css">
    </head>

    <body bgcolor="#FFCCFF" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="7%" align=center><img class="img-board" src="<?= image ?>" border="5" align=middle></td>
                <td class="tdtitle" width="14%" valign="top">&nbsp;<?= company ?></td><td id="agentdet" class="tdtitle"></td>
                <td class="tdtitleright" valign="top"><a href="/?r=gameboard"><input type="button" value="Back" class="buttonback"></a>
                    <a href="/?r=logout"><input type="button" class="buttonlogout" value="Logout"></a>
                </td>
            </tr>
        </table>
        <form method="POST" action="/?r=result" name="taxform">
            <div align="center">
                <table border="0" cellpadding="2" id="table1" cellspacing="0" width="100%">
                    <tr>
                        <td align="center">
                            <table border="0" width="100%" id="table2">
                                <tr>
                                    <td align="right" width="50%">Select Date :<input type="date" id="indate" name="indate" autocomplete=off value="<?= $date ?>" max="<?= date("Y-m-d") ?>"></td>
                                    <td colspan="3" align="left"><button type="submit" id="btnok" class="buttongreen">Get Results</button>
                                </tr>
                            </table>

                            <table border="0" width="100%" id="table1" cellspacing="1" cellpadding="2">
                                <tr><td align="center" class="tdseries"><?= date('l', strtotime($date)) . " " . date("F, d, Y", strtotime($date)) ?>&nbsp;Results</td></tr>
                                <?php
                                $jsonResponse = json_decode($response, true);
                                foreach ($jsonResponse as $k => $v) {
                                    ?>
                                    <tr>
                                        <td>
                                            <table border=0 bordercolor="#000000" cellspacing=4 cellpadding=1 width="100%">


                                                <tr>
                                                    <td colspan=10 class="tdtitle"><?= date("h:i A", strtotime($v["etime"])) ?></td>
                                                </tr>

                                                <?php
                                                $i = 0;
                                                foreach ($v["data"] as $s => $sr) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <table width="100%">
                                                                <tr>
                                                                    <?php
                                                                    foreach ($sr as $key => $val) {
                                                                        ?>
                                                                        <td class="tdr<?= $i ?>"><?= $val ?></td>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>



                                            </table>			
                                        </td>

                                    </tr>
                                    <?php
                                }
                                ?>



                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </form>



    </body>

</html>