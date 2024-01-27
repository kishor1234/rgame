<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CAskModule
 *
 * @author atharv
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class CAskModule {

    //put your code here
    private $main;

    public function __construct($mains) {
        $this->main = $mains;
    }

    function getCurrentDrawDetails() {
        $sql = $this->main->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSinglelessthanequal(array("stime" => date("H:i:s"))) . $this->main->ask_mysqli->orderBy("DESC", "id") . $this->main->ask_mysqli->limitWithOutOffset(1);
        $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            $_SESSION["gameid"] = $row["id"];
            $_SESSION["stime"] = $row["stime"];
            $_SESSION["etime"] = $row["etime"];
            $t = (int) strtotime($row["etime"]) - (int) strtotime(date("H:i:s"));
            $row["time"] = "" . $t;
            return $row;
        }
    }

    function getPreviousDrawDetails() {
        $sql = $this->main->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSinglelessthanequal(array("stime" => date("H:i:s"))) . $this->main->ask_mysqli->orderBy("DESC", "id"); //. $this->main->ask_mysqli->limitWithOutOffset(1);
        $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
        $array = array();
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
        return $array;
    }

    function getSinglePreviousDrawDetails() {
        $sql = $this->main->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSinglelessthanequal(array("stime" => date("H:i:s"))) . $this->main->ask_mysqli->orderBy("DESC", "id") . $this->main->ask_mysqli->limitWithOutOffset(1);
        $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
        $array = array();
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
    }

    function getSingleGameTiemByid($id) {
        $sql = $this->main->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSingle(array("id" => $id)) . $this->main->ask_mysqli->orderBy("DESC", "id") . $this->main->ask_mysqli->limitWithOutOffset(1);
        $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
        $array = array();
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
    }

    function getAllTiem() {
        $sql = $this->main->ask_mysqli->select("gametime", $_SESSION["db_1"]); // . $this->main->ask_mysqli->whereSingle(array("id" => $id)) . $this->main->ask_mysqli->orderBy("DESC", "id") . $this->main->ask_mysqli->limitWithOutOffset(1);
        $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
        $array = array();
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
        return $array;
    }

    function avarage() {
        return $this->main->getData("SELECT AVG(winper) FROM `enduser`", "AVG(winper)");
    }

    function avarageAgent() {
        return $this->main->getData("SELECT AVG(winper) FROM `agent`", "AVG(winper)");
    }

    function block($ticket) {
        $array = array();
        $sql = $this->main->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSingle(array("utrno" => $ticket));
        $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            $own = $row["own"];
            $sql = $this->main->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSingle(array("game" => $row["game"]));
            $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
            $array = array();
            while ($row = $result->fetch_assoc()) {
                $temp = json_decode($row["point"], true);
                $array = array_merge($array, $temp);
            }

            //$own = $this->main->getData($sql . $this->main->ask_mysql->limitWithOutOffset(1), "own");
            $sql = $this->main->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->main->ask_mysqli->whereSingle(array("userid" => $own));
            $result = $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $per = round((int) (count($array) * (float) $row['blockper']) / 100);
//                if ($per >= 50) {
//                    $per = 50;
//                } else {
//                    
//                }

                $blockNumber = array();
                shuffle($array);
                shuffle($array);
                shuffle($array);
                shuffle($array);
                shuffle($array);
                for ($i = 0; $i <= $per; $i++) {
                    $index = rand(0, count($array) - 1);
                    foreach ($array[$i] as $key => $val) {

                        $keylenght = strlen($key . "");
                        switch ($keylenght) {
                            case 1:
                                array_push($blockNumber, $key);
                                break;
                            case 2:
                                array_push($blockNumber, $key);
                                break;
                            case 3:
                                $x = (float) $key / 100;
                                $y = (int) $x;
                                $k = number_format($x - $y, 2);
                                $f = $k * 100;
                                array_push($blockNumber, $f);
                                break;
                            case 4:
                                $x = (float) $key / 100;
                                $y = (int) $x;
                                $k = number_format($x - $y, 2);
                                $f = $k * 100;
                                array_push($blockNumber, $f);
                                break;
                        }
//                        echo $key;
//                        print_r($blockNumber);die;
                    }
                }
                $sc = $this->main->ask_mysqli->select("admin", $_SESSION["db_1"]);
                $pt = $this->main->getData($sc, "blockno");
                $point = json_decode($pt, true);
                if (!empty($point)) {
                    $blockNumber = array_merge($point, $blockNumber);
                }
                $blockNumber = array_unique($blockNumber);

                $array = array();
                foreach ($blockNumber as $eky => $v) {
                    array_push($array, number_format($v));
                }
                $block = json_encode($array);
                $sql = $this->main->ask_mysqli->update(array("blockno" => $block), "admin") . $this->main->ask_mysqli->whereSingle(array("id" => 1));
                $this->main->adminDB[$_SESSION["db_1"]]->query($sql);
                return $array;
            }
        }
        return $array;
    }

}
