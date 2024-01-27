<?php

//use CAaskController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once controller;

class calculateResult extends CAaskController
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
        $t = 1; //test for manual
        if ($t === 0) {
            echo "Manual Resul<br>";
            $_POST["gameid"] = "12";
            $_POST["stime"] = "12:45:00";
            $_POST["etime"] = "13:00:00";
        }
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

            $sqlAdmin = "SELECT * FROM `admin` WHERE id=1 AND active=1 AND cron=1";
            $resultAdmin = $this->adminDB[$_SESSION["db_1"]]->query($sqlAdmin);
            if ($rowAdmin = $resultAdmin->fetch_assoc()) {
                $sql = "SELECT * FROM `gameseries`";
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $lotoResult = [];
                while ($row = $result->fetch_assoc()) {
                    $series = explode("-", $row["series"]);
                    $start = intval($series[0]);
                    $end = intval($series[1]);
                    $empty = [];
                    for ($k = 0; $k < 100; $k++) {
                        array_push($empty, $k);
                    }
                    $loadData = [];
                    $gsum = 0;
                    $grandSum = 0;
                    for ($i = $start; $i <= $end; $i = $i + 100) {
                        $seriesQuery = "SELECT `number`,`" . $_POST["gameid"] . "` as pt, (SELECT SUM(`" . $_POST["gameid"] . "`) as n FROM `" . $i . "`) as sum FROM `" . $i . "`";
                        $seriesResult = $this->adminDB[$_SESSION["db_1"]]->query($seriesQuery);
                        $grandSum = 0;
                        $seriesLoad = [];
                        while ($rowSeries = $seriesResult->fetch_assoc()) {
                            array_push($seriesLoad, $rowSeries["pt"]);
                            $grandSum = $rowSeries["sum"];
                        }
                        $gsum = $gsum + $grandSum;

                        $loadData[$i] = $seriesLoad;

                        $per = round(((($grandSum * $rowAdmin["resultper"]) / 100) * 2) / $rowAdmin["resultper"]);
                        for ($p = 0; $p < count($empty); $p++) {
                            $randomIndex = array_rand($empty);
                            if ($seriesLoad[$randomIndex] <= $per) {
                                array_push($lotoResult, $randomIndex);
                                unset($empty[$randomIndex]);
                                break;
                            }
                        }
                    }
                    $loadData["gameLoad"] = $gsum;
                    //print_r($lotoResult);
                    $query = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "series" => $row["series"]), "AND");
                    $data = array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "dload" => $grandSum, "80per" => $rowAdmin["resultper"], "loadarray" => json_encode($loadData), "series" => $row["series"]);
                    $d = array_merge($data, $lotoResult);
                    $rp = $this->adminDB[$_SESSION["db_1"]]->query($query);
                    if ($r = $rp->fetch_assoc()) {
                        echo "already Result Disply";
                    } else {
                        $sql = $this->ask_mysqli->insertSpecialChar("winnumber", $d);
                        $this->adminDB[$_SESSION["db_1"]]->query($sql);
                        $this->ResetDrawLoad($row["series"]);
                        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("status" => "1"), "gametime") . $this->ask_mysqli->whereSingle(array("id" => $_POST["gameid"])));
                    }
                    $lotoResult=[];
                }
            }else{
                echo "already Result Disply";
            }
        } catch (Exception $ex) {
        }
        return;
    }
    function ResetDrawLoad($subSeries)
    {
        for ($i = $subSeries[0]; $i <= $subSeries[1]; $i = $i + 100) {
            $sql = $this->ask_mysqli->update(array("" . $_POST["gameid"] . "" => 0), "`" . $i . "`");
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
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

    public function distory()
    {
        parent::distory();
        return;
    }
}
