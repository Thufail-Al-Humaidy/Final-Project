<?php
require_once "./Admin/Classes/init.php";
$id = $_GET['user_id'];
$user = new User();
$posts = new Post();
$users = $user->find(base64_decode($id));
$user_posts = $posts->all_paginate2(base64_decode($id));
$views = $posts->count_views(base64_decode($id));
// var_dump($users);
// echo($users[0]['avatar']);
?>

<div class="breadcrumbs text-sm px-5 lg:px-10 mt-5">
  <ul>
    <li><a href="./index.html" class="text-blue-500 hover:underline">Home</a></li>
    <li class="text-slate-400">Writer</li>
  </ul>
</div>

<!-- Header Section -->
<header class="px-5 lg:px-10 mt-5">
  <div class="relative bg-white shadow-lg rounded-2xl p-6">
    <!-- Banner -->
    <div class="relative w-full h-[200px] rounded-lg overflow-hidden bg-gray-200">
      <img src="<?= $users[0]['banner'] ? "./public/img/banner/" . $users[0]['banner'] : "./assets/card_img/card_header-1.jpg"; ?>" alt="Author Banner" class="w-full h-full object-cover">
    </div>
    <!-- Profile -->
    <div class="absolute top-[150px] left-1/2 transform -translate-x-1/2">
      <div class="w-[120px] h-[120px] rounded-full border-4 border-white shadow-lg overflow-hidden bg-gray-100">
        <img src="<?= $users[0]['avatar'] ? "./public/img/profile/" . $users[0]['avatar'] : "./Admin/assets/images/profile/no-profile.png"; ?>" alt="Profile Picture" class="w-full h-full object-cover">
      </div>
    </div>
    <!-- Profile Info -->
    <div class="mt-20 text-center">
      <h1 class="text-lg font-bold text-slate-700"><?= $users[0]['username']; ?></h1>
      <p class="text-sm text-slate-500 italic">Content Creator | Enthusiast Writer</p>
      <div class="flex justify-center gap-10 mt-5">
        <div class="text-center">
          <p class="text-xl font-semibold text-slate-800"><?= $views["total_views"] ?></p>
          <p class="text-sm text-slate-500">Views</p>
        </div>
        <div class="text-center">
          <p class="text-xl font-semibold text-slate-800"><?= count($user_posts) ?></p>
          <p class="text-sm text-slate-500">Posts</p>
        </div>
      </div>
      <button class="mt-5 px-6 py-2 bg-[#F81539] text-white rounded-full shadow-lg hover:bg-[#D51435] transition duration-300">
        <i class="fa-solid fa-plus mr-2"></i>Follow
      </button>
    </div>
  </div>
</header>

<!-- Posts Section -->
<section class="px-5 lg:px-10 mt-8">
  <h2 class="text-xl font-bold text-slate-700 mb-5">Latest Posts</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" onclick="window.location.href='?pg=post&content=<?= base64_encode($post['id_post']) ?>'">
    <?php foreach ($user_posts as $post) : ?>
      <div class="card_post bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition duration-300">
        <!-- Post Image -->
        <div class="relative w-full h-[200px] bg-gray-200">
          <img src="<?= $post["image_url"] ? "./public/img/post_img/$post[image_url]" : "./assets/card_img/category_4.jpg"; ?>" alt="Post Image" class="w-full h-full object-cover">
        </div>
        <!-- Post Content -->
        <div class="p-4 flex flex-col">
          <h3 class="text-lg font-semibold text-slate-800 truncate mb-2"><?= $post["title"] ?></h3>
          <div class="text-slate-500 text-[14px] line-clamp-3">
            <?= htmlspecialchars_decode($post["content"]) ?>
          </div>
          <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full overflow-hidden">
                <img src="<?= $post["avatar"] ? "./public/img/profile/$post[avatar]" : "./Admin/assets/images/profile/no-profile.png"; ?>" alt="Author Avatar" class="w-full h-full object-cover">
              </div>
              <div>
                <p class="text-sm font-bold text-slate-800"><?= $post["username"] ?></p>
                <p class="text-xs text-slate-500"><?= date('M d, Y', strtotime($post['created_at'])) ?></p>
              </div>
            </div>
            <i class="ph-bold ph-bookmark-simple text-xl text-slate-400 hover:text-slate-600 cursor-pointer"></i>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Pagination Section -->
<div class="flex justify-center items-center gap-2 mt-10">
  <button class="w-9 h-9 flex items-center justify-center bg-gray-200 rounded-full text-slate-600 hover:bg-gray-300 transition">
    <i class="fa-solid fa-chevron-left"></i>
  </button>
  <button class="w-9 h-9 flex items-center justify-center bg-blue-500 text-white rounded-full shadow-lg">1</button>
  <button class="w-9 h-9 flex items-center justify-center bg-gray-200 rounded-full text-slate-600 hover:bg-gray-300 transition">2</button>
  <button class="w-9 h-9 flex items-center justify-center bg-gray-200 rounded-full text-slate-600 hover:bg-gray-300 transition">3</button>
  <button class="w-9 h-9 flex items-center justify-center bg-gray-200 rounded-full text-slate-600 hover:bg-gray-300 transition">
    <i class="fa-solid fa-chevron-right"></i>
  </button>
</div>

<!-- ========== section end ========== -->