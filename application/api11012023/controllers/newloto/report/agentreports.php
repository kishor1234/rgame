
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grandSel
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class agentreports extends CAaskController {

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
        try {
            $postdata = file_get_contents("php://input");
            $request = $_POST; //json_decode($postdata, true);
            $sl = $this->ask_mysqli->select("agent", $_SESSION["db_1"]); // . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND active='1'";

            if (isset($request["m"])) {
                switch ($request["m"]) {
                    case "admin":
                        $sl .= $this->ask_mysqli->whereSingle(array("createBy" => $request["id"]));
                        break;
                    case "main":
                        $sl .= " WHERE createBy!='1'";
                        break;
                    default;
                        break;
                }
            } else {
                
            }

            //echo json_encode(array("s"=>$sl));die;
            $resultAgent = $this->adminDB[$_SESSION["db_1"]]->query($sl);
            $farrays = array();
            $ab = array("aid" => "", "uid" => "", "a" => 0, "_a" => 0, "f" => 0, "b" => 0, "c" => 0, "d" => 0, "e" => 0, "g" => 0, "h" => 0);

            while ($rowAgent = $resultAgent->fetch_assoc()) {
                $sl = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("agent_id" => $rowAgent["userid"])); //. $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND active='1'";
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);

                $farray = array();
                while ($row = $result->fetch_assoc()) {
                    $array = array();
                    $array["aid"] = $row["agent_id"];
                    $array["uid"] = $row["userid"];
                    $a = $this->getData($this->ask_mysqli->selectSum("usertranscation", "netamt") . $this->ask_mysqli->whereBetweenDates('enterydate', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}'", "sum(netamt)");
                    $a == null ? $array["a"] = 0 : $array["a"] = $a; // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
                    $_a = $this->getData($this->ask_mysqli->selectSum("usertranscation", "netamt") . $this->ask_mysqli->whereBetweenDates('enterydate', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}' AND active='0'", "sum(netamt)");
                    $_a == null ? $array["_a"] = 0 : $array["_a"] = $_a; // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));

                    $f = $this->getData($this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}' AND active='1'", "sum(discountamt)"); // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
                    $f == null ? $array["f"] = 0 : $array["f"] = $f;
                    $b = $this->getData($this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}' AND active='0'", "sum(discountamt)"); // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
                    $b == null ? $array["b"] = 0 : $array["b"] = $_a;
                    $c = $array["a"] - $array["_a"];
                    $c == null ? $array["c"] = 0 : $array["c"] = $c;
                    $d = $this->getData($this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereBetweenDates('isDate', $request["dateform"], $request["dateto"]) . " AND own='{$row["userid"]}'", "sum(winamt)");
                    $d == null ? $array["d"] = 0 : $array["d"] = $d;
                    $e = $array["c"] - $array["d"];
                    $e == null ? $array["e"] = 0 : $array["e"] = $e;
                    $array["g"] = "0";
                    $h = $array["c"] - $array["d"] - $array["f"];
                    $h == null ? $array["h"] = 0 : $array["h"] = $h;

                    array_push($farray, $array);
                }
                $sumofa = 0;
                $sumofb = 0;
                $sumofc = 0;
                $sumofd = 0;
                $sumofe = 0;
                $sumoff = 0;
                $sumofg = 0;
                $sumofh = 0;
                $aid = "";
                if (!empty($farray)) {
                    foreach ($farray as $in => $val) {


                        $i = $key + 1;
                        $aid = $val["aid"];
                        $sumofa += (float) $val["a"];
                        $sumofb += (float) $val["b"];
                        $sumofc += (float) $val["c"];
                        $sumofd += (float) $val["d"];
                        $sumofe += (float) $val["e"];
                        $sumoff += (float) $val["f"];
                        $sumofh += (float) $val["h"];
                    }

                    $temp = array(
                        "uid" => $aid,
                        "a" => $sumofa,
                        "b" => $sumofb,
                        "c" => $sumofc,
                        "d" => $sumofd,
                        "e" => $sumofe,
                        "f" => $sumoff,
                        "h" => $sumofh
                    );

                    array_push($farrays, $temp);
                }
            }
            echo json_encode($farrays);
//            foreach ($farrays as $key => $val) {
//                foreach ($val as $in => $arr) {
//                    $preview="";
//                    foreach ($arr as $ind => $arry) {
//                        if($preview===$arr["aid"]){
//                            
//                        }else{
//                           $preview=$arr["aid"];
//                           
//                        }
//                        $$arr["aid"] = array(
//                            "a" => $a
//                        );
//                    }
//                }
//            }
        } catch (Exception $ex) {
            
        }
        return;
    }

    public function execute() {
        parent::execute();

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
