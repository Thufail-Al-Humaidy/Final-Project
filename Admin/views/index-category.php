<?php
session_start();
require_once __DIR__ . '/../Classes/init.php';
require_once __DIR__ . '/../DB/connections.php';

$category = new Category();

$limit = 3; // Data per page
$pageActive = isset($_GET["page"]) ? (int)$_GET["page"] : 1; // Halaman yang aktif
$length = count($category->all()); // Total data
$countPage = ceil($length / $limit);

$key = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$offset = ($pageActive - 1) * $limit;

$no = $offset + 1;

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 : $countPage;

// Query dengan pagination
$categories = $category->all_paginate($offset, $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="./../assets/images/favicon.svg" type="image/x-icon" />
  <title>Category | PlainAdmin Demo</title>

  <!-- ========== All CSS files linkup ========= -->
  <link rel="stylesheet" href="./../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./../assets/css/lineicons.css" />
  <link rel="stylesheet" href="./../assets/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="./../assets/css/fullcalendar.css" />
  <link rel="stylesheet" href="./../assets/css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <!-- ======== Preloader =========== -->
  <div id="preloader">
    <div class="spinner"></div>
  </div>
  <!-- ======== Preloader =========== -->

  <!-- ======== sidebar-nav start =========== -->
  <?php include('./../components/sidebar.php'); ?>
  <div class="overlay"></div>
  <!-- ======== sidebar-nav end =========== -->

  <!-- ======== main-wrapper start =========== -->
  <main class="main-wrapper">
    <!-- ========== header start ========== -->
    <?php include('./../components/header.php'); ?>
    <!-- ========== header end ========== -->

    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="title">
                <h2>Tag</h2>
              </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
              <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="#0">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Tag
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card-style mb-30">
              <div class="d-flex justify-content-between align-items-center mb-20">
                <div>
                  <h6 class="mb-10">Data Tag</h6>
                  <p class="text-sm">Berikut adalah data tag yang ada</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                  <a href="index.php?pg=category" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                  </a>
                  <form action="" method="get">
                    <input type="text" id="search-input" name="keyword" class="form-control " placeholder="Cari Tag">
                  </form>
                </div>
              </div>
              <div id="bungkus-table" class="table-wrapper table-responsive">
                <?php if (empty($categories)) : ?>
                  <div class="d-flex justify-content-center align-items-center min-vh-50 m-5">
                    <div class="pesan text-center">
                      <img src="../assets/icons/no-data.gif" alt="" width="100">
                      <p>Data tidak ditemukan</p>
                    </div>
                  </div>
                <?php else : ?>
                  <table class="table" id="table_id">
                    <thead>
                      <tr>
                        <th>
                          <h6>#</h6>
                        </th>
                        <th>
                          <h6>Nama Tag</h6>
                        </th>
                        <th>
                          <h6>Attach</h6>
                        </th>
                        <th>
                          <h6>Action</h6>
                        </th>
                      </tr>
                      <!-- end table row-->
                    </thead>
                    <tbody>
                      <?php foreach ($categories as $cat): ?>
                        <tr>
                          <td>
                            <?= $no++ ?>
                          </td>
                          <td class="min-width">
                            <p><?= $cat['name_category'] ?></p>
                          </td>
                          <td class="min-width">
                            <p><img src="../../public/img/category_img/<?= $cat['category_img'] ?>" class="img-thumbnail rounded shadow-sm" width="150" alt=""></p>
                          </td>
                          <td>
                            <button href="#" data-id="<?= $cat['category_id'] ?>" class="hapus btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                            <a href="index.php?pg=category&id=<?= $cat['category_id'] ?>" class="btn btn-success"><i class="fa-solid fa-pencil"></i></a>
                          </td>
                        </tr>
                        <!-- end table row -->
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                <?php endif; ?>
                <!-- end table -->
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-end mt-4">
                    <!-- Tombol Previous -->
                    <li class="page-item <?= ($pageActive == 1) ? 'disabled' : '' ?>">
                      <a class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=<?= $prev ?>">
                        <i class="lni lni-chevron-left"></i>
                      </a>
                    </li>

                    <?php
                    // Menentukan range halaman yang ditampilkan
                    $range = 2; // Jumlah halaman sebelum/sesudah halaman aktif
                    $start = max(1, $pageActive - $range);
                    $end = min($countPage, $pageActive + $range);

                    // Tombol untuk halaman pertama jika tidak masuk dalam range
                    if ($start > 1) {
                      echo '<li class="page-item"><a class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=1">1</a></li>';
                      if ($start > 2) {
                        echo '<li class="page-item disabled"><span class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">...</span></li>';
                      }
                    }

                    // Halaman dalam range
                    for ($i = $start; $i <= $end; $i++) {
                      $activeClass = ($pageActive == $i) ? 'active' : '';
                      echo '<li class="page-item ' . $activeClass . '">
                <a class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=' . $i . '">' . $i . '</a>
              </li>';
                    }

                    // Tombol untuk halaman terakhir jika tidak masuk dalam range
                    if ($end < $countPage) {
                      if ($end < $countPage - 1) {
                        echo '<li class="page-item disabled"><span class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">...</span></li>';
                      }
                      echo '<li class="page-item"><a class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=' . $countPage . '">' . $countPage . '</a></li>';
                    }
                    ?>

                    <!-- Tombol Next -->
                    <li class="page-item <?= ($pageActive == $countPage) ? 'disabled' : '' ?>">
                      <a class="page-link border-0 rounded-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=<?= $next ?>">
                        <i class="lni lni-chevron-right"></i>
                      </a>
                    </li>
                  </ul>
                </nav>

              </div>
            </div>
            <!-- end card -->
          </div>
          <!-- end col -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->


    <!-- ========== footer start =========== -->
    <?php include('./../components/footer.php'); ?>
    <!-- ========== footer end =========== -->
  </main>
  <!-- ======== main-wrapper end =========== -->

  <!-- ========= All Javascript files linkup ======== -->
  <script src="./../assets/js/jquery-3.7.1.min.js"></script>
  <script src="./../assets/js/bootstrap.bundle.min.js"></script>
  <script src="./../assets/js/Chart.min.js"></script>
  <script src="./../assets/js/dynamic-pie-chart.js"></script>
  <script src="./../assets/js/moment.min.js"></script>
  <script src="./../assets/js/fullcalendar.js"></script>
  <script src="./../assets/js/jvectormap.min.js"></script>
  <script src="./../assets/js/world-merc.js"></script>
  <script src="./../assets/js/polyfill.js"></script>
  <script src="./../assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
    $(document).ready(function() {

      $('#search-input').on('keyup', function() {
        $('#bungkus-table').load(`../search/search_category.php?keyword=` + $('#search-input').val());
      });

      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });

      $(document).on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: './../services/delete_category.php',
              method: 'GET',
              data: {
                id: id
              },
              success: function(response) {
                Toast.fire({
                  icon: "success",
                  title: "Data deleted successfully"
                });
                setTimeout(function() {
                  window.location.href = "./index-category.php";
                }, 2200);
              },
              error: function(xhr, status, error) {
                console.error(error);
                Toast.fire({
                  icon: "error",
                  title: "Failed to delete data"
                });
              }
            });
          }
        });
      });

    });
  </script>
</body>

</html>