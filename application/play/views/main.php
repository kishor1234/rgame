<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Language" content="en-us">
        <title><?= company ?> - Play and Win</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="assets/plugins/jquery/jquery.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="assets/yatara/css/main.css" type="text/css">
        <style>
            .center{
                margin: 0px 20px;
                width: 80%;

            }
            .img {
                width: 40%;
                height: auto;
            }
        </style>
    </head>
    <body class="body" onload="onload();">
        <div align="center">
            <table border="0" width="40%">
                <tr>
                    <td colspan="3" align="center" class="headgame1">
                        <br>
                        <img border="0" class="img" src="<?= image ?>" border=3><br>
                        &nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" align="center" id="msg" class="headgame"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="tdorange">
                        <?= company ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center">
                        <table border="0" cellpadding="10" cellspacing="0">
                            <tr>
                                <td align="right" class="headgame">Login Id :</td>
                                <td><input type="text" id="uname" autofocus name="uname" size="20" tabindex="1" value="<?=$_SESSION["uname"]?>" class="tb7"></td>
                            </tr>
                            <tr>
                                <td align="right"  class="headgame">Password :</td>
                                <td><input type="password" id="passwd" name="passwd" size="20" tabindex="2" class="tb7"></td>
                            </tr>
                            <tr>
                            <input type="hidden" value="web" id="device">
                            <td><button class="buttonred" onclick='loadlogin("<?= api_url ?>?r=gamelogin");' tabindex="3">Login</button></td>
                            <td><button class="buttonred" style="width: 100%;" onclick='quit();' tabindex="4">Quit (Ctrl+Q)</button></td>
                </tr>
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" class="headgame1"><br>
            Only For Amusement</td>
    </tr>
</table>

<table style="width:100%; bottom: 0;left: 0;right: 0; position: fixed; margin-bottom: 50px; ">
    <tr>
        <td><button class="buttonred center" onclick='quit();' tabindex="5">Disconnect</button></td>

        <td><button class="buttonred center" onclick='quit();' tabindex="6">Shutdown</button></td>

        <td><button class="buttonred center" onclick='quit();' tabindex="7">Restart</button></td>

    </tr>
</table>



</div>

<script src="assets/yatara/login.js" type="text/javascript"></script>
<script src="assets/yatara/loginrender.js" type="text/javascript"></script>
</body>
</html>