
<html>

    <head>
        <!--<meta http-equiv="Content-Language" content="en-us">-->
        <!--<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">-->
        <title><?= company ?></title>
        <!--<script src="posjs/mygame.js"></script>-->

        <link rel="stylesheet" href="assets/yatara/css/main.css" type="text/css">
        <style>
            html, body {
                margin: 0px;
                padding: 0px;
                height: 100% !important;
                width: 100% !important;

            }
            
/*            input[type="textbox"],tdqty,tdamt,label{
                width: 100% !important;
                height: 100% !important;
            }*/
        </style>
    </head>
    <!--onload="load_frm();-->
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" onload="load_frm();">
        <div >
            <table border="1" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="7%" rowspan="2" align=center><img class="img-board" src="<?= image ?>" border="5" align=middle></td>
                                <td class="tdtitle" id="gname" width="14%"><?= company ?></td><td class="tdtitle"></td>
                                <td class="tdtitle">
                                    <table border="0" width="100%">
                                        <tr>
                                            <td class="tdtitle" id="agentdet" >
                                            </td>
                                            <td class="tdtitle" id="currtime">&nbsp;</td>
                                            <td class="tdtitleright"><a href="javascript:void(0)" onclick="game_click()"><input type="button" value="Back" class="buttonback"></a>&nbsp;&nbsp;&nbsp; <a href="/?r=logout"><input type="button" class="buttonlogout" value="Logout"></a></td>
                                        </tr>
                                    </table>
                                </td></tr>
                            <tr>
                                <td width="14%" class="tdtime" id="lastdraw">00:00 AM</td>
                                <td width="79%" valign="bottom" class="tdorange" colspan="2">
                                    <table border="0" width="100%">
                                        <tr>
                                            <td>
                                                <a href="/?r=report"><button class="bottombtn" id="btnbg1" style="background-color: gold;width:125px;">Accounts</button></a>
                                                &nbsp;
                                                <!--                                                <a href="/?r=counterReport"><button class="bottombtn" id="btnbg1" style="background-color: gold;width:125px;">Ctr. Accounts</button></a>
                                                                                                &nbsp;-->
                                                <button class="bottombtn" id="btnbg1" style="background-color: gold;width:155px;" onclick="changepasswordform()">Password</button>
                                                &nbsp;
                                                <button class="bottombtn" id="btnbets" style="background-color: gold;">TrDetails</button>
                                                &nbsp;
                                                <button class="bottombtn" id="btnbg0" style="background-color: gold;" onclick="reprintlist();">Reprint</button>
                                                &nbsp;
                                                <button class="bottombtn" id="btncan" style="background-color: gold;" onclick="canlist();">Cancel</button>
                                                &nbsp;<a href="/?r=result"><button class="bottombtn" id="btnbg0" style="background-color: gold;width:125px">Results</button></a>

                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" width="100%">
                                        <tr><td class="tdr0" id="res0">0000</td><td class="tdr1" id="res1">0100</td><td class="tdr2" id="res2">0200</td>
                                            <td class="tdr3" id="res3">0300</td><td class="tdr4" id="res4">0400</td><td class="tdr5" id="res5">0500</td>
                                            <td class="tdr6" id="res6">0600</td><td class="tdr7" id="res7">0700</td><td class="tdr8" id="res8">0800</td>
                                            <td class="tdr9" id="res9">0900</td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td>
                                                <table border="0" width="100%" cellspacing="1">
                                                    <tr>
                                                        <td class="tdblack">Time To Draw</td>
                                                        <td class="tdorange">Dr. Time</td>
                                                        <td class="tdblack">Dr. Date</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="counter9" class="tdtimer"></td>
                                                        <td id="nextdraw" class="tdtimer"></td>
                                                        <td id="currdate" class="tdtimer">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table border="0" width="100%" cellspacing="1">
                                                    <tr>
                                                        <td class="tdorange" onclick="BalanceStart();">Balance Credit</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="creditlimit" class="tdtimer" onclick="BalanceStart();">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table border="0" width="100%">
                                                    <tr>
                                                        <td class="tdblack">Last Tr. No.</td>

                                                    </tr>
                                                    <tr>
                                                        <td id="lasttsn" class="tdtimer">NA</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table border="0" width="100%">
                                                    <tr>
                                                        <td class="tdblack">Last Tr. PT.</td>
                                                        <td class="tdblack" rowspan="2" class="tdtimer">		
                                                            <button class="bottombtn" id="btnadv" style="background-color: gold;width:150px;" onclick="adv_click();">Advance Draw</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="lasttamt" class="tdtimer">NA</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="90%">
                        <div id="gamepan">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="3">
                                        <table border="0" width="100%">
                                            <tr>
                                                <td class="tdseries">Series</td>
                                                <td colspan="2">
                                                    <table border="0" width="100%" cellpadding="2">
                                                        <tr>
                                                            <td class="tdaeoo">
                                                                <input type="checkbox" name="sall" id="sall" value="A"  onclick="seriesclickall();">&nbsp; 
                                                                <label for="sall">All&nbsp;</label> </td>
                                                            <td class="tdaeob">
                                                                <input type="checkbox" name="seven" id="seven"  value="E"  onclick="seriesclickeven();">&nbsp; 
                                                                <label for="seven"> Even</label></td>
                                                            <td class="tdaeop">
                                                                <input type="checkbox" name="sodd" id="sodd"  value="O" onclick="seriesclickodd();">&nbsp; 
                                                                <label for="sodd"> Odd&nbsp;</label> </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="7" class="tdmsg"  id="msggst">GST Number Issued by Government of India. "27AALG58098I1ZG"</td>
                                            </tr>
                                            <tr>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s0" id="s0" Checked value="0" onclick="seriesclick();"><label for="s0">&nbsp;&nbsp;0000-0999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s1" id="s1" value="1" onclick="seriesclick();"><label for="s1">&nbsp;&nbsp;1000-1999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s2" id="s2" value="2" onclick="seriesclick();"><label for="s2">&nbsp;&nbsp;2000-2999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s3" id="s3" value="3" onclick="seriesclick();"><label for="s3">&nbsp;&nbsp;3000-3999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s4" id="s4" value="4" onclick="seriesclick();"><label for="s4">&nbsp;&nbsp;4000-4999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s5" id="s5" value="5" onclick="seriesclick();"><label for="s5">&nbsp;&nbsp;5000-5999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s6" id="s6" value="6" onclick="seriesclick();"><label for="s6">&nbsp;&nbsp;6000-6999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s7" id="s7" value="7" onclick="seriesclick();"><label for="s7">&nbsp;&nbsp;7000-7999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s8" id="s8" value="8" onclick="seriesclick();"><label for="s8">&nbsp;&nbsp;8000-8999</label></td>
                                                <td class="tdorange" nowrap valign=top><input type="checkbox" name="s9" id="s9" value="9" onclick="seriesclick();"><label for="s9">&nbsp;&nbsp;9000-9999</label></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <table border="0" width="100%">
                                            <tr>
                                                <td class="tdhl" onclick="showhide('L', 'H');">High</td>
                                                <td class="tdhl" onclick="showhide('L', 'L');">Low</td>
                                                <td bgcolor="#FFFFFF">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td nowrap bgcolor="#FFFFFF">
                                        <table border="0" width="100%">
                                            <tr>
                                                <td class="tdaeogp" nowrap>
                                                    <input type="checkbox" name="cball" id="cball" Checked onclick="cball_Click();">&nbsp; 
                                                    <label for="cball">All&nbsp;</label> </td>
                                                <td class="tdaeogp" nowrap>
                                                    <input type="checkbox" name="cbeven" id="cbeven" onclick="cbeven_Click();">&nbsp; 
                                                    <label for="cbeven">Even</label></td>
                                                <td class="tdaeogp" nowrap>
                                                    <input type="checkbox" name="chodd" id="chodd" onclick="cbodd_Click();">&nbsp; 
                                                    <label for="chodd">Odd&nbsp; </label></td>
                                                <td align="right">
                                                    <input type="textbox" name="txtLuckyStone" id="txtLuckyStone" class="tbmp" size=5 maxlength="2">&nbsp;&nbsp; </td>
                                                <td class="tdorange" onclick="btnLuckyStone_Click()">LP</td>

                                            </tr>
                                        </table>
                                    </td>
                                    <td nowrap>
                                        <table border="0" width="100%" cellpadding="0">
                                            <tr>
                                                <td class="tdorange" nowrap>
                                                    <input type="checkbox" name="cbfp" id="cbfp" onclick="cbfp_Click();"> 
                                                    <label for="cbfp">FP</label></td>
                                                <td class="tdorange" id="shres" nowrap onclick="showhide('R', 'P');">Show Results</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <table border="0" width="100%" bgcolor="#FFFFFF">
                                            <tr>
                                                <td class="tdpupd" style="height: 35px" onclick="pageup()">Page Up(F8)</td>
                                                <td class="tdpupd" style="height: 35px" onclick="pagedown()">Page Down(F9)</td>
                                                <td class="tdaeogp" nowrap>
                                                    <input type="checkbox" name="cballlow" id="cballlow" onclick="cballlow_click();"><label for="cballlow">&nbsp; 
                                                        All&nbsp;</label> </td>					</tr>
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%">
                                                        <tr><td class="tdgw" id="lblleft0" onclick="leftset(0);">0000-0099</td></tr>
                                                        <tr><td class="tdgw" id="lblleft1" onclick="leftset(1);">0100-0199</td></tr>
                                                        <tr><td class="tdgw" id="lblleft2" onclick="leftset(2);">0200-0299</td></tr>
                                                        <tr><td class="tdgw" id="lblleft3" onclick="leftset(3);">0300-0399</td></tr>
                                                        <tr><td class="tdgw" id="lblleft4" onclick="leftset(4);">0400-0499</td></tr>
                                                        <tr><td class="tdgw" id="lblleft5" onclick="leftset(5);">0500-0599</td></tr>
                                                        <tr><td class="tdgw" id="lblleft6" onclick="leftset(6);">0600-0699</td></tr>
                                                        <tr><td class="tdgw" id="lblleft7" onclick="leftset(7);">0700-0799</td></tr>
                                                        <tr><td class="tdgw" id="lblleft8" onclick="leftset(8);">0800-0899</td></tr>
                                                        <tr><td class="tdgw" id="lblleft9" onclick="leftset(9);">0900-0999</td></tr>
                                                    </table>
                                                </td>
                                                <td colspan="2">
                                                    <div id="divhigh">
                                                        <table border="0" width="100%">
                                                            <tr><td class="tdg0">
                                                                    <input type="checkbox" name="cbhigh0" id="cbhigh0" value="0" onclick="cbhighall_click(0)"><label for="cbhigh0"> (Rs. 2 * 1)</label></td><td class="tdg0">
                                                                    180</td></tr>
                                                            <tr><td class="tdg1">
                                                                    <input type="checkbox" name="cbhigh1" id="cbhigh1" value="0" onclick="cbhighall_click(1)"><label for="cbhigh1"> (Rs. 2 * 1)</label></td><td class="tdg1">
                                                                    180</td></tr>
                                                            <tr><td class="tdg2">
                                                                    <input type="checkbox" name="cbhigh2" id="cbhigh2" value="0" onclick="cbhighall_click(2)"><label for="cbhigh2"> (Rs. 2 * 2)</label></td><td class="tdg2">
                                                                    360</td></tr>
                                                            <tr><td class="tdg3">
                                                                    <input type="checkbox" name="cbhigh3" id="cbhigh3" value="0" onclick="cbhighall_click(3)"><label for="cbhigh3"> (Rs. 2 * 3)</label></td><td class="tdg3">
                                                                    540</td></tr>
                                                            <tr><td class="tdg4">
                                                                    <input type="checkbox" name="cbhigh4" id="cbhigh4" value="0" onclick="cbhighall_click(4)"><label for="cbhigh4"> (Rs. 2 * 5)</label></td><td class="tdg4">
                                                                    900</td></tr>
                                                            <tr><td class="tdg5">
                                                                    <input type="checkbox" name="cbhigh5" id="cbhigh5" value="0" onclick="cbhighall_click(5)"><label for="cbhigh5"> (Rs. 2 * 5)</label></td><td class="tdg5">
                                                                    900</td></tr>
                                                            <tr><td class="tdg6">
                                                                    <input type="checkbox" name="cbhigh6" id="cbhigh6" value="0" onclick="cbhighall_click(6)"><label for="cbhigh6"> (Rs. 2 * 10)</label></td><td class="tdg6">
                                                                    1800</td></tr>
                                                            <tr><td class="tdg7">
                                                                    <input type="checkbox" name="cbhigh7" id="cbhigh7" value="0" onclick="cbhighall_click(7)"><label for="cbhigh7"> (Rs. 2 * 20)</label></td><td class="tdg7">
                                                                    3600</td></tr>
                                                            <tr><td class="tdg8">
                                                                    <input type="checkbox" name="cbhigh8" id="cbhigh8" value="0" onclick="cbhighall_click(8)"><label for="cbhigh8"> (Rs. 2 * 25)</label></td><td class="tdg8">
                                                                    4500</td></tr>
                                                            <tr><td class="tdg9">
                                                                    <input type="checkbox" name="cbhigh9" id="cbhigh9" value="0" onclick="cbhighall_click(9)"> <label for="cbhigh9">(Rs. 2 * 25)</label></td><td class="tdg9">
                                                                    4500</td></tr>
                                                        </table>
                                                    </div>

                                                    <div id="divlow">
                                                        <table border="0" width="100%">
                                                            <tr><td class="tdg0">
                                                                    <input type="checkbox" name="cblow0" id="cblow0" value="0" onclick="cblow0_Click(0)"><label for="cblow0" id="lbllow0">(Rs. 2)</label></td>
                                                                <td rowspan="10">
                                                                    <table border="1" width="100%" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table border="0" width="100%" cellspacing="0" cellpadding="5">
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="radio" id="rbmul1" name="rbmul1" value="V1" checked onclick="rbmulall_Click(1);"><label for="rbmul1">2.00</label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="radio" id="rbmul2" name="rbmul2" value="V1" onclick="rbmulall_Click(2);"><label for="rbmul2">4.00</label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="radio" id="rbmul5" name="rbmul5" value="V1" onclick="rbmulall_Click(5);"><label for="rbmul5">10.00</label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="radio" id="rbmul10" name="rbmul10" value="V1" onclick="rbmulall_Click(10);"><label for="rbmul10">20.00</label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="radio" id="rbmul20" name="rbmul20" value="V1" onclick="rbmulall_Click(20);"><label for="rbmul20">40.00</label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td></tr>
                                                            <tr><td class="tdg1">
                                                                    <input type="checkbox" name="cblow1" id="cblow1" value="0" onclick="cblow0_Click(1)"><label for="cblow1" id="lbllow1">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg2">
                                                                    <input type="checkbox" name="cblow2" id="cblow2" value="0" onclick="cblow0_Click(2)"><label for="cblow2" id="lbllow2">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg3">
                                                                    <input type="checkbox" name="cblow3" id="cblow3" value="0" onclick="cblow0_Click(3)"><label for="cblow3" id="lbllow3">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg4">
                                                                    <input type="checkbox" name="cblow4" id="cblow4" value="0" onclick="cblow0_Click(4)"><label for="cblow4" id="lbllow4">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg5">
                                                                    <input type="checkbox" name="cblow5" id="cblow5" value="0" onclick="cblow0_Click(5)"><label for="cblow5" id="lbllow5">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg6">
                                                                    <input type="checkbox" name="cblow6" id="cblow6" value="0" onclick="cblow0_Click(6)"><label for="cblow6" id="lbllow6">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg7">
                                                                    <input type="checkbox" name="cblow7" id="cblow7" value="0" onclick="cblow0_Click(7)"><label for="cblow7" id="lbllow7">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg8">
                                                                    <input type="checkbox" name="cblow8" id="cblow8" value="0" onclick="cblow0_Click(8)"><label for="cblow8" id="lbllow8">(Rs. 2)</label></td></tr>
                                                            <tr><td class="tdg9">
                                                                    <input type="checkbox" name="cblow9" id="cblow9" value="0" onclick="cblow0_Click(9)"><label for="cblow9" id="lbllow9">(Rs. 2)</label></td></tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td bgcolor="#FFFFFF">

                                        <table border="0" width="100%" cellspacing="0" bgcolor="#FFFFFF">
                                            <tr>
                                                <td class="gptd">All</td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv0" id="tbv0" class="tball" size=5 oninput="allvh(this,0,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 0);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv1" id="tbv1" class="tball" size=5 oninput="allvh(this,1,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 1);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv2" id="tbv2" class="tball" size=5 oninput="allvh(this,2,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 2);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv3" id="tbv3" class="tball" size=5 oninput="allvh(this,3,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 3);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv4" id="tbv4" class="tball" size=5 oninput="allvh(this,4,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 4);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv5" id="tbv5" class="tball" size=5 oninput="allvh(this,5,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 5);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv6" id="tbv6" class="tball" size=5 oninput="allvh(this,6,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 6);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv7" id="tbv7" class="tball" size=5 oninput="allvh(this,7,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 7);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv8" id="tbv8" class="tball" size=5 oninput="allvh(this,8,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 8);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbv9" id="tbv9" class="tball" size=5 oninput="allvh(this,9,'V');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmovev(window.event, 9);"></td>
                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl0">00</td>
                                                <td class="gptd" id="lbl1">01</td>
                                                <td class="gptd" id="lbl2">02</td>
                                                <td class="gptd" id="lbl3">03</td>
                                                <td class="gptd" id="lbl4">04</td>
                                                <td class="gptd" id="lbl5">05</td>
                                                <td class="gptd" id="lbl6">06</td>
                                                <td class="gptd" id="lbl7">07</td>
                                                <td class="gptd" id="lbl8">08</td>
                                                <td class="gptd" id="lbl9">09</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh0" id="tbh0" class="tball" size=5 oninput="allvh(this,0,'H');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmoveh(window.event, 0);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num0" id="num0" class="tbmp" size=5 oninput="calculateamtqty(this,0)" onfocus="myFunction(this, 'N', '00');" onblur="myFunctionrev(this, 'N', '00');" onkeydown="arrowmove(window.event, 0);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num1" id="num1" class="tbmp" size=5 oninput="calculateamtqty(this,1)" onfocus="myFunction(this, 'N', '01');" onblur="myFunctionrev(this, 'N', '01');" onkeydown="arrowmove(window.event, 1);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num2" id="num2" class="tbmp" size=5 oninput="calculateamtqty(this,2)" onfocus="myFunction(this, 'N', '02');" onblur="myFunctionrev(this, 'N', '02');" onkeydown="arrowmove(window.event, 2);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num3" id="num3" class="tbmp" size=5 oninput="calculateamtqty(this,3)" onfocus="myFunction(this, 'N', '03');" onblur="myFunctionrev(this, 'N', '03');" onkeydown="arrowmove(window.event, 3);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num4" id="num4" class="tbmp" size=5 oninput="calculateamtqty(this,4)" onfocus="myFunction(this, 'N', '04');" onblur="myFunctionrev(this, 'N', '04');" onkeydown="arrowmove(window.event, 4);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num5" id="num5" class="tbmp" size=5 oninput="calculateamtqty(this,5)" onfocus="myFunction(this, 'N', '05');" onblur="myFunctionrev(this, 'N', '05');" onkeydown="arrowmove(window.event, 5);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num6" id="num6" class="tbmp" size=5 oninput="calculateamtqty(this,6)" onfocus="myFunction(this, 'N', '06');" onblur="myFunctionrev(this, 'N', '06');" onkeydown="arrowmove(window.event, 6);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num7" id="num7" class="tbmp" size=5 oninput="calculateamtqty(this,7)" onfocus="myFunction(this, 'N', '07');" onblur="myFunctionrev(this, 'N', '07');" onkeydown="arrowmove(window.event, 7);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num8" id="num8" class="tbmp" size=5 oninput="calculateamtqty(this,8)" onfocus="myFunction(this, 'N', '08');" onblur="myFunctionrev(this, 'N', '08');" onkeydown="arrowmove(window.event, 8);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num9" id="num9" class="tbmp" size=5 oninput="calculateamtqty(this,9)" onfocus="myFunction(this, 'N', '09');" onblur="myFunctionrev(this, 'N', '09');" onkeydown="arrowmove(window.event, 9);"></td>
                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl10">10</td>
                                                <td class="gptd" id="lbl11">11</td>
                                                <td class="gptd" id="lbl12">12</td>
                                                <td class="gptd" id="lbl13">13</td>
                                                <td class="gptd" id="lbl14">14</td>
                                                <td class="gptd" id="lbl15">15</td>
                                                <td class="gptd" id="lbl16">16</td>
                                                <td class="gptd" id="lbl17">17</td>
                                                <td class="gptd" id="lbl18">18</td>
                                                <td class="gptd" id="lbl19">19</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh1" id="tbh1" class="tball" size=5 oninput="allvh(this,10,'H');"  onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmoveh(window.event, 1);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num10" id="num10" class="tbmp" size=5 oninput="calculateamtqty(this,10)" onfocus="myFunction(this, 'N', '10');" onblur="myFunctionrev(this, 'N', '10');" onkeydown="arrowmove(window.event, 10);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num11" id="num11" class="tbmp" size=5 oninput="calculateamtqty(this,11)" onfocus="myFunction(this, 'N', '11');" onblur="myFunctionrev(this, 'N', '11');" onkeydown="arrowmove(window.event, 11);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num12" id="num12" class="tbmp" size=5 oninput="calculateamtqty(this,12)" onfocus="myFunction(this, 'N', '12');" onblur="myFunctionrev(this, 'N', '12');" onkeydown="arrowmove(window.event, 12);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num13" id="num13" class="tbmp" size=5 oninput="calculateamtqty(this,13)" onfocus="myFunction(this, 'N', '13');" onblur="myFunctionrev(this, 'N', '13');" onkeydown="arrowmove(window.event, 13);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num14" id="num14" class="tbmp" size=5 oninput="calculateamtqty(this,14)" onfocus="myFunction(this, 'N', '14');" onblur="myFunctionrev(this, 'N', '14');" onkeydown="arrowmove(window.event, 14);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num15" id="num15" class="tbmp" size=5 oninput="calculateamtqty(this,15)" onfocus="myFunction(this, 'N', '15');" onblur="myFunctionrev(this, 'N', '15');" onkeydown="arrowmove(window.event, 15);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num16" id="num16" class="tbmp" size=5 oninput="calculateamtqty(this,16)" onfocus="myFunction(this, 'N', '16');" onblur="myFunctionrev(this, 'N', '16');" onkeydown="arrowmove(window.event, 16);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num17" id="num17" class="tbmp" size=5 oninput="calculateamtqty(this,17)" onfocus="myFunction(this, 'N', '17');" onblur="myFunctionrev(this, 'N', '17');" onkeydown="arrowmove(window.event, 17);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num18" id="num18" class="tbmp" size=5 oninput="calculateamtqty(this,18)" onfocus="myFunction(this, 'N', '18');" onblur="myFunctionrev(this, 'N', '18');" onkeydown="arrowmove(window.event, 18);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num19" id="num19" class="tbmp" size=5 oninput="calculateamtqty(this,19)" onfocus="myFunction(this, 'N', '19');" onblur="myFunctionrev(this, 'N', '19');" onkeydown="arrowmove(window.event, 19);"></td>
                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl20">20</td>
                                                <td class="gptd" id="lbl21">21</td>
                                                <td class="gptd" id="lbl22">22</td>
                                                <td class="gptd" id="lbl23">23</td>
                                                <td class="gptd" id="lbl24">24</td>
                                                <td class="gptd" id="lbl25">25</td>
                                                <td class="gptd" id="lbl26">26</td>
                                                <td class="gptd" id="lbl27">27</td>
                                                <td class="gptd" id="lbl28">28</td>
                                                <td class="gptd" id="lbl29">29</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh2" id="tbh2" class="tball" size=5 oninput="allvh(this,20,'H');"  onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');" onkeydown="arrowmoveh(window.event, 2);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num20" id="num20" class="tbmp" size=5 oninput="calculateamtqty(this,20)" onfocus="myFunction(this, 'N', '20');" onblur="myFunctionrev(this, 'N', '20');" onkeydown="arrowmove(window.event, 20);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num21" id="num21" class="tbmp" size=5 oninput="calculateamtqty(this,21)" onfocus="myFunction(this, 'N', '21');" onblur="myFunctionrev(this, 'N', '21');" onkeydown="arrowmove(window.event, 21);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num22" id="num22" class="tbmp" size=5 oninput="calculateamtqty(this,22)" onfocus="myFunction(this, 'N', '22');" onblur="myFunctionrev(this, 'N', '22');" onkeydown="arrowmove(window.event, 22);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num23" id="num23" class="tbmp" size=5 oninput="calculateamtqty(this,23)" onfocus="myFunction(this, 'N', '23');" onblur="myFunctionrev(this, 'N', '23');" onkeydown="arrowmove(window.event, 23);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num24" id="num24" class="tbmp" size=5 oninput="calculateamtqty(this,24)" onfocus="myFunction(this, 'N', '24');" onblur="myFunctionrev(this, 'N', '24');" onkeydown="arrowmove(window.event, 24);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num25" id="num25" class="tbmp" size=5 oninput="calculateamtqty(this,25)" onfocus="myFunction(this, 'N', '25');" onblur="myFunctionrev(this, 'N', '25');" onkeydown="arrowmove(window.event, 25);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num26" id="num26" class="tbmp" size=5 oninput="calculateamtqty(this,26)" onfocus="myFunction(this, 'N', '26');" onblur="myFunctionrev(this, 'N', '26');" onkeydown="arrowmove(window.event, 26);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num27" id="num27" class="tbmp" size=5 oninput="calculateamtqty(this,27)" onfocus="myFunction(this, 'N', '27');" onblur="myFunctionrev(this, 'N', '27');" onkeydown="arrowmove(window.event, 27);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num28" id="num28" class="tbmp" size=5 oninput="calculateamtqty(this,28)" onfocus="myFunction(this, 'N', '28');" onblur="myFunctionrev(this, 'N', '28');" onkeydown="arrowmove(window.event, 28);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num29" id="num29" class="tbmp" size=5 oninput="calculateamtqty(this,29)" onfocus="myFunction(this, 'N', '29');" onblur="myFunctionrev(this, 'N', '29');" onkeydown="arrowmove(window.event, 29);"></td>
                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl30">30</td>
                                                <td class="gptd" id="lbl31">31</td>
                                                <td class="gptd" id="lbl32">32</td>
                                                <td class="gptd" id="lbl33">33</td>
                                                <td class="gptd" id="lbl34">34</td>
                                                <td class="gptd" id="lbl35">35</td>
                                                <td class="gptd" id="lbl36">36</td>
                                                <td class="gptd" id="lbl37">37</td>
                                                <td class="gptd" id="lbl38">38</td>
                                                <td class="gptd" id="lbl39">39</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh3" id="tbh3" class="tball" size=5 oninput="allvh(this,30,'H');"  onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 3);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num30" id="num30" class="tbmp" size=5 oninput="calculateamtqty(this,30)" onfocus="myFunction(this, 'N', '30');" onblur="myFunctionrev(this, 'N', '30');" onkeydown="arrowmove(window.event, 30);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num31" id="num31" class="tbmp" size=5 oninput="calculateamtqty(this,31)" onfocus="myFunction(this, 'N', '31');" onblur="myFunctionrev(this, 'N', '31');" onkeydown="arrowmove(window.event, 31);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num32" id="num32" class="tbmp" size=5 oninput="calculateamtqty(this,32)" onfocus="myFunction(this, 'N', '32');" onblur="myFunctionrev(this, 'N', '32');" onkeydown="arrowmove(window.event, 32);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num33" id="num33" class="tbmp" size=5 oninput="calculateamtqty(this,33)" onfocus="myFunction(this, 'N', '33');" onblur="myFunctionrev(this, 'N', '33');" onkeydown="arrowmove(window.event, 33);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num34" id="num34" class="tbmp" size=5 oninput="calculateamtqty(this,34)" onfocus="myFunction(this, 'N', '34');" onblur="myFunctionrev(this, 'N', '34');" onkeydown="arrowmove(window.event, 34);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 maxlength=3 name="num35" id="num35" class="tbmp" size=5 oninput="calculateamtqty(this,35)" onfocus="myFunction(this, 'N', '35');" onblur="myFunctionrev(this, 'N', '35');" onkeydown="arrowmove(window.event, 35);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num36" id="num36" class="tbmp" size=5 oninput="calculateamtqty(this,36)" onfocus="myFunction(this, 'N', '36');" onblur="myFunctionrev(this, 'N', '36');" onkeydown="arrowmove(window.event, 36);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num37" id="num37" class="tbmp" size=5 oninput="calculateamtqty(this,37)" onfocus="myFunction(this, 'N', '37');" onblur="myFunctionrev(this, 'N', '37');" onkeydown="arrowmove(window.event, 37);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num38" id="num38" class="tbmp" size=5 oninput="calculateamtqty(this,38)" onfocus="myFunction(this, 'N', '38');" onblur="myFunctionrev(this, 'N', '38');" onkeydown="arrowmove(window.event, 38);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num39" id="num39" class="tbmp" size=5 oninput="calculateamtqty(this,39)" onfocus="myFunction(this, 'N', '39');" onblur="myFunctionrev(this, 'N', '39');" onkeydown="arrowmove(window.event, 39);"></td>

                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl40">40</td>
                                                <td class="gptd" id="lbl41">41</td>
                                                <td class="gptd" id="lbl42">42</td>
                                                <td class="gptd" id="lbl43">43</td>
                                                <td class="gptd" id="lbl44">44</td>
                                                <td class="gptd" id="lbl45">45</td>
                                                <td class="gptd" id="lbl46">46</td>
                                                <td class="gptd" id="lbl47">47</td>
                                                <td class="gptd" id="lbl48">48</td>
                                                <td class="gptd" id="lbl49">49</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh4" id="tbh4" class="tball" size=5 oninput="allvh(this,40,'H');"  onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 4);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num40" id="num40" class="tbmp" size=5 oninput="calculateamtqty(this,40)" onfocus="myFunction(this, 'N', '40');" onblur="myFunctionrev(this, 'N', '40');" onkeydown="arrowmove(window.event, 40);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num41" id="num41" class="tbmp" size=5 oninput="calculateamtqty(this,41)" onfocus="myFunction(this, 'N', '41');" onblur="myFunctionrev(this, 'N', '41');" onkeydown="arrowmove(window.event, 41);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num42" id="num42" class="tbmp" size=5 oninput="calculateamtqty(this,42)" onfocus="myFunction(this, 'N', '42');" onblur="myFunctionrev(this, 'N', '402');" onkeydown="arrowmove(window.event, 42);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num43" id="num43" class="tbmp" size=5 oninput="calculateamtqty(this,43)" onfocus="myFunction(this, 'N', '43');" onblur="myFunctionrev(this, 'N', '43');" onkeydown="arrowmove(window.event, 43);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num44" id="num44" class="tbmp" size=5 oninput="calculateamtqty(this,44)" onfocus="myFunction(this, 'N', '44');" onblur="myFunctionrev(this, 'N', '44');" onkeydown="arrowmove(window.event, 44);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num45" id="num45" class="tbmp" size=5 oninput="calculateamtqty(this,45)" onfocus="myFunction(this, 'N', '45');" onblur="myFunctionrev(this, 'N', '45');" onkeydown="arrowmove(window.event, 45);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num46" id="num46" class="tbmp" size=5 oninput="calculateamtqty(this,46)" onfocus="myFunction(this, 'N', '46');" onblur="myFunctionrev(this, 'N', '46');" onkeydown="arrowmove(window.event, 46);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num47" id="num47" class="tbmp" size=5 oninput="calculateamtqty(this,47)" onfocus="myFunction(this, 'N', '47');" onblur="myFunctionrev(this, 'N', '47');" onkeydown="arrowmove(window.event, 47);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num48" id="num48" class="tbmp" size=5 oninput="calculateamtqty(this,48)" onfocus="myFunction(this, 'N', '48');" onblur="myFunctionrev(this, 'N', '48');" onkeydown="arrowmove(window.event, 48);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num49" id="num49" class="tbmp" size=5 oninput="calculateamtqty(this,49)" onfocus="myFunction(this, 'N', '49');" onblur="myFunctionrev(this, 'N', '49');" onkeydown="arrowmove(window.event, 49);"></td>

                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl50">50</td>
                                                <td class="gptd" id="lbl51">51</td>
                                                <td class="gptd" id="lbl52">52</td>
                                                <td class="gptd" id="lbl53">53</td>
                                                <td class="gptd" id="lbl54">54</td>
                                                <td class="gptd" id="lbl55">55</td>
                                                <td class="gptd" id="lbl56">56</td>
                                                <td class="gptd" id="lbl57">57</td>
                                                <td class="gptd" id="lbl58">58</td>
                                                <td class="gptd" id="lbl59">59</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh5" id="tbh5" class="tball" size=5 oninput="allvh(this,50,'H');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 5);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num50" id="num50" class="tbmp" size=5 oninput="calculateamtqty(this,50)" onfocus="myFunction(this, 'N', '50');" onblur="myFunctionrev(this, 'N', '50');" onkeydown="arrowmove(window.event, 50);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num51" id="num51" class="tbmp" size=5 oninput="calculateamtqty(this,51)" onfocus="myFunction(this, 'N', '51');" onblur="myFunctionrev(this, 'N', '51');" onkeydown="arrowmove(window.event, 51);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num52" id="num52" class="tbmp" size=5 oninput="calculateamtqty(this,52)" onfocus="myFunction(this, 'N', '52');" onblur="myFunctionrev(this, 'N', '52');" onkeydown="arrowmove(window.event, 52);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num53" id="num53" class="tbmp" size=5 oninput="calculateamtqty(this,53)" onfocus="myFunction(this, 'N', '53');" onblur="myFunctionrev(this, 'N', '53');" onkeydown="arrowmove(window.event, 53);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num54" id="num54" class="tbmp" size=5 oninput="calculateamtqty(this,54)" onfocus="myFunction(this, 'N', '54');" onblur="myFunctionrev(this, 'N', '54');" onkeydown="arrowmove(window.event, 54);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num55" id="num55" class="tbmp" size=5 oninput="calculateamtqty(this,55)" onfocus="myFunction(this, 'N', '55');" onblur="myFunctionrev(this, 'N', '55');" onkeydown="arrowmove(window.event, 55);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num56" id="num56" class="tbmp" size=5 oninput="calculateamtqty(this,56)" onfocus="myFunction(this, 'N', '56');" onblur="myFunctionrev(this, 'N', '56');" onkeydown="arrowmove(window.event, 56);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num57" id="num57" class="tbmp" size=5 oninput="calculateamtqty(this,57)" onfocus="myFunction(this, 'N', '57');" onblur="myFunctionrev(this, 'N', '57');" onkeydown="arrowmove(window.event, 57);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num58" id="num58" class="tbmp" size=5 oninput="calculateamtqty(this,58)" onfocus="myFunction(this, 'N', '58');" onblur="myFunctionrev(this, 'N', '58');" onkeydown="arrowmove(window.event, 58);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num59" id="num59" class="tbmp" size=5 oninput="calculateamtqty(this,59)" onfocus="myFunction(this, 'N', '59');" onblur="myFunctionrev(this, 'N', '59');" onkeydown="arrowmove(window.event, 59);"></td>

                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl60">60</td>
                                                <td class="gptd" id="lbl61">61</td>
                                                <td class="gptd" id="lbl62">62</td>
                                                <td class="gptd" id="lbl63">63</td>
                                                <td class="gptd" id="lbl64">64</td>
                                                <td class="gptd" id="lbl65">65</td>
                                                <td class="gptd" id="lbl66">66</td>
                                                <td class="gptd" id="lbl67">67</td>
                                                <td class="gptd" id="lbl68">68</td>
                                                <td class="gptd" id="lbl69">69</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh6" id="tbh6" class="tball" size=5 oninput="allvh(this,60,'H');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 6);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num60" id="num60" class="tbmp" size=5 oninput="calculateamtqty(this,60)" onfocus="myFunction(this, 'N', '60');" onblur="myFunctionrev(this, 'N', '60');" onkeydown="arrowmove(window.event, 60);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num61" id="num61" class="tbmp" size=5 oninput="calculateamtqty(this,61)" onfocus="myFunction(this, 'N', '61');" onblur="myFunctionrev(this, 'N', '61');" onkeydown="arrowmove(window.event, 61);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num62" id="num62" class="tbmp" size=5 oninput="calculateamtqty(this,62)" onfocus="myFunction(this, 'N', '62');" onblur="myFunctionrev(this, 'N', '62');" onkeydown="arrowmove(window.event, 62);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num63" id="num63" class="tbmp" size=5 oninput="calculateamtqty(this,63)" onfocus="myFunction(this, 'N', '63');" onblur="myFunctionrev(this, 'N', '63');" onkeydown="arrowmove(window.event, 63);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num64" id="num64" class="tbmp" size=5 oninput="calculateamtqty(this,64)" onfocus="myFunction(this, 'N', '64');" onblur="myFunctionrev(this, 'N', '64');" onkeydown="arrowmove(window.event, 64);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num65" id="num65" class="tbmp" size=5 oninput="calculateamtqty(this,65)" onfocus="myFunction(this, 'N', '65');" onblur="myFunctionrev(this, 'N', '65');" onkeydown="arrowmove(window.event, 65);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num66" id="num66" class="tbmp" size=5 oninput="calculateamtqty(this,66)" onfocus="myFunction(this, 'N', '66');" onblur="myFunctionrev(this, 'N', '66');" onkeydown="arrowmove(window.event, 66);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num67" id="num67" class="tbmp" size=5 oninput="calculateamtqty(this,67)" onfocus="myFunction(this, 'N', '67');" onblur="myFunctionrev(this, 'N', '67');" onkeydown="arrowmove(window.event, 67);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num68" id="num68" class="tbmp" size=5 oninput="calculateamtqty(this,68)" onfocus="myFunction(this, 'N', '68');" onblur="myFunctionrev(this, 'N', '68');" onkeydown="arrowmove(window.event, 68);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num69" id="num69" class="tbmp" size=5 oninput="calculateamtqty(this,69)" onfocus="myFunction(this, 'N', '69');" onblur="myFunctionrev(this, 'N', '69');" onkeydown="arrowmove(window.event, 69);"></td>

                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl70">70</td>
                                                <td class="gptd" id="lbl71">71</td>
                                                <td class="gptd" id="lbl72">72</td>
                                                <td class="gptd" id="lbl73">73</td>
                                                <td class="gptd" id="lbl74">74</td>
                                                <td class="gptd" id="lbl75">75</td>
                                                <td class="gptd" id="lbl76">76</td>
                                                <td class="gptd" id="lbl77">77</td>
                                                <td class="gptd" id="lbl78">78</td>
                                                <td class="gptd" id="lbl79">79</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh7" id="tbh7" class="tball" size=5 oninput="allvh(this,70,'H');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 7);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num70" id="num70" class="tbmp" size=5 oninput="calculateamtqty(this,70)" onfocus="myFunction(this, 'N', '70');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 70);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num71" id="num71" class="tbmp" size=5 oninput="calculateamtqty(this,71)" onfocus="myFunction(this, 'N', '71');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 71);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num72" id="num72" class="tbmp" size=5 oninput="calculateamtqty(this,72)" onfocus="myFunction(this, 'N', '72');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 72);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num73" id="num73" class="tbmp" size=5 oninput="calculateamtqty(this,73)" onfocus="myFunction(this, 'N', '73');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 73);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num74" id="num74" class="tbmp" size=5 oninput="calculateamtqty(this,74)" onfocus="myFunction(this, 'N', '74');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 74);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num75" id="num75" class="tbmp" size=5 oninput="calculateamtqty(this,75)" onfocus="myFunction(this, 'N', '75');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 75);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num76" id="num76" class="tbmp" size=5 oninput="calculateamtqty(this,76)" onfocus="myFunction(this, 'N', '76');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 76);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num77" id="num77" class="tbmp" size=5 oninput="calculateamtqty(this,77)" onfocus="myFunction(this, 'N', '77');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 77);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num78" id="num78" class="tbmp" size=5 oninput="calculateamtqty(this,78)" onfocus="myFunction(this, 'N', '78');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 78);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num79" id="num79" class="tbmp" size=5 oninput="calculateamtqty(this,79)" onfocus="myFunction(this, 'N', '79');" onblur="myFunctionrev(this, 'N');" onkeydown="arrowmove(window.event, 79);"></td>

                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl80">80</td>
                                                <td class="gptd" id="lbl81">81</td>
                                                <td class="gptd" id="lbl82">82</td>
                                                <td class="gptd" id="lbl83">83</td>
                                                <td class="gptd" id="lbl84">84</td>
                                                <td class="gptd" id="lbl85">85</td>
                                                <td class="gptd" id="lbl86">86</td>
                                                <td class="gptd" id="lbl87">87</td>
                                                <td class="gptd" id="lbl88">88</td>
                                                <td class="gptd" id="lbl89">89</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh8" id="tbh8" class="tball" size=5 oninput="allvh(this,80,'H');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 8);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num80" id="num80" class="tbmp" size=5 oninput="calculateamtqty(this,80)" onfocus="myFunction(this, 'N', '80');" onblur="myFunctionrev(this, 'N', '80');" onkeydown="arrowmove(window.event, 80);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num81" id="num81" class="tbmp" size=5 oninput="calculateamtqty(this,81)" onfocus="myFunction(this, 'N', '81');" onblur="myFunctionrev(this, 'N', '81');" onkeydown="arrowmove(window.event, 81);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num82" id="num82" class="tbmp" size=5 oninput="calculateamtqty(this,82)" onfocus="myFunction(this, 'N', '82');" onblur="myFunctionrev(this, 'N', '82');" onkeydown="arrowmove(window.event, 82);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num83" id="num83" class="tbmp" size=5 oninput="calculateamtqty(this,83)" onfocus="myFunction(this, 'N', '83');" onblur="myFunctionrev(this, 'N', '83');" onkeydown="arrowmove(window.event, 83);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num84" id="num84" class="tbmp" size=5 oninput="calculateamtqty(this,84)" onfocus="myFunction(this, 'N', '84');" onblur="myFunctionrev(this, 'N', '84');" onkeydown="arrowmove(window.event, 84);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num85" id="num85" class="tbmp" size=5 oninput="calculateamtqty(this,85)" onfocus="myFunction(this, 'N', '85');" onblur="myFunctionrev(this, 'N', '85');" onkeydown="arrowmove(window.event, 85);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num86" id="num86" class="tbmp" size=5 oninput="calculateamtqty(this,86)" onfocus="myFunction(this, 'N', '86');" onblur="myFunctionrev(this, 'N', '86');" onkeydown="arrowmove(window.event, 86);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num87" id="num87" class="tbmp" size=5 oninput="calculateamtqty(this,87)" onfocus="myFunction(this, 'N', '87');" onblur="myFunctionrev(this, 'N', '87');" onkeydown="arrowmove(window.event, 87);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num88" id="num88" class="tbmp" size=5 oninput="calculateamtqty(this,88)" onfocus="myFunction(this, 'N', '88');" onblur="myFunctionrev(this, 'N', '88');" onkeydown="arrowmove(window.event, 88);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num89" id="num89" class="tbmp" size=5 oninput="calculateamtqty(this,89)" onfocus="myFunction(this, 'N', '89');" onblur="myFunctionrev(this, 'N', '89');" onkeydown="arrowmove(window.event, 89);"></td>

                                            </tr>
                                            <tr>
                                                <td class="gptd">&nbsp;</td>
                                                <td class="gptd" id="lbl90">90</td>
                                                <td class="gptd" id="lbl91">91</td>
                                                <td class="gptd" id="lbl92">92</td>
                                                <td class="gptd" id="lbl93">93</td>
                                                <td class="gptd" id="lbl94">94</td>
                                                <td class="gptd" id="lbl95">95</td>
                                                <td class="gptd" id="lbl96">96</td>
                                                <td class="gptd" id="lbl97">97</td>
                                                <td class="gptd" id="lbl98">98</td>
                                                <td class="gptd" id="lbl99">99</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="tbh9" id="tbh9" class="tball" size=5 oninput="allvh(this,90,'H');" onfocus="myFunction(this, 'A');" onblur="myFunctionrev(this, 'A');"  onkeydown="arrowmoveh(window.event, 9);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num90" id="num90" class="tbmp" size=5 oninput="calculateamtqty(this,90)" onfocus="myFunction(this, 'N', '90');" onblur="myFunctionrev(this, 'N', '90');" onkeydown="arrowmove(window.event, 90);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num91" id="num91" class="tbmp" size=5 oninput="calculateamtqty(this,91)" onfocus="myFunction(this, 'N', '91');" onblur="myFunctionrev(this, 'N', '91');" onkeydown="arrowmove(window.event, 91);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num92" id="num92" class="tbmp" size=5 oninput="calculateamtqty(this,92)" onfocus="myFunction(this, 'N', '92');" onblur="myFunctionrev(this, 'N', '92');" onkeydown="arrowmove(window.event, 92);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num93" id="num93" class="tbmp" size=5 oninput="calculateamtqty(this,93)" onfocus="myFunction(this, 'N', '93');" onblur="myFunctionrev(this, 'N', '93');" onkeydown="arrowmove(window.event, 93);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num94" id="num94" class="tbmp" size=5 oninput="calculateamtqty(this,94)" onfocus="myFunction(this, 'N', '94');" onblur="myFunctionrev(this, 'N', '94');" onkeydown="arrowmove(window.event, 94);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num95" id="num95" class="tbmp" size=5 oninput="calculateamtqty(this,95)" onfocus="myFunction(this, 'N', '95');" onblur="myFunctionrev(this, 'N', '95');" onkeydown="arrowmove(window.event, 95);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num96" id="num96" class="tbmp" size=5 oninput="calculateamtqty(this,96)" onfocus="myFunction(this, 'N', '96');" onblur="myFunctionrev(this, 'N', '96');" onkeydown="arrowmove(window.event, 96);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num97" id="num97" class="tbmp" size=5 oninput="calculateamtqty(this,97)" onfocus="myFunction(this, 'N', '97');" onblur="myFunctionrev(this, 'N', '97');" onkeydown="arrowmove(window.event, 97);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num98" id="num98" class="tbmp" size=5 oninput="calculateamtqty(this,98)" onfocus="myFunction(this, 'N', '98');" onblur="myFunctionrev(this, 'N', '98');" onkeydown="arrowmove(window.event, 98);"></td>
                                                <td align="center">
                                                    <input type="textbox" maxlength=3 name="num99" id="num99" class="tbmp" size=5 oninput="calculateamtqty(this,99)" onfocus="myFunction(this, 'N', '99');" onblur="myFunctionrev(this, 'N', '99');" onkeydown="arrowmove(window.event, 99);"></td>

                                            </tr>
                                        </table>

                                    </td>
                                    <td valign="top" nowrap><div id="qtyamt">
                                            <table border="0" width="100%" height="100%" cellspacing="6">
                                                <tr>
                                                    <td class="tdqahead">QTY</td>
                                                    <td class="tdqahead">POINTS</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqa">&nbsp;</td>
                                                    <td class="tdamt" id="tbaa">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqb">&nbsp;</td>
                                                    <td class="tdamt" id="tbab">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqc">&nbsp;</td>
                                                    <td class="tdamt" id="tbac">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqd">&nbsp;</td>
                                                    <td class="tdamt" id="tbad">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqe">&nbsp;</td>
                                                    <td class="tdamt" id="tbae">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqf">&nbsp;</td>
                                                    <td class="tdamt" id="tbaf">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqg">&nbsp;</td>
                                                    <td class="tdamt" id="tbag">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqh">&nbsp;</td>
                                                    <td class="tdamt" id="tbah">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqi">&nbsp;</td>
                                                    <td class="tdamt" id="tbai">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="tdqty" id="tbqj">&nbsp;</td>
                                                    <td class="tdamt" id="tbaj">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div id="resdiv">
                                            <table border="0" width="100%">
                                                <tr><td class="tdtime" id="lastdrawr"></td></tr>
                                                <tr><td class="tdr0" id="rres0">0099</td></tr>
                                                <tr><td class="tdr1" id="rres1">0199</td></tr>
                                                <tr><td class="tdr2" id="rres2">0299</td></tr>
                                                <tr><td class="tdr3" id="rres3">0399</td></tr>
                                                <tr><td class="tdr4" id="rres4">0499</td></tr>
                                                <tr><td class="tdr5" id="rres5">0599</td></tr>
                                                <tr><td class="tdr6" id="rres6">0699</td></tr>
                                                <tr><td class="tdr7" id="rres7">0799</td></tr>
                                                <tr><td class="tdr8" id="rres8">0899</td></tr>
                                                <tr><td class="tdr9" id="rres9">0999</td></tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="advpan">
                            <table width="100%" border="0"><tr><td align="center"><table width="80%"></table></td></tr></table>
                        </div>
                    </td>
                </tr>
                <tr>

                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>

                                <td style="width:480px;">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td>
                                                <button class="tdseries" id="btnbg0" style=" width: 105px; height: 30px; margin-top:2px;" onclick="betreg();">Print (F6)</button>

                                            </td>
                                            <td>
                                                <button class="bottombtn" id="btnbg0" style="background-color: red;color: white;height: 30px; " onclick="btnlow_Click();">Clear</button>

                                            </td>
                                            <td>
                                                <input type="text" placeholder="F7 Scan Barcode Here" class="bottombtn" onkeyup="getClime(event)" id="scancode" name="scancode" style="background-color: white;width:auto; height: 30px;">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td  class="tdmsg2" id="msg" style="margin-left:5px;">
                                    MSG
                                </td>
                                <td style="position:relative ;width: 230px;">
                                    <table border="0" width="100%" cellspacing="6">
                                        <tr>
                                            <td class="tdqty" style="background-color: gold;" id="tblcqty">&nbsp;</td>
                                            <td class="tdamt" style="background-color: gold;" id="tblcamt">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    <marquee bgcolor="#000000">
        <div id="spannews" class="newsdv">

        </div>
    </marquee>


    <!--Bet Details modal-->
    <div id="modal">
        <div id="modal-content">
            <div class="modalr-header">
                <span class="close" id="close-m">&nbsp;Close&nbsp;</span>
            </div>
            <div class="modalr-body">
                <span id="betspan"></span>
            </div>
        </div>
    </div>
    <!--Bet Details modal ends here-->
    <style>

        /* The claim (background) */
        .claim {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* claim Content */
        .claim-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }



        #claim-msg{
            font-size: 25px;
            text-align: center;
            font-weight: bolder;
            color:red;
        }
    </style>
    <!-- Trigger/Open The claim -->
    <!--<button id="myBtn">Open claim</button>-->

    <!-- The claim -->
    <div id="myClaim" class="claim">

        <!-- claim content -->
        <div class="claim-content">
            <span class="close" id="close-btn" onclick="closebtn()">&times;</span>
            <p id="claim-msg"></p>
            <div id="claim-msg2"></div>

        </div>

    </div>

    <script>
        // Get the claim
        var claim = document.getElementById("myClaim");

        // Get the button that opens the claim
//        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the claim
        var span_close = document.getElementById("close-btn");

        // When the user clicks the button, open the claim 
//        btn.onclick = function () {
//            claim.style.display = "block";
//        };

        // When the user clicks on <span> (x), close the claim
        function closebtn() {

            claim.style.display = "none";
            document.getElementById("claim-msg").innerHTML = "";
        }

        // When the user clicks anywhere outside of the claim, close it

    </script>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("btncan");

        // Get the No btn element that closes the modal
        var btnno = document.getElementById("btnno");

        // Get the No btn element that closes the modal
        var btnyes = document.getElementById("btnyes");

        // Get the <span> element that closes the modal
        var span = document.getElementById("closec");

        // When the user clicks the button, open the modal 

        // When the user clicks on <span> (x), close the modal


        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            //alert(event.target);
            if (event.target == modal) {
                modal.style.display = "none";
            }

            if (event.target == modal1) {
                modal1.style.display = "none";
            }

            if (event.target == claim) {
                claim.style.display = "none";
                document.getElementById("claim-msg").innerHTML = "";
            }


        }

        document.onkeypress = function (e) {
            e = e || window.event;
            // use e.keyCode
            if (e.keyCode == 32) {
                claim.style.display = "none";
                document.getElementById("claim-msg").innerHTML = "";
                document.getElementById("claim-msg2").innerHTML = "";
            }

        };


        //bet details js

        var modal1 = document.getElementById('modal');

        var btn1 = document.getElementById("btnbets");

        var span1 = document.getElementById("close-m");

        btn1.onclick = function () {
            //alert("hi1");
            if (inflag == "true")
            {
                funclastbet1();
                modal1.style.display = "block";
            } else
            {
                document.getElementById("msg").innerHTML = "Please Login For Bet Details..";
                msgctr = 8;

            }

        };

        span1.onclick = function () {
            modal1.style.display = "none";
        };





        //bet detail js ends



        var api_url = "<?= api_url ?>";
        var userid = "<?= $_SESSION["userid"] ?>";
        var id = "<?= $_SESSION["id"] ?>";
        var company = "<?= company ?>";
        var image = api_url + "<?= image ?>";


        function getClime(event) {
            event.preventDefault();
            document.getElementById("claim-msg").innerHTML = "";
            document.getElementById("claim-msg2").innerHTML = "";
            if (event.keyCode == 13) {
                var barcode = document.getElementById("scancode").value;

                claminBet(barcode);
//                console.log(JSON.stringify({"id": barcode.trim(), "userid": userid,"key":event.keyCode}));
            }
        }
        function claminBet(barcode) {
            document.getElementById("claim-msg2").innerHTML = "";
            var jsonData2;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText != "false") {
                        //                        console.log(this.responseText);
                        var jsonData = JSON.parse(this.responseText);
                        var data;
                        if (jsonData.status === "1") {
                            document.getElementById("msg").innerHTML = jsonData.message;
                            document.getElementById("claim-msg").innerHTML = jsonData.message;
                            claim.style.display = "block";
                            document.getElementById("scancode").value = "";
                            jsonData2 = JSON.parse(this.responseText);
                            jsonData2 = JSON.parse(this.responseText);
                            if (jsonData2["0"]["recip"] != null) {
                                data = "<br>" + jsonData2["0"]["recip"];
                                document.getElementById("claim-msg2").innerHTML = data;
//                                    claim.style.display = "block";
                            }

//                                printWinRecipt(this.responseText);
                        } else {
                            document.getElementById("msg").innerHTML = jsonData.message;
                            document.getElementById("claim-msg").innerHTML = jsonData.message;
                            claim.style.display = "block";
                            document.getElementById("scancode").value = "";
                            jsonData2 = JSON.parse(this.responseText);
                            if (jsonData2["0"]["recip"] != null) {
                                data = "<br>" + jsonData2["0"]["recip"];
                                document.getElementById("claim-msg2").innerHTML = data;
                                // claim.style.display = "block";
                            }

                        }

                        updateBalance();
                    }
                }
            };
            xhttp.open("POST", api_url + "/?r=checkWinner", true);
            xhttp.setRequestHeader("Content-type", "application/json");
            xhttp.send(JSON.stringify({"id": barcode.trim(), "userid": userid}));

        }
    </script>

    <!--<script src="assets/yatara/gb.js" type="text/javascript"></script>-->
    <script src="assets/yatara/main.js" type="text/javascript"></script>
    <script src="assets/yatara/render.js" type="text/javascript"></script>
</body>

</html>