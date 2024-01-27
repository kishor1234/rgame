<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once controller;

class cleanEntry extends CAaskController
{

    //put your code here
 

    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        parent::create();

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
        try {

            $postdata = file_get_contents("php://input");
            $_POST = json_decode($postdata, true);

            $final = array();
            //$_POST['id'] = 'ask5ed87e5c59b6d';
            //$_POST['userid'] = '20200431';
            // $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $_POST["id"], "trno" => $_POST["id"]), "OR") . " AND own='{$_POST["userid"]}'";
            $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("enterydate" => $_POST["date"], "isStatus" => 1), "AND"); // . " AND own='{$_POST["userid"]}'";
            $resultTest = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $winpt = $this->getData("select * from admin where id='1'", "winrate");
            $fdata=array();
            while ($row = $resultTest->fetch_assoc()) {
                $sql = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game"=>$row["game"],"enterydate" => $_POST["date"], "isStatus" => 1), "AND"); // . " AND own='{$_POST["userid"]}'";
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $new=array();
                while($rowData=$result->fetch_assoc()){
                    
                    $t=json_decode($rowData["point"],true);
                    $new=array_merge($new,$t);
                }
                
                $nw=json_encode($new);
                $s=$this->ask_mysqli->update(array("point"=>$nw),"entry"). $this->ask_mysqli->whereSingle(array("id"=>$row["id"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql);
                array_push($fdata,$nw);
            }
            // array_push($final, array("recip" => $this->getRecip($final)));
            echo json_encode($fdata);
        } catch (Exception $ex) {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
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
