<div id="main_content">
    <div id="latest">
        <h4>최근 게시글</h4>
        <ul>
            <!-- 최근 게시 글 DB에서 불러오기 -->
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . "/rewhwanhome/db/db_connector.php";
            $sql = "select * from board order by num desc limit 5";             //query문 날리기
            $result = mysqli_query($con, $sql);                                 //mysqli_query 로 데이터베이스 조회 쿼리문이 없으면 $result 의 값은 false

            if (!$result)
                echo "<li>게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!</li>";
            else {
                while ($row = mysqli_fetch_array($result)) {
                    $regist_day = substr($row["regist_day"], 0, 10);
            ?>
                    <li>
                        <span><?= $row["subject"] ?></span>
                        <span><?= $row["name"] ?></span>
                        <span><?= $regist_day ?></span>
                    </li>
            <?php
                }
            }
            ?>
        </ul>
    </div>

    <div id="notice">
        <h4>공지사항</h4>
        <ul>
            <!-- 최근 게시 글 DB에서 불러오기 -->
            <?php
            $sql = "select * from notice order by num desc limit 5";             //query문 날리기
            $result = mysqli_query($con, $sql);                                 //mysqli_query 로 데이터베이스 조회 쿼리문이 없으면 $result 의 값은 false

            if (!$result)
                echo "<li>게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!</li>";
            else {
                while ($row = mysqli_fetch_array($result)) {
                    $regist_day = substr($row["regist_day"], 0, 10);
                    ?>
                    <li>
                        <span><?= $row["subject"] ?></span>
                        <span><?= $row["content"] ?></span>
                        <span><?= $row["name"] ?></span>
                        <span><?= $regist_day ?></span>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>

    <div id="point_rank">
        <h4>포인트 랭킹</h4>
        <ul>
            <!-- 포인트 랭킹 표시하기 -->
            <?php
            $rank = 1;
            $sql = "select * from members order by point desc limit 5";
            $result = mysqli_query($con, $sql);

            if (!$result)
                echo "<li>회원 DB 테이블(members)이 생성 전이거나 아직 가입된 회원이 없습니다!</li>";
            else {
                while ($row = mysqli_fetch_array($result)) {
                    $name  = $row["name"];
                    $id    = $row["id"];
                    $point = $row["point"];
                    $name = mb_substr($name, 0, 1) . " * " . mb_substr($name, 2, 1);
            ?>
                    <li>
                        <span><?= $rank ?></span>
                        <span><?= $name ?></span>
                        <span><?= $id ?></span>
                        <span><?= $point ?></span>
                    </li>
            <?php
                    $rank++;
                }
            }

            mysqli_close($con);
            ?>
        </ul>
    </div>
</div>