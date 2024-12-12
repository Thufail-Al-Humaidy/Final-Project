Untuk menambahkan fitur **views** (jumlah dilihat) pada setiap blog post, Anda dapat mengikuti langkah-langkah berikut:

---

### **1. Tambahkan Kolom `views` di Tabel Blog Posts**
Pastikan tabel `blog_posts` memiliki kolom `views` untuk menyimpan jumlah views setiap post. Anda dapat menambahkan kolom ini dengan query berikut:

```sql
ALTER TABLE blog_posts ADD COLUMN views INT DEFAULT 0;
```

---

### **2. Increment Views Setiap Post Dilihat**
Setiap kali sebuah post diakses, Anda perlu menambahkan 1 ke kolom `views`. Lakukan ini di bagian script PHP yang memuat konten post (misalnya, `single_post.php`).

#### Contoh:
```php
<?php
$post_id = $_GET['id']; // Ambil ID post dari URL

// Query untuk menambah views
$sql = "UPDATE blog_posts SET views = views + 1 WHERE id_post = $post_id";
mysqli_query($db, $sql);

// Query untuk mendapatkan data post (termasuk jumlah views)
$sql = "SELECT * FROM blog_posts WHERE id_post = $post_id";
$result = mysqli_query($db, $sql);
$post = mysqli_fetch_assoc($result);
?>
```

---

### **3. Tampilkan Jumlah Views di Post**
Anda bisa menampilkan jumlah views di halaman post dengan menambahkan elemen HTML sederhana:

#### Contoh:
```html
<div class="post-meta">
    <p><i class="ph ph-eye"></i> <?= $post['views']; ?> Views</p>
</div>
```

---

### **4. (Opsional) Atur Views di Halaman Daftar Post**
Jika Anda ingin menampilkan jumlah views di halaman daftar post (misalnya, dashboard admin atau halaman homepage), tambahkan kolom `views` pada query SELECT.

#### Contoh:
```php
$sql = "SELECT id_post, title, views FROM blog_posts ORDER BY views DESC";
$result = mysqli_query($db, $sql);

while ($post = mysqli_fetch_assoc($result)) {
    echo "<div class='post-item'>";
    echo "<h3>" . $post['title'] . "</h3>";
    echo "<p><i class='ph ph-eye'></i> " . $post['views'] . " Views</p>";
    echo "</div>";
}
```

---

### **5. (Opsional) Filter Berdasarkan Popularitas**
Jika Anda ingin menampilkan post berdasarkan jumlah views (post populer), Anda bisa menambahkan fitur sorting.

#### Contoh Query:
```php
$sql = "SELECT * FROM blog_posts ORDER BY views DESC LIMIT 5"; // Post dengan views terbanyak
```

---

### **6. Hindari Views Bertambah dari Pengunjung Sama (Opsional)**
Jika Anda ingin views hanya bertambah sekali untuk setiap pengguna dalam waktu tertentu, Anda bisa menggunakan **session** atau **cookie** untuk melacak post yang sudah dilihat.

#### Contoh:
```php
session_start();
$post_id = $_GET['id'];

// Cek apakah post ini sudah pernah dilihat
if (!isset($_SESSION['viewed_posts'][$post_id])) {
    // Tambah views
    $sql = "UPDATE blog_posts SET views = views + 1 WHERE id_post = $post_id";
    mysqli_query($db, $sql);

    // Tandai post ini sudah dilihat
    $_SESSION['viewed_posts'][$post_id] = true;
}
```

---

### **Hasil Akhir**
1. Setiap kali pengguna mengakses sebuah post, jumlah views akan otomatis bertambah.
2. Jumlah views akan ditampilkan di setiap post.
3. (Opsional) Anda dapat menambahkan fitur post populer berdasarkan jumlah views. 

Jika ada langkah tertentu yang ingin dijelaskan lebih mendalam, beri tahu saya! 😊

<a href="https://storyset.com/communication">Communication illustrations by Storyset</a>

sql jumlah kategori = 
```php
"SELECT
    blog_posts.*,
    categories.name_category
FROM
    blog_posts
JOIN categories ON blog_posts.id_category = categories.category_id 
ORDER BY
    RAND()
LIMIT 4";```