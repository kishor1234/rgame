<?php

//use CAaskController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once controller;

class calculateResultCustomeByDate extends CAaskController {

    //put your code here
    public $visState = false;
    public $l = array();
    public $per = 80;
    public $wrate = 180;
    public $min = "0";
    public $blockno = array();
    public $load = array();
    public $zeroload = array();
    public $nonzeroload = array();

    public function __construct() {
        parent::__construct();
        //die;
    }

    public function create() {
        parent::create();
        //status=0  to all draw active

//        $sql = "select * from gametime where etime>='" . date("H:i:s") . "'";
//        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
//        $row = $result->fetch_assoc();
//        if ($_POST["gameid"] >= $row["id"]) {
//            echo json_encode(array("status" => "0", "msg" => "Draw is not start yet.."));
//            die;
//        }
//        
//        $_POST["gameid"] = $row["id"];
//        $_POST["stime"] = $row["stime"];
//        $_POST["etime"] = $row["etime"];

        $t = 0; //test for manual
        if ($t === 0) {
            echo "Manual Resul<br>";
            $_POST["gameid"] = "4";
            $_POST["stime"] = "10:45:00";
            $_POST["etime"] = "11:00:00";
            $_POST["enterydate"] = "2021-08-22";
            die;
        }

        return;
    }

    public function initialize() {
        parent::initialize();
        return;
    }

    function getIndex($val2) {
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

    function checkKeypreset($n) {
        $flag = true;

        foreach ($this->l as $val) {
            if ($n == $val) {
                $flag = false;
            }
        }
        return $flag;
    }

    function getGlobal() {
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin", $_SESSION["db_1"]));
        $row = $result->fetch_assoc();
        //$this->per = rand(10, $row["resultper"]);
        $this->per = $row["resultper"];
        $this->wrate = $row["winrate"];
        $this->min = $row["min"];
        switch ($row["resultTech"]) {
            case "0":
                $this->per = $row["resultper"];
                break;
            case "1":
                $this->per = $this->module->avarageAgent(); //avarageAgent
                break;
//            case "2":
//                $this->per = $this->module->avarage();
//                break;
            default:
                $this->per = rand(50, 100);
                break;
        }
        $blockno = json_decode($row["blockno"], true);

        $i = 0;
        foreach ($blockno as $key => $val) {

            if ($i == 50) {
                break;
            }
            array_push($this->blockno, $val);
            $i++;
        }

        if ($row["cron"] == 0) {
            // echo "Admin Stop Result";
            echo json_encode(array("status" => "0", "msg" => "Admin Stop Draw Result.."));
            die;
            //die;
        }
    }

    function getSum($subSereis) {
        $sum = 0;
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $s = $this->ask_mysqli->selectSum("`" . $i . "`", "`" . $_POST["gameid"] . "`") . "\n";
            $sum += $this->getData($s, "sum(`" . $_POST["gameid"] . "`)");
        }
        return $sum;
    }

    function getEmptyLoad($subSereis) {
        $load = array();
        //sub series array
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $load[$i] = "";
        }
        return $load;
    }

    function getLoad($subSereis) {

        $this->zeroload = array();
        $this->nonzeroload = array();
        $this->load = array();
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
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

    function emptZeroLoad() {
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

    public function execute() {
        parent::execute();
        try {
            $sum = 0;
            $this->getGlobal();
            $resultSeries = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("gameseries", $_SESSION["db_1"]));
            while ($rowSereis = $resultSeries->fetch_assoc()) {
                //select series Array ( [sid] => 1 [id] => 1 [series] => 1000-1900 )
                $series = $rowSereis["series"];
                $subSs = explode("-", $rowSereis["series"]);
                $subSereis[0] = (int) $subSs[0];
                $subSereis[1] = (int) $subSs[1];
                $sum = $this->getSum($subSereis);
                $this->load = $this->getEmptyLoad($subSereis);
                $this->getLoad($subSereis);
                $this->load["lottoweight"] = $sum; //$totalLoad;
                $_POST["loadarray"] = json_encode($this->load);
                //$point contain total load of sereis
                $point = (float) $sum;
                $_POST["dload"] = $point;
//                echo "Total Points: " . $point . "<br>";
//                echo "Total Amount: " . $point * 2 . "<br>";
                $per = ((float) (($point * 2) * $this->per) / 100);
                //echo "Per " . $this->per . "% " . $per . "<br>";
                $_POST["80per"] = $per;
                //echo "<br>winrate {$this->wrate}<br>";
                $cpoint = 0;
                if ($this->emptZeroLoad()) {
                    $cpoint = round($per / $this->wrate) + 1;
                } else {
                    $cpoint = round($per / $this->wrate);
                }
                //echo "<br> zero point level {$cpoint}";
                $pointPerPlat = $cpoint / 10;
                //echo "<br> Perplat Point : " . round($pointPerPlat) . "</br>";
                $wamt = (round($per) / 2);
                //echo "Excepted Wingin amt  " . $wamt . PHP_EOL;
                //die;
                $perPlatload = array();
                for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                    $sum = $this->getData($this->ask_mysqli->selectSum("`" . $i . "`", "`" . $_POST["gameid"] . "`"), "sum(`" . $_POST["gameid"] . "`)");
                    array_push($perPlatload, $sum);
                }
//                print_r($perPlatload);
//                echo "<br>";
                $ppoint = $cpoint;
                if ($point >= 0) {

                    $markResult = array();
                    $sonaResult = array();
                    $lottery = array();
                    $sks = 0;
//                    unset($this->blockno["id"]);
//                    foreach ($this->blockno as $k => $v) {
//                        if (empty($v)) {
//                            unset($this->blockno[$k]);
//                        }
//                    }
//                    $cpoint = $ppoint;
                    $fraction = 0;
                    while ($sks < 1) {

                        $lottery = array();
                        $perPl = $pointPerPlat;
                        $keyarray = array();

                        foreach ($this->nonzeroload as $keys => $nonezero) {
                            array_push($keyarray, $keys);
                        }

                        $orginKey = $keyarray;
                        shuffle($keyarray);
                        shuffle($keyarray);
                        shuffle($keyarray);
                        //echo "<br>Series Array<Br>";

                        foreach ($keyarray as $ink => $key) {
                            $nonezero = $this->nonzeroload[$key];

                            $rnd = rand(0, 1);

                            //  echo "<br>Random Order {$rnd}<br>";
                            switch ($rnd) {
                                case 0:
                                    shuffle($nonezero);
                                    shuffle($nonezero);
                                    shuffle($nonezero);
                                    break;
                                case 1:
                                    shuffle($nonezero);
                                    shuffle($nonezero);
                                    break;
                                default :
                                    //uasort($nonezero, array('calculateResult', 'Descending'));
                                    break;
                            }

                            //echo "<br>Key=>{$key}<br>";
                            $i = 0;

                            if (!empty($nonezero)) {
                                $flag = false;
                                //  echo "<br> Update Flag<br>";

                                if ($rnd == 2) {
                                    //uasort($nonezero, array('calculateResult', 'Descending'));
                                }
                                //uasort($nonezero, array('calculateResult', 'Descending'));
                                //print_r($nonezero);
                                //die;
                                //echo "<br>" . $cpoint . " cpoint<br>";
//                                print_r($nonezero);
                                foreach ($nonezero as $nkey => $nono) {
                                    if (!in_array($nono, $this->blockno)) {

//                                        echo $this->load[$key][$nono];
//                                        echo "<br>";
                                        if (!in_array($nono, $lottery)) {
                                            //if (strcmp($this->min, "1") == 0) {
                                            $t = rand(1, round($pointPerPlat));
                                            if ($t < $cpoint) {
                                                $test = $t;
                                            }
//                                            echo "<br> T".$test;
//                                            echo "<br>";die;
                                            if ($this->load[$key][$nono] != 0) {
                                                if ($this->load[$key][$nono] >= $test && $this->load[$key][$nono] <= $cpoint) {
                                                    $perPl = $pointPerPlat;
                                                    $cpoint -= $this->load[$key][$nono];
//                                                    echo $cpoint . " non ZS [{$nono}]{$this->load[$key][$nono]}<br>";
                                                    $tkey = array_search($key, $orginKey);
                                                    //array_push($lottery, $nono);
                                                    $lottery[$tkey] = $nono;
                                                    $flag = true;
                                                    break;
                                                }
                                            }
//                                            } 
//                                            else {
//                                                if ($this->load[$key][$nono] <= $perPl) {
//                                                    $perPl = $pointPerPlat;
//                                                    echo $nono . " non Z [{$nkey}]{$this->load[$key][$nono]}<br>";
//                                                    $tkey = array_search($key, $orginKey);
//                                                    //array_push($lottery, $nono);
//                                                    $lottery[$tkey] = $nono;
//                                                    $flag = true;
//                                                    break;
//                                                }
//                                            }
                                        }
                                    }
                                }
                                if (!$flag) {
                                    $zdata = $this->zeroload[$key];
                                    shuffle($zdata);
                                    foreach ($zdata as $nkey => $nono) {
                                        if (!in_array($nono, $this->blockno)) {
                                            if (!in_array($nono, $lottery)) {
                                                if ($this->load[$key][$nono] <= $perPl) {
//                                                    echo $cpoint . " non [{$nono}]{$this->load[$key][$nono]}<br>";

                                                    $perPl += $pointPerPlat;
                                                    $tkey = array_search($key, $orginKey);
                                                    //array_push($lottery, $nono);
                                                    $lottery[$tkey] = $nono;
                                                    $flag = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (!$flag) {

                                    for ($i = 0; $i <= 99; $i++) {
                                        $nono = rand(0, 99);
                                        if (!in_array($nono, $this->blockno)) {
                                            if (!in_array($nono, $lottery)) {
                                                //if ($this->load[$key][$nono] <= $perPl) {
//                                                echo $nono . " Randome<br>";
                                                $perPl += $pointPerPlat;
                                                $tkey = array_search($key, $orginKey);
                                                //array_push($lottery, $nono);
                                                $lottery[$tkey] = $nono;
                                                $flag = true;
                                                break;
                                                // }
                                            }
                                        }
                                    }
                                }
//                                if ($flag) {
//                                    echo "true";
//                                } else {
//                                    echo "false";
//                                }
                            } else {
//                                echo "<br> ETotal Point {$key}<br>";
                                $zdata = $this->zeroload[$key];

                                shuffle($zdata);
                                foreach ($zdata as $nkey => $nono) {
                                    if (!in_array($nono, $this->blockno)) {
                                        if (!in_array($nono, $lottery)) {
                                            if ($this->load[$key][$nono] <= $perPl) {
//                                                echo $nono . " Else Zero <br>";
                                                $perPl = $pointPerPlat;
                                                $tkey = array_search($key, $orginKey);
                                                //array_push($lottery, $nono);
                                                $lottery[$tkey] = $nono;
                                                $flag = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
//              
                        }

                        $entir_sum = 0;
                        if (count($lottery) == 10) {
                            $p = 0;
                            for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
//                                echo $this->load[$i][$lottery[$p]] . "<br>";
                                $entir_sum += $this->load[$i][$lottery[$p]];
                                $p++;
                            }

                            $sonaResult[$sks] = $entir_sum;
                            $markResult[$sks] = $lottery;
                            $sks++;
                        }

                        ksort($lottery);
//                        print_r($lottery);
                        //die;
                    }
                    $fcount = 0;
                    if (strcmp($this->min, "1") == 0) {
                        $flt = true;
//                        foreach ($sonaResult as $ind => $val) {
//                            if ($val <= $per && $val!=0) {
//                                $index = $ind;
//                                $flt = false;
//                                break;
//                            }
//                        }
                        if ($flt) {
                            $index = array_search(max($sonaResult), $sonaResult);
                            $fcount = $sonaResult[$index];
                            $lottery = $markResult[$index];
                        }
//                        echo "Max Result";
                    } else {
                        $index = array_search(min($sonaResult), $sonaResult);
                        $fcount = $sonaResult[$index];
                        $lottery = $markResult[$index];
//                        echo "Min Result";
                    }
                }

//                print_r($lottery);
                ksort($lottery);
                //print_r($lottery);
                //print_r($sonaResult);
//                echo "<br>Final array " . $fcount * ($this->wrate) . "</br>";

                $loadData = $_POST["loadarray"];
                $data = array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => $_POST["enterydate"], "dload" => $_POST["dload"], "80per" => $this->per, "loadarray" => $loadData, "series" => $series);
                $d = array_merge($data, $lottery);
                $query = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => $_POST["enterydate"], "series" => $series), "AND");
                $rp = $this->adminDB[$_SESSION["db_1"]]->query($query);
                if ($r = $rp->fetch_assoc()) {
//                    echo json_encode(array("status" => "0", "msg" => "already Result Disply.."));
//                    echo "already Result Disply"; //$this->ResetDrawLoad();
//                    //$this->ResetD[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99]rawLoad($subSereis);
                } else {
                    $sql = $this->ask_mysqli->insertSpecialChar("winnumber", $d);
                    //echo "<br>";
                    $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    $this->ResetDrawLoad($subSereis);
//                    echo json_encode(array("status" => "1", "msg" => "Successfully Result Release.."));
//                  
                }
            }
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("status" => "1"), "gametime") . $this->ask_mysqli->whereSingle(array("id" => $_POST["gameid"])));
            $block = json_encode(array());
            $sql = $this->ask_mysqli->update(array("blockno" => $block), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
            echo json_encode(array("status" => "1", "msg" => "Successfully Result Release.."));
            //die;
        } catch (Exception $ex) {
            
        }
        return;
    }

    public function finalize() {
        parent::finalize();
        return;
    }

    public function reader() {
        parent::reader();

        return;
    }

    function ResetDrawLoad($subSeries) {
        for ($i = $subSeries[0]; $i <= $subSeries[1]; $i = $i + 100) {
            $sql = $this->ask_mysqli->update(array("" . $_POST["gameid"] . "" => 0), "`" . $i . "`");
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
//        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("`" . $_POST["gameid"] . "`" => 0), "lottoweight"));
//        for ($i = 1000; $i < 2000; $i = $i + 100) {
//            $this->adminDB[$_SESSION["db_1"]]->query($this->update(array("`" . $_POST["gameid"] . "`" => 0), "`" . $i . "`"));
//        }
    }

    public function distory() {
        parent::distory();
        return;
    }

    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    function discard($unicarray, $arr) {
        foreach ($unicarray as $key => $val) {
            
        }
    }

    function paddZeor($val, $s) {
        $s = $s * 1000;
        for ($i = 0; $i < 100; $i++) {
            if ((int) $val[$i] == 0) {
                $val[$i] = $s;
            }
        }
        return $val;
    }

    function getArray($val) {
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

    private static function Descending($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }

}
