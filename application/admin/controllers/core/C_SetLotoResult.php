<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once controller;

class C_SetLotoResult extends CAaskController
{

    //put your code here
    public $visState = false;
    public $l = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        //$this->load->vie("login.php");
        parent::create();
        //$this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("status" => "1"), "gametime"));


        return;
    }

    public function initialize()
    {
        parent::initialize();

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

        foreach ($this->l as $key => $val) {
            if ($n == $val) {
                $flag = false;
            }
        }
        return $flag;
    }

    public function execute()
    {
        parent::execute();
        try {

            $error = array();
            $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("gameseries", $_SESSION["db_1"]));
            $k = 0;
            while ($row = $result->fetch_assoc()) {

                $lottery = array();
                $p = 0;
                for ($i = $k; $i < ($k + 10); $i++) {
                    if ($_POST[$i] !== "") {
                        $lottery["`{$p}`"] = $_POST[$i];
                    } // === "" ? null : $_POST[$i];
                    $p++;
                }
                $k += 10;
                // echo "<option>" . $row["series"] . "</option>";
                // print_r($lottery);
                $data = array("series" => $row["series"], "gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "dload" => "N", "80per" => "N", "loadarray" => $_POST["loadarray"]);
                $d = array_merge($data, $lottery);

                $query = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("series" => $row["series"], "gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d")), "AND");

                $rp = $this->adminDB[$_SESSION["db_1"]]->query($query);
                if ($r = $rp->fetch_assoc()) {
                    $error[$row['series']] = "series result is already publish ";
                    //echo "already Result Disply"; //$this->ResetDrawLoad();
                    $this->ResetDrawLoad();
                } else {
                    echo $sql = $this->ask_mysqli->insert("winnumber", $d);
                    $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    $this->ResetDrawLoad();
                    //$error[$row['series']] = "series result is published ";
                }
            }
            if (empty($error)) {
                echo "<h1>Result is publised successfully..</h1>";
            } else {
                echo "<h1>Result is already published.....</h1>";
            }
            //$this->adminDB[$_SESSION["db_1"]]->query($this->update(array("status" => "1"), "gametime") . $this->whereSingle(array("id" => $_POST["gameid"])));
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

    function ResetDrawLoad()
    {
        $ss = explode("-", $_REQUEST["series"]);
        //$this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("`" . $_POST["gameid"] . "`" => 0), "lottoweight"));
        for ($i = $ss[0]; $i < $ss[1]; $i = $i + 100) {
            // echo $this->ask_mysqli->update(array("`" . $_POST["gameid"] . "`" => 0), "`" . $i . "`");
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("" . $_POST["gameid"] . "" => 0), "`" . $i . "`"));
        }
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

    function getArray()
    {
        $arr = array();

        for ($i = 0; $i < 100; $i++) {
            $arr[$i] = $i;
        }

        shuffle($arr);

        return $arr;
    }
}
