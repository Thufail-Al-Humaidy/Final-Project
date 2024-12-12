<?php require_once("./Admin/Classes/init.php") ?>
<div class="my-20">

  <div class="breadcrumbs text-sm px-5 lg:px-8 mt-5">
    <ul class="flex gap-2 items-center text-gray-600">
      <li><a href="?pg=home" class="hover:text-primary">Home</a></li>
      <li class="text-gray-400">/</li>
      <li class="text-slate-400">Categories</li>
    </ul>
  </div>
  
  <section class="categories_container px-6 py-10 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="flex flex-wrap justify-center gap-8">
      <!-- Card Category -->
      <?php
      $category = new Category();
      $categories = $category->category_views();
      foreach ($categories as $category) {
      ?>
        <div
          class="card_category w-[280px] h-[300px] relative rounded-2xl shadow-md bg-white overflow-hidden cursor-pointer hover:scale-105 transition-transform duration-300"
          onclick="window.location.href='?pg=single_category&category=<?= base64_encode($category['category_id']) ?>'">
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
          <!-- Image -->
          <img
            src="./public/img/category_img/<?= $category["category_img"] ?>"
            alt="<?= $category["category_name"] ?>"
            class="w-full h-full object-cover rounded-2xl" />
          <!-- Info -->
          <div class="absolute bottom-4 left-4 right-4 bg-white/80 backdrop-blur-lg py-4 px-5 rounded-lg shadow-md">
            <h3 class="text-gray-800 font-bold text-lg truncate"><?= $category["category_name"] ?></h3>
            <p class="text-gray-500 text-sm"><?= $category["total_articles"] ?> Posts</p>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>
</div>