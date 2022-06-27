<?php
    $sql = "SELECT count(blogID) FROM myBlog";
    $result = $connect -> query($sql);

    $blogDataArray = $result -> fetch_array(MYSQLI_ASSOC);
    $blogArticleCount = $blogDataArray['count(blogID)'];
    
    if(isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }

    $pageLimit = 6;
    
    $startPage = $page - $pageLimit;
    $endPage = $page + $pageLimit;
    $prevPage;
    $nextPage;
    
    if($startPage < 0) {
        $startPage = 1;
    }

    if($endPage >= $blogArticleCount) {
        $endPage = $blogArticleCount;
    }

    if($startPage != 1) {
        echo "<li><a href='blogView.php?blogID=1'>처음</a></li>";
    }
    
    if($startPage != 1) {
        $prevPage = $page - 1;
        echo "<li><a href='blogView.php?blogID={$prevPage}'>이전</a></li>";
    }

    for($count = $startPage; $count <= $endPage; $count++) {
        $active = "";

        if($count == $page) {
            $active = "active";

            echo "<li class='{$active}'><a href='blogView.php?blogID={$count}'>{$count}</a></li>";
        }
    }

    if($page != $endPage) {
        $nextPage = $page + 1;
        echo "<li><a href='blogView.php?blogID={$nextPage}'>다음</a></li>";
    }

    if($page != $blogArticleCount) {
        echo "<li><a href='blogView.php?blogID={$blogArticleCount}'>마지막</a></li>";
    }

?>