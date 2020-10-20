<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>회원가입</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/member/css/member.css">
        <script type="text/javascript" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/member/js/member.js"></script>

        <!--Jquery 및 자바스크립트 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-1.10.2.min.js"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/main.js"></script>

    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/header.php"; ?>
        </header>

        <section>
            <div id="main_content">
                <div id="join_box">

                    <form name="member_form" method="post" action="member_insert.php">
                        <h2>회원 가입</h2>
                        <hr>

                        <div class="form">
                            <ul>
                                <li>
                                    <p for="id">아이디</p>
                                    <input type="text" name="id">
                                    <a href="#"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/img/check_id.gif"
                                                     onclick="check_id()"></a>
                                </li>

                                <li>
                                    <p for="password">비밀번호</p>
                                    <input type="password" name="pass">
                                </li>

                                <li>
                                    <p for="password_ck">비밀번호 확인</p>
                                    <input type="password" name="pass_confirm">
                                </li>
                                <li>
                                    <p for="name">이름</p>
                                    <input type="text" name="name">
                                </li>
                                <li>
                                    <p for="e-mail">이메일</p>
                                    <input type="text" name="email1">@<input type="text" name="email2">
                                </li>
                                <li>
                                    <hr>
                                </li>
                                <li>
                                    <img style="cursor:pointer" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/img/button_save.gif" onclick="check_input()">&nbsp;
                                    <img id="reset_button" style="cursor:pointer" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/img/button_reset.gif"
                                         onclick="reset_form()">
                                </li>
                            </ul>
                        </div>

                    </form>

                </div> <!-- join_box -->
            </div> <!-- main_content -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>

