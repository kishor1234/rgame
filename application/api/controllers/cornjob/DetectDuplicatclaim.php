<?php

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

class DetectDuplicatclaim extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        echo "Start";
        return;
    }

    public function initialize() {
        parent::initialize();
        $user = $this->adminDB[$_SESSION["db_1"]]->query("SELECT userid FROM `enduser`" );
        while ($row = $user->fetch_assoc()) {
            print_r($row);
            $sql="SELECT own, utrno, winamt, game FROM `entry` WHERE own='{$row["userid"]}'";
            if($_REQUEST["type"]==="1"){
                $sql="SELECT own, utrno, winamt, game FROM `entry` WHERE own='{$row["userid"]}' and isStatus=0 AND winamt >0.00";
            }
           // echo $sql;die;
            $entry = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($rowEntery = $entry->fetch_assoc()) {
                
                //game
                //utrno
                //winamt
                $tracount = $this->adminDB[$_SESSION["db_1"]]->query("SELECT COUNT(utrno),enteryid,utrno FROM `claim` WHERE enteryid='{$rowEntery["own"]}' AND claimstatus='1' AND utrno='{$rowEntery["utrno"]}' GROUP BY utrno");
                while ($rowct = $tracount->fetch_assoc()) {
                    if($_REQUEST["type"]==="1"){
                        $rowct["COUNT(utrno)"]=(int)$rowct["COUNT(utrno)"]+1;
                    }
                    if ((int)$rowct["COUNT(utrno)"] > 1) {
                        
                        for ($i = 1; $i < $rowct["COUNT(utrno)"]; $i++) {
                            //echo "DELETE FROM claim WHERE utrno='{$rowEntery["utrno"]}' LIMIT 1";
                            //call get point
                            $this->getPoint(array("utrno"=>$rowEntery["utrno"],"point"=>(int)$rowEntery["winamt"],"userid"=>$rowEntery["own"],"barcode"=>$rowEntery["game"]));
                            
                            //end
                        }
                    }
                }
            }
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

    function getPoint($data) {
        try {
            
            //unset($data["action"]);
            //print_r($data);die;
            $this->adminDB[$_SESSION['db_1']]->autocommit(FALSE);
            $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            
            if (true) {
                $error = array();
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $data["point"]), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance+" . $data["point"]), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $data["userid"], "debit" => $data["point"], "remark" => "Admin get Back Balance From user {$data["userid"]} for dublicat claim Winner Point\'s transfer {$data["point"]} Invoic ID#{$data["barcode"]} ", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => 1, "credit" => $data["point"], "remark" => "Self Debit form User to Admin transfer balance {$data["userid"]} for dublicat claim Winner Point\'s transfer {$data["point"]} Invoic ID#{$data["barcode"]} ", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1)), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                //remove claim
                if($_REQUEST["type"]==="1"){
                    $this->adminDB[$_SESSION["db_1"]]->query("UPDATE `entry` SET `winamt` = '0' WHERE utrno='{$data["utrno"]}'  LIMIT 1")!= 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                }
                $this->adminDB[$_SESSION["db_1"]]->query("UPDATE `claim` SET `claimstatus` = '0' WHERE utrno='{$data["utrno"]}' AND claimstatus='1' LIMIT 1")!= 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                //end
                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("toast" => array("success", "User", "Information Update Success... "), "status" => 1, "message" => "User Information Update Success.. "));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    $json_error = json_encode($error);
                    echo json_encode(array("toast" => array("danger", "User", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "User Information Update Failed.. {$json_error}"));
                }
            } else {

                echo json_encode(array("toast" => array("danger", "User", "User Insuficent account point"), "status" => 0, "message" => "User Insuficent account point"));
            }
        } catch (Exception $ex) {
            
        }
    }

}
