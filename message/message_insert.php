<meta charset='utf-8'>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["send_id"])) {
        alert_back("send_id 값을 불러올수 없습니다.");
    }
    if (!isset($_POST["rv_id"])) {
        alert_back("rv_id 값을 불러올수 없습니다.");
    }
//	if (!isset($_POST["send_id"])) {
//		alert_back("로그인 후 이용해주세요.");
//	}
    if (!isset($_POST["subject"])) {
        alert_back("subject 값을 불러올수 없습니다.");
    }
    if (!isset($_POST["content"])) {
        alert_back("content 값을 불러올수 없습니다.");
    }
    $send_id = $_POST["send_id"];
    $rv_id = $_POST['rv_id'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];
} else {
    echo("
			<script>
			alert('Action 방식이 다릅니다! ');
			history.go(-1)
			</script>
			");
    exit;
}
test_input($subject);
test_input($content);

$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장


// $con = mysqli_connect("localhost", "user1", "12345", "sample");
//받는사람이 멤버 테이블에 실제로 존재하는지 점검
$sql = "select * from members where id='$rv_id'";
$result = mysqli_query($con, $sql);
//레코드셋에 객수를 체크해서 저장한다.
$num_record = mysqli_num_rows($result);

if ($num_record) {
    $sql = "insert into message (send_id, rv_id, subject, content,  regist_day) ";
    $sql .= "values('$send_id', '$rv_id', '$subject', '$content', '$regist_day')";
    mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
} else {
    echo("
			<script>
			alert('수신 아이디가 잘못 되었습니다!');
			history.go(-1)
			</script>
			");
    exit;
}

mysqli_close($con);                // DB 연결 끊기

echo "
	   <script>
	    location.href = 'message_box.php?mode=send';
	   </script>
	";
?>