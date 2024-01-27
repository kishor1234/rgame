<?php

//use CAaskController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once controller;

class calculateResult extends CAaskController
{

    //put your code here
    public $winnerid;
    public $idLoad;
    public $idLoadNonZero;
    public $type;
    public $visState = false;
    public $l = array();
    public $per = 80;
    public $wrate = 180;
    public $min = "0";
    public $blockno = array();
    public $load = array();
    public $zeroload = array();
    public $nonzeroload = array();

    public function __construct()
    {
        parent::__construct();
        //die;
    }

    public function create()
    {
        parent::create();
        //status=0  to all draw active
        //$sql = "select * from gametime where etime>='" . date("H:i:s") . "'";
        $old = __DIR__ . "/calculateResultOld.php";
        $className = "calculateResultOld";
        $sql = "select * from gametime where id='" . $_REQUEST["id"] . "'";
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        if ($row["method"] === "0") {
            $old = __DIR__ . "/calculateResultOld.php";
            $className = "calculateResultOld";
        } else {
            $old = __DIR__ . "/newResult.php";
            $className = "newResult";
        }
        
        require_once $old;
        $controlObject = new $className;
        $controlObject->create();
        $controlObject->initialize();
        $controlObject->execute();
        $controlObject->finalize();
        $controlObject->reader();
        $controlObject->distory();
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
