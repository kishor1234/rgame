<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CTicketReport
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
class admintransaction extends CAaskController {

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

        $request = $_REQUEST; //json_decode($request3, true);
	
        switch ($request["action"]) {
            case "searchTicket":
                //$_REQUEST=$request;
                $this->searchTicket($request);
                break;
            case "agentTransaction":
                $this->agentTransaction($request);
                break;
            default :
                echo json_encode(array("status" => "0", "message" => "Invalid Request", "request" => $request));
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

//custome code start below

    function agentTransaction($request) {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'userid',
                2 => 'debit',
                3 => 'credit',
                4 => 'remark',
                5 => 'balance',
                6 => 'ip',
                7 => 'create_on',
                8 => 'botStatus'
            );
            $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("agent_id" => $request["userid"]));
            $resultUser = $this->adminDB[$_SESSION["db_1"]]->query($sql);

            $sql = $this->ask_mysqli->select("transaction", $_SESSION["db_1"]); // . $this->ask_mysqli->whereSingle(array("userid" => 1));
            // $sql .= $this->ask_mysqli->whereBetweenDatesID("create_on", $request["dateform"] . " 00:00:00", $request["dateto"] . " 23:59:59", "userid", $request["own"]);
            $sql .= " WHERE ";
            $n = $resultUser->num_rows;
            ;
            $i = 0;
            while ($r = $resultUser->fetch_assoc()) {
                if ($i === 0) {
                    $sql .= " userid='{$r["userid"]}' ";
                } else {
                    $sql .= " OR userid='{$r["userid"]}' ";
                }
                $i++;
            }
            $sql .= " OR userid='{$request["userid"]}' ";
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql .= " OR id Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  userid Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  remark Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            //$request = $_REQUEST;
            $sql .= $this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            //echo $sql;
            $totalData = $query->num_rows;
            $i = 0;
            while ($row = $query->fetch_assoc()) {
                $data[] = $this->setData($row);
                $i++;
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFilter),
                "data" => $data,
            );
            //print_r($json_data);die;
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function searchTicket($request) {
//        try {
//            //$sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDatesID("enterydate", $request["dateform"], $request["dateto"], "own", $request["own"]);
//        } catch (Exception $ex) {
//            
//        }
        try {
            //$request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'userid',
                2 => 'debit',
                3 => 'credit',
                4 => 'remark',
                5 => 'balance',
                6 => 'ip',
                7 => 'create_on',
                8 => 'botStatus'
            );
            $sql = $this->ask_mysqli->select("transaction", $_SESSION["db_1"]); // . $this->ask_mysqli->whereSingle(array("userid" => 1));
            // $sql .= $this->ask_mysqli->whereBetweenDatesID("create_on", $request["dateform"] . " 00:00:00", $request["dateto"] . " 23:59:59", "userid", $request["own"]);
            $query = $this->executeQuery($_SESSION["db_1"], "SELECT COUNT(id) AS count FROM rajshri.transaction");
            $row = $query->fetch_assoc();
            $totalData = $row["count"];
            $totalFilter = $totalData;
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql .= " Where (id Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  userid Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  remark Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $request = $_REQUEST;
            $sql .= $this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            //echo $sql;
            $totalData = $query->num_rows;
            $i = 0;
            while ($row = $query->fetch_assoc()) {
                $data[] = $this->setData($row);
                $i++;
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFilter),
                "data" => $data,
            );
            //print_r($json_data);die;
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function setData($row) {
        $subdata = array();
        $subdata[] = $row['id'];
        $subdata[] = $row['userid'];
        if (!empty($row["credit"])) {
            $subdata[] = "<span class='text-success'>+ {$row['credit']}</span>";
        } else {
            $subdata[] = "<span class='text-danger'>- {$row['debit']}</span>";
        }
        $subdata[] = "<span class='text-default'>{$row['balance']}</span>";
        $subdata[] = $row['create_on'];
        $subdata[] = $row['remark'];
        return $subdata;
    }

}