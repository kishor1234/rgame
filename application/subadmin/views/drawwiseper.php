<?php
if ($_SESSION["m"] === "main") {
?>
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
                    <div class="col-lg-12">
                        <div id="dp"></div>
                        <div class="card card-primary">
                            <div class="card-header with-border">
                                <h2 class="card-title">Lotto Win Percentage draw wise</h2>
                            </div>
                            <div class="card-body">
                                <form action="javascript:void(0)" method="post" class="form-horizontal" id="myMainResultPer">
                                    <div class="form-group">
                                        <?php
                                        $sl = "SELECT * FROM `gametime`";
                                        $result = $main->adminDB[$_SESSION["db_1"]]->query($sl);
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label id="label label-primary"><strong>Draw_<?php echo $row["id"]; ?> (%)</strong>*</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="hidden" name="ids[]" value="<?php echo  $row["id"]; ?>" />
                                                    <input type="radio" onchange="hideFunction('#new','#old','<?php echo $row['id'] ?>')" name="method<?php echo  $row["id"]; ?>" <?php if ($row["method"] === "0") {
                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                    }  ?> value="0" /> <span style="font-size: 8xp; color:red;">Old </span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="radio" onchange="hideFunction('#old','#new','<?php echo $row['id'] ?>')" name="method<?php echo  $row["id"]; ?>" <?php if ($row["method"] === "1") {
                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                    }  ?> value="1" /> <span style="font-size: 8xp; color:green;">New </span>
                                                </div>
                                            </div>
                                            <div class="row" id="old<?php echo  $row["id"]; ?>" style="<?php if ($row["method"] === "1") { ?>display:none;<?php } ?>">
                                                <div class="col-lg-12">
                                                    <label>All Plat Id</label>
                                                    <input class='form-control' style=" margin:1px; padding:1px; border-radius: 5px; text-align:center; border-color: #FFAAD2; color:red; font-size: 20px;" type="text" maxlength="3" onkeypress="return isNumber(event)" name="per[]" value="<?php echo  $row["per"]; ?>" id="<?php echo  $row["id"]; ?>" class="form-control">

                                                </div>

                                            </div>
                                            <div class="row" id="new<?php echo  $row["id"]; ?>" style="<?php if ($row["method"] === "0") { ?>display:none;<?php } ?>">

                                                <?php
                                                for ($p = 0; $p < 10; $p++) {
                                                ?>
                                                    <div class="col-lg-1">
                                                        <label>Plat Id <?php echo $p; ?></label>
                                                        <input class='form-control' style=" margin:1px; padding:1px; border-radius: 5px; text-align:center; border-color: #FFAAD2; color:red; font-size: 20px;" type="text" maxlength="3" onkeypress="return isNumber(event)" name='s<?php echo $p; ?>[]' value="<?php echo  $row["s" . $p]; ?>" id="S<?php echo  $row["id"]; ?>" class="form-control">
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="col-lg-2"></div>
                                            </div>


                                        <?php
                                        }

                                        ?>

                                        <div class="col-lg-12">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="btn btn-success bnt-sm form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="box-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <script>
        function hideFunction(hide, display, id) {

            document.querySelector(hide + id).style.display = "none";
            document.querySelector(display + id).style.display = "flex";
        }
        $("document").ready(function() {
            report();
            $("#myMainResultPer").submit(function() {
                $("#myMainSubmitPer").attr("disabled", true);
                var formdata = new FormData($("#myMainResultPer")[0]);

                $.ajax({
                    url: '<?= api_url ?>/?r=CUpdaePer',
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
                        //console.log(data);
                        $("#myMainSubmit").attr("disabled", false);
                        $("#mainloadimg").hide();
                        var json = JSON.parse(data);
                        if (json.status === 1) {
                            swal("Success", json.message, "success");
                            setTimeout(function() {
                                //window.location.reload();
                            }, 2000);

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
            report();
        });

        function report() {
            $.post("<?= api_url ?>?r=CAddUser", {
                action: "getBlockno",
                id: "<?= $_SESSION["id"] ?>"
            }, function(data) {
                console.log(data);
                var json = JSON.parse(data);
                console.log(json);
                for (var i = 0; i < 15; i++) {
                    $("#" + i).val(json[i]);
                }

            });
        }

        function getDrawLoto(id, list) {

            var val = $(id).val();
            var opts = $(list).children(); //.childNodes;
            for (var i = 0; i < opts.length; i++) {
                if (opts[i].value === val) {
                    var res = opts[i].value.split("|");
                    $("#gameid").val(res[0]);
                    $("#stime").val(res[1]);
                    $("#etime").val(res[2]);
                    $.post("/?r=<?php echo $obj->encdata("C_GetDrawLoadLoto"); ?>", {
                        id: res[0],
                        series: $("#series").val()
                    }, function(d) {
                        //console.log(d);
                        $("#display").html(d);
                    });
                    break;
                }
            }
        }

        function formPost(id, file, display) {

            var formData = new FormData($(id)[0]);
            onLoading();
            $.ajax({
                type: "POST",
                url: '/?r=' + file,
                data: formData, //$("#studetnReg").serialize(), // serializes the form's elements.,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    //alert(data);
                    offLoading();
                    $(display).html(data);
                    printMsg("#msg");
                    //alert(data); // show response from the php script.
                }

            });

            $(id)[0].reset();
            return false;
        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;

            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                //alert("Only Number Accept");
                return false;
            }
            return true;
        }

        function printMsg(msg) {
            $.post("/?r=<?php echo $obj->encdata("C_PrintMsg"); ?>", {}, function(data) {
                $(msg).html(data);
            });
        }
    </script>
<?php
}
else{
    echo "<h1>Page not found</h1>";
}
?>