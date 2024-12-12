

  <section class="container mx-auto px-5 lg:px-10 py-10 bg-white rounded-lg shadow-lg my-20">
    <h2 class="text-2xl font-bold text-blue-900 mb-5 text-center">Contact Us</h2>
    <form action="#" method="post" class="space-y-8">
      <!-- Form Fields -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
          <label for="input-subject" class="block text-sm font-medium text-blue-900 mb-2">Subject</label>
          <input
            type="text"
            id="input-subject"
            name="subject"
            class="py-3 px-4 block w-full bg-blue-100 border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        </div>
        <div>
          <label for="input-name" class="block text-sm font-medium text-blue-900 mb-2">Name</label>
          <input
            type="text"
            id="input-name"
            name="name"
            class="py-3 px-4 block w-full bg-blue-100 border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        </div>
        <div>
          <label for="input-email" class="block text-sm font-medium text-blue-900 mb-2">Email</label>
          <input
            type="email"
            id="input-email"
            name="email"
            class="py-3 px-4 block w-full bg-blue-100 border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        </div>
      </div>

      <!-- Explanation Section -->
      <div>
        <label for="editor" class="block text-sm font-medium text-blue-900 mb-2">Explanation</label>
        <textarea
          id="editor"
          name="explanation"
          class="w-full h-40 p-4 bg-blue-100 border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
          placeholder="Type your explanation here..."></textarea>
      </div>

      <!-- File Upload -->
      <div>
        <label class="block text-sm font-medium text-blue-900 mb-2">Image Report</label>
        <div class="bg-blue-100 border border-blue-300 border-dashed rounded-lg p-4 text-center">
          <input id="file-upload" type="file" class="hidden" />
          <label for="file-upload" class="cursor-pointer flex flex-col items-center">
            <i class="fa-solid fa-upload text-blue-500 text-4xl"></i>
            <span class="mt-2 text-blue-500">Click to upload an image</span>
          </label>
          <p class="mt-2 text-sm text-blue-500">No file selected</p>
        </div>
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md flex items-center justify-center gap-2">
        <i class="fa-regular fa-paper-plane"></i>
        <span>Send</span>
      </button>
    </form>
  </section>



<!-- ModuleScripts -->
<script src="./node_modules/preline/dist/preline.js"></script>
<script src="./src/js/jquery-3.7.1.min.js"></script>
<script src="./assets/slick/slick.js"></script>
<!-- JavaScript -->
<script>
  const mobileMenuBtn = document.getElementById("mobile-menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");

  mobileMenuBtn.addEventListener("click", () => {
    if (mobileMenu.classList.contains("hidden")) {
      // Show menu
      mobileMenu.classList.remove("hidden");
      mobileMenu.classList.remove("-translate-y-full", "opacity-0");
      mobileMenu.classList.add("translate-y-0", "opacity-100");
    } else {
      // Hide menu
      mobileMenu.classList.add("-translate-y-full", "opacity-0");
      mobileMenu.classList.remove("translate-y-0", "opacity-100");
      setTimeout(() => mobileMenu.classList.add("hidden"), 300); // Delay for animation
    }
  });
</script>

