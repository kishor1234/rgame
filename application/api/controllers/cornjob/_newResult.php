<?php

//use CAaskController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once controller;

class newResult extends CAaskController
{

    //put your code here
    public $winnerid;
    public $idLoad;
    public $idLoadNonZero;
    public $type;
    public $visState = false;
    public $l = array();
    public $per = 80;
    public $wrate = 180;
    public $min = "0";
    public $blockno = array();
    public $load = array();
    public $zeroload = array();
    public $nonzeroload = array();

    public function __construct()
    {
        parent::__construct();
        //die;
    }

    public function create()
    {
        parent::create();
        $sql = "select * from gametime where id='" . $_REQUEST["id"] . "'";
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $_POST["gameid"] = $row["id"];
        $_POST["stime"] = $row["stime"];
        $_POST["etime"] = $row["etime"];
        $_POST["per"] = $row["per"];
        $_POST["method"] = "NEW";
        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("status" => "1"), "gametime") . $this->ask_mysqli->whereSingle(array("id" => $_POST["gameid"])));
        $t = 1; //test for manual
        if ($t === 0) {
            echo "Manual Resul<br>";
            $_POST["gameid"] = "12";
            $_POST["stime"] = "12:45:00";
            $_POST["etime"] = "13:00:00";
            $_POST["per"] = "80";
        }
        // print_r($_POST);die;
        return;
    }

    public function initialize()
    {
        parent::initialize();
        return;
    }

    public function execute()
    {
        parent::execute();
        try {
            $sum = 0;
            $this->getGlobal();
            $resultSeries = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("gameseries", $_SESSION["db_1"]));
            while ($rowSereis = $resultSeries->fetch_assoc()) {
                print_r($rowSereis); //$rowSereis is series ID
                //select series Array ( [sid] => 1 [id] => 1 [series] => 1000-1900 )
                $series = $rowSereis["series"];
                $sereisid = $rowSereis["id"];
                $subSs = explode("-", $rowSereis["series"]);
                $subSereis[0] = (int) $subSs[0];
                $subSereis[1] = (int) $subSs[1];
                $sum = $this->getSum($subSereis);
                $this->load = $this->getEmptyLoad($subSereis);
                $this->getLoad($subSereis);
                $lottoweight = $sum; //$totalLoad;
                $_POST["loadarray"] = json_encode($this->load);
                //$point contain total load of sereis
                $point = (float) $sum;
                echo "Total Points: " . $point . "<br>";
                echo "Total Amount: " . $point * 2 . "<br>";
                $_POST["dload"] = $point;
                $temp = $this->per - 10;
                $per = ((float) (($point) * $temp) / 100);
                echo "Per " . $this->per . "% " . $per . "<br>";
                $_POST["80per"] = $per;
                $perPlate = ($per / 10);
                echo "<br> zero point level {$perPlate}  ";
                $winNumber = round($perPlate / $this->wrate);
                echo "<br>winrate {$this->wrate}=={$winNumber}<br>";
                // print_r($_POST);
                $wamt = (round($winNumber) * 180);
                echo "Excepted Wingin amt  " . $wamt . " >>" . $point . PHP_EOL;
                $lottery = array();
                if ($point > 0 && $winNumber > 0) {
                    // print_r($this->load);
                    $keyarray = array();
                    $exp = 0;
                    foreach ($this->load as $key => $nonzero) {

                        // Get random indices where values are less than or equal to 2
                        $randomIndices = array_filter(array_keys($nonzero), function ($index) use ($nonzero, $wamt) {
                            return $nonzero[$index] <= $wamt;
                        });

                        // Get unique indices in the range from 1 to 10
                        $uniqueIndices = array_unique(array_map(function () use ($randomIndices) {
                            return mt_rand(0, 99);
                        }, range(1, count($randomIndices))));

                        // Extract values from the original array based on the unique indices
                        $selectedValues = array_intersect_key($nonzero, array_flip($uniqueIndices));
                        // Display the results
                        // echo "Random Indices: " . implode(', ', $randomIndices) . PHP_EOL;
                        // echo "Unique Indices: " . implode(', ', $uniqueIndices) . PHP_EOL;
                        // echo "Selected Values: " . implode(', ', $selectedValues) . PHP_EOL;
                        // die;
                        foreach ($uniqueIndices as $k => $v) {

                            if (!in_array($v, $lottery)) {
                                if ($this->load[$key][$k] != 0) {
                                    if ($this->load[$key][$k] <= $winNumber) {
                                        array_push($lottery, $v);
                                        // $exp = $exp + $this->load[$key][$v];
                                        $flag = true;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    $i = 0;
                    foreach ($this->load as $key => $nonzero) {

                        echo  $this->load[$key][$lottery[$i]] . PHP_EOL;
                        $exp = $exp + $this->load[$key][$lottery[$i]];
                        $i++;
                    }
                    echo "Actual Excepted Wingin amt" . $exp * 90  . PHP_EOL;
                    
                } else {
                    $keyarray = array();
                    $exp = 0;
                    foreach ($this->load as $key => $nonzero) {

                        // Get random indices where values are less than or equal to 2
                        $randomIndices = array_filter(array_keys($nonzero), function ($index) use ($nonzero, $wamt) {
                            return $nonzero[$index] <= $wamt;
                        });

                        // Get unique indices in the range from 1 to 10
                        $uniqueIndices = array_unique(array_map(function () use ($randomIndices) {
                            return mt_rand(0, 99);
                        }, range(1, count($randomIndices))));

                        // Extract values from the original array based on the unique indices
                        $selectedValues = array_intersect_key($nonzero, array_flip($uniqueIndices));
                        // Display the results
                        // echo "Random Indices: " . implode(', ', $randomIndices) . PHP_EOL;
                        // echo "Unique Indices: " . implode(', ', $uniqueIndices) . PHP_EOL;
                        // echo "Selected Values: " . implode(', ', $selectedValues) . PHP_EOL;
                        // die;
                        foreach ($uniqueIndices as $k => $v) {

                            if (!in_array($v, $lottery)) {

                                if ($this->load[$key][$k] <= $winNumber) {
                                    array_push($lottery, $v);
                                    // $exp = $exp + $this->load[$key][$v];
                                    $flag = true;
                                    break;
                                }
                            }
                        }
                    }
                    $i = 0;
                    foreach ($this->load as $key => $nonzero) {

                        echo  $this->load[$key][$lottery[$i]] . PHP_EOL;
                        $exp = $exp + $this->load[$key][$lottery[$i]];
                        $i++;
                    }
                    echo "Actual Excepted Wingin amt" . $exp * 90  . PHP_EOL;
                    print_r($lottery);
                    // die;
                }
                // die;
                $loadData = $_POST["loadarray"];
                $data = array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "dload" => $_POST["dload"], "80per" => $this->per, "loadarray" => $loadData, "series" => $series, "method" => $_POST["method"]);
                $d = array_merge($data, $lottery);
                // print_r($d);
                $query = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "series" => $series), "AND");
                $rp = $this->adminDB[$_SESSION["db_1"]]->query($query);
                if ($r = $rp->fetch_assoc()) {
                    for ($i = 0; $i < 10; $i++) {

                        if ($r[$i] != "") {
                            if (!in_array($r[$i], $lottery)) {
                                $lottery[$i] = $r[$i];
                            } else {
                                $temp = $lottery[$i];
                                for ($k = 0; $k < 10; $k++) {
                                    if ($r[$i] == $lottery[$k]) {
                                        $lottery[$k] = $temp;
                                    }
                                }
                                $lottery[$i] = $r[$i];
                            }
                        }
                    }

                    $d = array_merge($data, $lottery);

                    echo $quey = $this->ask_mysqli->update($d, "winnumber") . $this->ask_mysqli->where(array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "series" => $series, "method" => $_POST["method"]), "AND");
                    // die;
                    $rpc = $this->adminDB[$_SESSION["db_1"]]->query($quey);
                    // echo "already Result Disply"; //$this->ResetDrawLoad();
                    //$this->ResetD[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99]rawLoad($subSereis);
                } else {
                    $sql = $this->ask_mysqli->insertSpecialChar("winnumber", $d);
                    echo $sql . "<br>";
                    $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    // $this->ResetDrawLoad($subSereis);
                }
                // die;
            }
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("status" => "1"), "gametime") . $this->ask_mysqli->whereSingle(array("id" => $_POST["gameid"])));
            $block = json_encode(array());
            $sql = $this->ask_mysqli->update(array("blockno" => ""), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        } catch (Exception $ex) {
        }
        return;
    }

    public function finalize()
    {
        parent::finalize();
        return;
    }

    public function reader()
    {
        parent::reader();

        return;
    }

    function getIndex($val2)
    {
        $i = 0;
        while ($i < 100) {
            $n = rand(0, count($val2) - 1);
            if ($this->checkKeypreset($val2[$n])) {

                return $n;
            }
            $i++;
        }
        return null;
    }

    function checkKeypreset($n)
    {
        $flag = true;

        foreach ($this->l as $val) {
            if ($n == $val) {
                $flag = false;
            }
        }
        return $flag;
    }

    function userwise()
    {
        //$sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("enterydate" => date("Y-m-d"), "gametime" => $_POST["stime"], "gametimeid" => $_POST["gameid"], "gameendtime" => $_POST["etime"]), "AND");

        $arr = array();
        for ($i = 0; $i < 100; $i++) {
            $arr[$i] = 0;
        }
        $seriesAlphaindex = array("alltxta", "alltxtb", "alltxtc", "alltxtd", "alltxte", "alltxtf", "alltxtg", "alltxth", "alltxti", "alltxtj");
        $seriesAlpha = array("alltxta" => $arr, "alltxtb" => $arr, "alltxtc" => $arr, "alltxtd" => $arr, "alltxte" => $arr, "alltxtf" => $arr, "alltxtg" => $arr, "alltxth" => $arr, "alltxti" => $arr, "alltxtj" => $arr);
        $srl = array($seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha, $seriesAlpha);
        echo $sqlrsp = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("own" => $this->winnerid, "enterydate" => date("Y-m-d"), "gametime" => $_POST["stime"], "gametimeid" => $_POST["gameid"], "gameendtime" => $_POST["etime"]), "AND");
        $rsp = $this->adminDB[$_SESSION["db_1"]]->query($sqlrsp);
        $array = array();
        $flag = false;
        while ($rowrsp = $rsp->fetch_assoc()) {
            //echo $rowrsp["point"];
            $flag = true;
            $pt = json_decode($rowrsp["point"], true);
            $s = 0;

            foreach ($pt["seriesa"] as $key => $val) { //series
                for ($k = 0; $k < 10; $k++) { //plates
                    for ($p = 0; $p < 100; $p++) {

                        if (isset($pt["data"][$seriesAlphaindex[$k]][$p])) {
                            $s += ((int) $pt["data"][$seriesAlphaindex[$k]][$p] * $pt["multiplier"][$k]);
                            $t = ((int) $pt["data"][$seriesAlphaindex[$k]][$p] * $pt["multiplier"][$k]);
                            $srl[$val][$seriesAlphaindex[$k]][$p] += $t;
                        }
                    }
                }
            }
            array_push($array, $s);
            $s = 0;
        }
        if ($flag) {
            $this->idLoad = $srl;
            $this->idLoadNonZero = $srl;
        }
        //unset zero load
        foreach ($this->idLoad as $key => $val) { //series
            for ($k = 0; $k < 10; $k++) { //plates
                for ($p = 0; $p < 100; $p++) {
                    // print_r($this->idLoadNonZero[$key][$seriesAlphaindex[$k]][$p]);die;
                    if ($this->idLoadNonZero[$key][$seriesAlphaindex[$k]][$p] === 0) {
                        unset($this->idLoadNonZero[$key][$seriesAlphaindex[$k]][$p]);
                    } else {
                        if (count($this->blockno) <= 71) {
                            array_push($this->blockno, $p);
                        }
                    }
                }
            }
        }

        $this->blockno = array_unique($this->blockno);
    }

    function getGlobal()
    {
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin", $_SESSION["db_1"]));
        $row = $result->fetch_assoc();
        $this->winnerid = $row["wid"];
        $this->type = $row["type"];
        //$this->per = rand(10, $row["resultper"]);
        if ($_POST["per"]) {
            $this->per = (int) $_POST["per"];
        } else {
            $this->per = (int) $row["resultper"];
        }
        $this->wrate = $row["winrate"];
        $this->min = $row["min"];
        switch ($row["resultTech"]) {
            case "0":
                $this->per = (int) $row["resultper"];
                break;
            case "1":
                $this->userwise();
                if ($this->type === "1") {
                    $this->blockno = array();
                    //                    echo "Total Point";
                    //                    print_r($this->idLoadNonZero);
                    if (!empty($this->idLoadNonZero)) {
                        $this->per = (int) $row["resultper"] * 1;
                    }
                } else {
                    $this->idLoadNonZero = array();
                    $this->idLoad = array();
                }

                //                $this->per = $this->module->avarageAgent(); //avarageAgent
                break;
            case "2":
                //                $this->per = $this->module->avarage();
                $this->userwise();
                break;
            case "3":
                $this->per = rand(50, 100);
                break;
            default:
                //get all played no of winner id//
                break;
        }


        $blockno = json_decode($row["blockno"], true);

        $i = 0;
        foreach ($blockno as $key => $val) {

            if ($i == 60) {
                break;
            }
            // array_push($this->blockno, $val);
            $i++;
        }

        if ($row["cron"] == 0) {
            echo "Admin Stop Result";
            die;
        }
    }

    function getSum($subSereis)
    {
        $sum = 0;
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $s = $this->ask_mysqli->selectSum("`" . $i . "`", "`" . $_POST["gameid"] . "`");
            $sum += $this->getData($s, "sum(`" . $_POST["gameid"] . "`)");
        }
        return $sum;
    }

    function getEmptyLoad($subSereis)
    {
        $load = array();
        //sub series array
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $load[$i] = "";
        }
        return $load;
    }

    function getLoad($subSereis)
    {

        $this->zeroload = array();
        $this->nonzeroload = array();
        $this->load = array();
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) { //0-900 
            //echo "SELECT `" . $_POST["gameid"] . "` FROM `" . $i . "` ORDER BY `number` ASC" . PHP_EOL;
            $resutl = $this->adminDB[$_SESSION['db_1']]->query("SELECT `" . $_POST["gameid"] . "` FROM `" . $i . "` ORDER BY `number` ASC");
            $totalLoad = array();
            $zero = array();
            $nonzero = array();
            $k = 0;
            while ($row = $resutl->fetch_assoc()) {
                array_push($totalLoad, $row[$_POST["gameid"]]);
                if ($row[$_POST["gameid"]] == 0) {
                    array_push($zero, $k);
                } else {
                    array_push($nonzero, $k);
                }
                $k++;
            }
            $this->zeroload[$i] = $zero;
            $this->nonzeroload[$i] = $nonzero;
            $this->load[$i] = $totalLoad;
        }
    }

    function emptZeroLoad()
    {
        $return = false;
        foreach ($this->zeroload as $sr => $point) {
            if (empty($point)) {
                $return = true;
            } else {
                $return = false;
                break;
            }
        }
        return $return;
    }

    function ResetDrawLoad($subSeries)
    {
        for ($i = $subSeries[0]; $i <= $subSeries[1]; $i = $i + 100) {
            $sql = $this->ask_mysqli->update(array("" . $_POST["gameid"] . "" => 0), "`" . $i . "`");
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
        //        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("`" . $_POST["gameid"] . "`" => 0), "lottoweight"));
        //        for ($i = 1000; $i < 2000; $i = $i + 100) {
        //            $this->adminDB[$_SESSION["db_1"]]->query($this->update(array("`" . $_POST["gameid"] . "`" => 0), "`" . $i . "`"));
        //        }
    }

    public function distory()
    {
        parent::distory();
        return;
    }

    function UniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    function discard($unicarray, $arr)
    {
        foreach ($unicarray as $key => $val) {
        }
    }

    function paddZeor($val, $s)
    {
        $s = $s * 1000;
        for ($i = 0; $i < 100; $i++) {
            if ((int) $val[$i] == 0) {
                $val[$i] = $s;
            }
        }
        return $val;
    }

    function getArray($val)
    {
        $load = array();
        $notload = array();
        foreach ($val as $key => $v) {
            foreach ($v as $k => $vv) {
                if ($vv > 0) {
                    array_push($load, $k);
                } else {
                    array_push($notload, $k);
                }
            }
        }
        shuffle($load);
        shuffle($notload);
        $arr = array_merge($load, $notload);
        return $arr;
    }

    private static function Descending($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }
}
