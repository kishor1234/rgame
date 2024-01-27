<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <style>
            *{
                font-family: 'Montserrat', sans-serif !important;
            }
            table {

                border-collapse: collapse;
                border: 0px solid #FFF;
                font-family: 'Montserrat', sans-serif !important;
            }

        </style>
    </head>
    <body>
        <div class="ticketContainer">


            <div class="drawTime">

                <?php
                $date = new \DateTime($row["gameendtime"]);
                $drtime = date_format($date, 'h:i A');
                echo "<p style='font-family: 'Montserrat', sans-serif !important;'><b style='font-size:15px; '>" . company . "</b><br>";
                echo "Game for Adults Amusement Only<br>";
                // echo "GST No. issued by Govt. of INDIA<br>";
                // echo "GST No. ".GST."<br>";
                echo "Draw. {$row["gametimeid"]} | Date: {$row["enterydate"]} {$drtime}</p>"
                ?>
            </div>
            <table class="numbers-played" style="margin-top: -5px !important; padding: 0px;">
                <thead>
                    <tr style='border:none;'>
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> NUM </td> 
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> QTY </td>
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> NUM </td> 
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> QTY </td>
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> NUM </td> 
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> QTY </td>
                    </tr>
                </thead>
                <tbody class="numbers-played-data">
                    <?php
                    $limit = 1;
                    $json = json_decode($row["point"], true);
                    foreach ($json as $key1 => $val1) {
                        foreach ($val1 as $key => $val) {
                            $knum = str_pad($key, 4, "0", STR_PAD_LEFT);
                            if ($limit == 1) {
                                echo "<tr style='border:none;'>";
                            }
                            if ($limit == 3) {

                                echo "<td style='font-size:10px; margin:0px; padding:0px;color:#000;'> {$knum} </td> <td style='font-size:10px; margin:0px; padding:0px;'> {$val} </td></tr>";
                                $limit = 0;
                            } else {

                                echo "<td style='font-size:10px; margin:0px; padding:0px;color:#000;'> {$knum} </td> <td style='font-size:10px; margin:0px; padding:0px;'> {$val} </td>";
                            }
                            $limit++;
                        }
                    }
                    ?>
                </tbody>
            </table>
            <p>
                Per ticket price .<span class="perTickt"> 2 . 00</span>
                <br>
                Qty. :  <span class="qty"><?= $row["totalpoint"] ?></span>
                <br>
                Total Rs. <span class="amount"><?= $row["amount"] ?></span>
                <br>
                Bet Date: <span class="platTime"><?= $row["isDate"] ?></span>
                <br>
                Retailer Code
                <span class="retailer_code">
                    <?= $row["own"] ?>
                </span>

            </p>
        </div>

    </body>
</html>






