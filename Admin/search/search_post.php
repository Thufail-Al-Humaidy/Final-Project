<?php
session_start();
require_once __DIR__ . '/../Classes/init.php';
require_once __DIR__ . '/../DB/connections.php';

$post = new Post();
$keyword = $_GET['keyword'];
if (!isset($_SESSION["id_user"])) {
    die("Anda harus login untuk mengakses halaman ini");
  } else {
    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));
    $id = $user['id_user'];
    $avatar = $user['avatar'];
  }

$limit = 6; // Data per page
$pageActive = isset($_GET["page"]) ? (int)$_GET["page"] : 1; // Halaman yang aktif
$key = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$length = $key !== '' ? count($post->all_paginate2($id,$keyword)) : count($post->all()) ; // Total data
$countPage = ceil($length / $limit);

$offset = ($pageActive - 1) * $limit;

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 : $countPage;

$posts = $post->all_paginate2($id, $offset, $limit, $keyword);
?>
<div id="bungkus-post">
    <?php if (empty($posts)) : ?>
        <div class="d-flex justify-content-center align-items-center min-vh-50 m-5">
            <div class="pesan text-center">
                <img src="../assets/images/empty.png" alt="" width="350">
                <p>Upss! Blog Yang kamu cari tidak ditemukan</p>
            </div>
        </div>
    <?php else : ?>
        <div id="card_container" class="row g-3">
            <?php foreach ($posts as $pos) : ?>
                <div class="card_isi col-lg-4">
                    <div class="card p-3 shadow-sm border rounded">
                        <div class="image-container position-relative mb-3 overflow-hidden rounded">
                            <img
                                src="../../public/img/post_img/<?= $pos['image_url'] ?>"
                                alt=""
                                class="img-fluid rounded"
                                style="height: 12rem; object-fit: cover; width: 100%;" />
                            <div class="opsi hover-options position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center gap-3">
                                <a class="fa-solid fa-eye text-white bg-primary py-2 px-3 rounded small"></a>
                                <a href="index.php?pg=edit_post&id=<?= $pos['id_post'] ?>" class="fa-solid fa-pen-to-square text-white bg-success py-2 px-3 rounded small"></a>
                                <button id="btn_hapus" data-id="<?= $pos['id_post'] ?>" class="btn fa-solid fa-trash text-white bg-danger py-2 px-3 rounded small"></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="fw -bold text-dark"><?= $pos['title'] ?></h5>
                            <div class="small" style="max-width: 250px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars_decode($pos['content']) ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between bg-light rounded p-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle overflow-hidden" style="width: 40px; height: 40px;">
                                    <img
                                        src="<?php echo isset($avatar) ? "../../public/img/profile/$avatar" : "./../assets/images/profile/no-profile.png"; ?>"
                                        alt="Profile Avatar"
                                        class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>

                                <div>
                                    <p class="fw-bold mb-0 text-dark small"><?= $pos['username'] ?></p>
                                    <p class="text-muted small mb-0">July 14, 2024</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>