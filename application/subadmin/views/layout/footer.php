<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Lottery v1.0
    </div>
    <!-- Default to the left -->
</footer>
</div>
<!-- ./wrapper -->

<script>
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
    $("document").ready(function () {
        report();
//        setInterval(function(){report();},2000);
        $("#myMainResultPer").submit(function () {
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
                xhr: function () {
                    $("#mainloadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#mainpro1").css('width', progressbar + '%');
                        $("#mainpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
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
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#mainpro1").css('width', '0%');
                    $("#mainpro1").html('0%');
                    $("#progress").hide();
                    report();
                },
                error: function (xhr, error, code)
                {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
    });

    function report() {
        $.post("<?= api_url ?>?r=CAddSubadmin", {userid: '<?= $_SESSION["userid"] ?>', action: "adminBalance"}, function (data) {
            console.log(data);
            var js = JSON.parse(data);
            $("#compaines").html(js[1]);
            $("#live").html(js[0]);
            $("#agent").html(js[2]);
            $("#exams").html(js[3]);
            $("#per").html(js[6] + "%(Max)");
            $("#widid").html(js[7]);
            $("#resultperMain").html(js[8]);

        });
    }
    function ResultServices(id)
    {
        $.post("<?= api_url ?>?r=CStartorStop", {cron: id}, function (data) {
            $("#center").html(data);
        });
    }
</script>
<script>
    function onLoading(id, i)
    {
        var load = "<div class=\"ph-item\">" +
                "<div class=\"ph-col-12\">" +
                "<div class=\"ph-picture\"></div>" +
                " <div class=\"ph-row\">" +
                "<div class=\"ph-col-6 big\"></div>" +
                "<div class=\"ph-col-4 empty big\"></div>" +
                "<div class=\"ph-col-2 big\"></div>" +
                "<div class=\"ph-col-4\"></div>" +
                "<div class=\"ph-col-8 empty\"></div>" +
                "<div class=\"ph-col-6\"></div>" +
                "<div class=\"ph-col-6 empty\"></div>" +
                "<div class=\"ph-col-12\"></div>" +
                "</div>" +
                " </div>" +
                "</div>";
        var l = "";
        for (var k = 0; k <= i; k++)
        {
            l = l + load;
        }

        $(id).html(l);
        report();
    }
    function offLoading(id) {
        $(id).html("");
    }

    function clickOnLink(url, display, condition)
    {
        onLoading(display, 1);
        $.post(url, {condition: condition}, function (data) {
            //console.log(data);
            offLoading(display);
            $(display).html(data);
            $("#app-msg").show();
            printMessage('/?r=CPrintMessage', "#app-msg");
            if (typeof (history.pushState) != "undefined") {
                var obj = {Title: "Title", Url: url};
                history.pushState(obj, obj.Title, obj.Url);
                //$.session.set("historyurl", "" + "?r=" + file + "1");
            } else {
                alert("Browser does not support HTML5.");
            }
            // history.pushState(obj, obj.Title, obj.Url);
        });
        return false;
    }
    function printMessage(file, display)
    {
        $.post(file, {}, function (data) {
            $(display).html(data);
        });
    }
//    function clickOnLink(url, display, condition)
//    {
//        $.post(url, {condition: condition}, function (data) {
//            $(display).html(onLoading);
//            $(display).html(data);
//
//            window.history.pushState("object or string", "Title", url);
//        });
//        return false;
//    }

</script>

</body>
</html>
