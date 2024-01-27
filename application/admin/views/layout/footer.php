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
    $(function () {
        report();
    });
//    var a = 32;
//    var b = 12;
//    console.log(check(a, b));
//    function check(a, b) {
//        if (a === 33) {
//            return true;
//        } else if (b === 33) {
//            return true;
//        } else if ((a + b) === 33) {
//            return true;
//        } else if ((a - b) === 33) {
//            return true;
//        } else {
//            return false;
//        }
//    }
    function report() {
        $.post("<?= api_url ?>?r=CAddUser", {action: "adminBalance"}, function (data) {
            console.log(data);
            var js = JSON.parse(data);
            $("#compaines").html(js[1]);
            $("#colleges").html(js[0]);
            $("#students").html(js[2]);
            $("#exams").html(js[3]);
            if (js[5] === "1") {
                $("#per").html(js[4] + "%(Max)/ ₹" + js[7] + "/-");
            } else {
                $("#per").html(js[4] + "%(Min)/ ₹" + js[7] + "/-");
            }
            $("#widid").html(js[6]);
        });
    }
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
