<div align="center" class="body">
    <table border="0" width="80%">
        <tr>
            <td colspan="3" align="center" class="headgame1">
                <br>
                <img border="0" style="width: 100px; height:auto;" class="img" src="<?= image ?>" border=3><br>
                &nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="center" id="msg" class="headgame"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="tdorange">
                Change Password
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="center">
                <table border="0" cellpadding="10" cellspacing="0">
                    <tr>
                        <td align="right" class="headgame" style="float:right;">Old Password :</td>
                        <td><input type="password" id="opwd" autofocus name="opwd" size="20" tabindex="1" class="tb7"></td>
                    </tr>
                    <tr>
                        <td align="right"  class="headgame" style="float:right;">New Password :</td>
                        <td><input type="password" id="pwd" name="pwd" size="20" tabindex="2" class="tb7"></td>
                    </tr>
                    <tr>
                        <td align="right"  class="headgame" style="float:right;">Confirm Password :</td>
                        <td><input type="password" id="cpwd" name="cpwd" size="20" tabindex="2" class="tb7"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="<?= $_SESSION["userid"] ?>" name="userid" id="userid">
                            <button class="buttonred" style="width: 100%;" onclick='changePWD("<?= api_url ?>?r=ChangePassword");' tabindex="3">Change Password</button>
                        </td>
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

</div>