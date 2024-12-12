<?php
require_once __DIR__ . '/../DB/connections.php';
require_once __DIR__ . '/../Classes/init.php';

if (!isset($_SESSION["id_user"])) {
  header("Location: ./../no_permession.html");
  exit();
} else {
  $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));
  $id = $user['id_user'];
  $avatar = $user['avatar'];
}

$post = new Post();
$posts = $post->all_paginate2($id);
$posts_new = $post->filter_data($id, 'created_at', 'DESC');
$posts_popular = $post->filter_data($id, 'views', 'DESC');
$views = $post->count_views($id);
$no = 0;
?>
<div class="container-fluid">
  <!-- ========== title-wrapper start ========== -->
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title">
          <h2>Hallo👋🏿 , <br> Selamat Datang <?= $username ?></h2>
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
                Blog Page
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
    <div class="col-xl-3 col-lg-4 col-sm-6">
      <div class="icon-card mb-30">
        <div class="icon success">
          <i class="fa-regular fa-window-restore"></i>
        </div>
        <div class="content">
          <h6 class="mb-10">Total Post</h6>
          <h3 class="text-bold mb-10"><?= count($posts) ?></h3>
        </div>
      </div>
      <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
      <div class="icon-card mb-30">
        <div class="icon primary">
          <i class="fa-solid fa-eye"></i>
        </div>
        <div class="content">
          <h6 class="mb-10">Total Views</h6>
          <h3 class="text-bold mb-10"><?= $views['total_views'] != null ? $views['total_views'] : 0 ?></h3>
        </div>
      </div>
      <!-- End Icon Cart -->
    </div>
    <?php if ($user['role'] == 'admin') : ?>
    <!-- End Col -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
      <div class="icon-card mb-30">
        <div class="icon orange">
        <i class="fa-solid fa-tags"></i>
        </div>
        <div class="content">
          <h6 class="mb-10">Total Tag</h6>
          <h3 class="text-bold mb-10">100</h3>
        </div>
      </div>
      <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
      <div class="icon-card mb-30">
        <div class="icon purple">
        <i class="fa-solid fa-layer-group"></i>
        </div>
        <div class="content">
          <h6 class="mb-10">Total Kategori</h6>
          <h3 class="text-bold mb-10">$74,567</h3>
        </div>
      </div>
      <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
     <?php endif; ?>
    <!-- Artikel Terbaru & Shortcut -->
    <div class="row mb-4">
      <!-- Artikel Terbaru -->
      <div class="col-md-8">
        <h5>Artikel Terbaru</h5>
        <ul class="list-group mt-2">
          <?php foreach ($posts_new as $post) : ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <strong><?= $post['title'] ?></strong>
              <p class="mb-0">Kategori: <?= $post['name_category'] ?></p>
            </div>
            <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- Shortcut -->
      <div class="col-md-4">
        <h5>Tambah Artikel</h5>
        <div class="d-flex justify-content-center align-items-center w-100 h-100 py-3">
          <a href="#" class="btn d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; background-color: #f8f9fa; border: 2px dashed #dee2e6;">
            <i class="fas fa-plus fa-lg text-secondary"></i>
            <span class="d-none">Buat Artikel Baru</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Grafik Aktivitas atau Artikel Favorit -->
    <div class="row">
      <div class="col-12">
        <h5>Artikel Favorit</h5>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Views</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($posts_popular as $post) : ?>
                <?php $no++ ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= $post['title'] ?></td>
                <td><?= $post['name_category'] ?></td>
                <td><?= $post['views'] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row -->
  <div class="row">

  </div>
</div>
<!-- end container -->