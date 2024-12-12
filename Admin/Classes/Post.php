<?php
require_once __DIR__ . '/../DB/connections.php';
require_once __DIR__ . '/Model.php';

class Post extends Model
{
    protected $table = 'blog_posts';
    protected $primary_key = 'id_post';

    public function all()
    {
        return parent::all_data($this->table);
    }
    public function find($id)
    {
        return parent::find_data($id, $this->table, $this->primary_key);
    }
    public function find_tag($post_id)
    {
        // Menggunakan prepared statement untuk keamanan
        $sql = "SELECT tags.tags_id, tags.name_tag 
            FROM pivot_post_tags 
            JOIN tags ON pivot_post_tags.tag_id_pivot = tags.tags_id 
            WHERE pivot_post_tags.post_id_pivot = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function delete($id)
    {
        return parent::delete_data($id, $this->table, $this->primary_key);
    }
    public function all_paginate($start, $limit)
    {
        return parent::paginate_data($limit, $start, $this->table);
    }

    public function create($post_data, $file_data)
    {
        if (empty($post_data) && empty($file_data)) {
            return ['status' => false, 'message' => 'Artikel tidak boleh kosong!'];
        }

        // Validasi gambar utama
        if (!isset($file_data["image_url"]) || $file_data["image_url"]["error"] === 4) {
            return ['status' => false, 'message' => 'Gambar artikel tidak boleh kosong!'];
        }

        $nama_file = $file_data["image_url"]["name"];
        $file_size = $file_data["image_url"]["size"];
        $tmp_name = $file_data["image_url"]["tmp_name"];
        $file_extension = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $allowed_extension = ["jpg", "jpeg", "gif", "svg", "png", "webp", "avif"];

        if (!in_array($file_extension, $allowed_extension)) {
            return ['status' => false, 'message' => 'Ekstensi file tidak diizinkan!'];
        }

        if ($file_size > 5120000) {
            return ['status' => false, 'message' => 'Ukuran file terlalu besar! Maksimal 5MB'];
        }

        $upload_dir = __DIR__ . '/../../public/img/post_img/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $nama_img_artikel = uniqid() . '_' . preg_replace('/[^\w\-]/', '_', $post_data['title']) . '.' . $file_extension;
        $upload_path = $upload_dir . $nama_img_artikel;

        if (!move_uploaded_file($tmp_name, $upload_path)) {
            return ['status' => false, 'message' => 'Gagal mengupload gambar'];
        }

        $data_to_save = [
            'user_id' => $_SESSION['id_user'],
            'title' => $post_data['title'],
            'id_category' => $post_data['id_category'],
            'image_url' => $nama_img_artikel
        ];

        $artikel_konten = $post_data['content'] ?? '';

        // Proses gambar base64
        preg_match_all('/<img[^>]+src="data:image\/([^;]+);base64,([^"]+)"[^>]*>/', $artikel_konten, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $image = base64_decode($match[2]);
            $image_extension = $match[1];
            $image_name = uniqid() . '.' . $image_extension;
            $image_path = $upload_dir . $image_name;

            if (file_put_contents($image_path, $image)) {
                $artikel_konten = str_replace($match[0], '<img src="./public/img/post_img/' . $image_name . '" alt="'. $image_name .'">', $artikel_konten);
            } else {
                return ['status' => false, 'message' => 'Gagal menyimpan gambar'];
            }
        }

        $clean_html = htmlspecialchars($artikel_konten, ENT_QUOTES, 'UTF-8');

        $data_to_save['content'] = $clean_html;
        $result = parent::create_data($data_to_save, $this->table);


        $tags = $_POST["tags"] ? $_POST["tags"] : [];
        $post_id = $this->db->insert_id;

        // var_dump($post_id);
        // var_dump($tags);
        // if (!is_string($tags)) {
        //     error_log("Tags bukan string, melainkan: " . gettype($tags));
        // }
        // die();

        if (!$post_id) {
            return ['status' => false, 'message' => 'Gagal menyimpan artikel'];
        }

        $tag_ids = [];

        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (ctype_digit($tag)) {
                $tag_ids[] = (int)$tag; // Konversi ke integer untuk menghindari SQL Injection
                continue;
            }

            $sql_check = "SELECT tags_id FROM tags WHERE name_tag = '" . $tag . "'";
            $result_check = mysqli_query($this->db, $sql_check);
            $exiting_tag = mysqli_fetch_assoc($result_check);

            if ($exiting_tag) {
                $tag_ids[] = $exiting_tag["tags_id"];
            } else {
                $sql_insert = "INSERT INTO tags (name_tag) VALUES ('" . $tag . "')";
                $result_insert = mysqli_query($this->db, $sql_insert);
                $tag_ids[] = mysqli_insert_id($this->db);
            }
        }

        foreach ($tag_ids as $tag_id) {
            $check_pivot = "SELECT * FROM pivot_post_tags WHERE post_id_pivot = $post_id AND tag_id_pivot = $tag_id";
            $result_check = mysqli_query($this->db, $check_pivot);

            if (mysqli_num_rows($result_check) === 0) {
                $insert_sql = "INSERT INTO `pivot_post_tags` (`post_id_pivot`, `tag_id_pivot`) VALUES ('$post_id', '$tag_id');";
                $result_insert = mysqli_query($this->db, $insert_sql);
            }

            if ($result_insert === false) {
                return ['status' => false, 'message' => 'Gagal menyimpan artikel'];
            }
        }


        if ($result) {
            return ['status' => true, 'message' => 'Artikel berhasil ditambahkan', 'data' => $result];
        }

        return ['status' => false, 'message' => 'Gagal menyimpan artikel'];
    }

    public function all_paginate2($id, $start = null, $limit = null, $keyword = null)
    {
        $sqlSearch = '';
        if (!empty($keyword)) {
            $keyword = mysqli_real_escape_string($this->db, $keyword);
            $sqlSearch = "AND blog_posts.title LIKE '%$keyword%'";
        }
        $sqlLimit = '';
        if ($start !== null && $limit !== null) {
            $sqlLimit = " LIMIT $start, $limit";
        }
        $sql = "SELECT 
        blog_posts.id_post, 
        blog_posts.content, 
        blog_posts.image_url,
        blog_posts.created_at, 
        blog_posts.title, 
        categories.name_category, 
        blog_posts.user_id, 
        users.username, 
        users.avatar, 
        GROUP_CONCAT(tags.name_tag SEPARATOR ', ') AS tags
    FROM 
        blog_posts
    JOIN 
        categories ON blog_posts.id_category = categories.category_id 
    JOIN 
        users ON blog_posts.user_id = users.id_user 
    JOIN 
        pivot_post_tags ON pivot_post_tags.post_id_pivot = blog_posts.id_post 
    JOIN 
        tags ON pivot_post_tags.tag_id_pivot = tags.tags_id 
    WHERE 
        blog_posts.user_id = '$id' $sqlSearch
    GROUP BY 
        blog_posts.id_post
    $sqlLimit";

        $result = $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function update($post_id, $post_data, $file_data)
    {
        if (empty($post_id) || empty($post_data)) {
            return ['status' => false, 'message' => 'Data artikel tidak boleh kosong!'];
        }

        // Validasi gambar baru (jika ada)
        $nama_img_artikel = null;
        if (isset($file_data["image_url"]) && $file_data["image_url"]["error"] !== 4) {
            $nama_file = $file_data["image_url"]["name"];
            $file_size = $file_data["image_url"]["size"];
            $tmp_name = $file_data["image_url"]["tmp_name"];
            $file_extension = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
            $allowed_extension = ["jpg", "jpeg", "gif", "svg", "png", "webp", "avif"];

            if (!in_array($file_extension, $allowed_extension)) {
                return ['status' => false, 'message' => 'Ekstensi file tidak diizinkan!'];
            }

            if ($file_size > 5120000) {
                return ['status' => false, 'message' => 'Ukuran file terlalu besar! Maksimal 5MB'];
            }

            $upload_dir = __DIR__ . '/../../public/img/post_img/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $nama_img_artikel = uniqid() . '_' . preg_replace('/[^\w\-]/', '_', $post_data['title']) . '.' . $file_extension;
            $upload_path = $upload_dir . $nama_img_artikel;

            if (!move_uploaded_file($tmp_name, $upload_path)) {
                return ['status' => false, 'message' => 'Gagal mengupload gambar'];
            }
        }

        // Siapkan data untuk update
        $data_to_update = [
            'title' => $post_data['title'],
            'id_category' => $post_data['id_category']
        ];

        if ($nama_img_artikel) {
            $data_to_update['image_url'] = $nama_img_artikel;
        }

        $artikel_konten = $post_data['content'] ?? '';
        $upload_dir = __DIR__ . '/../../public/img/post_img/';

        // Proses gambar base64
        preg_match_all('/<img[^>]+src="data:image\/([^;]+);base64,([^"]+)"[^>]*>/', $artikel_konten, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $image = base64_decode($match[2]);
            $image_extension = $match[1];
            $image_name = uniqid() . '.' . $image_extension;
            $image_path = $upload_dir . $image_name;

            if (file_put_contents($image_path, $image)) {
                $artikel_konten = str_replace($match[0], '<img src="/img/post_img/' . $image_name . '" alt="Image">', $artikel_konten);
            } else {
                return ['status' => false, 'message' => 'Gagal menyimpan gambar'];
            }
        }

        $clean_html = htmlspecialchars($artikel_konten, ENT_QUOTES, 'UTF-8');
        $data_to_update['content'] = $clean_html;

        // Update data artikel
        $result = parent::update_data($post_id, $data_to_update, $this->table, $this->primary_key);

        if (!$result) {
            return ['status' => false, 'message' => 'Gagal memperbarui artikel'];
        }

        // Update tag
        $tags = $_POST["tags"] ?? [];
        $tag_ids = [];

        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (ctype_digit($tag)) {
                $tag_ids[] = (int)$tag;
                continue;
            }

            $sql_check = "SELECT tags_id FROM tags WHERE name_tag = '" . $tag . "'";
            $result_check = mysqli_query($this->db, $sql_check);
            $existing_tag = mysqli_fetch_assoc($result_check);

            if ($existing_tag) {
                $tag_ids[] = $existing_tag["tags_id"];
            } else {
                $sql_insert = "INSERT INTO tags (name_tag) VALUES ('" . $tag . "')";
                $result_insert = mysqli_query($this->db, $sql_insert);
                $tag_ids[] = mysqli_insert_id($this->db);
            }
        }


        $delete_pivot = "DELETE FROM pivot_post_tags WHERE post_id_pivot = $post_id";
        mysqli_query($this->db, $delete_pivot);

        foreach ($tag_ids as $tag_id) {
            $insert_sql = "INSERT INTO `pivot_post_tags` (`post_id_pivot`, `tag_id_pivot`) VALUES ('$post_id', '$tag_id')";
            $result_insert = mysqli_query($this->db, $insert_sql);
            if (!$result_insert) {
                return ['status' => false, 'message' => 'Gagal memperbarui tag artikel'];
            }
        }

        return ['status' => true, 'message' => 'Artikel berhasil diperbarui'];
    }

    public function filter_data($id_user = null, $newwst = null, $views = null, $limit = null)
    {
        $allowed_sort_columns = ['created_at', 'views', 'updated_at'];
        $allowed_views = ['ASC', 'DESC'];

        if ($newwst !== null && !in_array($newwst, $allowed_sort_columns)) {
            $newwst = null;
        }

        if ($views !== null && !in_array($views, $allowed_views)) {
            $views = null;
        }

        $query = "SELECT 
            blog_posts.*, 
            categories.name_category,
            users.username,
            users.avatar
        FROM 
            blog_posts
        JOIN 
            users 
        ON 
            blog_posts.user_id = users.id_user 
        JOIN 
            categories 
        ON 
            blog_posts.id_category = categories.category_id";

        if ($id_user != null) {
            $query .= " WHERE blog_posts.user_id = $id_user";
        }

        if ($newwst !== null) {
            $query .= " ORDER BY $newwst";
            if ($views !== null) {
                $query .= " $views";
            }
        }

        if ($limit !== null) {
            $query .= " LIMIT $limit";
        }

        $result = mysqli_query($this->db, $query);
        

        if (!$result) {
            die("Query gagal: " . mysqli_error($this->db));
        }

        return parent::convert_data($result);
    }

    public function singgle_post($id_post)
    {
     $sql = "SELECT
    blog_posts.*,
    categories.name_category,
    blog_posts.user_id,
    users.username,
    users.avatar,
    GROUP_CONCAT(tags.name_tag SEPARATOR ', ') AS tags
    FROM
    blog_posts
    JOIN categories ON blog_posts.id_category = categories.category_id
    JOIN users ON blog_posts.user_id = users.id_user
    JOIN pivot_post_tags ON pivot_post_tags.post_id_pivot = blog_posts.id_post
    JOIN tags ON pivot_post_tags.tag_id_pivot = tags.tags_id
    WHERE
    blog_posts.id_post = '$id_post'
    GROUP BY
    blog_posts.id_post";
        $result = $this->db->query($sql)->fetch_assoc();
        return $result;
    }

    function count_views($id)
    {
        $sql = "SELECT SUM(blog_posts.views) AS total_views
    FROM blog_posts
    JOIN users ON blog_posts.user_id = users.id_user
    WHERE users.id_user = $id;";
        $result = mysqli_query($this->db, $sql);
        $result = $result->fetch_assoc();
        return $result;
    }

    public function post_category($id_category)
    {
        $sql = "SELECT 
        blog_posts.*,
        users.username,
        users.avatar,
        categories.name_category
        FROM
        categories
        JOIN blog_posts ON categories.category_id = blog_posts.id_category
        JOIN users ON blog_posts.user_id = users.id_user
        WHERE id_category = $id_category";

        $result = mysqli_query($this->db, $sql);
        return parent::convert_data($result);
    }
}
