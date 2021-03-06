<?php session_start();  //if(!isset($_SESSION['id'])){

//echo"<script>window.open('admin/index.php','_self')</script>";

//} 

	
	?>
<?php
include("config.php");
include("classes/SiteResultsProvider.php");
include("classes/ImageResultsProvider.php");
    if(isset($_GET["term"])){
        $term = $_GET["term"];
    }else{
        exit("please letter search > 0");
    }
    $type = isset($_GET["type"]) ? $_GET["type"] : "sites";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web Search Engine</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>

<?php //include("nev.php"); ?>
    <div class="wrapper">
        <div class="header">
            <div class="headerContent">
                <div class="logoContainer">
                    <a href="index.php">
					
                        <img src="assets/images/search.png" alt="Web Search Engine">
                    </a>
                </div>
                <div class="searchContainer">
                    <form action="search.php" method="get">
                        <div class="searchBarContainer">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="text" class="searchBox" name="term" value="<?php echo $term; ?>">
                            <button class="searchButton"><img src="assets/images/icons/search.png"></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tabsContainer">
                <ul class="tabList">
                    <li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
                        <a href="<?php echo "search.php?term=$term&type=sites"; ?>">
                            All
                        </a>
                    </li>
                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                        <a href="<?php echo "search.php?term=$term&type=images"; ?>">
                            Images
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mainResultsSection">
            <?php
                if($type == "sites"){
                    $resultsProvider = new SiteResultsProvider($con);
                    $pageLimit = 20;
                }else{
                    $resultsProvider = new ImageResultsProvider($con);
                    $pageLimit = 30;
                }

                $numResults = $resultsProvider->getNumResults($term);
                echo "<p class='resultsCount'>About $numResults</p>";
                echo $resultsProvider->getResultsHtml($page, $pageLimit, $term);
            ?>
        </div>
        <div class="paginationContainer">
            <div class="pageButtons">
                <div class="pageNumberContainer">
                    <img src="assets/images/pageStart.png">
                </div>
                <?php
                $pagesToShow = 10; // s??? page hi???n th??? t???i ??a
                $pageSize = 20; //s??? b??i tr??n trang
				$numResults = substr($numResults, 0, strpos($numResults, ' '));
                $numPages = ceil($numResults / $pageSize); // s??? trang b???ng l??m tr??n s??? ( s??? b??i vi???t chia co s??? b??i tr??n trang )
                $pageLefts = min($pagesToShow, $numPages); //s??? trang c??n l???i b???ng s??? nh??? nh???t gi???a pha ????? hi???n th??? v?? s??? trang
                $currentPage = $page - floor( $pagesToShow / 2 ); //trang hi???n t???i b???ng $page get tr??? cho l??m tr??n s??? xu???ng ( page hi???n th??? chia 2 )
                if($currentPage < 1){ //n???u page hi???n tai nh??? h??n 1 th?? set page hi???n t???i b???ng 1
                    $currentPage = 1;
                }
                if($currentPage + $pageLefts > $numPages + 1) { // n???u page hi???n t???i c???ng v???i s??? trang c??n l???i nh??? h??n t???ng s??? trang c???ng 1
                    $currentPage = $numPages + 1 - $pageLefts; // th?? s??? trang hi???n t???i b???ng t???ng s??? trang + 1 - s??? trang c??n l???i
                }
                while($pageLefts != 0 && $currentPage <= $numPages) { // n???u s??? trang c??n l???i ko b???ng 0 v?? s??? trang hi???n t???i nh??? h??n ho???c b???ng t???ng s??? trang
                    if($currentPage == $page){
                        echo "<div class='pageNumberContainer'>
                            <img src='assets/images/pageSelected.png'>
                            <span class='pageNumber'>$currentPage</span>
                          </div>";
                    }else{
                        echo "<div class='pageNumberContainer'>
                                  <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                    <img src='assets/images/page.png'>
                                    <span class='pageNumber'>$currentPage</span>
                                  </a>
                              </div>";
                    }
                    $currentPage++;
                    $pageLefts--;
                }

                ?>
                <div class="pageNumberContainer">
                    <img src="assets/images/searchend.jpg">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>