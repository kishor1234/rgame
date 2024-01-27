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

class loadgame extends CAaskController {

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
        $data2 = array();
        //$systm = date("H:i:s");
//        $data["uid"]="20210723";
//        $data["u"]=3;
        $gmtm = "";
        $schcd = 11954;
        $gmcd = "YG01";
        $mrp = 2;
        $lastdrtm = "";

        //result
        $lastres = "";
        $resstr = "Result";
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

        $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $last["id"], "gamestime" => $last["stime"], "gameetime" => $last["etime"], "gdate" => date("Y-m-d")), "AND").$this->ask_mysqli->orderBy("ASC", "series");
        $query = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $rflat = false;
        while ($qrow = $query->fetch_assoc()) {

            $series = explode("-", $qrow["series"]);
//            print_r($series);die;
            $j = 0;
            for ($i = $series[0]; $i <= $series[1]; $i = $i + 100) {
                $lastres .= str_pad($i + $qrow[$j], 4, "0", STR_PAD_LEFT) . ",";
                $j++;
            }
            $rflat = true;
        }
        if (!$rflat) {
            $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $last["id"]-1,"gdate" => date("Y-m-d")), "AND");
            $query = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $rflat = false;
            while ($qrow = $query->fetch_assoc()) {

                $series = explode("-", $qrow["series"]);
//            print_r($series);die;
                $j = 0;
                for ($i = $series[0]; $i <= $series[1]; $i = $i + 100) {
                    $lastres .= str_pad($i + $qrow[$j], 4, "0", STR_PAD_LEFT) . ",";
                    $j++;
                }
            }
        }

        $uname = "";
        $uid = "";
        $climit = 0;
        $inflag = "true";
        $newsstr = "";
        $agentname;
        $advstr;
        //messge
        $msgResult = $this->adminDB[$_SESSION["db_1"]]->query("SELECT * FROM `message`");
        while ($msgRow = $msgResult->fetch_assoc()) {
            $newsstr .= "{$msgRow["message"]} ";
        }
        //end message

        $msgResult = $this->adminDB[$_SESSION["db_1"]]->query("SELECT * FROM `enduser`  WHERE `enduser`.`userid`='{$data["uid"]}'");
        while ($msgRow = $msgResult->fetch_assoc()) {
            if ($msgRow["agent_id"] == "") {
                $agentname = " Admin ONE 1 ";
            } else {
                $s = $this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $msgRow["agent_id"]));
                $r = $this->adminDB[$_SESSION["db_1"]]->query($s);
                $ro = $r->fetch_assoc();
                $agentname = " {$ro["name"]} ONE {$ro["userid"]} ";
            }
            $uid = $msgRow["userid"];
            $uname = "{$msgRow["name"]} {$msgRow["userid"]} ";
            $climit = "{$msgRow["balance"]} ";
        }

        //end result
        $sql = $this->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->ask_mysqli->whereSinglegreaterthanequal(array("etime" => date("H:i:s")));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            if ($i === 0) {
                $gmtm = date("h:i A", strtotime($row["etime"]));
                $lastdrtm = date("h:i A", strtotime($row["stime"]));
                $L = date("h:i A", strtotime($row["etime"]));
                $advstr .= "{$row["id"]}- {$L}";
                $schcd = "{$row["id"]} ";
            } else {
                $l = date("h:i A", strtotime($row["etime"]));
                $advstr .= "~{$row["id"]}- {$l}";
            }
            //array_push($data2, $row["id"] . "-" . $row["stime"]);
            $i++;
        }
        $ltsn = "NA";
        $lpt = "NA";
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("enterydate" => date("Y-m-d"), "own" => $data["uid"]), "AND") . $this->ask_mysqli->orderBy("DESC", "utrno") . $this->ask_mysqli->limitWithOutOffset(1);
        $rew = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($rw = $rew->fetch_assoc()) {
            $ltsn = $rw["utrno"];
            $lpt = $rw["amount"];
        }
        echo date("H:i:s") . "!" . $gmtm . "!" . $schcd . "!" . $gmcd . "!" . $mrp . "!" . $lastdrtm . "!" .
        $lastres . "!" . $resstr . "!" . $uname . "!" . $climit . "!" .
        $inflag . "!" . $newsstr . "!" . $agentname . "!" . $advstr . "!" . $ltsn . "!" . $lpt;
        //echo json_encode(array("status" => "1", "message" => "Success", "data" => $data2));


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
