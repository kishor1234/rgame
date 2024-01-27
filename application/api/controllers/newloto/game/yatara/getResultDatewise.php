<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of getResultDatewise
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');
class getResultDatewise extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();

        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
        $final = array();
        $data = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $date = $request["date"];
        $game = $this->module->getAllTiem();
       
        foreach ($game as $k => $games) {
            $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $games["id"], "gamestime" => $games["stime"], "gameetime" => $games["etime"], "gdate" => $date), "AND") . $this->ask_mysqli->orderBy("ASC", "series");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $data[$games["id"]] = array("stime" => $games["stime"], "etime" => $games["etime"], "data" => array());
            $temp = array();
            while ($row = $result->fetch_assoc()) {

                $series = explode("-", $row["series"]);
                $temp[$series["0"]] = array();

                $j = 0;
                for ($i = $series[0]; $i <= $series[1]; $i = $i + 100) {
                    $lastres = str_pad($i + $row[$j], 4, "0", STR_PAD_LEFT);
                    array_push($temp[$series["0"]], $lastres);
                    $j++;
                }
            }
            if (!empty($temp)) {
                $data[$games["id"]]["data"] = $temp;
            } else {
                unset($data[$games["id"]]);
            }


//            array_push($data[$games["id"]]["data"], $temp);
        }
//        print_r($data);
        echo json_encode($data);

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

    public function distory() {
        parent::distory();
        return;
    }

}
