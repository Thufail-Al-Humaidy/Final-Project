<?php
require_once("./Admin/Classes/init.php");
$id = $_GET['category'];
$category = new Post();
$categories_id = $category->post_category(base64_decode($id));
?>
<div class="breadcrumbs text-sm px-5 lg:px-10 mt-5">
    <ul class="flex gap-2 items-center text-gray-600">
        <li><a href="./index.php" class="hover:text-primary">Home</a></li>
        <li>/</li>
        <li><a href="?pg=category" class="hover:text-primary">Categories</a></li>
        <li class="text-slate-400"><?= $categories_id[0]['name_category'] ?></li>
    </ul>
</div>

<section class="categories_container px-6 py-10 bg-gray-50">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php foreach ($categories_id as $post) : ?>
            <div class="card relative bg-white shadow-md rounded-xl overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300" onclick="window.location.href='?pg=post&content=<?= base64_encode($post['id_post']) ?>'">
                <!-- Image -->
                <div class="relative h-[200px]">
                    <img
                        src="./public/img/post_img/<?= $post['image_url']; ?>"
                        alt="Post Image"
                        class="w-full h-full object-cover">
                </div>

                <!-- Content -->
                <div class="p-5 flex flex-col gap-3">
                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-800 truncate"><?= $post["title"] ?></h3>

                    <!-- Description -->
                    <div class="text-sm text-gray-500 line-clamp-3"><?= htmlspecialchars_decode($post["content"]) ?></div>

                    <!-- Author -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-3">
                            <img
                                src="<?= $post["avatar"] ? "./public/img/profile/$post[avatar]" : "./Admin/assets/images/profile/no-profile.png"; ?>"
                                alt="User Avatar"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="text-sm font-medium text-gray-800"><?= $post["username"] ?></p>
                                <p class="text-xs text-gray-500"><?= date('M d, Y', strtotime($post['created_at'])) ?></p>
                            </div>
                        </div>
                        <!-- Save Button -->
                        <button class="p-2 rounded-full hover:bg-gray-100 transition">
                            <i class="ph-bold ph-bookmark-simple text-xl text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>