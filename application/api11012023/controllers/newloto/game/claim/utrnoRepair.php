<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once controller;

class utrnoRepair extends CAaskController
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
            //$sql = "SELECT (9+id) as utrno,id FROM `entry` WHERE enterydate='2022-07-24'"; // = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("enterydate" => $_POST["date"], "isStatus" => 1), "AND"); // . " AND own='{$_POST["userid"]}'";
            
           // $sql="SELECT table_1.id,table_2.trno as utrno FROM (SELECT @rank:=@rank+1 AS eid, `entry`.`id` FROM `entry` WHERE `entry`.`enterydate`='2022-07-24' ORDER BY `id` ASC) table_1 INNER JOIN (SELECT @ranks:=@ranks+1 AS tid, `usertranscation`.`trno` FROM `usertranscation` WHERE `usertranscation`.`enterydate`='2022-07-24' ORDER BY `id` ASC) AS table_2 ON table_1.eid=table_2.tid";
          // $sql="SELECT game, ct FROM (SELECT game, COUNT(game) as ct FROM `entry` WHERE enterydate='2022-07-24' GROUP BY game) as ctt WHERE ct>1;";
          $sql="SELECT * FROM `transaction` WHERE create_on like '%2022-07-24%' and remark LIKE '%Winner Point\'s transfer%'";  
          $resultTest = $this->adminDB[$_SESSION["db_1"]]->query($sql);

            $fdata = array();
            while ($row = $resultTest->fetch_assoc()) {
                $s=explode('#',$row["remark"]);
                $sql="UPDATE `entry` SET winamt='{$row['credit']}' WHERE game='{$s[1]}'";
                //$sql ="UPDATE entry SET utrno={$row['utrno']} where id='{$row['id']}'";//= $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $row["game"], "enterydate" => $_POST["date"], "isStatus" => 1), "AND"); // . " AND own='{$_POST["userid"]}'";
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
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
