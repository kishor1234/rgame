<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of posTicket
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class posTicket extends CAaskController {

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
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("utrno" => $_POST["utrno"]));
        $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($rows = $results->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("game" => $rows["game"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $content = "";
            $barcode = $rows["game"];
            $ticket = array();
            while ($row = $result->fetch_assoc()) {
                ob_start();
                $this->isLoadView(array("header" => "webheader", "main" => "posticketPrint", "footer" => "webfooter", "error" => "page_404"), false, array("row" => $row));
                $content = ob_get_contents();
                ob_end_clean();
                array_push($ticket, array("barcode" => $barcode, "ticket" => $content));
                $content = "";
                //echo $content;
            }
            echo json_encode(array("status" => "1", "message" => "success", "ticket" => $ticket));
        } else {
            echo json_encode(array("status" => "0", "message" => "invalid trid or barcode"));
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

}
