<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/myhome/db/db_connector.php";
    session_start();
    $userid = $_SESSION["userid"];

    $sql = "delete from members where id = '$userid'";

    $value = mysqli_query($con, $sql);

    if ($value) {
        unset($_SESSION["userid"]);
        unset($_SESSION["username"]);
        unset($_SESSION["userlevel"]);
        unset($_SESSION["userpoint"]);
        mysqli_close($con);

        echo "<script>alert('삭제성공')</script>";

    } else {
        echo "<script>alert('삭제오류'); history.go(-1);</script>";
    }

    echo "<script>
            location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/rewhwanhome/';
            </script>";
?>