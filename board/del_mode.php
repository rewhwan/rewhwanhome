<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT']."/rewhwanhome/db/db_connector.php";

    //로그인 되어 있는지를 사전에 체크
    if(!isset($_SESSION['userid'])) {
        echo "<script>alert('권한없음! 로그인을 먼저 해주세여.');history.go(-1);</script>";
        exit;
    }

    //아이디 이름 세션에서 정보 가져옴
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";

    if(isset($_POST['mode']) && $_POST['mode'] == 'insert') {

        //테이블이 없으면 생성해준다.
        include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/create_table.php";
        create_table($con, 'board');

        $subject = $_POST["subject"];
        $content = $_POST["content"];

        $subject = test_input($subject);
        $content = test_input($content);

        $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

        $upload_dir = "./data/";

        $upfile_name = $_FILES["upfile"]["name"];
        $upfile_tmp_name = $_FILES["upfile"]["tmp_name"]; //서버의 임시버퍼장치에 저장되어있다
        $upfile_type = $_FILES["upfile"]["type"];
        $upfile_size = $_FILES["upfile"]["size"];
        $upfile_error = $_FILES["upfile"]["error"];

        if ($upfile_name && !$upfile_error) {
            $file = explode(".", $upfile_name);
            $file_name = $file[0];
            $file_ext = $file[1];

            $new_file_name = date("Y_m_d_H_i_s");
            $new_file_name = $new_file_name . "_" . $file_name;
            $copied_file_name = $new_file_name . "." . $file_ext;
            $uploaded_file = $upload_dir . $copied_file_name;

            if ($upfile_size > 200000000) {
                echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(200MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
                exit;
            }

            if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
                echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
                exit;
            }
        } else {
            $upfile_name = "";
            $upfile_type = "";
            $copied_file_name = "";
        }

        $sql = "insert into board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
        $sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
        $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
        mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

        // 포인트 부여하기
        $point_up = 100;

        $sql = "select point from members where id='$userid'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $new_point = $row["point"] + $point_up;

        $sql = "update members set point=$new_point where id='$userid'";
        mysqli_query($con, $sql);
        mysqli_close($con);                // DB 연결 끊기

        echo "
	   <script>
	    location.href = 'board_list.php';
	   </script>
	    ";

    }else if(isset($_POST['mode']) && $_POST['mode'] == 'delete') {
        $num   = $_GET["num"];
        $page   = $_GET["page"];

        $sql = "select * from board where num = $num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $copied_name = $row["file_copied"];
        $id = $row['id'];

        if(!isset($_SESSION['userid']) || !($_SESSION['userid'] == $userid || $_SESSION['userlevel'] == 1)) {
            mysqli_close($con);
            alert_back("삭제 권한이 없습니다.");
        }

        if ($copied_name)
        {
            $file_path = "./data/".$copied_name;
            unlink($file_path);
        }

        $sql = "delete from board where num = $num";
        mysqli_query($con, $sql);
        mysqli_close($con);

        echo "
	     <script>
	         location.href = 'board_list.php?page=$page';
	     </script>
	   ";
    }else if(isset($_POST['mode']) && $_POST['mode'] == 'modify') {
        $num = $_GET["num"];
        $page = $_GET["page"];

        $subject = $_POST["subject"];
        $content = $_POST["content"];

        $sql = "select * from board where num = {$num}";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        if(!isset($_SESSION["userid"]) || ($_SESSION["userid"] != $row['id'] && $_SESSION['userlevel'] != 1)) {
            mysqli_close($con);
            alert_back("수정 권한이 없습니다.");
        }

        //이전 파일 삭제하기 위한 절차
        if(isset($_POST['delete'])) {
            $copied_name = $row["file_copied"];

            $file_path = "./data/".$copied_name;
            unlink($file_path);
        }

        //파일새로 등록
        $upload_dir = "./data/";

        $upfile_name	 = $_FILES["upfile"]["name"];
        $upfile_tmp_name = $_FILES["upfile"]["tmp_name"]; //서버의 임시버퍼장치에 저장되어있다
        $upfile_type     = $_FILES["upfile"]["type"];
        $upfile_size     = $_FILES["upfile"]["size"];
        $upfile_error    = $_FILES["upfile"]["error"];

        if((isset($_POST['delete']) && $_POST['delete'] == 'true') || ($upfile_name && !$upfile_error)) {
            if ($upfile_name && !$upfile_error)
            {
                $file = explode(".", $upfile_name);
                $file_name = $file[0];
                $file_ext  = $file[1];

                $new_file_name = date("Y_m_d_H_i_s");
                $new_file_name = $new_file_name."_".$file_name;
                $copied_file_name = $new_file_name.".".$file_ext;
                $uploaded_file = $upload_dir.$copied_file_name;

                if( $upfile_size  > 200000000 ) {
                    echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(200MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
                    exit;
                }

                if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
                {
                    echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
                    exit;
                }
            }else {
                $upfile_name      = "";
                $upfile_type      = "";
                $copied_file_name = "";
            }

            $sql = "update board set subject='$subject', content='$content', file_name='$upfile_name', file_type='$upfile_type', file_copied='$copied_file_name' ";
            $sql .= " where num=$num";
        }else {
            $sql = "update board set subject='$subject', content='$content' ";
            $sql .= " where num=$num";
        }

        mysqli_query($con, $sql);
        mysqli_close($con);

        echo "
	      <script>
	          location.href = 'board_view.php?page=$page&num=$num';
	      </script>
	  ";
    }

