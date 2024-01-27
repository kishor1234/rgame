<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

class CAddSubadmin extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (!isset($_SESSION["subadmin_id"])) {
            // redirect(HOSTURL . "?r=" . $this->encript->encdata("main"));
        }
        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
        switch ($_POST["action"]) {
            case "loadTable";
                $this->loadTable();
                break;
            case "addSubAdmin":
                $this->addSubAdmin();
                break;
            case "delete":
                $this->deleteSubAdmin();
                break;
            case "putPoint":
                $this->putPoint();
                break;
            case "getPoint":
                $this->getPoint();
                break;
            case "suspend":
                $this->suspend();
                break;
            case "adminBalance":
                $this->adminBalance();
                break;
            case "update":
                $this->update();
                break;
            case "loadMessageTable":
                $this->loadMessageTable();
                break;
            case "message":
                $this->message();
                break;
            case "changePassword":
                break;
            case "updateper":
                $this->updateper();
                break;
            case "allSubAdmin":
                $this->allSubAdmin();
                break;
            case "uploadGame":
                $this->upoadGame();
                break;
            case "loadGame":
                $this->loadGame();
                break;
            case "deleteGame":
                $this->deleteGame();
                break;
            case "blockno":
                $this->blockno();
                break;
            case "getBlockno":
                $this->getBlockno();
                break;
            default :
                $postdata = file_get_contents("php://input");
                $request = json_decode($postdata, true);
                print_r($request);
                //echo json_encode(array("toast" => array("danger", "Series", "Invalid Sereis selected "), "status" => 0, "message" => "Invalid Series selected"));
                break;
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

    function upoadGame() {
        $uploadDir = "assets/upload/hostGame";
        $fileData = $this->uploadFiletoFileSystem('file', $uploadDir);
        $fileData["game"] = $_POST["game"];
        $sql = $this->ask_mysqli->insert("hostgame", $fileData);

        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Game", " Added Successfully"), "status" => 1, "message" => "Add Successfully.."));
        } else {
            unlink($fileData["path"]);
            echo json_encode(array($fileData, "toast" => array("danger", "Game", " Added Failed " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Insert Failed.."));
        }
    }

    function loadGame() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'game',
                2 => 'name',
                3 => 'extension',
                4 => 'url',
                5 => 'path',
                6 => 'isSubAdmin',
                7 => 'onCreate'
            );
            $sql = $this->ask_mysqli->select("hostgame", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .= $this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql .= " AND (name Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $sql .= $this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['game'];
                $subdata[] = '<a target="_blank" href="' . $row["url"] . '" class="btn btn-success btn-xs"> <i class="fa fa-download"></i></a>';
                $subdata[] = $row['onCreate'];
                $subdata[] = '<button onclick="deleteGame(' . $row["subadmin_id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
                $data[] = $subdata;
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFilter),
                "data" => $data,
            );
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function deleteGame() {
        $sql = $this->ask_mysqli->select("hostgame", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("subadmin_id" => $_POST["subadmin_id"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            unlink($row["path"]);
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("hostgame") . $this->ask_mysqli->whereSingle(array("subadmin_id" => $_POST["subadmin_id"])));
            echo json_encode(array("toast" => array("success", "Game", " Delete Successfully"), "status" => 1, "message" => "Game Delete Successfully.."));
        } else {
            echo json_encode(array("toast" => array("danger", "Game", " Delete Failed..Try again"), "status" => 0, "message" => "Delete Failed..Try again"));
        }
    }

    function blockno() {
        $id = $_POST["subadmin_id"];
        unset($_POST["action"]);
        $blockno = json_encode($_POST);
        $sql = $this->ask_mysqli->update(array("blockno" => $blockno), "admin") . $this->ask_mysqli->whereSingle(array("subadmin_id" => $id));
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Game", " Block no set  Successfully"), "status" => 1, "message" => "Block no set Successfully.."));
        } else {
            echo json_encode(array("toast" => array("danger", "Game", " Bloc No set Failed..Try again"), "status" => 0, "message" => "Block no set Try again"));
        }
    }

    function getBlockno() {
        $resutl = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("subadmin_id" => $_POST["subadmin_id"])));
        $row = $resutl->fetch_assoc();
        echo $row["blockno"];
    }

    function loadTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'subadmin_id',
                1 => 'userid',
                2 => 'passowrd',
                3 => 'name',
                4 => 'mobileno',
                5 => 'balance',
                6 => 'device',
                7 => 'ip',
                8 => 'is_active',
                9 => 'create_on',
                10 => 'isdate'
            );
            $sql = $this->ask_mysqli->select("subadmin", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .= $this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql .= " AND (name Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $sql .= $this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['subadmin_id'];
                $subdata[] = $row['userid'];
                $subdata[] = $row['password'];
                $subdata[] = $row['name'];
                $subdata[] = $row['mobileno'];
                $subdata[] = $row['balance'];
                $subdata[] = $row['device'];
                $subdata[] = $row['ip'];
                if ($row["is_active"] === "1") {
                    $subdata[] = "<span class='text-success'>Active</a>";
                } else {
                    $subdata[] = "<span class='text-danger'>In-Active</a>";
                }
                $subdata[] = $row['create_on'];
                $subdata[] = $row['isdate'];
                $active = '<button onclick="deleteFullAccount(\'' . $row["subadmin_id"] . '\',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
                $active .= ' <button onclick="editAccount(\'' . $row["subadmin_id"] . '\',\'' . $row["name"] . '\',\'' . $row["mobileno"] . '\',\'' . $row["comission"] . '\',\'' . $row["device"] . '\',\'' . $row["winper"] . '\',\'' . $row["auto"] . '\')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> Edit</button>';
                $active .= ' <button onclick="putPoint(\'' . $row["userid"] . '\',\'' . $row["name"] . '\',\'' . $row["balance"] . '\')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i>Add Point</button>';
                $active .= ' <button onclick="getPoint(\'' . $row["userid"] . '\',\'' . $row["name"] . '\',\'' . $row["balance"] . '\')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i>Remove Point</button>';
                $b = array(1 => "danger", 0 => "success");
                $b2 = array(1 => "Suspend", 0 => "Active");
                $ac = array(0 => 1, 1 => 0);
                $subdata[] = $active . ' <button onclick="suspendAccount(' . $row["subadmin_id"] . ',' . $ac[$row["is_active"]] . ')" data-toggle="modal" data-target="#myModal" class="btn btn-' . $b[$row['is_active']] . ' btn-xs"> <i class="fa fa-scissors"></i>' . $b2[$row['is_active']] . '</button>';

                $data[] = $subdata;
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFilter),
                "data" => $data,
            );
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function loadMessageTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'message'
            );
            $sql = $this->ask_mysqli->select("message", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .= $this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql .= " AND (name Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $sql .= $this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['message'];
                $data[] = $subdata;
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFilter),
                "data" => $data,
            );
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function addSubAdmin() {
        $data = $_POST;
        if ($data["auto"]) {
            $data["auto"] = 1;
        } else {
            $data["auto"] = 0;
        }
        unset($data["subadmin_id"]);
        unset($data["action"]);
        $data["ip"] = $_SERVER["REMOTE_ADDR"];
        $data["is_active"] = 1;
        $data["create_on"] = date("Y-m-d");
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $sql = $this->ask_mysqli->insert("subadmin", $data);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
        if (empty($error)) {
            $last_id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
//            if ($last_id > 25) {
//                array_push($error, "You Enter Only 25 id, try update limit...!");
//            }
            $userid = "SAM" . date("Y") . date("m") . date("d") . $last_id;
            $sql = $this->ask_mysqli->update(array("userid" => $userid), "subadmin") . $this->ask_mysqli->whereSingle(array("subadmin_id" => $last_id));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "SubAdmin", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            } else {
                $json_error = json_encode($error);
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                echo json_encode(array("toast" => array("danger", "SubAdmin", " Added failed {$json_error}"), "status" => 0, "message" => "Insert Failed.. {$json_error}"));
            }
        } else {
            $json_error = json_encode($error);
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("toast" => array("danger", "SubAdmin", " Added failed {$json_error}"), "status" => 0, "message" => "Insert Failed.. {$json_error}"));
        }
    }

    function deleteSubAdmin() {
        $data = $_POST;
//        print_r($data);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $erroe = array();

        $where = $this->ask_mysqli->whereSingle(array("agent_id" => $data["agent_id"]));
        $sql = $this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $where;
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {




            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->_updateINC(array("balance" => "balance-" . $row["balance"]), "agent") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($erroe, "Erro(001) Unable to Update Balance.. subadmin") : true;
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->_updateINC(array("balance" => "balance+" . $row["balance"]), "subadmin") . $this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]))) != 1 ? array_push($erroe, "Erro(001) Unable to Update Balance.. Admin") : true;
            $s = $this->ask_mysqli->insert("transaction", array("userid" => $row["userid"], "debit" => $row["balance"], "remark" => "Sub-Admin Get Back Balance from agent and Delete Account", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($s) != true ? array_push($erroe, "Error on Transcation Table Error Code 02 subadmin transaction") : true;
            $s1 = $this->ask_mysqli->insert("transaction", array("userid" => $_POST["id"], "credit" => $row["balance"], "remark" => "Self Credit form sub-admin to transfer balance from agent {$row["userid"]} and delete it account", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("subadmin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["id"])), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($s1) != true ? array_push($error, "Error on Transcation Table Error Code 02 ") : true;
            $sql = $this->ask_mysqli->delete("agent") . $where;
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;

            if (empty($erroe)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "SubAdmin", " Delete SubAdmin Success.."), "status" => 1, "message" => "Delete SubAdmin Success... "));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($erroe);
                echo json_encode(array("toast" => array("danger", "SubAdmin", " Delete SubAdmin  failed {$json_error}"), "status" => 0, "message" => "Delete SubAdmin  Failed.. {$json_error}"));
            }
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            $json_error = json_encode($erroe);
            echo json_encode(array("toast" => array("danger", "SubAdmin", " Delete SubAdmin Invalid or failed {$json_error}"), "status" => 0, "message" => "Delete SubAdmin Invalid or Failed.. {$json_error}"));
        }
    }

    function deleteSubAdminUser($data, $erroe) {

        //print_r($data);die;
        $where = $this->ask_mysqli->whereSingle(array("id" => $data["id"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $where);
        if ($row = $result->fetch_assoc()) {
            //print_r($row);die;
            //$erroe = array();
//            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->_updateINC(array("balance" => "balance-" . $row["balance"]), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($erroe, "Erro(001) Unable to Update Balance.. enduser") : true;
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->_updateINC(array("balance" => "balance+" . $row["balance"]), "subadmin") . $this->ask_mysqli->whereSingle(array("userid" => $data["subadmin_id"]))) != 1 ? array_push($erroe, "Erro(001) Unable to Update Balance.. user") : true;
            $s = $this->ask_mysqli->insert("transaction", array("userid" => $row["userid"], "debit" => $row["balance"], "remark" => "SubAdmin Get Back Balance from user and Delete Account", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($s) != true ? array_push($erroe, "Error on Transcation Table Error Code 02 enduser transaction") : true;
            $s1 = $this->ask_mysqli->insert("transaction", array("userid" => $row["subadmin_id"], "credit" => $row["balance"], "remark" => "Self Credit form admin to transfer balance from user {$row["userid"]} and delete it account", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("subadmin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["subadmin_id"])), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($s1) != true ? array_push($erroe, "Error on Transcation Table Error Code 02 ") : true;
            $sql = $this->ask_mysqli->delete("enduser") . $where;
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($erroe, $this->adminDB[$_SESSION["db_1"]]->error) : true;

            if (empty($erroe)) {
//                $this->adminDB[$_SESSION["db_1"]]->commit();
                // echo json_encode(array("toast" => array("success", "User", " Delete User Success.."), "status" => 1, "message" => "Delete User Success... "));
            } else {
//                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($erroe);
                //echo json_encode(array("toast" => array("danger", "User", " Delete User  failed {$json_error}"), "status" => 0, "message" => "Delete User  Failed.. {$json_error}"));
            }
        } else {
//            $this->adminDB[$_SESSION["db_1"]]->rollback();
            $json_error = json_encode($erroe);
            //echo json_encode(array("toast" => array("danger", "User", " Delete User Invalid or failed {$json_error}"), "status" => 0, "message" => "Delete User Invalid or Failed.. {$json_error}"));
        }
        return $erroe;
    }

    function getData($sql, $col) {
        try {

            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            return $row[$col];
        } catch (Exception $ex) {
            
        }
    }

    function update() {
        try {
            $data = $_POST;
            if ($data["auto"]) {
                $data["auto"] = 1;
            } else {
                $data["auto"] = 0;
            }
            unset($data['action']);
            $where = $this->ask_mysqli->whereSingle(array("subadmin_id" => $data["subadmin_id"]));
            unset($data[["subadmin_id"]]);
            $error = array();
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $sql = $this->ask_mysqli->update($data, "subadmin") . $where;
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                $json_error = json_encode($error);
                echo json_encode(array("toast" => array("success", "SubAdmin", "Information Update Succesfully.."), "status" => 1, "message" => "SubAdmin Information Update Successfully.."));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($error);
                echo json_encode(array("toast" => array("danger", "SubAdmin", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "SubAdmin Information Update Failed.. {$json_error}"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function putPoint() {
        try {
            $data = $_POST;

            unset($data["action"]);
            unset($data["id"]);
            //print_r($data);die;
            $this->adminDB[$_SESSION['db_1']]->autocommit(FALSE);
            $sql = $this->ask_mysqli->select("subadmin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["subadmin"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            if ((float) $row["balance"] > (float) $data["point"]) {
                $error = array();
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance+" . $data["point"]), "agent") . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $data["point"]), "subadmin") . $this->ask_mysqli->whereSingle(array("userid" => $_POST["subadmin"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $data["userid"], "credit" => $data["point"], "remark" => "Sub-Admin Send Balance to Agent", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $_POST["subadmin"], "debit" => $data["point"], "remark" => "Self Debit form sub-admin to transfer balance", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("subadmin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["subadmin"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("toast" => array("success", "SubAdmin", "Information Update Success... "), "status" => 1, "message" => "SubAdmin Information Update Success.. "));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    $json_error = json_encode($error);
                    echo json_encode(array("toast" => array("danger", "SubAdmin", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "SubAdmin Information Update Failed.. {$json_error}"));
                }
            } else {

                echo json_encode(array("toast" => array("danger", "SubAdmin", "Admin Insuficent account point"), "status" => 0, "sql" => $sql, "message" => "Admin Insuficent account point"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function getPoint() {
        try {
            $data = $_POST;

            unset($data["action"]);
            unset($data["id"]);
            //print_r($data);die;
            $this->adminDB[$_SESSION['db_1']]->autocommit(FALSE);
            $sql = $this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            if ((float) $row["balance"] >= (float) $data["point"]) {
                $error = array();
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $data["point"]), "agent") . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance+" . $data["point"]), "subadmin") . $this->ask_mysqli->whereSingle(array("userid" => $_POST["subadmin"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $data["userid"], "debit" => $data["point"], "remark" => "sub-Admin get Back Balance From agent", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("agent", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $_POST["subadmin"], "credit" => $data["point"], "remark" => "Self Debit form SubAdmin to Admin transfer balance", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("subadmin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["subadmin"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("toast" => array("success", "SubAdmin", "Information Update Success... "), "status" => 1, "message" => "SubAdmin Information Update Success.. "));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    $json_error = json_encode($error);
                    echo json_encode(array("toast" => array("danger", "SubAdmin", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "SubAdmin Information Update Failed.. {$json_error}"));
                }
            } else {

                echo json_encode(array("toast" => array("danger", "SubAdmin", "SubAdmin Insuficent account point"), "status" => 0, "message" => "SubAdmin Insuficent account point"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function suspend() {
        try {
            $data = $_POST;
            unset($data["action"]);
            $where = $this->ask_mysqli->whereSingle(array("subadmin_id" => $data["id"]));
            unset($data["id"]);
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update($data, "subadmin") . $where) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "SubAdmin", "Information Update Success... "), "status" => 1, "message" => "SubAdmin Information Update Success.. "));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($error);
                echo json_encode(array("toast" => array("danger", "SubAdmin", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "SubAdmin Information Update Failed.. {$json_error}"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function updateper() {
        try {
            $sql = $this->ask_mysqli->update(array("resultper" => $_POST["resultper"], "min" => $_POST["min"]), "admin") . $this->ask_mysqli->whereSingle(array("subadmin_id" => $_POST["subadmin_id"]));
            if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
                echo json_encode(array("toast" => array("success", "Admin", "Information Update Success... "), "status" => 1, "message" => "SubAdmin Information Update Success.. "));
            } else {
                echo json_encode(array("toast" => array("danger", "Admin", "Information Update Failed... "), "status" => 0, "message" => "SubAdmin Information Update Failed.. {$json_error}"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function adminBalance() {

        $data = array();
        $sql = $this->ask_mysqli->select("subadmin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["3"] = $row["balance"];
        $data["4"] = $row["comission"] * 100;
        $data["5"] = $row["userid"];

        $sql = $this->ask_mysqli->selectCount("enduser", "id"); // . $this->ask_mysqli->whereSingle(array("subadmin_id" => $_POST["userid"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["1"] = $row["count(id)"];

        $sql = $this->ask_mysqli->selectCount("agent", "agent_id"); // . $this->ask_mysqli->whereSingle(array("subadmin_id" => $_POST["userid"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["2"] = $row["count(agent_id)"];

        $sql = $this->ask_mysqli->selectCount("enduser", "id") . $this->ask_mysqli->whereSingle(array("live" => 1));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["0"] = $row["count(id)"];

        $sql = "SELECT avg(winper) FROM `enduser`";
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["6"] = round((float)$row["avg(winper)"], 2);
        $sql = $this->ask_mysqli->select("admin", $_SESSION["db_1"]);// . $this->ask_mysqli->whereSingle(array("id" => "1"));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        if ($row["type"]) {
            $data["7"] = $row["wid"] . "/Winner";
        } else {
            $data["7"] = $row["wid"] . "/Looser";
        }
        if ($row["min"]) {
            $data["8"] = $row["resultper"] . "/Max";
        } else {
            $data["8"] = $row["resultper"] . "/Min";
        }
        echo json_encode($data);
    }

    function message() {
        unset($_POST["action"]);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update($_POST, "message") . $this->ask_mysqli->whereSingle(array("subadmin_id" => 1))) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            echo json_encode(array("toast" => array("success", "Messaage", "SubAdmin Message Information Update Success... "), "status" => 1, "message" => "SubAdmin Message Information Update Success.. "));
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            $json_error = json_encode($error);
            echo json_encode(array("toast" => array("danger", "Message", "SubAdmin Message Information Update Failed... {$json_error}"), "status" => 0, "message" => "SubAdmin Message Information Update Failed.. {$json_error}"));
        }
    }

    function allSubAdmin() {
        try {
            $sql = $this->ask_mysqli->select("subadmin", $_SESSION["db_1"]);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $array = array();
            while ($row = $result->fetch_assoc()) {
                unset($row["password"]);
                array_push($array, $row);
            }
            echo json_encode($array);
        } catch (Exception $ex) {
            
        }
    }

}
