<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>쪽지 보내기</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/message/css/message.css">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/message/js/message.js"></script>

        <!--Jquery 및 자바스크립트 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-1.10.2.min.js"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/main.js"></script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/header.php"; ?>
        </header>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/create_table.php";

        create_table($con, 'message');

        if (!$userid) {
            echo("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
            exit;
        }
        ?>
        <section>
            <div id="message_box">
                <h3 id="write_title">
                    쪽지 보내기
                </h3>
                <ul class="top_buttons">
                    <li><span><a href="message_box.php?mode=rv">수신 쪽지함 </a></span></li>
                    <li><span><a href="message_box.php?mode=send">송신 쪽지함</a></span></li>
                </ul>
                <form name="message_form" method="post" action="message_insert.php?send_id=<?= $userid ?>">
                    <div id="write_msg">
                        <ul>
                            <li>
                                <span class="col1">보내는 사람 : </span>
                                <span class="col2"><?= $userid ?></span>
                                <input type="text" name="send_id" hidden value="<?= $userid ?>">
                            </li>
                            <li>
                                <span class="col1">수신 아이디 : </span>
                                <span class="col2"><input name="rv_id" type="text"></span>
                            </li>
                            <li>
                                <span class="col1">제목 : </span>
                                <span class="col2"><input name="subject" type="text"></span>
                            </li>
                            <li id="text_area">
                                <span class="col1">내용 : </span>
                                <span class="col2">
	    				<textarea name="content"></textarea>
	    			</span>
                            </li>
                        </ul>
                        <button type="button" onclick="check_input()">보내기</button>
                    </div>
                </form>
            </div> <!-- message_box -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>
