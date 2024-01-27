
<div class="ticketContainer">


    <div class="drawTime">

        <?php
//        $date = new \DateTime($row["gameendtime"]);
//        $drtime = date_format($date, 'G:iA');
        echo "<p><b style='font-size:15px;'>" . company . "</b><br>";
        echo "<b>Game for Adults Amusement Only</b><br>";
        // echo "<b>GST No. issued by Govt. of INDIA</b><br>";
        // echo "<b>GST No. ".GST."</b><br>";
        echo "<b>Draw.</b> {$row["drawid"]} | <b>Date:</b> {$row["date"]}</p>"
        ?>
    </div>
    <table class="numbers-played" style="margin-top: -8px !important; padding: 0px;">
        <thead>
            <tr style='border:none;'>
                <th style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>Numb</strong> </th> 
                <th style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>Qty</strong> </th>
                <th style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>Numb</strong> </th> 
                <th style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>Qty</strong> </th>
                <th style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>Numb</strong> </th> 
                <th style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>Qty</strong> </th>
            </tr>
        </thead>
        <tbody class="numbers-played-data">
            <?php
            $limit = 1;
            //$json = json_decode($row["point"], true);
            $json = $row["winPoint"];
            foreach ($json as $key => $val) {
//                foreach ($val1 as $key => $val) {
                $knum = str_pad($key, 4, "0", STR_PAD_LEFT);
                if ($limit == 1) {
                    echo "<tr style='border:none;'>";
                }
                if ($limit == 3) {

                    echo "<td style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>{$knum}</strong> </td> <td style='font-size:15px; margin:0px; padding:0px;'> <strong>{$val} </strong></td></tr>";
                    $limit = 0;
                } else {

                    echo "<td style='font-size:15px; margin:0px; padding:0px;color:#000;'> <strong>{$knum}</strong> </td> <td style='font-size:15px; margin:0px; padding:0px;'> <strong>{$val}</strong> </td>";
                }
                $limit++;
//                }
            }
            ?>
        </tbody>
    </table>
    <p>
        <b>Per ticket price .</b><span class="perTickt"> 2 . 00</span>
        <br>
        <b>Win AMT Rs. </b><span class="amount"><?= $row["amount"] ?></span>
        <br>
        <b>TSN. : </b> 
        <span class="qty"><?= $row["utrno"] ?></span>

        <br>
        <b>Retailer Code</b>
        <span class="retailer_code">
            <?= $row["own"] ?>
        </span>

    </p>
</div>



