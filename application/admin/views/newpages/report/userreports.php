<!-- Content Wrapper. Contains page content -->
<div id="app-container">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?= $main->isLoadView(array("header" => "webheader", "main" => "banner", "footer" => "webfooter", "error" => "page_404"), false, array("title" => $title, "link" => $link)); ?>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <!--                        <div class="card-header">
                                                        <div class="card-title mb-2">
                                                            
                            -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

                                    <style>
                                        #tickets-data {
                                            width: 250px;
                                            max-width: 250px;
                                            overflow: hidden;
                                            line-height: 1.2em;
                                        }

                                        .sign:not(:last-child) {
                                            padding-bottom: 30px;
                                            margin-bottom: 30px;
                                            border-bottom: 1px solid #e5e5e5;
                                        }

                                        div {
                                            line-height: 17px;
                                        }

                                        .game_title {
                                            line-height: 45px;
                                            font-size: 14px;
                                            margin-bottom: 10px;
                                            text-align: center;
                                        }

                                        .logo {
                                            width: 100%;
                                        }

                                        .first_prize {
                                            font-size: 16px;
                                            font-weight: normal;
                                        }

                                        .numbers-played {
                                            width: 100%;
                                            margin-bottom: 10px;
                                        }

                                        .numbers-played tr th,
                                        .numbers-played tr td {
                                            text-align: center;
                                        }

                                        .numbers-played tr td:nth-child(odd) {
                                            font-size: 11px;
                                            font-weight: normal;
                                        }

                                        .numbers-played tr td:nth-child(even) {
                                            font-weight: normal;
                                        }

                                        .normal_font {
                                            font-weight: normal;
                                        }

                                        .barcode {
                                            width: 75%;
                                        }

                                        .sign {
                                            text-align: center;
                                        }

                                        .sign img {
                                            height: 30px;
                                        }

                                        .sign_name {
                                            text-align: center;
                                            font-size: 12px;
                                        }

                                        .signImage {
                                            width: 100%;
                                        }
                                    </style>
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title">Show Ticket</p>
                                        </div>
                                        <div class="modal-body" id="ticket">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                            if (isset($_POST["dateform"]) && isset($_POST["dateto"])) {
                                $dateform = $_POST["dateform"];
                                $dateto = $_POST["dateto"];
                            } else {
                                $dateform = date("Y-m-d");
                                $dateto = date("Y-m-d");
                            }
                            ?>
                            <!--
                                                        </div>
                                                    </div>-->
                            <div class="card-body">
                                <div class="progress" id="progress">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress">Please wait....</div>
                                </div>

                                <div class="card-text">
                                    <div class="row">
                                        <div class="col-12">
                                            <form method="post" id="myMainForm">
                                                <!--  action="/?r=link&v=userreports" -->
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Form Date:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="date" value="<?= $dateform ?>" class="form-control float-right" id="reservation" name="dateform" max="<?= date("Y-m-d"); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>To Date:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="date" value="<?= $dateto ?>" class="form-control float-right" id="reservation" name="dateto" max="<?= date("Y-m-d"); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label><br></label>
                                                            <button type="submit" id="myMainSubmit" class="btn btn-primary btn-sm form-control"><i class="fa fa-search "></i> Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="action" id="action" value="searchTicket">

                                            </form>
                                        </div>
                                        <div class="col-12">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            #
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            User ID
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            Purchase<br>
                                                            (a)
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            Cancel<br>
                                                            (b)
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            Net Purchase PT<br>
                                                            (c=a-b)
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            Win Pts<br>
                                                            (d)
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            End PT<br>
                                                            (e=c-d)
                                                        </th>
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            Commission<br>(f)
                                                        </th>
                                                        <!--                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;"  class="col-xs-2" >
                                                            Incentive
                                                            (g)
                                                        </th>-->
                                                        <th style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2">
                                                            Net Payable<br>
                                                            (H=c-d-f)
                                                        </th>
                                                    </tr>

                                                </thead>
                                                <tbody id="tbody">
                                                <tr><td colspan='9'><p style='text-align:center;'>Please wait, we're fetching data it might take some time....</p></td></tr>
                                                    <?php
                                                    $sumofa = 0;
                                                    $sumofb = 0;
                                                    $sumofc = 0;
                                                    $sumofd = 0;
                                                    $sumofe = 0;
                                                    $sumoff = 0;
                                                    $sumofg = 0;
                                                    $sumofh = 0;
                                                    $responseData = $main->jsonRespon(api_url . "/?r=userreports", array("dateform" => $dateform, "dateto" => $dateto));
                                                    $json = json_decode($responseData, true);
                                                    foreach ($json as $key => $val) {
                                                        $i = $key + 1;
                                                        echo "<tr>";
                                                        echo "<td>{$i}</td>";
                                                        echo "<td>{$val["uid"]}</td>";
                                                        echo "<td>₹ {$val["a"]}</td>";
                                                        $sumofa += $val["a"];
                                                        echo "<td>₹ {$val["b"]}</td>";
                                                        $sumofb += $val["b"];
                                                        echo "<td>₹ {$val["c"]}</td>";
                                                        $sumofc += $val["c"];
                                                        echo "<td>₹ {$val["d"]}</td>";
                                                        $sumofd += $val["d"];
                                                        echo "<td>₹ {$val["e"]}</td>";
                                                        $sumofe += $val["e"];
                                                        echo "<td>₹ {$val["f"]}</td>";
                                                        $sumoff += $val["f"];
                                                        //    echo "<td>{$val["g"]}</td>";
                                                        //    $sumofg += $val["g"];
                                                        echo "<td>₹ {$val["h"]}</td>";
                                                        $sumofh += $val["h"];
                                                        echo "<tr>";
                                                    }
                                                    ?>

                                                </tbody>
                                                <tfoot style="background-color:#0ff">
                                                    <tr>
                                                        <td></td>
                                                        <th>Total:</th>
                                                        <th>₹ <span id="sumofa"><?= $sumofa ?></span></th>
                                                        <th>₹ <span id="sumofb"><?= $sumofb ?></span></th>
                                                        <th>₹ <span id="sumofc"><?= $sumofc ?></span></th>
                                                        <th>₹ <span id="sumofd"><?= $sumofd ?></span></th>
                                                        <th>₹ <span id="sumofe"><?= $sumofe ?></span></th>
                                                        <th>₹ <span id="sumoff"><?= $sumoff ?></span></th>
                                                        <!--                                                    <th><= $sumofg ?></th>-->
                                                        <th>₹ <span id="sumofh"><?= $sumofh ?></span></th>

                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function() {
        $.fn.serializeObject = function() {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        $("#myMainForm").submit(function() {
            $("#myMainSubmit").attr("disabled", true);
            var formdata = new FormData($("#myMainForm")[0]);
            $("#tbody").html("<tr><td colspan='9'><p style='text-align:center;'>Please wait, we're fetching data it might take some time....</p></td></tr>");
            $("#sumofa").html("");
            $("#sumofb").html("");
            $("#sumofc").html("");
            $("#sumofd").html("");
            $("#sumofe").html("");
            $("#sumoff").html("");
            $("#sumofh").html("");
            var object = {};
            formdata.forEach(function(value, key) {
                object[key] = value;
            });
            var json = JSON.stringify(object);
            $.ajax({
                type: 'POST',
                url: '<?= api_url ?>/?r=userreports',
                dataType: "json",
                data: json,
                success: function(obj) {
                    var dt = "";
                    var sumofa = 0.0;
                    var sumofb = 0.0;
                    var sumofc = 0.0;
                    var sumofd = 0.0;
                    var sumofe = 0.0;
                    var sumoff = 0.0;
                    var sumofh = 0.0;
                    var i = 1;
                    obj.forEach(function(value, index) {
                        sumofa = sumofa + parseFloat(value?.a);
                        sumofb = sumofb + parseFloat(value?.b);
                        sumofc = sumofc + parseFloat(value?.c);
                        sumofd = sumofd + parseFloat(value?.d);
                        sumofe = sumofe + parseFloat(value?.e);
                        sumoff = sumoff + parseFloat(value?.f);
                        sumofh = sumofh + parseFloat(value?.h);
                        dt = dt + '<tr><td>' + i + '</td><td>' + value?.uid + '</td><td>' + value?.a + '</td><td>' + value?.b + '</td><td>' + value?.c + '</td><td>' + value?.d + '</td><td>' + value?.e + '</td><td>' + value?.f + '</td>><td>' + value?.h + '</td></tr>';
                        i++;
                    });
                    $("#tbody").html(dt);
                    $("#sumofa").html(parseFloat(sumofa));
                    $("#sumofb").html(parseFloat(sumofb));
                    $("#sumofc").html(parseFloat(sumofc));
                    $("#sumofd").html(parseFloat(sumofd));
                    $("#sumofe").html(parseFloat(sumofe));
                    $("#sumoff").html(parseFloat(sumoff));
                    $("#sumofh").html(parseFloat(sumofh));
                },
                error: function(request, status, error) {
                    printMessage("Error on " + error, "danger", ".msg");
                }
            });
            $("#myMainSubmit").attr("disabled", false);
            return false;
        });
    });

    function deleteSeries(id, st) {
        swal({
                title: "Are you sure?",
                text: "want to delete Series?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: true
            },
            function() {
                $.post('<?= api_url ?>/?r=CSeries', {
                    id: id,
                    action: 'delete'
                }, function(data) {
                    console.log(data);
                    table.ajax.reload(null, false);
                    var json = JSON.parse(data);
                    $.toaster({
                        priority: json.toast[0],
                        title: json.toast[1],
                        message: json.toast[2]
                    });

                });

            });

    }

    function loadTicket(id) {
        console.log(id);
        $("#ticket").html("Loading.....");
        $.post("<?= api_url ?>/?r=reprintTicket", {
            game: id
        }, function(d) {
            var json = JSON.parse(d);
            $("#ticket").html(json.ticket);
        });
    }
</script>