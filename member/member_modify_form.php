<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>회원 정보수정</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css"
              href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/member/css/member.css">
        <script type="text/javascript"
                src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/member/js/member_modify.js"></script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/header.php"; ?>
        </header>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
        $sql = "select * from members where id='$userid'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $pass = $row["pass"];
        $name = $row["name"];

        $email = explode("@", $row["email"]);
        $email1 = $email[0];
        $email2 = $email[1];

        mysqli_close($con);
        ?>
        <section>
            <div id="main_content">
                <div id="join_box">
                    <form name="member_form" method="post" action="member_modify.php">
                        <h2>회원 정보수정</h2>
                        <div class="form id">
                            <div class="col1">아이디</div>
                            <div class="col2">
                                <input type="hidden" name="id" value="<?= $userid ?>">
                                <?= $userid ?>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div class="form">
                            <div class="col1">비밀번호</div>
                            <div class="col2">
                                <input type="password" name="pass" value="<?= $pass ?>">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form">
                            <div class="col1">비밀번호 확인</div>
                            <div class="col2">
                                <input type="password" name="pass_confirm" value="<?= $pass ?>">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form">
                            <div class="col1">이름</div>
                            <div class="col2">
                                <input type="text" name="name" value="<?= $name ?>">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form email">
                            <div class="col1">이메일</div>
                            <div class="col2">
                                <input type="text" name="email1" value="<?= $email1 ?>">@
                                <input type="text" name="email2" value="<?= $email2 ?>">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="bottom_line"></div>
                        <div class="buttons">
                            <img style="cursor:pointer" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/img/button_save.gif" onclick="check_input()">&nbsp;
                            <img id="reset_button" style="cursor:pointer" src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/img/button_reset.gif"
                                 onclick="reset_form()">
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

