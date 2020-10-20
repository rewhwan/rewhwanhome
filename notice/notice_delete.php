<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
    $num   = $_GET["num"];
    $page   = $_GET["page"];

    $sql = "select * from notice where num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];

	if ($copied_name)
	{
		$file_path = "./data/".$copied_name;
		unlink($file_path);
    }

    $sql = "delete from notice where num = $num";
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'notice_list.php?page=$page';
	     </script>
	   ";
?>

