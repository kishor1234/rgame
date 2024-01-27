<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <?= $main->isLoadView(array("header" => "webheader", "main" => "banner", "footer" => "webfooter", "error" => "page_404"), false, array("title" => $title, "link" => $link)); ?>
    <!-- /.content-header -->
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Users</span>
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=user', '#app-container', false)" class="nav-link">
                                <span class="info-box-number" id="compaines">

                                </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-code"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Agent</span>
                            <a href="javascript:void(0)" class="nav-link">
                                <span class="info-box-number" id="agent"></span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-play"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Live Users</span>
                            <a href="javascript:void(0)" class="nav-link"> <span class="info-box-number" id="live">1</span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Point Transfer Agent</span>
                            <a href="javascript:clickOnLink('/?r=dashboard&v=agent', '#app-container', false)" class="nav-link"> <span class="info-box-number" id="live">Click here</span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Point Transfer User</span>
                            <a href="javascript:clickOnLink('/?r=dashboard&v=user', '#app-container', false)" class="nav-link"> <span class="info-box-number" id="live">Click here</span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Agent Sell Report</span>
                            <a href="javascript:clickOnLink('/?r=dashboard&v=agentreports', '#app-container', false)" class="nav-link"> <span class="info-box-number" id="live">Click here</span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Avg. Winning Percentage</span>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#myMain" class="nav-link"><span class="info-box-number" id="per"></span></a>
                        </div>
                        
                    </div>
                   
                </div> -->
                <!-- /.col -->
                <?php
                if ($_SESSION["m"] === "main") {
                ?>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Set Winner ID</span>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#winner" class="nav-link" data-toggle="modal" onclick="$('#myMainWinnerId')[0].reset();" data-target="#myMain"><span class="info-box-number" id="widid"></span></a>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Result Percentage</span>
                                <a href="javascript:void(0)" class="nav-link" data-toggle="modal" onclick="$('#myMainResultPerMain')[0].reset();" data-target="#myMainMain"><span class="info-box-number" id="resultperMain"></span></a>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                <?php
                }
                ?>
            </div>


            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php
    if ($_SESSION["m"] === "main") {
    ?>
        <div class="container">
            <div class="row">
                <style>
                    #center {
                        text-align: center;
                        margin-left: auto;
                        margin-right: auto;
                    }
                </style>
                <div class="col-8 offset-2">
                    <div id="center">
                        <?php
                        $result = $main->adminDB[$_SESSION["db_1"]]->query($main->ask_mysqli->select("admin", $_SESSION["db_1"]));
                        $row = $result->fetch_assoc();
                        if ((int) $row["cron"] == 0) {
                        ?>
                            <h1>Click Button to Start Result</h1>
                            <button class="btn btn-success" onclick="ResultServices(1)"><i class="fa fa-star"></i> Start</button>
                        <?php
                        } else {
                        ?>
                            <h1>Click Button to Stop Result</h1>
                            <button class="btn btn-danger" onclick="ResultServices(0)"><i class="fa fa-stop"></i> Stop</button>

                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-12">
                    <div>
                        <h3 id="center">Result Calculation Techniques</h3>
                        <table class="table">
                            <tr>
                                <td class="panel panle-primary">
                                    <input type="radio" name="resultTech" id="rb0" value="0" onclick="changeRT('0', '<?= $_SESSION["id"] ?>')">&nbsp;<label>As define Percentage wise</label>
                                </td>
                                <td class="panel panel-warning">
                                    <input type="radio" name="resultTech" id="rb1" value="1" onclick="changeRT('1', '<?= $_SESSION["id"] ?>')">&nbsp;<label>Set Winner ID</label>
                                </td>
                                <td class="panel panel-danger">
                                    <input type="radio" name="resultTech" id="rb2" value="2" onclick="changeRT('2', '<?= $_SESSION["id"] ?>')">&nbsp;<label>Random Percentage between 50% to 100%</label>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- /.content -->
    <?php
    if ($_SESSION["m"] === "main") {
    ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Result Release Status</h2>

                    </div>
                </div>
                <div class="row">

                    <?php
                    $data = $main->module->getAllTiem();
                    foreach ($data as $in => $row) {
                        echo "<div class='col-xs-1' style='margin:2px;'>";
                        $etime = date("h:i A", strtotime($row["etime"]));
                        if ($row["status"]) {

                            echo "<button class='btn btn-danger' disabled>{$etime}</button>";
                        } else {

                            echo "<button class='btn btn-success' onclick=\"calculate('{$row["id"]}','{$row["stime"]}','{$row["etime"]}')\">{$etime}</button>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<div class="modal fade preview-modal" data-backdrop="" id="myMainMain" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Result Percentage</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="javascript:void(0)" method="post" id="myMainResultPerMain">
                            <div class="form-group">
                                <label class="form-control-label">Result Percentage <span class="text-danger">*</span></label>
                                <input type="text" name="resultper" id="resultper" placeholder="Enter Message" title="Message" required autocomplete="off" class="form-control">
                                <span id="error_name" class=""></span>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Result Min/Max <span class="text-danger">*</span></label>
                                <select name="min" id="min" placeholder="Result Min/Max" title="Result Min/Max" required autocomplete="off" class="form-control">
                                    <option value="0">Minimum</option>
                                    <option value="1">Maximum</option>
                                </select>
                                <span id="error_name" class=""></span>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Wining Jackpot set(min 180) <span class="text-danger">*</span></label>
                                <input type="number" min="180" name="winrate" id="winrate" placeholder="Enter Message" title="Message" required autocomplete="off" class="form-control">
                                <span id="error_name" class=""></span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="action" id="action" value="updateper">
                                <input type="hidden" id="id" name="id" value="1">
                                <button class="btn btn-primary btn-sm form-control" id="myMainSubmitPerMain">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <br>
                <div class="progress" id="progress">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress mainpro1">Please wait....</div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade preview-modal" data-backdrop="" id="myMain" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Winning Percentage for all user</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#" method="post" id="myMainResultPer">
                            <div class="form-group">
                                <label class="form-control-label">Winning Percentage <span class="text-danger">*</span></label>
                                <input type="number" step="1" max="100" min="10" name="winper" id="winper" placeholder="Enter Percentage" title="Message" required autocomplete="off" class="form-control">
                                <span id="error_name" class=""></span>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="action" id="action" value="updatewinper">
                                <input type="hidden" id="id" name="id" value="<?= $_SESSION["userid"] ?>">
                                <button class="btn btn-primary btn-sm form-control" id="myMainSubmitPer">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <br>
                <div class="progress" id="progress">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress mainpro1">Please wait....</div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="winner" tabindex="-1" role="dialog" aria-labelledby="winner" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Set Winner ID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="myMainWinnerid">
                    <div class="form-group">
                        <label class="form-control-label">Select Winner id <span class="text-danger">*</span></label>
                        <select name="wid" id="wid" placeholder="Result Min/Max" title="Result Min/Max" required autocomplete="off" class="form-control">
                            <option value="NO ID">no id</option>
                            <?php
                            $responseData = $main->jsonRespon(api_url . "/?r=CAddUser", array("action" => "allUser"));
                            $json = json_decode($responseData, true);
                            foreach ($json as $key => $val) {
                                echo "<option value='{$val["userid"]}'>{$val["userid"]}</option>";
                            }
                            ?>
                        </select>
                        <span id="error_name" class=""></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Winner/Looser <span class="text-danger">*</span></label>
                        <select name="type" id="type" placeholder="Result Min/Max" title="Result Min/Max" required autocomplete="off" class="form-control">
                            <option selected value="1">Winner</option>
                            <option value="0">Looser</option>
                        </select>
                        <span id="error_name" class=""></span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="action" id="action" value="updatewin">
                        <input type="hidden" id="id" name="id" value="1">
                        <!--<button class="btn btn-primary btn-sm form-control" id="myMainSubmitPer">Update</button>-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="myMainWinnerid" id="myMainSubmitWin" class="btn btn-primary btn-sm form-control">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(() => {
        var ch = '<?= $_SESSION['resultTech'] ?>';

        //alert(parseInt(ch));
        switch (parseInt(ch)) {
            case 0:

                document.getElementById("rb0").checked = true;
                break;
            case 1:

                document.getElementById("rb1").checked = true;
                break;
            default:
                document.getElementById("rb2").checked = true;
                break;
        }
        $("#myMainResultPerMain").submit(function() {
            $("#myMainSubmitPerMain").attr("disabled", true);
            var formdata = new FormData($("#myMainResultPerMain")[0]);
            console.log(formdata);
            $.ajax({
                url: '<?= api_url ?>/?r=CAddUser',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function() {
                    $("#mainloadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#mainpro1").css('width', progressbar + '%');
                        $("#mainpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function(data) {
                    console.log(data);
                    $("#myMainSubmitPerMain").attr("disabled", false);

                    $("#mainloadimg").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.message, "success");


                    } else {
                        swal("Error", json.message, "error");
                    }
                    $('#myMainResultPerMain')[0].reset();
                    $.toaster({
                        priority: json.toast[0],
                        title: json.toast[1],
                        message: json.toast[2]
                    });
                    $("#mainpro1").css('width', '0%');
                    $("#mainpro1").html('0%');
                    $("#progress").hide();
                    report();
                },
                error: function(xhr, error, code) {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
        $("#myMainResultPer").submit(function() {
            $("#myMainSubmitPer").attr("disabled", true);
            var formdata = new FormData($("#myMainResultPer")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CAddUser',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function() {
                    $("#mainloadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#mainpro1").css('width', progressbar + '%');
                        $("#mainpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function(data) {
                    console.log(data);
                    $("#myMainSubmit").attr("disabled", false);
                    $("#mainloadimg").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.message, "success");


                    } else {
                        swal("Error", json.message, "error");
                    }
                    $('#myMainResultPer')[0].reset();
                    $.toaster({
                        priority: json.toast[0],
                        title: json.toast[1],
                        message: json.toast[2]
                    });
                    $("#mainpro1").css('width', '0%');
                    $("#mainpro1").html('0%');
                    $("#progress").hide();
                    report();
                },
                error: function(xhr, error, code) {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
        $("#myMainWinnerid").submit(function() {

            $("#myMainSubmitWin").attr("disabled", true);
            var formdata = new FormData($("#myMainWinnerid")[0]);
            console.log(formdata);
            $.ajax({
                url: '<?= api_url ?>/?r=CAddUser',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function() {
                    $("#mainloadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#mainpro1").css('width', progressbar + '%');
                        $("#mainpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function(data) {
                    console.log(data);
                    $("#myMainSubmitWin").attr("disabled", false);

                    $("#mainloadimg").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.message, "success");


                    } else {
                        swal("Error", json.message, "error");
                    }
                    $('#myMainWinnerid')[0].reset();
                    $.toaster({
                        priority: json.toast[0],
                        title: json.toast[1],
                        message: json.toast[2]
                    });
                    $("#mainpro1").css('width', '0%');
                    $("#mainpro1").html('0%');
                    $("#progress").hide();
                    report();
                },
                error: function(xhr, error, code) {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
    });

    function ResultServices(id) {
        $.post("<?= api_url ?>?r=CStartorStop", {
            cron: id
        }, function(data) {
            $("#center").html(data);
        });
    }

    function changeRT(id, uid) {
        uid = 1;
        console.log(id, uid)
        $.post("<?= api_url ?>?r=updateResultTechnique", {
            "resultTech": id,
            "id": uid
        }, function(data) {
            console.log(data);
            var json = JSON.parse(data);

            if (json.status === 1) {
                swal("Success", json.message, "success");
                setSession(json);

            } else {
                swal("Error", json.message, "error");
            }

            $.toaster({
                priority: json.toast[0],
                title: json.toast[1],
                message: json.toast[2]
            });

        });
    }

    function setSession(obj) {
        $.post("/?r=C_SetSession", {
            "resultTech": obj.resultTech
        }, function(data) {
            console.log(data);
        });
    }

    function calculate(id, stime, etime) {
        swal({
                title: "Are you sure?",
                text: "Relese result by your self",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Do it!",
                closeOnConfirm: true
            },
            function() {
                $.post('<?= api_url ?>/?r=calculateResultCustome', {
                    gameid: id,
                    stime: stime,
                    etime: etime
                }, function(data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    alert(json.msg);
                    window.location.reload();
                });

            });
    }
</script>