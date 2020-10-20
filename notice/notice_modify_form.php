<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>공지사항 수정</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/notice/css/notice.css">

        <!--Jquery 및 자바스크립트 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-1.10.2.min.js"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/js/main.js"></script>
        <script>
            function check_input() {
                if (!document.notice_form.subject.value) {
                    alert("제목을 입력하세요!");
                    document.notice_form.subject.focus();
                    return;
                }
                if (!document.notice_form.content.value) {
                    alert("내용을 입력하세요!");
                    document.notice_form.content.focus();
                    return;
                }
                document.notice_form.submit();
            }
        </script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/header.php"; ?>
        </header>
        <section>
            <div id="notice_box">
                <h3 id="notice_title">
                    공지사항 > 글 쓰기
                </h3>
                <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
                $num = $_GET["num"];
                $page = $_GET["page"];

                $sql = "select * from notice where num=$num";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                $name = $row["name"];
                $subject = $row["subject"];
                $content = $row["content"];
                $file_name = $row["file_name"];
                ?>
                <form name="notice_form" method="post" action="notice_modify.php?num=<?= $num ?>&page=<?= $page ?>"
                      enctype="multipart/form-data">
                    <ul id="notice_form">
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
                            <span class="col2"><?= $file_name ?></span>
                        </li>
                    </ul>
                    <ul class="buttons">
                        <li>
                            <button type="button" onclick="check_input()">수정하기</button>
                        </li>
                        <li>
                            <button type="button" onclick="location.href='notice_list.php'">목록</button>
                        </li>
                    </ul>
                </form>
            </div> <!-- notice_box -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>
