
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cashSummery
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class agentcashSummery extends CAaskController {

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
            $request = json_decode($postdata, true);
            $ntotal = 0;
            $ftotal = 0;
            $fnpay = 0;
            $wamt = 0;
            $commisionAMT = 0;
            $pa = 0;
            $sql = $this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $request["own"]));
            $agentResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($agent = $agentResult->fetch_assoc()) {

                $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("agent_id" => $agent["userid"]));
                $userResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                while ($user = $userResult->fetch_assoc()) {
                    $sl = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDatesID('on_create', $request["dateform"], $request["dateto"], "userid", $user["userid"]) . " AND active='1'";
                    $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);
                    $ntotal2 = 0;
                    $ftotal2 = 0;
                    $fnpay2 = 0;
                    $wamt2 = 0;
                    $commisionAMT2 = 0;
                    
                    while ($row = $result->fetch_assoc()) {
                        $tc = $this->getData($this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"])), "sum(winamt)");
                        $nc = $row["netamt"] - $row["discountamt"] - $tc;
                        $commisionAMT += (float) $commisionAMT2 + (float) $row["discountamt"];
                        $pa += $row["total"];
                        $ntotal += (float) $ntotal2 + (float) $row["netamt"];
                        $ftotal += (float) $ftotal2 + (float) $row["total"];
                        $fnpay += (float) $fnpay2 + (float) $nc;
                        $wamt += (float) $wamt2 + (float) $tc;
                    }
                }
            }

            echo json_encode(array("userid" => $request["own"], "cdate" => "Form " . $request["dateform"] . " To " . $request["dateto"], "sale" => number_format($ntotal, 2), "ta" => number_format($ntotal, 2), "pa" => number_format($pa, 2), "claim" => number_format($wamt, 2), "np" => number_format($fnpay, 2), "cm" => number_format($commisionAMT, 2)));
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
