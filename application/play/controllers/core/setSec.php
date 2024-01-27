<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setSec
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class setSec extends CAaskController {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (empty($_POST)) {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $data = $request;
            
        } else {
            $data = $_POST;
            
        }
        // echo json_encode(array("status" => 0,"data"=>$data["userid"]));die;
        if (!empty($data["userid"])) {
            $_SESSION["userid"] = $data["userid"];
            $_SESSION["id"] = $data["id"];
            $_SESSION["name"] = $data["name"];
            echo json_encode(array("status" => 1));
        } else {
            echo json_encode(array("status" => 0));
        }
        return;
    }

    public function initialize() {
        parent::initialize();

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
