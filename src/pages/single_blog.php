<?php
require_once("./Admin/DB/connections.php");
require_once("./Admin/Classes/init.php");
$post = new Post();
$id = $_GET['content'];
$posts_id = $post->find(base64_decode($id));
$posts = $post->singgle_post(base64_decode($id));
$tags = $post->find_tag(base64_decode($id));
$tags_name = array_column($tags, 'name_tag');
$id_user = $posts['user_id'];
$all_post = $post->all_paginate2($id_user);
$sql_add_Views = "UPDATE blog_posts SET views = views + 1 WHERE id_post = " . base64_decode($id);
mysqli_query($conn, $sql_add_Views);
$popular_post = $post->filter_data(null, 'views', 'DESC', 4);
$sql_random = "SELECT blog_posts.*, users.username, users.avatar FROM blog_posts JOIN users ON blog_posts.user_id = users.id_user ORDER BY RAND() LIMIT 4";
$result_random = mysqli_query($conn, $sql_random);
$random_post = mysqli_fetch_all($result_random, MYSQLI_ASSOC);
// var_dump($posts["user_id"]);
?>
<title>Blog | <?= $posts['title']; ?></title>
<div class="breadcrumbs text-sm px-5 lg:px-8 mt-5">
  <ul>
    <li><a>Home</a></li>
    <li><a>Featublue</a></li>
    <li class="text-slate-400"><?= $posts['title']; ?></li>
  </ul>
</div>

<main class="main-content container mx-auto px-5 lg:px-10 mt-10 grid grid-cols-1 lg:grid-cols-12 gap-10">
  <!-- Main Post Section -->
  <div class="main-content-container lg:col-span-8 space-y-8">
    <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 leading-tight"><?= $posts['title']; ?></h1>

    <div class="rounded-xl overflow-hidden shadow-lg">
      <img
        src="./public/img/post_img/<?= $posts['image_url']; ?>"
        alt="<?= $posts['title']; ?>"
        class="w-full object-cover h-80 lg:h-96" />
    </div>

    <div class="flex items-center justify-between text-gray-500 text-sm">
      <div class="flex items-center space-x-2">
        <i class="fa-regular fa-calendar"></i>
        <span><?= date('M d, Y', strtotime($posts['created_at'])); ?></span>
      </div>
      <div class="flex items-center space-x-2">
        <i class="fa-solid fa-eye"></i>
        <span><?= $posts['views']; ?></span>
      </div>
      <div class="flex items-center space-x-2">
        <i class="fa-solid fa-tags"></i>
        <span><?= $posts['name_category']; ?></span>
      </div>
    </div>

    <div class="text-lg leading-relaxed text-gray-700"><?= htmlspecialchars_decode($posts['content']); ?></div>

    <!-- Comments Section -->
    <section class="comments-section space-y-6">
      <h2 class="text-2xl font-semibold text-gray-800">Comments</h2>
      <div class="space-y-5">
        <!-- Comment Card -->
        <div class="comment-card bg-gray-100 rounded-lg p-4 flex items-start space-x-4 shadow-md">
          <img
            src="assets/card_img/card_1.jpg"
            alt="User Avatar"
            class="w-12 h-12 rounded-full object-cover" />
          <div>
            <p class="font-semibold text-gray-800">Cassie</p>
            <p class="text-sm text-gray-500 mb-2">July 14, 2024</p>
            <p class="text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.</p>
          </div>
        </div>

        <!-- Comment Form -->
        <div>
          <h3 class="text-xl font-semibold text-gray-800">Leave a Comment</h3>
          <form action="" class="space-y-4">
            <textarea
              class="w-full p-4 bg-gray-100 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none"
              rows="5"
              placeholder="Write your comment here..."></textarea>
            <button
              type="submit"
              class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-600 transition duration-300">
              Send Comment
            </button>
          </form>
        </div>
      </div>
    </section>
  </div>

  <!-- Sidebar -->
  <aside class="sidebar lg:col-span-4 space-y-8">
    <!-- Author Section -->
    <div class="bg-gray-100 rounded-lg p-6 shadow-md">
      <div class="flex items-center space-x-4">
        <img
          src="<?= $posts['avatar'] ? "./public/img/profile/$posts[avatar]" : "./Admin/assets/images/profile/no-profile.png"; ?>"
          alt="Author Avatar"
          class="w-16 h-16 rounded-full object-cover" />
        <div>
          <p class="font-semibold text-gray-800"><?= $posts['username']; ?></p>
          <p class="text-sm text-gray-500"><?= count($all_post); ?> Posts</p>
        </div>
      </div>
      <a
        href="?pg=about-author&user_id=<?= base64_encode($id_user) ?>"
        class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition duration-300">
        View Profile
      </a>
    </div>

    <!-- Tags Section -->
    <div class="bg-gray-100 rounded-lg p-6 shadow-md">
      <h3 class="font-semibold text-gray-800 mb-4">Related Tags</h3>
      <div class="flex flex-wrap gap-2">
        <?php foreach ($tags as $tag) : ?>
          <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm"><?= $tag['name_tag']; ?></span>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Popular Posts Section -->
    <div class="bg-gray-100 rounded-lg p-6 shadow-md">
      <h3 class="font-semibold text-gray-800 mb-4">Popular Posts</h3>
      <div class="space-y-4">
        <?php foreach ($popular_post as $post) : ?>
          <div
            class="flex items-start space-x-4 hover:bg-gray-200 p-2 rounded-lg transition cursor-pointer"
            onclick="window.location.href='?pg=post&content=<?= base64_encode($post['id_post']) ?>'">
            <img
              src="./public/img/post_img/<?= $post['image_url']; ?>"
              alt="Popular Post"
              class="w-16 h-16 rounded-lg object-cover" />
            <div>
              <p class="font-semibold text-gray-800 line-clamp-1"><?= $post['title']; ?></p>
              <div class="text-sm text-gray-500 line-clamp-2"><?= htmlspecialchars_decode($post['content']); ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </aside>
</main>

<!-- Designed Comments Section -->
<section class="comments px-5 mt-7 lg:px-20">
  <!-- Comments Header -->
  <div class="comments_header mb-6">
    <h2 class="font-bold text-3xl text-gray-800">Comments</h2>
    <p class="text-gray-500 text-sm">Share your thoughts below</p>
  </div>

  <!-- Comments List -->
  <div class="comments_container space-y-6">
    <!-- Comment Card -->
    <div class="comment_card flex flex-col md:flex-row items-start gap-4 bg-white shadow-md rounded-lg p-4 transition-all hover:shadow-lg">
      <div class="profile_img rounded-full w-14 h-14 overflow-hidden">
        <img
          src="assets/card_img/card_1.jpg"
          alt="Profile Comment"
          class="w-full h-full object-cover" />
      </div>
      <div class="flex-1">
        <div class="flex justify-between items-center">
          <p class="font-semibold text-gray-700 text-lg">Cassie</p>
          <span class="text-gray-400 text-sm">July 14, 2024</span>
        </div>
        <p class="text-gray-600 mt-2 text-base">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
        </p>
        <button
          class="text-sm text-blue-500 mt-3 flex items-center hover:underline">
          <i class="fa-solid fa-reply mr-2"></i>Reply
        </button>
      </div>
    </div>

    <!-- Comment Card -->
    <div class="comment_card flex flex-col md:flex-row items-start gap-4 bg-white shadow-md rounded-lg p-4 transition-all hover:shadow-lg">
      <div class="profile_img rounded-full w-14 h-14 overflow-hidden">
        <img
          src="assets/card_img/card_3.jpg"
          alt="Profile Comment"
          class="w-full h-full object-cover" />
      </div>
      <div class="flex-1">
        <div class="flex justify-between items-center">
          <p class="font-semibold text-gray-700 text-lg">Cassie</p>
          <span class="text-gray-400 text-sm">July 14, 2024</span>
        </div>
        <p class="text-gray-600 mt-2 text-base">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
        </p>
        <button
          class="text-sm text-blue-500 mt-3 flex items-center hover:underline">
          <i class="fa-solid fa-reply mr-2"></i>Reply
        </button>
      </div>
    </div>
  </div>

  <!-- Comment Form -->
  <div class="comment_form mt-10">
    <h3 class="font-bold text-2xl text-gray-800 mb-4">Leave a Comment</h3>
    <form class="space-y-4">
      <textarea
        class="w-full rounded-lg bg-gray-100 p-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        rows="4"
        placeholder="Write your comment here..."></textarea>
      <div class="rating flex items-center gap-4">
        <p class="text-lg font-medium text-gray-800">Rate this post:</p>
        <div class="flex gap-3">
          <button
            class="rating-btn text-gray-500 hover:text-blue-500 transition-all">
            <i class="fa-regular fa-face-angry text-xl"></i>
          </button>
          <button
            class="rating-btn text-gray-500 hover:text-orange-500 transition-all">
            <i class="fa-regular fa-face-meh text-xl"></i>
          </button>
          <button
            class="rating-btn text-gray-500 hover:text-yellow-500 transition-all">
            <i class="fa-regular fa-face-laugh text-xl"></i>
          </button>
          <button
            class="rating-btn text-gray-500 hover:text-blue-500 transition-all">
            <i class="fa-regular fa-face-grin-hearts text-xl"></i>
          </button>
          <button
            class="rating-btn text-gray-500 hover:text-green-500 transition-all">
            <i class="fa-regular fa-face-grin-stars text-xl"></i>
          </button>
        </div>
      </div>
      <button
        type="submit"
        class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg font-medium hover:bg-blue-700 transition-all">
        <i class="fa-solid fa-comment-dots mr-2"></i>Send Comment
      </button>
    </form>
  </div>
</section>


<section class="popular mt-10 lg:mt-16 px-6 lg:px-20">
  <!-- Section Header -->
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-extrabold text-gray-900 tracking-wide">Recommended Posts</h2>
    <a href="?pg=all-posts" class="text-sm text-blue-500 hover:text-blue-600 hover:underline">See All</a>
  </div>

  <!-- Posts Container -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach ($random_post as $post) : ?>
      <!-- Post Card -->
      <div class="relative group bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <!-- Card Image -->
        <div class="relative w-full h-52 overflow-hidden">
          <img
            src="./public/img/post_img/<?= $post['image_url']; ?>"
            alt="Post Image"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
          <!-- Gradient Overlay -->
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>

        <!-- Content -->
        <div class="p-5 space-y-3">
          <!-- Title -->
          <h3 class="text-lg font-semibold text-gray-800 line-clamp-1 group-hover:text-blue-600 transition-colors">
            <?= $post["title"] ?>
          </h3>
          <!-- Excerpt -->
          <div class="text-sm text-gray-600 line-clamp-2">
            <?= htmlspecialchars_decode($post["content"]) ?>
          </div>
        </div>

        <!-- Profile and Interaction -->
        <div class="absolute bottom-0 left-0 w-full bg-white border-t flex items-center justify-between p-4">
          <!-- Profile Info -->
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full overflow-hidden">
              <img
                src="<?= $post["avatar"] ? "./public/img/profile/$post[avatar]" : "./Admin/assets/images/profile/no-profile.png"; ?>"
                alt="User Avatar"
                class="w-full h-full object-cover" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700"><?= $post["username"] ?></p>
              <p class="text-xs text-gray-500"><?= date('M d, Y', strtotime($post['created_at'])) ?></p>
            </div>
          </div>
          <!-- Save Icon -->
          <div class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors cursor-pointer">
            <i class="ph-bold ph-bookmark-simple text-gray-600"></i>
          </div>
        </div>

        <!-- Clickable Link -->
        <a
          href="?pg=post&content=<?= base64_encode($post['id_post']) ?>"
          class="absolute inset-0 z-10"></a>
      </div>
    <?php endforeach; ?>
  </div>
</section>



<script>
  const ratingButtons = document.querySelectorAll(".rating-btn");

  ratingButtons.forEach((button) => {
    const ratingLabel = button.querySelector(".rating-label");

    button.addEventListener("click", () => {
      ratingButtons.forEach((btn) => {
        const label = btn.querySelector(".rating-label");
        const colorClass = btn.getAttribute("data-color");

        btn.classList.remove(colorClass, "text-white");
        btn.classList.remove("px-6", "py-3");

        label.classList.add("hidden");
      });
      const bgColorClass = button.getAttribute("data-color");
      ratingLabel.classList.remove("hidden");
      button.classList.add(bgColorClass, "text-white", "px-6", "py-3");
      button.classList.remove("text-gray-700", "border");
    });
  });

  $(document).ready(function() {
    $(".carrousel_post").slick({
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: false,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            autoplay: false,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 4000,
          },
        },
      ],
    });
  });

  const profileAuthor = document.querySelectorAll(".profile_author_img");

  profileAuthor.forEach((author) => {
    author.addEventListener("click", () => {
      window.location.href = "?pg=about-author&user_id=<?= base64_encode($user['id_user']) ?>";
    });
  });
</script>