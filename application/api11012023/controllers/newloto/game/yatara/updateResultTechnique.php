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

class updateResultTechnique extends CAaskController {

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
//        echo $postdata = file_get_contents("php://input");
//        $_POST = json_decode($postdata, true);
        $s = $this->ask_mysqli->update(array("resultTech" => $_POST["resultTech"]),"admin") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
        if ($this->adminDB[$_SESSION["db_1"]]->query($s)) {
            echo json_encode(array("toast" => array("success", "Game", " ResultTechnique Update Successfully"), "status" => 1,"resultTech"=>$_POST["resultTech"] ,"message" => "Game ResultTechnique Update Successfully.."));
        } else {
            echo json_encode(array("toast" => array("danger", "Game", " Update Faied please try again..."), "status" => 0, "message" => "Game ResultTechnique Update Failed..{$s}",$_POST));
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
