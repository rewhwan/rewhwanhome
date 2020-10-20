<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판 글쓰기</title>
        <script src="./js/board.js"></script>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/board/css/board.css">

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
            <?php
            if (!isset($_SESSION['userid'])) {
                echo "<script>alert('로그인을 먼저해주세요!'); history.go(-1);</script>";
                exit;
            }
            ?>
            <div id="board_box">
                <h3 id="board_title">
                    게시판 > 글 쓰기
                </h3>
                <!--파일을 전송할때는 엔코드타입 enctype attribute를 적어줘야한다.-->
                <form name="board_form" method="post" action="del_mode.php" enctype="multipart/form-data">
                    <input type="hidden" name="mode" value="insert">
                    <ul id="board_form">
                        <li>
                            <span class="col1">이름 : </span>
                            <span class="col2"><?= $username ?></span>
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
                        <li>
                            <span class="col1"> 첨부 파일</span>
                            <span class="col2"><input type="file" name="upfile"></span>
                        </li>
                    </ul>
                    <ul class="buttons">
                        <li>
                            <button type="button" onclick="check_input()">완료</button>
                        </li>
                        <li>
                            <button type="button" onclick="location.href='board_list.php'">목록</button>
                        </li>
                    </ul>
                </form>
            </div> <!-- board_box -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>
