<?php

session_start();
include "database/pdo_connection.php";

$select_category=$conn->prepare("SELECT * FROM categories");
$select_category->execute();
$categories=$select_category->fetchAll(PDO::FETCH_ASSOC);

$select=$conn->prepare("SELECT * FROM news ORDER BY 'news_id' DESC LIMIT 9");
$select->execute();
$news=$select->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="styles/css/bootstrap.min.css">
    <!-- Main Css -->
    <link rel="stylesheet" href="styles/css/style.css">
    <!-- Css Reset -->
    <link rel="stylesheet" href="styles/css/reset.css">
    <!-- NavBar Style -->
    <link rel="stylesheet" href="styles/css/nav.css">
    <!-- Footer Style -->
    <link rel="stylesheet" href="styles/css/footer.css">
    <!-- Posts Style -->
    <link rel="stylesheet" href="styles/css/posts.css">
    <!-- Categories -->
    <link rel="stylesheet" href="styles/css/categories.css">
    <!-- Header Style -->
    <link rel="stylesheet" href="styles/css/header.css">
    <!-- Vazir Font -->
    <link rel="stylesheet" href="fonts/vazir.css">
    <!-- Fontawsome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>وبلاگ | صفحه اصلی</title>
</head>
<body>
    <div class="modal fade" id="modalSearchBox">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="#" class="position-relative">
                    <input type="search" placeholder="جستجو ..." class="form-control searchField">
                    <button class="searchBtn"><i class="fas fa-search fs-6"></i></button>
                </form>
            </div>
        </div>
    </div>



    <nav class="navMenu navbar navbar-dark navbar-expand-lg align-items-center fixed-top"> 
        <div class="container flex-row-reverse">
            <div class="d-flex align-items-center">
                <button type="button" class="search-icon" data-bs-toggle="modal" data-bs-target="#modalSearchBox">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fff" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
                <button id="switchTheme"></button>
                <!--<a class="navbar-brand text-white fw-bold fs-5" href="indexhome.php"><img src="panel/images/logo.png"  alt="News Website" width="20%" height="25px"></a>-->
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <i class="fas fa-bars fs-3"></i>
            </button>
            

            <div class="collapse navbar-collapse right-nav justify-content-start" id="navbar">
                <ul class="navbar-nav nav-left">
                    <li class="nav-item me-0">
                        <a class="nav-link mt-3 mt-lg-0" href="indexhome.php">
                            <span>صفحه اصلی</span>
                        </a>
                    </li>
                    <?php foreach($categories as $category): ?>
							<!--<li><a href="category.php?catid=<?php  $category['category_id']; ?>">
                                </a>
                            </li>-->
                    <li class="nav-item me-0">
                        <a class="nav-link mt-3 mt-lg-0" href="">
                            <span><?php echo $category['category_name'] ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    
                    <li class="nav-item me-0">
                        <a class="nav-link mt-3 mt-lg-0" href="login.php">
                            <i class="fa fa-sign-in ms-1"></i>
                            <span>ورود</span>
                        </a>
                    </li>
                    
                    <li class="nav-item me-0">
                        <a class="nav-link mt-3 mt-lg-0" href="register.php">
                            <i class="fa fa-user-plus ms-1"></i>
                            <span>عضویت</span>
                        </a>
                    </li>
                </ul>
            </div>

            
        </div>
    </nav>


    <main class="my-5">
        <div class="container row align-items-start mx-auto mt-4">
            <div id="posts" class="mb-5 col-lg-9">
                <h4 class="posts__title">اخبار</h4>
                <div class="row">
    
                <?php    function limit_words($string, $word_limit)
                    {
                        $words = explode(" ",$string);
                        return implode(" ",array_splice($words,0,$word_limit));
                    } foreach($news as $new):?>
                    <div class="col-md-6 col-lg-4 mt-3">
                        <div class="post">
                            <div class="post__img">
                                <a href="#">
                                    <img src="<?= $new['news_picture']?>" class="w-100 rounded" alt="Image post">
                                </a>
                            </div>
                            <h4 class="">
                                <a href="#" class="post__title d-block"><?= $new['news_title']?></a>
                            </h4>
                            <p class="post__desc">
                            <?php 
                            $content = $new['news_content'];
                            echo limit_words($content,25)." ... ";
                            ?>
                            </p>

                            <a href="single.php?id=<?=$new['news_id'];?>"  class="post__link">مشاهده پست</a>
                        </div>
                    </div>
                <?php endforeach;?>

                </div>
            </div>
            <aside class="categories col-lg-3 mt-5 mt-md-0">
                <h4 class="categories__title">
                    پربازدید ترین
                </h4>
                <ul class="categories__list">
                    <li class="categories__item"><a href="#" class="categories__link"> </a></li>
                    <li class="categories__item"><a href="#" class="categories__link"> </a></li>
                    <li class="categories__item"><a href="#" class="categories__link"> </a></li>
                    <li class="categories__item"><a href="#" class="categories__link"> </a></li>
                </ul>
            </aside>
        </div>
    </main>


    <footer class="footer">
    <div class="col-md-4 footer-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
				<h4>درباره ما</h4>
				<p>تیم خبری ما کار خود را از سال 1403 شروع کرده است.</p>
				<img src="images/t4.jpg" class="img-responsive" alt="">
					<div class="bht1">
						<a href="singlepage.php">ادامه مطلب</a>
					</div>
			</div>
    </footer>


    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/scrollToUp.js"></script>
    <script src="js/darkMode.js"></script>
</body>
</html>