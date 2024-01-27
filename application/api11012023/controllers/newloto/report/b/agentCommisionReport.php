
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

class agentCommisionReport extends CAaskController {

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
            $sql = "SELECT `entry`.`utrno`,`entry`.`game`,`enduser`.`userid`,`entry`.`amount`,COALESCE(`entry`.`amount`*`entry`.`comission`,0) AS usercmiision,`enduser`.`agent_id`,COALESCE(`entry`.`amount`*`agent`.`comission`,0)AS AgentCommision,COALESCE(`entry`.`amount`*`agent`.`comission`-`entry`.`amount`*`entry`.`comission`,0) AS AgentC FROM `entry` INNER JOIN `enduser` ON `entry`.`own`=`enduser`.`userid` INNER JOIN `agent` ON `enduser`.`agent_id`=`agent`.`userid`";
            $sql .= " WHERE DATE(`entry`.`isDate`) BETWEEN '" . $request["dateform"] . "' AND '" . $request["dateto"] . "'" . " AND `entry`.`isStatus`=1 AND `enduser`.`agent_id`='" . $request["own"] . "'";
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $sell = 0;
            $userPer = 0;
            $agentPer = 0;
            while ($row = $result->fetch_assoc()) {
                $sell += (float) $row["amount"];
                $userPer += (float) $row["usercmiision"];
                $agentPer += (float) $row["AgentC"];
            }
            echo json_encode(array("userid" => $request["own"], "cdate" => "Form " . $request["dateform"] . " To " . $request["dateto"], "sale" => number_format($sell, 2), "user" => number_format($userPer, 2), "agent" => number_format($agentPer, 2)));
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
