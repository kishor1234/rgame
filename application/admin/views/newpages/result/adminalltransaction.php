<!-- Content Wrapper. Contains page content -->
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
                                <link rel="stylesheet"
                                      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!--                                <style>
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
                                </style>-->
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
                        <!--
                                                    </div>
                                                </div>-->
                        <div class="card-body">


                            <div class="card-text">
                                <div class="row">


                                    <div class="col-12">
                                        <table class="stripe hover display responsive nowrap table" id="myTable" cellspacing='0'>
                                            <thead>
                                                <tr>
                                                    <th>Tr.No.</th>
                                                    <th>User ID</th>
                                                    <th><i class="fa fa-rupee"></i> Credit/Debit</th>
                                                    <th><i class="fa fa-rupee"></i> Balance</th>

                                                    <th>Transaction Date</th>
                                                    <th>Remark</th>

                                                </tr>
                                            </thead>

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
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function () {
        $.fn.serializeObject = function ()
        {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
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
        table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            destroy: true,
            order: [[0, "desc"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: '<?= api_url ?>/?r=admintransaction&action=searchTicket',
                type: "post", // method  , by default get
                dataType: "json",
//                    success: function (sta) {
//                        console.log(sta);
//                    },
                //data: json, //{action: $("#action").val(), own: $("#own").val(), dateform: $("#dateform").val(), dateto: $("#dateto").val()},
                error: function () {  // error handling
                    //console.log(formdata);
                    $(".data-grid-error").html("");
                    $("#data-grid").append('<tbody class="data-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#data-grid_processing").css("display", "none");
                }
            },
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                info: "_START_-_END_ of _TOTAL_ entries",
                searchPlaceholder: "Search"
            }
        });
//        $("#myMainForm").submit(function () {
//            $("#myMainSubmit").attr("disabled", true);
//            console.log('<?= api_url ?>/?r=transaction&own=' + $("#own").val() + '&dateform=' + $("#dateform").val() + '&dateto=' + $("#dateto").val() + '&action=searchTicket');
//
//            return false;
//        });
    });

    function deleteSeries(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete Series?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
                function () {
                    $.post('<?= api_url ?>/?r=CSeries', {id: id, action: 'delete'}, function (data) {
                        console.log(data);
                        table.ajax.reload(null, false);
                        var json = JSON.parse(data);
                        $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

                    });

                });

    }
    function loadTicket(id)
    {
        console.log(id);
        $("#ticket").html("Loading.....");
        $.post("<?= api_url ?>/?r=reprintTicket", {game: id}, function (d) {
            var json = JSON.parse(d);
            $("#ticket").html(json.ticket);
        });
    }

</script>