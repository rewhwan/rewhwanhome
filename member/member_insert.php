<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
    date_default_timezone_set("asia/seoul");
    $id   = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	$sql = "insert into members(id, pass, name, email, regist_day, level, point) ";
	$sql .= "values('$id', '$pass', '$name', '$email', '$regist_day', 9, 500)";

	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
    mysqli_close($con);     

    echo "
	      <script>
              location.href = 'http://".$_SERVER['HTTP_HOST']."/rewhwanhome/';
	      </script>
	  ";    //내가원하는 창으로 보내준다. 바로전으로 가는법 history.go(-2)
?>
