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

class dataClenupScript extends CAaskController
{

    //put your code here
    //entry
    //subentry
    //winer
    //transaction
    // usertransaction
    // claim
    //
    public $data = array();

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
        //WHERE DATE(cdate) < "2022-05-26"
        $_POST = json_decode(file_get_contents("php://input"), true); //get request parame form url request post or header

        $this->adminDB[$_SESSION["db_1"]]->autocommit(FALSE); //it stop for db auto commit untill and unless all query execute success

        //The below if condition checking cdate is set or not
        try {
            if (isset($_POST["cdate"])) {
                $date = $_POST["cdate"];
                $queryArray = array(
                    "DELETE FROM `claim`  WHERE DATE(cdate) < '{$date}' ",
                    "DELETE FROM `entry`  WHERE DATE(enterydate) < '{$date}' ",
                    "DELETE FROM `subentry`  WHERE DATE(enterydate) < '{$date}'",
                    "DELETE FROM `transaction`  WHERE DATE(create_on) < '{$date} 00:00:00'",
                    "DELETE FROM `usertranscation`  WHERE DATE(enterydate) < '{$date}'",
                    "DELETE FROM `winnumber`  WHERE DATE(gdate) < '{$date}'"
                );
                $error = array();
                foreach ($queryArray as $sql) {
                    $this->executeQueryWithParame($sql,$error);
                }
                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("status" => "Success", "data" => array(), "error" => $error));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    echo json_encode(array("status" => "Failed", "data" => array(), "error" => $error));
                }
            }
        } catch (Exception $ex) {
            echo "Exception";
            echo $ex->getMessage();
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("status" => "Failed", "data" => array(), "error" => $error));
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
    function executeQueryWithParame($sql, &$error)
    {
        return $this->executeQuery($_SESSION["db_1"], $sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;;
    }
}
