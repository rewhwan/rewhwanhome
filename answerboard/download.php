<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/rewhwanhome/db/db_connector.php";
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한없음!');history.go(-1);</script>";
  exit;
}
$row=$file_name_0=$file_copied_0=$file_type_0="";

if(isset($_GET["mode"])&&$_GET["mode"]=="download"){
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($con, $num);

    //등록된사용자가 최근 입력한 다운로드게시판을 보여주기 위하여 num 찾아서 전달하기 위함이다.
    $sql="SELECT * from `answerboard` where num ='$q_num';";
    $result = mysqli_query($con,$sql);
    if (!$result) {
      alert_back('Error: 1' . mysqli_error($con));
      // die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $file_name_0=$row['file_name_0'];
    $file_copied_0=$row['file_copied_0'];
    $file_type_0=$row['file_type_0'];
    mysqli_close($con);
}

// 1. 테이블에서 파일명이 있는지 점검


if(empty($file_copied_0)|| $file_type_0 =="image"){
    alert_back(' 테이블에 파일명이 존재하지 않거나 이미지 파일입니다.!');
}
$file_path = "./data/$file_copied_0";

    //$_SERVER['HTTP_USER_AGENT'] : 웹브라우저 정보 가져옴
    //preg_match(data, target): target에서 data정보가 찾아라
    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
            strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    //IE인경우 한글파일명이 깨지는 경우를 방지하기 위한 코드 
    if( $ie ){
         $file_name = iconv('utf-8', 'euc-kr', $file_name_0);
    }

    if( file_exists($file_path) )
    { 
      $fp = fopen($file_path,"rb"); 
      Header("Content-type: application/x-msdownload"); 
      Header("Content-Length: ".filesize($file_path));     
      Header("Content-Disposition: attachment; filename=".$file_name_0);   
      Header("Content-Transfer-Encoding: binary"); 
      Header("Content-Description: File Transfer"); 
      Header("Expires: 0");       
    } 
	
    if(!fpassthru($fp)) 
		fclose($fp); 
?>
