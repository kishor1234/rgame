<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of report
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class report extends CAaskController {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (!isset($_SESSION["userid"])) {
            redirect(HOSTURL . "?r=logout");
        }
        return;
    }

    public function initialize() {
        parent::initialize();
        //Report From Sunday, July 4, 2021 To Sunday, July 4, 2021
        $sdate = date("Y-m-d");
        $edate = date("Y-m-d");
        if (!empty($_POST["fromdate"]) && !empty($_POST["todate"])) {
            $sdate = $_POST["fromdate"];
            $edate = $_POST["todate"];
        }
        $line = "Report From " . date('l', strtotime($sdate)) . " " . date("F, d, Y", strtotime($sdate)) . " TO " . date('l', strtotime($edate)) . " " . date("F, d, Y", strtotime($edate));
        $line2 = "From " . $sdate. " to " . $edate;
        
        $response = $this->postJsonRespon(api_url . "/?r=netreport", array("fdate" => $sdate, "tdate" => $edate, "userid" => $_SESSION["userid"]));
        $this->isLoadView(array("header" => null, "main" => "report", "footer" => null, "error" => "page_404"), false, array("sdate" => $sdate, "edate" => $edate, "line" => $line, "line2" => $line2, "response" => $response));

        return;
    }

    public function execute() {
        //parent::execute();
        return;
    }

    public function finalize() {
        //parent::finalize();
        return;
    }

    public function reader() {
        //parent::reader();
        return;
    }

    public function distory() {
        //parent::distory();
        return;
    }

}
