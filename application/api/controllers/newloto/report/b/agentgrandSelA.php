
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

class agentgrandSelA extends CAaskController {

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
            $sql = $this->ask_mysqli->select("agent", $_SESSION["db_1"]);
            if(isset($request["action"])){
                $sql.=$this->ask_mysqli->whereSingle(array("createBy"=>$request["userid"]));
            }
            $agentResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($agent = $agentResult->fetch_assoc()) {

                $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("agent_id" => $agent["userid"]));
                $userResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                while ($user = $userResult->fetch_assoc()) {
                    $sl = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND active='1' AND userid='{$user['userid']}'";
                    $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);
                    $ntotal2 = 0;
                    $ftotal2 = 0;
                    $fnpay2 = 0;
                    $wamt2 = 0;
                    $sql = "";
                    while ($row = $result->fetch_assoc()) {
                        $tc = $this->getData($this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"])), "sum(winamt)");
                        $nc = $row["netamt"] - $row["discountamt"] - $tc;
                        $ntotal += (float) $ntotal2 + (float) $row["netamt"];
                        $ftotal += (float) $ftotal2 + (float) $row["total"];
                        $fnpay += (float) $fnpay2 + (float) $nc;
                        $wamt += (float) $wamt2 + (float) $tc;
                    }
                }
            }
            echo json_encode(array("cdate" => "Form " . $request["dateform"] . " To " . $request["dateto"], "ftotal" => number_format($ftotal, 2), "gs" => number_format($ntotal, 2), "wa" => number_format($wamt, 2), "sql" => $sql, "np" => number_format($fnpay, 2)));
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