<?php
session_start();
include "../database/pdo_connection.php";
include "../database/jdf.php";

$getId= $_GET['id'];

$select=$conn->prepare("SELECT * FROM news WHERE news_id=? ");
$select->bindValue(1,$getId);
$select->execute();
$news=$select->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['sub'])){
  $title=$_POST['title'];
  $datetime=jdate("Y/m/d"); #$datetime=jmktime( "Y/m/d h;mi" );
  $content=$_POST['content'];
  $writer=$_POST['writer'];
  $image=$_POST['image'];

  $result=$conn->prepare("UPDATE news SET news_title=?, news_date=? ,news_content=?, news_author=?, news_picture=? WHERE news_id=?");
  $result->bindValue(1,$title);
  $result->bindValue(2,$datetime);
  $result->bindValue(3,$content);
  $result->bindValue(4,$writer);
  $result->bindValue(5,$image);
  $result->bindValue(6,$getId);
  $result->execute();
  header('location:news.php');
}

if(!isset($_SESSION['user'])){
  header("location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.rtl.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/panel.css" />
    <title>ویرایش  خبر</title>
  </head>
  <body>
    <section x-data="toggleSidebar" class="">
      <nav
        class="nav p-3 navbar navbar-expand-lg bg-light shadow fixed-top mb-5 transition"
      >
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="News Website Logo" width="50" />
            <span class="text-gray fw-bold">سایت خبری</span>
          </a>

          <button id="switchTheme"></button>
        </div>
      </nav>
      <section
        x-cloak
        class="sidebar bg-light transition"
        :class="open || 'inactive'"
      >
        <div
          class="d-flex align-items-center justify-content-between justify-content-lg-center"
        >
          <h4 class="fw-bold">News Website</h4>
          <i @click="toggle" class="d-lg-none fs-1 bi bi-x"></i>
        </div>
        <div class="mt-4">
          <ul class="list-unstyled">
            <li class="sidebar-item ">
              <a class="sidebar-link" href="index.php">
                <i class="me-2 bi bi-grid-fill"></i>
                <span>داشبورد</span>
              </a>
            </li>

            <li x-data="dropdown" class="sidebar-item active">
              <div @click="toggle" class="sidebar-link">
                <i class="me-2 bi bi-shop"></i>
                <span>اخبار</span>
                <i class="ms-auto bi bi-chevron-down"></i>
              </div>
              <ul x-show="open" x-transition class="submenu">
                <li class="submenu-item">
                  <a href="addnews.php"> افزودن خبر </a>
                </li>
                <li class="submenu-item">
                  <a href="edit_news.php">ویرایش اخبار </a>
                </li>
              </ul>
            </li>

            <li x-data="dropdown" class="sidebar-item">
              <div @click="toggle" class="sidebar-link">
                <i class="me-2 bi bi-box-seam"></i>
                <span>دسته بندی ها</span>
                <i class="ms-auto bi bi-chevron-down"></i>
              </div>
              <ul x-show="open" x-transition class="submenu">
                <li class="submenu-item">
                  <a href="categories.php">لیست دسته بندی ها </a>
                </li>
                <li class="submenu-item">
                  <a href="add_category.php">درج دسته بندی جدید </a>
                </li>
                <li class="submenu-item">
                  <a href="edit_category.php">ویرایش دسته بندی ها</a>
                </li>
              </ul>
            </li>


            <li x-data="dropdown" class="sidebar-item">
              <div @click="toggle" class="sidebar-link">
                <i class="me-2 bi bi-people-fill"></i>
                <span>کاربران</span>
                <i class="ms-auto bi bi-chevron-down"></i>
              </div>
              <ul x-show="open" x-transition class="submenu">
                <li class="submenu-item">
                  <a href="users.php">لیست کاربران</a>
                </li>
                <li class="submenu-item">
                  <a href="#">ایجاد کاربران</a>
                </li>
                <li class="submenu-item">
                  <a href="edit_user.php">ویرایش کاربران</a>
                </li>
              </ul>
            </li>

            <li x-data="dropdown" class="sidebar-item">
              <div @click="toggle" class="sidebar-link">
                <i class="me-2 bi bi-power"></i>
                <span> خروج</span>
                <i class="ms-auto bi"></i>
              </div>
              <ul x-show="open" x-transition class="submenu"></ul>
            </li>
          </ul>
        </div>
      </section>

      <section class="main" :class="open || 'active'">
        <div class="container">
          <div class="card card-primary bg-light shadow p-4 mt-5">
            <h1 class="text-gray h4 fw-bold">
              <i class="bi bi-plus-circle"></i>
              <span>ویرایش خبر</span>
            </h1>
            <form action="#" class="mt-4" method="POST">
                <?php foreach($news as $new): ?>
              <div class="row">
                <div class="col-md-6">
                  <label for="name" class="text-gray-600 fw-bold"
                    >نام خبر</label
                  >
                  <input  name="title" id="name" type="text" class="form-control mt-2"  value="<?= $new['news_title']; ?>"/>
                </div>
                <div class="col-md-6">
                  <label for="name" class="text-gray-600 fw-bold"
                    > لینک عکس</label
                  >
                  <input name="image" id="name" type="text" class="form-control mt-2" value="<?= $new['news_picture']; ?>" />
                </div>
              </div>

              <div class="mt-4">
                <label for="text" class="text-gray-600 fw-bold">متن پست</label>
                <textarea
                  name="content"
                  id="text"
                  class="form-control mt-2"
                  cols="30"
                  rows="10"
                ><?= $new['news_content']; ?></textarea>
              </div>

              <div class="row mt-4">
                <div class="col-md-6">
                  <label for="category" class="text-gray-600 fw-bold"
                    > نویسنده</label
                  >
                  <select name="writer" class="form-select mt-2" id="category">
                    <option value="<?= $new['news_author']; ?>">  میرزاد</option>
                    
                  </select>
                </div>
               
              </div>

              <div class="d-flex justify-content-end mt-5">
                <button name="sub" type="submit" class="btn btn-primary btn-lg me-3 fs-6">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-send"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"
                    />
                  </svg>
                  <span>  ویرایش و ثبت </span>
                </button>

              </div>
              <?php endforeach; ?>
            </form>
          </div>
        </div>
      </section>
    </section>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>

    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>

    <script
      defer
      src="https://unpkg.com/alpinejs@3.3.4/dist/cdn.min.js"
    ></script>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <script src="js/charts/chart1.js"></script>
    <script src="js/charts/chart2.js"></script>
    <script src="js/alpineComponents.js"></script>
    <script src="js/darkMode.js"></script>
  </body>
</html>
