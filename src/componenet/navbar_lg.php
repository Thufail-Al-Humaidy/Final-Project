<?php
if (isset($_SESSION["id_user"])) {

  $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));

  $username = $user['username'];
  $email = $user['email'];
  $no_telp = $user['phone'];
  $alamat = $user['address'];
  $bio = $user['bio'];
  $profile = $user['avatar'];
  $gender = $user['gender'];
}

?>
<nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-50">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center h-16">
    <!-- Logo / Brand -->
    <a href="index.php" class="text-2xl font-extrabold text-blue-600">
      EL Blog
    </a>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex items-center space-x-8">
      <a href="?pg=category" class="text-gray-700 hover:text-blue-600 font-medium transition">Category</a>
      <a href="?pg=contact-us" class="text-gray-700 hover:text-blue-600 font-medium transition">Contact Us</a>
      <a href="?pg=about-us" class="text-gray-700 hover:text-blue-600 font-medium transition">About Us</a>

      <!-- Search Box -->
      <div class="relative">
        <input
          type="text"
          placeholder="Search..."
          class="bg-gray-100 border border-gray-300 rounded-full px-4 py-2 w-72 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <button class="absolute top-1/2 right-3 transform -translate-y-1/2 text-blue-600">
          <i class="ph-bold ph-magnifying-glass"></i>
        </button>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="hidden lg:flex items-center space-x-6">
      <?php if (isset($_SESSION["id_user"])): ?>
        <?php
        $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));
        $username = $user['username'];
        $profile = $user['avatar'] ?: "default-avatar.png";
        ?>
        <!-- Profile Dropdown -->
        <div class="relative">
          <button class="flex items-center space-x-2 focus:outline-none">
            <img src="public/img/profile/<?= $profile; ?>" alt="Profile Photo" class="w-8 h-8 rounded-full">
            <span class="text-gray-700 hover:text-blue-600 font-medium transition">
              <?= htmlspecialchars($username); ?>
            </span>
          </button>
        </div>
        <a href="?pg=dashboard" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 font-medium transition">Dashboard</a>
        <a href="./Admin/services/logout.php" class="px-4 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 font-medium transition">Logout</a>
      <?php else: ?>
        <a href="./Admin/index.php" class="text-gray-700 hover:text-blue-600 font-medium transition">Login</a>
      <?php endif; ?>
    </div>

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn" class="lg:hidden text-gray-600 focus:outline-none">
      <i class="ph-bold ph-list text-2xl"></i>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden bg-white shadow-lg lg:hidden transition-transform duration-300">
    <ul class="space-y-4 py-6 px-6">
      <li><a href="?pg=category" class="block text-gray-700 hover:text-blue-600 font-medium transition">Category</a></li>
      <li><a href="?pg=contact-us" class="block text-gray-700 hover:text-blue-600 font-medium transition">Contact Us</a></li>
      <li><a href="?pg=about-us" class="block text-gray-700 hover:text-blue-600 font-medium transition">About Us</a></li>
      <li>
        <div class="relative">
          <input
            type="text"
            placeholder="Search..."
            class="bg-gray-100 border border-gray-300 rounded-full px-4 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <button class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-600">
            <i class="ph-bold ph-magnifying-glass"></i>
          </button>
        </div>
      </li>
      <?php if (isset($_SESSION["id_user"])): ?>
        <li>
          <div class="flex items-center space-x-4">
            <img src="public/img/profile/<?= $profile; ?>" alt="Profile Photo" class="w-10 h-10 rounded-full">
            <div>
              <p class="text-gray-700 font-medium">Welcome, <?= htmlspecialchars($username); ?></p>
              <a href="./Admin/index.php" class="text-blue-600 hover:underline text-sm">Dashboard</a>
            </div>
          </div>
        </li>
        <li><a href="./Admin/services/logout.php" class="block bg-red-600 text-white text-center rounded-full py-2 hover:bg-red-700 font-medium transition">Logout</a></li>
      <?php else: ?>
        <li><a href="./Admin/index.php" class="block text-gray-700 hover:text-blue-600 font-medium transition">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<script>
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  // Mobile menu toggle with animation
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
</script>