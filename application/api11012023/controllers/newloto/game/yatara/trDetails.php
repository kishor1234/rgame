<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trDetails
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class trDetails extends CAaskController {

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

        switch ($request["action"]) {
            case "drawWiseTrDeails" :
                $this->drawWiseTrDeails($request["userid"]);
                break;
            case "singledrawWiseTrDeails" :
                $this->singledrawWiseTrDeails($request["drawid"], $request["userid"]);
                break;
            case "TrDeailsbytsn" :
                $this->TrDeailsbytsn($request["tsn"], $request["userid"]);
                break;
            case "cancellist" :
                $this->cancellist($request["userid"]);
                break;
            case "cancelbet":
                $this->cancelbet($request["tsn"], $request["userid"], $request["ip"]);
                break;
            case "printlist":
                $this->printlist($request["userid"]);
                break;
            case "claimlist":
                $this->claimlist($request["userid"]);
                break;
            default :
                //$this->TrDeailsbytsn(9536465, 20210718);
                //$this->cancellist(20210718);
                break;
        }

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

    function getPointAgentCommission($data, $error) {
        try {

            $sql = $this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $data["point"]), "agent") . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
            $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance+" . $data["point"]), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
            $sql = $this->ask_mysqli->insert("transaction", array("userid" => $data["userid"], "debit" => $data["point"], "remark" => "Admin get Back Commission  From Agent, because of user cancel ticket", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"])), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
            $sql = $this->ask_mysqli->insert("transaction", array("userid" => 1, "credit" => $data["point"], "remark" => "Self Debit form Agent to Admin transfer balance", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1)), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
        } catch (Exception $ex) {
            
        }
        return $error;
    }

    function cancelbet($tsn, $userid, $ip) {
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);

        $sql = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("ip" => $ip, "enterydate" => date("Y-m-d"), "active" => 1), "AND");

        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $error = array();
        while ($row = $result->fetch_assoc()) {
            $tsn = $row["trno"];
            $balance = $row["total"];
            //check user limit
            if ($this->checkResult($row)) {
                array_push($error, "After releaseing result you cannot delete ticket");
                //echo json_encode(array("status" => "0", "message" => "Invalid Ticket", "error" => $error));
                break;
            } else {
                $ruserid = $row["userid"];
//                echo ($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])));
                $limitQuery = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])));

                if ($limitRow = $limitQuery->fetch_assoc()) {
                    if ($limitRow["climit"] > 0) {
                        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateINC(array("balance" => $balance), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($error, "Update Balance Error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
//after balance update
                        $sql = $this->ask_mysqli->insert("transaction", array("userid" => $row["userid"], "credit" => $balance, "remark" => "Cancel Tickt by user, ticket at PT {$balance}", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])), "balance")));
                        $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;

                        //1=active 0=deactive
                        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("active" => 0), "usertranscation") . $this->ask_mysqli->whereSingle(array("trno" => $tsn))) != 1 ? array_push($error, "Transaction Error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                        //transaction deactive complete
//        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateDNC(array("climit" => 1), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($error, "Limit decress Error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                        //agent get back commission
                        if ($row["discountamtagent"] > 0) {
                            $error = $this->getPointAgentCommission(array("point" => $row["discountamtagent"], "userid" => $row["agent_id"]), $error);
                        }
//end

                        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("utrno" => $tsn, "own" => $userid), "AND");
                        $resultInner = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                        $i = 1;
                        $error = array();

                        $resultArray = array();
                        while ($rowInner = $resultInner->fetch_assoc()) {

                            $loadQuery = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("trno" => $rowInner["trno"]), "AND");
                            $result2 = $this->adminDB[$_SESSION["db_1"]]->query($loadQuery);
                            while ($row2 = $result2->fetch_assoc()) {
                                $point = json_decode($row2["point"], true);
                                foreach ($point as $key => $val) {
                                    foreach ($val as $index => $value) {
                                        $inValue = ($index % 100);
                                        $inTable = $index - $inValue;

                                        $qq = $this->ask_mysqli->updateDNC(array("`" . $row2["gametimeid"] . "`" => $value), "`{$inTable}`") . $this->ask_mysqli->whereSingle(array("number" => sprintf("%02d", $inValue)));

                                        $this->adminDB[$_SESSION["db_1"]]->query($qq) != 1 ? array_push($error, "Unable to Reove load " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                                    }
                                }
//                $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("subentry") . $this->ask_mysqli->whereSingle(array("id" => $row2["id"]))) != 1 ? array_push($error, "Unable to delte") : true;
                            }
//end
//            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("entry") . $this->ask_mysqli->whereSingle(array("id" => $row["id"]))) != 1 ? array_push($error, "Unable to delte") : true;
                            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("botStatus" => 1, "winstatus" => 0, "claimstatus" => 1, "isStatus" => 0), "entry") . $this->ask_mysqli->whereSingle(array("id" => $rowInner["id"]))) != 1 ? array_push($error, "Unable to delte") : true;
                            //$this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("usertranscation") . $this->ask_mysqli->whereSingle(array("invoiceno" => $_POST["game"]))) != 1 ? array_push($error, "Unable to delte") : true;
                        }
//                        if (empty($error)) {
//                            $sl = $this->ask_mysqli->updateDNC(array("climit" => 1), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $ruserid));
//                            $this->adminDB[$_SESSION["db_1"]]->query($sl);
////                            echo json_encode(array("status" => "1", "message" => "Ticket Successfully", "Err" => $error));
////                            $this->adminDB[$_SESSION["db_1"]]->commit();
//                        } else {
//                            //echo $this->printMessage("Invalid Entry ", "danger");
////                            $this->adminDB[$_SESSION["db_1"]]->rollback();
////                            echo json_encode(array("status" => "0", "message" => "Ticket cannot be canceled, Please contact to Admin", "error" => $error));
//                        }
                    } else {
                        echo json_encode(array("status" => "0", "message" => "Cancel limit is over now ", "error" => $error));
                    }
                } else {
                    echo json_encode(array("status" => "0", "message" => "[ET] Ticket cannot be canceled, Please contact to Admin", "error" => $error));
                }
            }
        }
        if (empty($error)) {
            $sl = $this->ask_mysqli->updateDNC(array("climit" => 1), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $ruserid));
            $this->adminDB[$_SESSION["db_1"]]->query($sl);
            echo json_encode(array("status" => "1", "message" => "Ticket Successfully", "Err" => $error));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            //echo $this->printMessage("Invalid Entry ", "danger");
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("status" => "0", "message" => "Ticket cannot be canceled, Please contact to Admin", "error" => $error));
        }
//        else {
//            echo json_encode(array("status" => "0", "message" => "Invalid Ticket", "error" => $error));
//        }
    }

    function checkResult($r) {
        $sql = $this->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $r["drawid"]));
        $res = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $ro = $res->fetch_assoc();
        if ($ro["status"] === "1") {
            return true;
        } else {
            return false;
        }
    }

    function claimlist($userid) {
        $final = array();
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("isStatus" => 1, "own" => $userid, "enterydate" => date("Y-m-d")), "AND") . $this->ask_mysqli->orderBy("DESC", "utrno");
        $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($rows = $results->fetch_assoc()) {
            array_push($final, array("barcode" => $rows["game"], "tsn" => $rows["utrno"], "btime" => date("Y-m-d H:i:s A", strtotime($rows["isDate"])), "dtime" => date("Y-m-d H:i:s A", strtotime($rows["enterydate"] . " " . $rows["gameendtime"])), "point" => $rows["amount"], "wamt" => $rows["winamt"], "cstatus" => $rows["claimstatus"]));
        }
        if (!empty($final)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $final));
        } else {
            echo json_encode(array("status" => "0", "message" => "Draw Over"));
        }
    }

    function printlist($userid) {
        $final = array();
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("isStatus" => 1, "own" => $userid, "enterydate" => date("Y-m-d")), "AND") . $this->ask_mysqli->orderBy("DESC", "utrno");
        $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($rows = $results->fetch_assoc()) {
            array_push($final, array("tsn" => $rows["utrno"], "btime" => date("Y-m-d H:i:s A", strtotime($rows["isDate"])), "dtime" => date("Y-m-d H:i:s A", strtotime($rows["enterydate"] . " " . $rows["gameendtime"])), "point" => $rows["amount"]));
        }
        if (!empty($final)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $final));
        } else {
            echo json_encode(array("status" => "0", "message" => "Draw Over"));
        }
    }

    function cancellist($userid) {
        $sql = $this->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->ask_mysqli->whereSinglegreaterthanequal(array("etime" => date("H:i:s"))) . $this->ask_mysqli->limitWithOutOffset(1);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $final = array();
        while ($row = $result->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("isStatus" => 1, "own" => $userid, "gametimeid" => $row["id"], "enterydate" => date("Y-m-d")), "AND") . $this->ask_mysqli->orderBy("DESC", "utrno");
            $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($rows = $results->fetch_assoc()) {
                array_push($final, array("tsn" => $rows["utrno"], "ip" => $rows["ip"], "btime" => date("Y-m-d H:i:s A", strtotime($rows["isDate"])), "dtime" => date("Y-m-d H:i:s A", strtotime($rows["enterydate"] . " " . $rows["gameendtime"])), "point" => $rows["amount"]));
            }
        }
        if (!empty($final)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $final));
        } else {
            echo json_encode(array("status" => "0", "message" => "Draw Over"));
        }
    }

    //tsn//schme name//num//qty//amt
    function TrDeailsbytsn($tsn, $userid) {
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("own" => $userid, "utrno" => $tsn), "AND") . $this->ask_mysqli->orderBy("DESC", "id");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $final = array();
        if ($row = $result->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("own" => $userid, "trno" => $row["trno"]), "AND"); //. $this->ask_mysqli->orderBy("DESC", "id");
            $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($rows = $results->fetch_assoc()) {
                $point = json_decode($rows["point"], true);
                foreach ($point as $i => $v) {
                    foreach ($v as $index => $value) {

                        $scm = (int) ($index / 100);
                        $fl = (float) ($index / 100);
                        $f2 = $fl - $scm;
                        $num = (int) (round($f2, 2) * 100);
                        array_push($final, array("game" => $row["game"], "tsn" => $row["utrno"], "index" => $index, "schme" => $scm, "num" => str_pad($num . "", 2, "0", STR_PAD_LEFT), "qty" => $value, "amt" => $value * 2));
                    }
                }
            }
        }
        if (!empty($final)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $final));
        } else {
            echo json_encode(array("status" => "0", "message" => "Draw Over"));
        }
    }

    //TSN//BetTime//Draw Time// Point //Canel // Winnin//winpt
    function singledrawWiseTrDeails($drawid, $userid) {
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("own" => $userid, "gametimeid" => $drawid, "enterydate" => date("Y-m-d")), "AND") . $this->ask_mysqli->orderBy("DESC", "id");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $status = array("Y", "N");
        $win = array("L", "W");
        $final = array();
        while ($row = $result->fetch_assoc()) {
            array_push($final, array("tsn" => $row["utrno"], "btime" => date("Y-m-d h:i:s A", strtotime($row["isDate"])), "dtime" => date("Y-m-d h:i A", strtotime($row["enterydate"] . " " . $row["gameendtime"])), "point" => $row["amount"], "cancel" => $status[$row["isStatus"]], "win" => $win[$row["winstatus"]], "winpt" => $row["winamt"]));
        }
        if (!empty($final)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $final));
        } else {
            echo json_encode(array("status" => "0", "message" => "Draw Over"));
        }
    }

    function drawWiseTrDeails($userid) {
        $currentDraw = $this->module->getPreviousDrawDetails();
        $final = array();
        foreach ($currentDraw as $key => $value) {

            $sql = $this->ask_mysqli->selectSumIFNULL('entry', 'amount') . $this->ask_mysqli->where(array("own" => $userid, "gametimeid" => $value["id"], "enterydate" => date("Y-m-d"), "isStatus" => 1), "AND");
            $betPoint = $this->getData($sql, "sum(amount)");
            $sql = $this->ask_mysqli->selectSumIFNULL('entry', 'amount') . $this->ask_mysqli->where(array("own" => $userid, "gametimeid" => $value["id"], "enterydate" => date("Y-m-d"), "isStatus" => 0), "AND");
            $cancelPoint = $this->getData($sql, "sum(amount)");
            $sql = $this->ask_mysqli->selectSumIFNULL('entry', 'winamt') . $this->ask_mysqli->where(array("own" => $userid, "gametimeid" => $value["id"], "enterydate" => date("Y-m-d"), "isStatus" => 1, "winstatus" => 1, "claimstatus" => 1), "AND");
            $winPoint = $this->getData($sql, "sum(winamt)");
            if ($betPoint != 0.00 || $cancelPoint != 0.00) {
                array_push($final, array("id" => $value["id"], "stime" => date("h:i A", strtotime($value["stime"])), "etime" => date("h:i A", strtotime($value["etime"])), "bet" => $betPoint, "cancel" => $cancelPoint, "win" => $winPoint));
            }
        }
        if (!empty($final)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $final));
        } else {
            echo json_encode(array("status" => "0", "message" => "Draw Over"));
        }
    }

}
