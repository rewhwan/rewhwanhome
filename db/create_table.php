<?php
function create_table($con, $table_name)
{
    $flag = false;
    $sql = "show tables from sample";
    $result = mysqli_query($con, $sql) or die('Error:' . mysqli_error($con));

    //반복문을 통해서 레코드셋에서 한 레코드씩 가져와서 첫번째 필드내용을 조사해서 해당테이블이 있는지 확인한다.
    while ($row = mysqli_fetch_row($result)) {
        if ($row[0] === "$table_name") {
            $flag = true;
            break;
        }
    }

    //테이블 명이 없으면 해당된 테이블명을 찾아서 테이블 쿼리문을 작성한다.
    if ($flag === false) {
        switch ($table_name) {
            case 'message':
                $sql = "CREATE TABLE `message` (
                        `num` int(11) NOT NULL AUTO_INCREMENT,
                        `send_id` char(20) NOT NULL,
                        `rv_id` char(20) NOT NULL,
                        `subject` char(200) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20) DEFAULT NULL,
                        PRIMARY KEY (`num`)
                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    ";
                break;

            case 'board':
                $sql = "CREATE TABLE `board` (
                      `num` int(11) NOT NULL AUTO_INCREMENT,
                      `id` char(15) NOT NULL,
                      `name` char(10) NOT NULL,
                      `subject` char(200) NOT NULL,
                      `content` text NOT NULL,
                      `regist_day` char(20) NOT NULL,
                      `hit` int(11) NOT NULL,
                      `file_name` char(40) DEFAULT NULL,
                      `file_type` char(40) DEFAULT NULL,
                      `file_copied` char(40) DEFAULT NULL,
                      PRIMARY KEY (`num`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    ";
                break;

            case 'answerboard' :
                $sql = "CREATE TABLE `answerboard` (
                        `num` int(11) NOT NULL AUTO_INCREMENT,
                        `id` char(15) NOT NULL,
                        `name` char(10) NOT NULL,
                        `nick` char(10) NOT NULL,
                        `subject` varchar(100) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20) DEFAULT NULL,
                        `hit` int(11) DEFAULT NULL,
                        `is_html` char(1) DEFAULT NULL,
                        `file_name_0` char(40) DEFAULT NULL,
                        `file_copied_0` char(30) DEFAULT NULL,
                        `file_type_0` char(30) DEFAULT NULL,
                        PRIMARY KEY (`num`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                break;

            case 'answerboard_ripple' :
                $sql = "CREATE TABLE `answerboard_ripple` (
                        `num` int(11) NOT NULL AUTO_INCREMENT,
                        `parent` int(11) NOT NULL,
                        `id` char(15) NOT NULL,
                        `name` char(10) NOT NULL,
                        `nick` char(10) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20) DEFAULT NULL,
                        PRIMARY KEY (`num`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                break;

            case 'imgboard' :
                $sql = "CREATE TABLE `imgboard` (
                        `num` int(11) NOT NULL AUTO_INCREMENT,
                        `id` char(15) NOT NULL,
                        `name` char(10) NOT NULL,
                        `nick` char(10) NOT NULL,
                        `subject` varchar(100) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20) DEFAULT NULL,
                        `hit` int(11) DEFAULT NULL,
                        `is_html` char(1) DEFAULT NULL,
                        `file_name_0` char(40) DEFAULT NULL,
                        `file_copied_0` char(30) DEFAULT NULL,
                        `file_type_0` char(30) DEFAULT NULL,
                        PRIMARY KEY (`num`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                break;

            case 'imgboard_ripple' :
                $sql = "CREATE TABLE `imgboard_ripple` (
                        `num` int(11) NOT NULL AUTO_INCREMENT,
                        `parent` int(11) NOT NULL,
                        `id` char(15) NOT NULL,
                        `name` char(10) NOT NULL,
                        `nick` char(10) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20) DEFAULT NULL,
                        PRIMARY KEY (`num`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                break;

            default:
                echo "<script>alert('해당테이블 명이 없습니다.');</script>";
                break;

        } //end switch
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('{$table_name}테이블이 생성되었습니다.');</script>";
        } else {
            echo "테이블 생성 실패 : " . mysqli_error($con);
        }
    } //end if $flag
}
