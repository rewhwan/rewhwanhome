<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>로그인</title>
        <!--CSS 파일 추가-->
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/login/css/login.css">
        <!--스크립트 추가-->
        <script type="text/javascript" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/login/js/login.js"></script>
        <script type="text/javascript" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/main.js"></script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/header.php"; ?>
        </header>
        <section>
            </div>
            <div id="main_content">
                <div id="login_box">
                    <div id="login_title">
                        <span>로그인</span>
                    </div>
                    <div id="login_form">
                        <form name="login_form" method="post" action="login.php">
                            <ul>
                                <li><input type="text" id="id" name="id" placeholder="아이디"></li>
                                <li><input type="password" id="pass" name="pass" placeholder="비밀번호"></li>
                            </ul>
                            <div id="login_btn">
                                <a href="#"><img src="../img/login.png" onclick="check_input(event)"></a>
                            </div>
                        </form>
                    </div> <!-- login_form -->
                </div> <!-- login_box -->
            </div> <!-- main_content -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>

