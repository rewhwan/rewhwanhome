<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판 글 수정하기</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/board/css/board.css">
        <script src="./js/board.js"></script>

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
            <div id="board_box">
                <h3 id="board_title">
                    게시판 > 글 수정하기
                </h3>
                <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
                $num = $_GET["num"];
                $page = $_GET["page"];

                $sql = "select * from board where num=$num";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                $name = $row["name"];
                $subject = $row["subject"];
                $content = $row["content"];
                $file_name = $row["file_name"];
                ?>
                <form name="board_form" method="post" action="del_mode.php?num=<?= $num ?>&page=<?= $page ?>"
                      enctype="multipart/form-data">
                    <input type="hidden" name="mode" value="modify">
                    <ul id="board_form">
                        <li>
                            <span class="col1">이름 : </span>
                            <span class="col2"><?= $name ?></span>
                        </li>
                        <li>
                            <span class="col1">제목 : </span>
                            <span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
                        </li>
                        <li id="text_area">
                            <span class="col1">내용 : </span>
                            <span class="col2">
	    				<textarea name="content"><?= $content ?></textarea>
	    			</span>
                        </li>
                        <li>
                            <span class="col1"> 첨부 파일 : </span>
                            <span class="col2"><input type="file" name="upfile" onchange="check_delete(this)"></span>
                        </li>
                        <?php
                            if(isset($file_name) && $file_name != ''){
                        ?>
                        <li>
                            <span class="col1"> 이전 첨부 파일 : </span>
                            <span class="col2">
                                <?= $file_name ?>
                                <label for='delete'><input type='checkbox' id='delete' name='delete' value='true'>첨부파일 삭제</label>
                            </span>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                    <ul class="buttons">
                        <li>
                            <button type="button" onclick="check_input()">수정하기</button>
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
