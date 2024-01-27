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
            table tr th,td{
                text-align: left !important;
            }

        </style>
    </head>
    <body>
        <div class="ticketContainer">


            <div class="drawTime">

                <?php
                echo "<p style='font-family: 'Montserrat', sans-serif !important;'><b style='font-size:15px; '>" . company . "</b><br>";
                echo "Game for Adults Amusement Only<br>";
                echo "GST No. issued by Govt. of INDIA<br>";
                echo "GST No. ".GST."<br>";
                echo "</p>";
                echo "<p><center><b>{$row["date"]}<br>{$report}</b></center></p>";
                ?>
            </div>
            <table class="numbers-played" style="margin-top: -5px !important; padding: 0px;">
<!--                <thead>
                    <tr style='border:none;'>
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> # </td> 
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> Particular </td> 
                        <td style='font-size:10px; margin:0px; padding:0px;color:#000;'> Point </td>


                    </tr>
                </thead>-->
                <tbody class="numbers-played-data">
                    <?php
                    $limit = 1;

                    foreach ($print1 as $key1 => $val1) {
                        $val=number_format($val1,2);
                        echo "<tr style='border:none;'><th style='font-size:10px; margin:0px; padding:0px;color:#000;'>{$limit}</th><th style='font-size:10px; margin:0px; padding:0px;color:#000;'>{$key1}</th><td style='font-size:10px; margin:0px; padding:0px;color:#000;'>{$val}</td></tr>";
                        $limit++;
                    }
                    ?>
                </tbody>
            </table>
            <br><br><br>
            

        </div>

    </body>
</html>






