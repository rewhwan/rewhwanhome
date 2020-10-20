<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
    $id = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1 = $_POST["email1"];
    $email2 = $_POST["email2"];

    $email = $email1 . "@" . $email2;

    $sql = "update members set pass='$pass', name='$name' , email='$email'";
    $sql .= " where id='$id'";

    $value = mysqli_query($con, $sql);

    if ($value) {
        session_start();
        $_SESSION["username"] = $name;
        mysqli_close($con);
    } else {
        echo "<script>
            alert('수정오류');
            history.go(-1);
            </script>";
    }

    echo "  <script>
                  location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/rewhwanhome/';
            </script>
          ";
?>

   
