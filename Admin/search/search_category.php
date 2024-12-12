<?php
require_once __DIR__ . '/../Classes/init.php';

$category = new Category();
$keyword = $_GET['keyword'];

$limit = 3; // Data per page
$pageActive = isset($_GET["page"]) ? (int)$_GET["page"] : 1; // Halaman yang aktif
$key = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$length = $key !== '' ? count($category->search($keyword)) : count($category->all()); // Total data
$countPage = ceil($length / $limit);

$offset = ($pageActive - 1) * $limit;

$no = $offset + 1;

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 : $countPage;

// Query dengan pagination
$categories = $key !== '' ? $category->search($keyword, $offset, $limit) : $category->all_paginate($offset, $limit);
?>

<!-- Tabel atau Data Kategori -->
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