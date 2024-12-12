<div class="container mx-auto px-6 lg:px-8 mt-32">
    <!-- HERO SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Slider -->
        <div class="lg:col-span-2">
            <div class="relative rounded-lg overflow-hidden shadow-xl hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <img src="./assets/card_img/card_1.jpg" alt="Hero Image" class="w-full h-[300px] lg:h-[450px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-70"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-2">Discover the Power of Minimalism</h2>
                    <p class="text-sm lg:text-base">How a single monitor setup can redefine your productivity.</p>
                    <a href="#!" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Read More</a>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <aside class="bg-white rounded-lg shadow-xl hover:-translate-y-2 hover:shadow-2xl transition-all duration-300  p-6 relative">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Popular Categories</h3>
            <!-- <div class="absolute inset-0 bg-gradient-to-b from-teal-500  to-transparent opacity-50"></div> -->
            <ul class="space-y-4">
                <?php
                $popular_category = new Category();
                $categories = $popular_category->category_views(4);
                foreach ($categories as $category):
                ?>
                    <li class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-500">
                            <i class="ph-bold ph-laptop"></i>
                        </div>
                        <span class="text-lg font-medium text-gray-700"><?= $category['category_name'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
    <!-- TOP WRITTERS -->
    <section class="top-writer mt-12">
        <div class="container mx-auto">
            <!-- Title Section -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <span class="block w-2 h-2 bg-orange-500 rounded-full mr-2"></span> Top Writers
                </h2>
                <div class="hidden lg:flex space-x-2">
                    <button class="btn-prev bg-gray-200 hover:bg-gray-300 p-2 rounded-full">
                        <i class="ph-bold ph-caret-left text-gray-600"></i>
                    </button>
                    <button class="btn-next bg-gray-200 hover:bg-gray-300 p-2 rounded-full">
                        <i class="ph-bold ph-caret-right text-gray-600"></i>
                    </button>
                </div>
            </div>

            <!-- Writer Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  gap-6">
                <?php
                $author = new User();
                $top_user = $author->top_user();
                foreach ($top_user as $user): ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Avatar -->
                        <div class="relative">
                            <div class="w-24 h-24 mx-auto mt-6 border-4 border-blue-500 rounded-full overflow-hidden">
                                <img src="<?= $user["avatar"] ? "./public/img/profile/$user[avatar]" : "./Admin/assets/images/profile/no-profile.png"; ?>"
                                    alt="Profile Photo"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="absolute top-0 right-0 bg-blue-500 text-white text-xs px-2 py-1 rounded-bl-lg">Top</div>
                        </div>
                        <!-- Content -->
                        <div class="text-center p-4">
                            <h3 class="font-bold text-lg text-gray-800"><?= $user["username"] ?></h3>
                            <p class="text-sm text-gray-500"><?= $user["job"] ?? "Blogger" ?></p>
                            <div class="flex justify-center gap-4 mt-4">
                                <!-- Stats -->
                                <div class="text-center">
                                    <p class="font-bold text-lg text-gray-800"><?= $user["total_posts"] ?></p>
                                    <p class="text-sm text-gray-500">Posts</p>
                                </div>
                                <div class="text-center">
                                    <p class="font-bold text-lg text-gray-800"><?= $user["total_views"] ?></p>
                                    <p class="text-sm text-gray-500">Views</p>
                                </div>
                            </div>
                            <!-- Button -->
                            <button
                                onclick="window.location.href='?pg=about-author&user_id=<?= base64_encode($user['id_user']) ?>'"
                                class="mt-4 bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600 text-sm font-medium">
                                View Profile
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- NEWEST POSTS -->
    <section class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center mb-8">
            <span class="block w-2 h-2 bg-orange-500 rounded-full mr-2"></span> Newest Post
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($newest as $post) : ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="./public/img/post_img/<?= $post['image_url'] ?>" alt="Post Image" class="w-full h-[150px] object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 truncate"><?= $post["title"] ?></h3>
                        <div class="text-sm text-gray-600 mt-2 line-clamp-2"><?= htmlspecialchars_decode($post["content"]) ?></div>
                        <a href="?pg=post&content=<?= base64_encode($post['id_post']) ?>" class=" block mt-4 text-blue-500 hover:text-blue-600 text-sm">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center mb-8">
            <span class="block w-2 h-2 bg-orange-500 rounded-full mr-2"></span> Trending Post
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post) : ?>
                <div class="post-card relative bg-white rounded-lg shadow-xl overflow-hidden group">
                    <!-- Image -->
                    <img src="./public/img/post_img/<?= $post['image_url'] ?>" alt="Trending Image" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">

                    <!-- Content Wrapper -->
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-indigo-800 opacity-70"></div>

                    <div class="relative p-4">
                        <!-- Post Title -->
                        <h3 class="text-xl font-semibold text-white"><?= $post["title"] ?></h3>

                        <!-- Post Excerpt (with line-clamp) -->
                        <div class="text-sm text-white mt-2 line-clamp-3"><?= htmlspecialchars_decode($post["content"]) ?></div>

                        <!-- Explore Button -->
                        <a href="?pg=post&content=<?= base64_encode($post['id_post']) ?>" class=" inline-block mt-4 bg-blue-500 text-white py-2 px-4 rounded-md font-medium hover:bg-blue-600 transition-all duration-300">
                            Explore
                        </a>
                    </div>

                    <!-- Trending Label -->
                    <div class="absolute top-4 right-4 bg-red-500 text-xs font-bold px-3 py-1 rounded-full text-white shadow-lg transform scale-90 group-hover:scale-100 transition-all duration-200 ease-in-out">
                        Trending
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>



</div>