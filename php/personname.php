<?php
session_start();
require_once ('dbconnection.php');
$link=db_connect();
$session_id=$_SESSION['username'];
$sql="select sex from all_student where stundentname='$session_id'";
$sex=mysqli_query($link,$sql);
$sql="select hometown from all_student where stundentname='$session_id'";
$town=mysqli_query($link,$sql);
$sql="select email from all_student where stundentname='$session_id'";
$email=mysqli_query($link,$sql);
$sql="select phonenumber from all_student where stundentname='$session_id'";
$phonenumber=mysqli_query($link,$sql);
$sql="select teachers from all_student where stundentname='$session_id'";
$teachers=mysqli_query($link,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教师端</title>
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/normalize/0/normalize.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <link href="../css/StudentStyle.css" rel="stylesheet" type="text/css" />
    <link href="../Script/jBox/Skins/Blue/jbox.css" rel="stylesheet" type="text/css" />
    <link href="../css/ks.css" rel="stylesheet" type="text/css" />
    <script src="../Script/jBox/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="../Script/jBox/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <script src="../Script/jBox/i18n/jquery.jBox-zh-CN.js" type="text/javascript"></script>
    <script src="../Script/Common.js" type="text/javascript"></script>
    <script src="../Script/Data.js" type="text/javascript"></script>
    <script type="text/javascript">
        $().ready(function () {
            setStudMsgHeadTabCheck();
            showUnreadSysMsgCount();
        });

        //我的信息头部选项卡
        function setStudMsgHeadTabCheck() {
            var currentUrl = window.location.href;
            currentUrl = currentUrl.toLowerCase();
            var asmhm = "";
            $("#ulStudMsgHeadTab li").each(function () {
                asmhm = $(this).find('a').attr("href").toLowerCase();
                if (currentUrl.indexOf(asmhm) > 0) {
                    $(this).find('a').attr("class", "tab1");
                    return;
                }
            });
        }

        //显示未读系统信息
        function showUnreadSysMsgCount() {
            var unreadSysMsgCount = "0";
            if (Number(unreadSysMsgCount) > 0) {
                $("#unreadSysMsgCount").html("(" + unreadSysMsgCount + ")");
            }
        }

        //退出
        function loginOut() {
            if (confirm("确定退出吗？")) {
                StudentLogin.loginOut(function (data) {
                    if (data == "true") {
                        window.location = "/Login.aspx";
                    }
                    else {
                        jBox.alert("退出失败！", "提示", new { buttons: { "确定": true} });
                    }
                });
            }
        }
        //更改报考类别
        function changeCateory(thisObj, id) {
            var oldCateoryId = $("#cateoryId").val();
            var cateoryId = "";
            if (id != null) {
                cateoryId = id;
            }
            else {
                cateoryId = thisObj.val();
            }
            var studentId = $("#studentId").val();
            if (cateoryId.length <= 0) {
                jBox.tip("报考类别不能为空！");
                if (id == null) {
                    thisObj.val(oldCateoryId);
                }
            }
            else {
                studentInfo.changeStudentCateory(cateoryId, function (data) {
                    var result = $.parseJSON(data);
                    if ((String(result.ok) == "true")) {
                        window.location.href = "/Index.aspx";
                    }
                    else {
                        jBox.tip(result.message);
                    }
                });
            }
        }
    </script>

    <script type="text/javascript">
        function submitMail() {
            var mtitle = "联系方式有修改";
            var html = "<div style='padding:10px;'><div style='width:65px; height:120px; float:left;'>修改的地方：</div><div style='width:250px; height:120px; float:left;'><textarea id='objeCont' name='objeCont' style='width:250px; height:105px;'></textarea></div></div>";

            var submit = function (v, h, f) {
                if (f.objeCont == '' || f.objeCont.length > 80) {
                    $.jBox.tip("请您输入有修改的地方，且不超过80个字！", 'error', { focusId: "objeCont" }); // 关闭设置 objeCont 为焦点
                    return false;
                }

                StudentCompain.insertCompain('', mtitle, 5, f.objeCont, function (data) {
                    var obj = $.parseJSON(data);
                    var resultObj = false;
                    if (obj.ok) {
                        $.jBox.tip("成功提交联系方式的修改邮件！");
                    }
                });
            };

            $.jBox(html, { title: "联系方式修改的邮件", submit: submit });
        }
    </script>
    <style>

        .cdlist{height: 435.82px;}
        .item{height: 20% !important; display: flex;align-items: center;justify-content: center}
        .item a{font-size: 1rem;}
    </style>
</head>
<body>
<!--贯穿群聊-->
<div class="top-nav">
    <div class="container clearf">
        <div class="fl">
            <a class="item" href="#">首页</a>
        </div>
        <div class="fr">
            <a class="item" href="#">我的收藏</a>
            <a class="item" href="#">登录</a>
            <a class="item" href="#">注册</a>
        </div>
    </div>
</div>
<div class="header clearf">
    <div class="container">
        <div class="col-2 logo">
            <img src="" alt="Logo">
        </div>
        <div class="col-5 search-bar">
            <label>
                <input type="text">
            </label>

            <button>搜索</button>
        </div>
        <div class="col-3 cart">
            <a class="item" href="#">已购课程</a>
        </div>
    </div>
</div>

<div class="page">
    <div class="box mtop">
        <div class="leftbox">
            <div class="l_nav2">
                <div class="ta1">
                    <strong>个人中心</strong>
                    <div class="leftbgbt">
                    </div>
                </div>
                <div class="cdlist">
                    <div class="item">
                        <a href="tc.html">我的信息</a></div>
                    <div class="item">
                        <a href="ClassInfo.aspx.html">班级信息</a>
                    </div>
                    <div class="item">
                        <a href="Letter.aspx.html">短信息</a></div>
                    <div class="item">
                        <a href="systemMsge.aspx.html">学院通知</a></div>
                    <div class="item">
                        <a href="Objection.aspx.html">我的异议</a></div>
                </div>
            </div>
        </div>

        <!--右侧的信息菜单-->
        <div class="rightbox">

            <h2 class="mbx">我的信息 &gt; 个人资料 &nbsp;&nbsp;&nbsp;</h2>
            <div class="morebt">


                <ul id="ulStudMsgHeadTab">
                    <li><a class="tab2" onclick="" href="tc.html">个人资料</a> </li>
                    <li><a class="tab2" onclick="" href="ClassInfo.aspx.html">班级信息</a></li>
                    <li><a class="tab2" onclick="" href="Letter.aspx.html">短信息</a></li>
                    <li><a class="tab2" onclick="" href="systemMsge.aspx.html">通知<span style="color:#ff0000; padding-left:5px;" id="unreadSysMsgCount"></span></a></li>
                    <li><a class="tab2" onclick="" href="Objection.aspx.html">我的异议</a></li>
                </ul>

            </div>

            <!--这里是右边的信息栏目-->
            <div class="cztable">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="right" width="80">姓名：</td>
                        <td>邹智&nbsp;</td>
                        <td align="right" width="90">身份证号码：</td>
                        <td>430181198612113330&nbsp;</td>

                        <td rowspan="9"><div align="center"><img id="pic_face"  height="160" width="120" src="../Images/Student/photo.jpg" style="padding:2px 2px 5px; border:1px #ddd solid;"></div>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">性别：</td>
                        <td>男&nbsp;</td>
                        <td align="right">考籍号：</td>
                        <td>910513201419&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">报考类别：</td>
                        <td>自考&nbsp;</td>
                        <td align="right">报考学校：</td>
                        <td>湖南大学&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">报考专业：</td>
                        <td>经济法学&nbsp;</td>
                        <td align="right">原专业：</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">报考层次：</td>
                        <td>专本同读&nbsp;</td>

                        <td align="right">注册批次：</td>
                        <td>2013秋&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">报名时间：</td>
                        <td>2013-08-16&nbsp;</td>
                        <td align="right">状态：</td>
                        <td>在读&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left">联系方式（如联系方式有变动请及时修改，以便能及时联系到你。谢谢！）</td>

                    </tr>
                    <tr>
                        <td align="right">手机号码：</td>
                        <td>15111141999</td>
                        <td align="right">第二联系号码：</td>
                        <td></td>

                    </tr>
                    <tr>
                        <td align="right">QQ:</td>
                        <td></td>
                        <td align="right">电子邮箱：</td>
                        <td></td>

                    </tr>
                    <tr>
                        <td align="right">联系地址：</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr align="center">
                        <td colspan="5" height="40">
                            <div align="center">

                                <input type="button" id="button2" value="联系方式有修改" onclick="submitMail()" class="input2" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
    <div class="footer">
        <p>
            广东外语外贸大学</p>
    </div>
</div>
</body>
</html>