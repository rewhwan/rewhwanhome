<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('로그인을 한 이후에 이용이 가능합니다.');history.go(-1);</script>";
    exit;
}

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

if (isset($_POST["mode"]) && $_POST["mode"] == "insert") {
    $content = trim($_POST["content"]);
    $subject = trim($_POST["subject"]);
    if (empty($content) || empty($subject)) {
        alert_back('1. 내용이나제목입력요망!');
    }
    $subject = test_input($_POST["subject"]);
    $content = test_input($_POST["content"]);
    $userid = test_input($userid);
    $hit = 0;
    $is_html = (!isset($_POST["is_html"])) ? ('n') : ('y');
    $q_subject = mysqli_real_escape_string($con, $subject);
    $q_content = mysqli_real_escape_string($con, $content);
    $q_userid = mysqli_real_escape_string($con, $userid);
    $regist_day = date("Y-m-d (H:i)");

    //파일업로드기능
    //1. $_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
    $upfile = $_FILES['upfile'];//한개파일업로드정보(5가지정보배열로들어있음)
    $upfile_name = $_FILES['upfile']['name'];//f03.jpg
    $upfile_type = $_FILES['upfile']['type'];//image/gif  file/txt
    $upfile_tmp_name = $_FILES['upfile']['tmp_name'];
    $upfile_error = $_FILES['upfile']['error'];
    $upfile_size = $_FILES['upfile']['size'];

    //2. 파일명과 확장자를 구분해서 저장한다.
    $file = explode(".", $upfile_name); //파일명과 확장자구분에서 배열저장
    $file_name = $file[0];              //파일명
    $file_extension = $file[1];         //확장자

    //3.업로드될 폴더를 지정한다.
    $upload_dir = "./data/"; //업로드된파일을 저장하는장소지정

    //4.파일업로드가성공되었는지 점검한다. 성공:0 실패:1
    //파일명이 중복되지 않도록 임의파일명을 정한다.
    if (!$upfile_error) {
        $new_file_name = date("Y_m_d_H_i_s");
        $new_file_name = $new_file_name . "_" . "0";
        $copied_file_name = $new_file_name . "." . $file_extension;
        $uploaded_file = $upload_dir . $copied_file_name;
        // $uploaded_file = "./data/2019_04_22_15_09_30_0.jpg";
    }

    //5 업로드된 파일확장자를 체크한다.  "image/gif"
    $type = explode("/", $upfile_type);

    if ($type[0] == 'image') {
        switch ($type[1]) {
            case 'gif':
            case 'jpg':
            case 'png':
            case 'jpeg':
            case 'pjpeg':
                break;
            default:
                alert_back('3. gif jpg png 확장자가아닙니다.');
        }
        //6 업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
        if ($upfile_size > 2000000) {
            alert_back('2. 이미지파일사이즈가 2MB이상입니다.');
        }
    } else {
        //5 업로드된 파일사이즈(500kb)를 체크해서 넘어버리면 돌려보낸다.
        if ($upfile_size > 500000) {
            alert_back('2. 파일사이즈가 500KB이상입니다.');
        }
    }

    //7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.송
    if(isset($_FILES['upfile']) && $_FILES['upfile']['error'] != UPLOAD_ERR_NO_FILE) {
        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            alert_back('4. 서버 전송에러!!');
        }
        alert_back($upfile_tmp_name);
    }

    //8 파일의 실제명과 저장되는 명을 삽입한다.
    $sql = "INSERT INTO `answerboard` VALUES (null,'$q_userid','$username','','$q_subject','$q_content','$regist_day',0,'$is_html','$upfile_name','$copied_file_name','$type[0]');";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        alert_back('Error:5 ' . mysqli_error($con));
        // die('Error: ' . mysqli_error($con));
    }

    //등록된사용자가 최근 입력한 이미지게시판을 보여주기 위하여 num 찾아서 전달하기 위함이다.
    $sql = "SELECT num from `answerboard` where id ='$userid' order by num desc limit 1;";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        alert_back('Error: 6' . mysqli_error($con));
        // die('Error: ' . mysqli_error($con));
    }
    $row = mysqli_fetch_array($result);
    $num = $row['num'];
    mysqli_close($con);

    echo "<script>location.href='./view.php?num=$num&hit=$hit';</script>";

} else if (isset($_GET["mode"]) && $_GET["mode"] == "delete") {
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($con, $num);

    //삭제할 게시물의 이미지파일명을 가져와서 삭제한다.
    $sql = "SELECT `file_copied_0` from `answerboard` where num ='$q_num';";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        alert_back('Error: 6' . mysqli_error($con));
        // die('Error: ' . mysqli_error($con));
    }
    $row = mysqli_fetch_array($result);
    $file_copied_0 = $row['file_copied_0'];

    if (!empty($file_copied_0)) {
        unlink("./data/" . $file_copied_0);
    }

    $sql = "DELETE FROM `answerboard` WHERE num=$q_num";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }

    $sql = "DELETE FROM `answerboard_ripple` WHERE parent=$q_num";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }
    mysqli_close($con);

    echo "<script>location.href='./list.php';</script>";

} else if (isset($_POST["mode"]) && $_POST["mode"] == "update") {
    $content = trim($_POST["content"]);
    $subject = trim($_POST["subject"]);
    if (empty($content) || empty($subject)) {
        echo "<script>alert('내용이나제목입력요망!');history.go(-1);</script>";
        exit;
    }
    $subject = test_input($_POST["subject"]);
    $content = test_input($_POST["content"]);
    $userid = test_input($userid);
    $num = test_input($_POST["num"]);
    $hit = test_input($_POST["hit"]);
    $is_html = (isset($_POST["is_html"])) ? ('y') : ('n');
    $q_subject = mysqli_real_escape_string($con, $subject);
    $q_content = mysqli_real_escape_string($con, $content);
    $q_userid = mysqli_real_escape_string($con, $userid);
    $q_num = mysqli_real_escape_string($con, $num);
    $regist_day = date("Y-m-d (H:i)");

    //1번과 2번이 해당이 된다. 파일삭제만 체크한다..
    if (isset($_POST['del_file']) && $_POST['del_file'] == '1') {
        //삭제할 게시물의 이미지파일명을 가져와서 삭제한다.
        $sql = "SELECT `file_copied_0` from `answerboard` where num ='$q_num';";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            alert_back('Error: 6' . mysqli_error($con));
            // die('Error: ' . mysqli_error($con));
        }
        $row = mysqli_fetch_array($result);
        $file_copied_0 = $row['file_copied_0'];
        if (!empty($file_copied_0)) {
            unlink("./data/" . $file_copied_0);
        }

        $sql = "UPDATE `answerboard` SET `file_name_0`='', `file_copied_0` ='', `file_type_0` =''  WHERE `num`=$q_num;";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }

    }

    //1번과 2번 파일삭제신경쓰지 않고 업로드가 됬느냐? 안됐는냐?
    if (!empty($_FILES['upfile']['name'])) {
        //include 파일업로드기능
        include "./lib/file_upload.php";

        $sql = "UPDATE `answerboard` SET `file_name_0`= '$upfile_name', `file_copied_0` ='$copied_file_name', `file_type_0` ='$type[0]' WHERE `num`=$q_num;";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }
    }

    //3번 파일과 상관없이 무조건 내용중심으로 update한다.
    $sql = "UPDATE `answerboard` SET `subject`='$q_subject',`content`='$q_content',`regist_day`='$regist_day',`is_html` ='$is_html'  WHERE `num`=$q_num;";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }

    echo "<script>location.href='./view.php?num=$num&page=1&hit=$hit';</script>";

} else if (isset($_POST["mode"]) && $_POST["mode"] == "insert_ripple") {
    if (empty($_POST["ripple_content"])) {
        echo "<script>alert('내용입력요망!');history.go(-1);</script>";
        exit;
    }
    //"덧글을 다는사람은 로그인을 해야한다." 말한것이다.
    $userid = $_SESSION['userid'];
    $q_userid = mysqli_real_escape_string($con, $userid);
    $sql = "select * from members where id = '$q_userid'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }
    $rowcount = mysqli_num_rows($result);

    if (!$rowcount) {
        echo "<script>alert('없는 아이디!!');history.go(-1);</script>";
        exit;
    } else {
        $content = test_input($_POST["ripple_content"]);
        $page = test_input($_POST["page"]);
        $parent = test_input($_POST["parent"]);
        $hit = test_input($_POST["hit"]);
        $q_username = mysqli_real_escape_string($con, $_SESSION['username']);
        $q_content = mysqli_real_escape_string($con, $content);
        $q_parent = mysqli_real_escape_string($con, $parent);
        $regist_day = date("Y-m-d (H:i)");

        $sql = "INSERT INTO `answerboard_ripple` VALUES (null,'$q_parent','$q_userid','$q_username', '','$q_content','$regist_day')";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
        echo "<script>location.href='./view.php?num=$parent&page=$page&hit=$hit';</script>";
    }//end of if rowcount
} else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_ripple") {
    $page = test_input($_POST["page"]);
    $hit = test_input($_POST["hit"]);
    $num = test_input($_POST["num"]);
    $parent = test_input($_POST["parent"]);
    $q_num = mysqli_real_escape_string($con, $num);

    $sql = "DELETE FROM `answerboard_ripple` WHERE num={$q_num}";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }
    mysqli_close($con);
    echo "<script>location.href='./view.php?num=$parent&page=$page&hit=$hit';</script>";

}//end of if insert

?>
