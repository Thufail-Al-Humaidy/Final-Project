<?php
require_once __DIR__ . '/../Classes/init.php';

$tag = new Tag();
$keyword = $_GET['keyword'];

$limit = 3; // Data per page
$pageActive = isset($_GET["page"]) ? (int)$_GET["page"] : 1; // Halaman yang aktif
$key = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$length = $key !== '' ? count($tag->search($keyword)) : count($tag->all()) ; // Total data
$countPage = ceil($length / $limit);

$offset = ($pageActive - 1) * $limit;

$no = $offset + 1;

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 : $countPage;

// Query dengan pagination
$tags = $key !== '' ? $tag->search($keyword, $offset, $limit) : $tag->all_paginate($offset, $limit);
?>

<!-- Tabel atau Data Kategori -->
<div id="bungkus-table" class="table-wrapper table-responsive">
  <?php if (empty($tags)) : ?>
    <div class="d-flex justify-content-center align-items-center min-vh-50 m-5">
      <div class="pesan text-center">
        <img src="../assets/icons/no-data.gif" alt="" width="100">
        <p>Data tidak ditemukan</p>
      </div>
    </div>
  <?php else : ?>
    <table class="table">
      <thead>
        <tr>
          <th>
            <h6>#</h6>
          </th>
          <th>
            <h6>Nama Tag</h6>
          </th>
          <th>
            <h6>Action</h6>
          </th>
        </tr>
        <!-- end table row-->
      </thead>
      <tbody>
        <?php foreach ($tags as $tag): ?>
          <tr>
            <td>
              <?= $no++ ?>
            </td>
            <td class="min-width">
              <p><?= $tag['name_tag'] ?></p>
            </td>
            <td>
              <a href="#" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
              <a href="index.php?pg=tags&id=<?= $tag['tags_id'] ?>" class="btn btn-success"><i class="fa-solid fa-pencil"></i></a>
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
      <li class="page-item <?= ($pageActive == 1) ? 'disabled' : '' ?>">
        <a class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=<?= $prev ?>">
          <i class="lni lni-chevron-left"></i>
        </a>
      </li>

      <?php for ($i = 1; $i <= $countPage; $i++): ?>
        <li class="page-item <?= ($pageActive == $i) ? 'active' : '' ?>">
          <a class="page-link border-0 rounded-2 me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?= ($pageActive == $countPage) ? 'disabled' : '' ?>">
        <a class="page-link border-0 rounded-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" href="?page=<?= $next ?>">
          <i class="lni lni-chevron-right"></i>
        </a>
      </li>
    </ul>
  </nav>
</div>