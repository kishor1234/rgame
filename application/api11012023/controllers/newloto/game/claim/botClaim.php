<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once controller;

class botClaim extends CAaskController
{

    //put your code here
    public $amount = 0;
    public $sad;
    public $happy;
    public $fw;
    public $tpoint = 0;
    public $wnumber = 0;
    public $no;

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
        //$this->sad = "<img src='https://i0.wp.com/www.aktricks.in/wp-content/uploads/2018/03/3ae816da-3a55-4bac-a613-b5dd5c1dfac5.jpg' style='height:100px;'>";
        $this->sad = "<center><h1 style='color:red;'>No Wining Point!</h1></center>";
        $this->happy = "<img src='/assets/img/happyr.gif' style='height:100px;'>";
        $this->fw = "<img src='/assets/img/fw.gif' style='height:100px;'>";
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
                //echo 1;
                $_POST["userid"] = $row["own"];
                $_POST["id"] = $row["game"];
                if (strtotime(date("H:i:s")) < strtotime($row["gameendtime"]) && strtotime(date("Y-m-d")) == strtotime($row["enterydate"])) {
                    $final = array(
                        "status" => "0",
                        "message" => "Draw is not over yet!"
                    );
                    echo json_encode($final);
                    continue;
                } else {
                    $claimStatis = $row["claimstatus"];
                    $ClaimTime = $row["ClaimTime"];
                    $winpt = $row["winpt"];
                    $drid = $row["gametimeid"];
                    $game = $row["game"];
                    $utrno = $row["utrno"];
                    $sql = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $row["game"], "own" => $_POST["userid"]), "AND");
                    $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    $sum = 0;
                    $winArray = array();
                    while ($row1 = $result->fetch_assoc()) {
                        //print_r($row);
                        $game_id = $row1["gametimeid"];
                        //$claimStatis = $row["claimstatus"];
                        $date = $row1["enterydate"];
                        $ResultArray = array();
                        $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $game_id, "gdate" => $date), "AND");
                        $drawResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                        while ($drawRow = $drawResult->fetch_assoc()) {
                            $subSeries = explode("-", $drawRow["series"]);

                            $k = 0;
                            $tempArray = array();
                            for ($i = $subSeries[0]; $i <= $subSeries[1]; $i = $i + 100) {
                                $ipl = $i + $drawRow[$k];
                                //echo "<br>";
                                $tempArray[$ipl] = $k;
                                $k++;
                            }
                            array_push($ResultArray, $tempArray);
                            //  die;
                        }



                        $p = json_decode($row1["point"], true);
                        foreach ($p as $k => $v) {
                            foreach ($v as $k1 => $v1) {
                                foreach ($ResultArray as $key => $val) {
                                    if (array_key_exists($k1, $val)) {
                                        $sum = $sum + (int) $v1;
                                        $winArray[$k1] = $v1;
                                    }
                                }
                            }
                        }
                    }
                    //echo $sum;die;
                    if ($claimStatis === "1") {
                        $pri = $sum * $winpt;
                        $final = array(
                            "status" => "0",
                            "message" => "Ticket already claimed \nPoint win:{$pri} \nClaim date : {$ClaimTime}",
                            "amount" => (string) ($sum * $winpt),
                            "own" => $_POST["userid"],
                            "drawid" => $game_id,
                            "game" => $game,
                            "date" => $date,
                            "utrno" => $utrno,
                            "winPoint" => $winArray
                        );
                    } else if (empty($winArray)) {

                        $final = array(
                            "status" => "0",
                            "message" => "No winning ticket",
                            "amount" => (string) ($sum * $winpt),
                            "own" => $_POST["userid"],
                            "drawid" => $game_id,
                            "game" => $game,
                            "utrno" => $utrno,
                            "winPoint" => $winArray
                        );
                        $er = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("winamt" => $this->amount, "winstatus" => 0, "claimstatus" => 0), "entry") . $this->ask_mysqli->whereSingle(array("game" => $_POST["id"])));
                        // $er == false ? array_push($error, "Update win and claim status  table error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                    } else {
                        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
                        $this->amount = $sum * $winpt;
                        $error = array();
                        $sql = $this->ask_mysqli->insert("claim", array("enteryid" => $_POST["userid"], 'utrno' => $row["utrno"], "winnumber" => json_encode($winArray), "gameid" => $row["gametimeid"], "gametime" => $row["gametime"], "gameetime" => $row["gameendtime"], "cdate" => $row["enterydate"]));
                        $er = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                        $er == false ? array_push($error, "Insert on claim table error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                        $max = $this->adminDB[$_SESSION["db_1"]]->insert_id; // $this->getData($this->select("claim", $_SESSION["db_1"]) . $this->whereSingle(array("id" => $this->filterPost("id"))), "id");
                        $er = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("winamt" => $this->amount, "winstatus" => 1, "claimstatus" => 1), "entry") . $this->ask_mysqli->whereSingle(array("game" => $_POST["id"])));
                        $er == false ? array_push($error, "Update win and claim status  table error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                        //echo $this->ask_mysqli->updateINC(array("balance"=>"".$this->amount), "enduser").$this->ask_mysqli->whereSingle(array("userid"=>$_POST["userid"]));

                        //$this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateINC(array("balance" => $this->amount), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"]))) != 1 ? array_push($error, "Error on Update Wining Points Update " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                        //echo($this->insert("transaction", $_SESSION["db_1"], array("userid" => $_SESSION["userid"], "debit" => $this->amount, "remark" => "Winner Point's transfer " . $this->amount . " Invoic ID#" . $this->filterPost("id"), "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->select("enduser", $_SESSION["db_1"]) . $this->whereSingle(array("userid" => $_SESSION["userid"])), "balance"))));// != 1 ? array_push($error, "Error on Transcation Table Error Code 02 ") : true;
                        //$this->adminDB[$_SESSION["db_1"]]->query($this->update(array("winamt"=>$this->amount), "entry").$this->whereSingle(array("id"=>$s[1])))!=1?array_push($error, "Unable to update Net Payable "):true;

                        $sql = $this->ask_mysqli->insert("transaction", array("userid" => $_POST["userid"], "credit" => $this->amount, "remark" => "Winner Point\'s transfer " . $this->amount . " Invoic ID#" . $_POST["id"], "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"])), "balance")));
                       // $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, "Error on Transcation Table Error Code 02 " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                        //admin point tr
                        $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $this->amount), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
                        //$this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                        //admin transaction
                        $sql = $this->ask_mysqli->insert("transaction", array("userid" => 1, "debit" => $this->amount, "remark" => "Admin transfer Winner Point\'s " . $this->amount . " Invoic ID#" . $_POST["id"], "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . /$this->ask_mysqli->whereSingle(array("id" => 1)), "balance")));
                        //$this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, "Error on Transcation Table Error Code 02 " . $this->adminDB[$_SESSION["db_1"]]->error) : true;

                        if (!empty($error)) {
                            $this->adminDB[$_SESSION["db_1"]]->rollback();
                            $final = array(
                                "status" => "0",
                                "message" => "error on Update! " . json_encode($error),
                                "amount" => (string) ($sum * $winpt),
                                "own" => $_POST["userid"],
                                "drawid" => $game_id,
                                "game" => $game,
                                "utrno" => $utrno,
                                "winPoint" => $winArray
                            );
                        } else {
                            $this->adminDB[$_SESSION["db_1"]]->commit();
                            if ($winpt > 180) {
                                $jackpot = "JACKPOT POINT ";
                            }
                            $final = array(
                                "status" => "1",
                                "message" => $jackpot . " You won! " . ($sum * $winpt) . "\nDr ID. : {$drid} \nClaim date : {$ClaimTime}",
                                "amount" => (string) ($sum * $winpt),
                                "own" => $_POST["userid"],
                                "drawid" => $game_id,
                                "id" => $_POST["id"],
                                "date" => $date,
                                "game" => $game,
                                "utrno" => $utrno,
                                "winPoint" => $winArray
                            );
                        }
                    }
                }
                array_push($fdata,$final);
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

    function getRecip($array)
    {
        $r = null;
        if (!empty($array["winPoint"])) {
            ob_start();
            $this->isLoadView(array("header" => "webheader", "main" => "posWinRecip", "footer" => "webfooter", "error" => "page_404"), false, array("row" => $array));
            $r = ob_get_contents();
            ob_end_clean();
        }
        return $r;
    }
}
