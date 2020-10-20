<?php
    //1.DB 시간설정
    date_default_timezone_set("Asia/seoul");

    //2.DB connect or error(DB가 없으면 생성해준다.)
    $servername = "localhost:3306";
    $username = "root";
    $password = "12345678";
    $con = mysqli_connect($servername,$username,$password);

    if(!$con){
        die("connect faild".mysqli_connect_error());
    }

    //3.데이터 베이스 확인하기
    $database_flag = false;
    $sql = "show databases;";
    $result=mysqli_query($con,$sql) or die("Check error".mysqli_error($con));
    while($row=mysqli_fetch_array($result)){
        if($row["Database"]=="sample"){
            $database_flag = true;
        break;
        }
    }

    //4.데이타베이스 없으면 만들기
    if($database_flag === false){
        $sql = "create database sample";
        $value = mysqli_query($con,$sql) or die("Create error".mysqli_error($con));
        if($value === true){
            echo "<script> alert('create sample db.'); </script>";
        }
    }

    //5.데이터베이스 접속하기
    $dbcon = mysqli_select_db($con,"sample") or die("Conect error".mysqli_error($con));
    if(!$dbcon){
        echo "<script> alert('select sample db error.'); </script>";
    }

    function alert_back($message){
        echo ("
			<script>
			alert('$message');
			history.go(-1)
			</script>
			");
    }

    function test_input($data){
        $data = stripslashes($data);
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>