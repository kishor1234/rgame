<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reprintTicket
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class netreport extends CAaskController {

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
        $_POST = json_decode($postdata, true);
        ///
        $request["fdate"] = $_POST["fdate"];
        $request["tdate"] = $_POST["tdate"];
        $row["userid"] = $_POST["userid"];
        $array = array();
        $array["uid"] = $row["userid"];

        $a = $this->getData($this->ask_mysqli->selectSum("usertranscation", "netamt") . $this->ask_mysqli->whereBetweenDates('enterydate', $request["fdate"], $request["tdate"]) . " AND userid='{$row["userid"]}'", "sum(netamt)");
        $a == null ? $array["a"] = 0 : $array["a"] = $a; // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
        $_a = $this->getData($this->ask_mysqli->selectSum("usertranscation", "netamt") . $this->ask_mysqli->whereBetweenDates('enterydate', $request["fdate"], $request["tdate"]) . " AND userid='{$row["userid"]}' AND active='0'", "sum(netamt)");
        $_a == null ? $array["_a"] = 0 : $array["_a"] = $_a; // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
//        echo $this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["fdate"], $request["tdate"]) . " AND userid='{$row["userid"]}' AND active='1'";
        $f = $this->getData($this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["fdate"], $request["tdate"]) . " AND userid='{$row["userid"]}' AND active='1'", "sum(discountamt)"); // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
        $f == null ? $array["f"] = 0 : $array["f"] = $f;
        $b = $this->getData($this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["fdate"], $request["tdate"]) . " AND userid='{$row["userid"]}' AND active='0'", "sum(discountamt)"); // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
        $b == null ? $array["b"] = 0 : $array["b"] = $_a;
        $c = $array["a"] - $array["_a"];
        $c == null ? $array["c"] = 0 : $array["c"] = $c;
        //echo $this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereBetweenDates('ClaimTime', $request["fdate"]." 00:00:00", $request["tdate"]." 23:59:59") . " AND own='{$row["userid"]}'";
        $d = $this->getData($this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereBetweenDates('ClaimTime', $request["fdate"] . " 00:00:00", $request["tdate"] . " 23:59:59") . " AND own='{$row["userid"]}'", "sum(winamt)");
        $d == null ? $array["d"] = 0 : $array["d"] = $d;
        $e = $array["c"] - $array["d"];
        $e == null ? $array["e"] = 0 : $array["e"] = $e;
        $array["g"] = "0";
        $h = $array["c"] - $array["d"] - $array["f"];
        $h == null ? $array["h"] = 0 : $array["h"] = $h;
        array_push($farray, $array);
        $fnl = array(
            "totalNetPoint" => $array["a"], //number_format($ntotal, 2),
            "totalPoint" => $array["f"], //number_format($ftotal, 2),
            "cancelPoint" => $array["b"], // number_format($cp, 2),
            "winPoint" => $array["d"], // number_format($wamt, 2),
            "netPayble" => $array["h"], // number_format($fnpay, 2),
            "data" => $array
        );
        echo json_encode($fnl);
//        die;
        ///
//        $sl = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDatesID('enterydate', $_POST["fdate"], $_POST["tdate"], "userid", $_POST["userid"]) . "AND active='1'";
//        $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);
//        $i = 1;
//        $data = array();
//        while ($row = $result->fetch_assoc()) {
//            //$tc = $this->getData($this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("utrno" => $row["trno"]), "AND"), "winamt");
//            $sl = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("utrno" => $row["trno"], "isStatus" => 1), "AND");
//
//            $result2 = $this->adminDB[$_SESSION["db_1"]]->query($sl);
//            $game = "";
//            $drid = "";
//            $tc = 0;
//            $cp = 0;
//            while ($row2 = $result2->fetch_assoc()) {
//
//                $game = $row2["utrno"];
//                $drid = $row2["gametimeid"];
//                $tc = $tc + $row2["winamt"];
//            }
//
//            $nc = $row["netamt"] - $row["discountamt"] - $tc;
//            $temp = array(
//                "id" => (string) $i,
//                "userid" => (string) $row["userid"],
//                "game" => company,
//                "ticket" => (string) $game,
//                "drawid" => (string) $drid,
//                "netPoint" => (string) $row["netamt"], //selll
//                "discountPer" => (string) $row["discount"], //per
//                "discountPoint" => (string) $row["discountamt"], //profit
//                "finalPoint" => (string) $row["total"], //after profit move
//                "cancelPoint" => (string) $cp,
//                "isStatus" => (string) $row["active"],
//                "winAmount" => (string) $tc,
//                "netPayble" => (string) $nc,
//                "date" => (string) $row["on_create"]
//            );
//            array_push($data, $temp);
//            $ntotal = $ntotal + (float) $row["netamt"];
//            $ftotal = $ftotal + (float) $row["discountamt"];
//            $fnpay = $fnpay + (float) $nc;
//            $wamt = $wamt + (float) $tc;
//
//            $i++;
//        }
//        $sl = $this->ask_mysqli->selectSum("usertranscation", "netamt") . $this->ask_mysqli->whereBetweenDatesID('enterydate', $_POST["fdate"], $_POST["tdate"], "userid", $_POST["userid"]) . "AND active='0'";
//        $cp = $this->getData($sl, "sum(netamt)");
//
//        $sl = $this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereBetweenDatesID('ClaimTime', $_POST["fdate"] . " 00:00:00", $_POST["tdate"] . " 23:59:59", "own", $_POST["userid"]) . "AND claimstatus='1'";
//        $wamt = $this->getData($sl, "sum(winamt)");
//        $fnpay = $ntotal - $ftotal - $wamt;
//        $fnl = array(
//            "totalNetPoint" => $ntotal, //number_format($ntotal, 2),
//            "totalPoint" => $ftotal, //number_format($ftotal, 2),
//            "cancelPoint" => $cp, // number_format($cp, 2),
//            "winPoint" => $wamt, // number_format($wamt, 2),
//            "netPayble" => $fnpay, // number_format($fnpay, 2),
//            "data" => $data
//        );
//        echo json_encode($fnl);
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
