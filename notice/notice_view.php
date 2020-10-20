<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>공지사항 관람</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/notice/css/notice.css">

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
            <div id="notice_box">
                <h3 class="title">
                    공지사항 > 내용보기
                </h3>
                <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
                $num = $_GET["num"];
                $page = $_GET["page"];

//                $con = mysqli_connect("localhost", "user1", "12345", "sample");
                $sql = "select * from notice where num=$num";
                $result = mysqli_query($con, $sql);

                $row = mysqli_fetch_array($result);
                $id = $row["id"];
                $name = $row["name"];
                $regist_day = $row["regist_day"];
                $subject = $row["subject"];
                $content = $row["content"];
                $file_name = $row["file_name"];
                $file_type = $row["file_type"];
                $file_copied = $row["file_copied"];
                $hit = $row["hit"];

                $content = str_replace(" ", "&nbsp;", $content);
                $content = str_replace("\n", "<br>", $content);

                $new_hit = $hit + 1;
                $sql = "update notice set hit=$new_hit where num=$num";
                mysqli_query($con, $sql);
                ?>
                <ul id="view_content">
                    <li>
                        <span class="col1"><b>제목 :</b> <?= $subject ?></span>
                        <span class="col2"><?= $name ?> | <?= $regist_day ?></span>
                    </li>
                    <li>
                        <?php
                        if ($file_name) {
                            $real_name = $file_copied;
                            $file_path = "./data/" . $real_name;
                            $file_size = filesize($file_path);

                            echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='notice_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
                        }
                        ?>
                        <?= $content ?>
                    </li>
                </ul>
                <ul class="buttons">
                    <li>
                        <button onclick="location.href='notice_list.php?page=<?= $page ?>'">목록</button>
                    </li>
                    <?php
                    if($userlevel == 1) {
                    ?>
                    <li>
                        <button onclick="location.href='notice_modify_form.php?num=<?= $num ?>&page=<?= $page ?>'">수정</button>
                    </li>
                    <li>
                        <button onclick="location.href='notice_delete.php?num=<?= $num ?>&page=<?= $page ?>'">삭제</button>
                    </li>
                    <li>
                        <button onclick="location.href='notice_form.php'">글쓰기</button>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div> <!-- notice_box -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>
