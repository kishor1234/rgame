<?php

defined('BASEPATH') or exit('No direct script access allowed');

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

class CUpdaeper extends CAaskController
{

    //put your code here
    public $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        parent::create();
        if (!isset($_SESSION["id"])) {
            // redirect(HOSTURL . "?r=" . $this->encript->encdata("main"));
        }
        return;
    }

    public function initialize()
    {
        parent::initialize();

        return;
    }

    public function execute()
    {
        parent::execute();
        $sql = "";
        foreach ($_POST["ids"] as $index => $val) {
            $i = $index + 1;
            $sql = "UPDATE `gametime` SET `per`='{$_POST["per"][$index]}',`method`='{$_POST["method" .$i]}', `s0`='{$_POST["s0"][$index]}', `s1`='{$_POST["s1"][$index]}', `s2`='{$_POST["s2"][$index]}', `s3`='{$_POST["s3"][$index]}', `s4`='{$_POST["s4"][$index]}', `s5`='{$_POST["s5"][$index]}', `s6`='{$_POST["s6"][$index]}', `s7`='{$_POST["s7"][$index]}', `s8`='{$_POST["s8"][$index]}', `s9`='{$_POST["s9"][$index]}' WHERE id='{$val}'";
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
        echo json_encode(array("status" => 1, "message" => "success", "sql" => $sql));
        return;
    }

    public function finalize()
    {
        parent::finalize();
        return;
    }

    public function reader()
    {
        parent::reader();
        return;
    }

    public function distory()
    {
        parent::distory();
        return;
    }
}
