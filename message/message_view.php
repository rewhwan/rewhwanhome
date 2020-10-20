<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>송신 쪽지 보기</title>
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/css/common.css">
        <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/rewhwanhome/message/css/message.css">

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
            <div id="message_box">
                <h3 class="title">
                    <?php
                    $mode = $_GET["mode"];
                    $num = $_GET["num"];

                    include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
//                    $con = mysqli_connect("localhost:3306", "root", "12345678", "sample");
                    $sql = "select * from message where num=$num";
                    $result = mysqli_query($con, $sql);

                    $row = mysqli_fetch_array($result);
                    $send_id = $row["send_id"];
                    $rv_id = $row["rv_id"];
                    $regist_day = $row["regist_day"];
                    $subject = $row["subject"];
                    $content = $row["content"];

                    $content = str_replace(" ", "&nbsp;", $content);
                    $content = str_replace("\n", "<br>", $content);

                    if ($mode == "send")
                        $result2 = mysqli_query($con, "select name from members where id='$rv_id'");
                    else
                        $result2 = mysqli_query($con, "select name from members where id='$send_id'");

                    $record = mysqli_fetch_array($result2);
                    $msg_name = $record["name"];

                    if ($mode == "send")
                        echo "송신 쪽지함 > 내용보기";
                    else
                        echo "수신 쪽지함 > 내용보기";
                    ?>
                </h3>
                <ul id="view_content">
                    <li>
                        <span class="col1"><b>제목 :</b> <?= $subject ?></span>
                        <span class="col2"><?= $msg_name ?> | <?= $regist_day ?></span>
                    </li>
                    <li>
                        <?= $content ?>
                    </li>
                </ul>
                <ul class="buttons">
                    <li>
                        <button onclick="location.href='message_box.php?mode=rv'">수신 쪽지함</button>
                    </li>
                    <li>
                        <button onclick="location.href='message_box.php?mode=send'">송신 쪽지함</button>
                    </li>
                    <?php
                        if ($mode == "rv") {
                            echo "<li><button onclick=\"location.href='message_response_form.php?num={$num}'\">답변 쪽지</button></li>";
                        }else {
                            echo "<li><button onclick=\"location.href='message_modify_form.php?num={$num}'\">쪽지 수정</button></li>";
                        }
                    ?>

                    <li>
                        <button onclick="location.href='message_delete.php?num=<?= $num ?>&mode=<?= $mode ?>'">삭제</button>
                    </li>
                </ul>
            </div> <!-- message_box -->
        </section>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/footer.php"; ?>
        </footer>
    </body>
</html>
