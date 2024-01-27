<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loadgame
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;
header('Content-Type: application/json');

class resultapi extends CAaskController {

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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $data = $request;
        
        $last = $this->module->getSinglePreviousDrawDetails();
        $ctime = date("H:i:s");

        if ($last["id"] === "0") {
            $id = 0;
        } else if ($last["id"] === "49" && strtotime($ctime) >= strtotime($last["etime"])) {
            $id = 49;
        } else {
            $id = $last["id"] - 1;
        }
        $last = $this->module->getSingleGameTiemByid($id);
        $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $last["id"], "gamestime" => $last["stime"], "gameetime" => $last["etime"], "gdate" => date("Y-m-d")), "AND").$this->ask_mysqli->orderBy("ASC", "series").$this->ask_mysqli->limitWithOutOffset(1);
        $query = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $rflat = array();
        while ($qrow = $query->fetch_assoc()) {
            unset($qrow["loadarray"]);
            unset($qrow["80per"]);
            unset($qrow["dload"]);
            array_push($rflat,$qrow);
        }
        $result=array();
        for($i=0;$i<10;$i++){
            $result[$i]=$rflat[0][$i];
            unset($rflat[0][$i]);
        }
        $rflat[0]["result"]=$result;
        echo json_encode($rflat);
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
