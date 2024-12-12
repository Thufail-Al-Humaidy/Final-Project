<?php
require_once __DIR__ . '/Model.php';

class Category extends Model
{
    private $table = 'categories';
    protected $primary_key = 'category_id';

    public function create_category(array $post_data, array $file_data)
    {

        if (empty($post_data['name_category'])) {
            return [
                'status' => false,
                'message' => 'Nama kategori tidak boleh kosong!'
            ];
        }

        if (!isset($file_data["category_img"]) || $file_data["category_img"]["error"] === 4) {
            return [
                'status' => false,
                'message' => 'File gambar harus diupload!'
            ];
        }

        $nama_file = $file_data["category_img"]["name"];
        $file_size = $file_data["category_img"]["size"];
        $tmp_name = $file_data["category_img"]["tmp_name"];
        $file_extension = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $allowed_extension = ["jpg", "jpeg", "gif", "svg", "png", "webp", "avif"];


        if (!in_array($file_extension, $allowed_extension)) {
            return [
                'status' => false,
                'message' => 'Ekstensi file tidak diizinkan!'
            ];
        }

        if ($file_size > 5120000) {
            return [
                'status' => false,
                'message' => 'Ukuran file terlalu besar! Maksimal 5MB'
            ];
        }

        try {
            $nama_file = random_int(1000, 9999) . "_" . time() . "." . $file_extension;
            $upload_path = __DIR__ . "/../../public/img/category_img/";


            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            // Upload file
            if (!move_uploaded_file($tmp_name, $upload_path . $nama_file)) {
                return [
                    'status' => false,
                    'message' => 'Gagal mengupload file!'
                ];
            }

            $data_to_save = [
                'name_category' => $post_data['name_category'],
                'category_img' => $nama_file
            ];

            $result = parent::create_data($data_to_save, $this->table);

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Kategori berhasil ditambahkan',
                    'data' => $result
                ];
            }

            unlink($upload_path . $nama_file);
            return [
                'status' => false,
                'message' => 'Gagal menyimpan data kategori'
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function find($id)
    {
        return parent::find_data($id, $this->table, $this->primary_key);
    }

    public function all()
    {
        return parent::all_data($this->table);
    }

    public function all_paginate($limit, $start)
    {
        return parent::paginate_data($limit, $start, $this->table);
    }

    public function search($keyword, $start = null, $limit = null)
    {
        $queryLimit = '';
        if ($start !== null && $limit !== null) {
            $queryLimit = " LIMIT $start, $limit";
        }
        $keyword = "WHERE name_category LIKE '%$keyword%' $queryLimit";
        return parent::search_data($keyword, $this->table);
    }

    public function edit($id, $post_data, $file_data = null)
    {
        $allowed_extension = ["jpg", "jpeg", "gif", "svg", "png", "webp", "avif"];
        $upload_path = __DIR__ . "/../../public/img/category_img/";

        try {
            $current_data = parent::find_data($id, $this->table, $this->primary_key);
            if (!$current_data) {
                return [
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ];
            }

            $data_to_save = [
                'name_category' => $post_data['name_category'],
            ];

            if ($file_data && isset($file_data["category_img"])) {
                $nama_file = $file_data["category_img"]["name"];
                $file_size = $file_data["category_img"]["size"];
                $tmp_name = $file_data["category_img"]["tmp_name"];
                $file_extension = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

                // Validasi ekstensi file
                if (!in_array($file_extension, $allowed_extension)) {
                    return [
                        'status' => false,
                        'message' => 'Ekstensi file tidak diizinkan!'
                    ];
                }

                // Validasi ukuran file
                if ($file_size > 5120000) {
                    return [
                        'status' => false,
                        'message' => 'Ukuran file terlalu besar! Maksimal 5MB'
                    ];
                }

                $nama_file_baru = random_int(1000, 9999) . "_" . time() . "." . $file_extension;

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                if (!move_uploaded_file($tmp_name, $upload_path . $nama_file_baru)) {
                    return [
                        'status' => false,
                        'message' => 'Gagal mengupload file!'
                    ];
                }

                $data_to_save['category_img'] = $nama_file_baru;


                if (!empty($current_data['category_img']) && file_exists($upload_path . $current_data['category_img'])) {
                    unlink($upload_path . $current_data['category_img']);
                }
            }


            $result = parent::update_data($id, $data_to_save, $this->table, $this->primary_key);

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Kategori berhasil diubah',
                    'data' => $result
                ];
            }

            if (isset($data_to_save['category_img']) && file_exists($upload_path . $data_to_save['category_img'])) {
                unlink($upload_path . $data_to_save['category_img']);
            }

            return [
                'status' => false,
                'message' => 'Gagal menyimpan data kategori'
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        return parent::delete_data($id, $this->table, $this->primary_key);
    }

    public function category_views($limit = null)
    {
        $sqlLimit = '';
        if ($limit !== null) {
            $sqlLimit = "LIMIT $limit";
        }
        $sql = "SELECT
    categories.name_category AS category_name,
    categories.category_img AS category_img,
    categories.category_id AS category_id,
    COUNT(blog_posts.id_post) AS total_articles
    FROM
    categories
    LEFT JOIN blog_posts ON categories.category_id = blog_posts.id_category
    GROUP BY
    categories.category_id,
    categories.name_category
    ORDER BY
    total_articles
    DESC $sqlLimit";

        $result = mysqli_query($this->db, $sql);
        return parent::convert_data($result);
    }
}
