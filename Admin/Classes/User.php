<?php
require_once __DIR__ . '/Model.php';

class User extends Model
{
    protected $table = "users";
    protected $primary_key = "id_user";

    public function all()
    {
        return parent::all_data($this->table);
    }
    public function all_limit($limit)
    {
        return parent::all_data($this->table, $limit);
    }
    public function find($id)
    {
        return parent::find_data($id, $this->table, $this->primary_key);
    }
    public function update_profile($id, $post_data, $file_data = null)
    {
        $allowed_extension = ["jpg", "jpeg", "gif", "svg", "png", "webp", "avif"];
        $upload_path = __DIR__ . "/../../public/img/profile/";
        $upload_path_banner =  __DIR__ . "/../../public/img/banner/";

        try {
            $current_data = parent::find_data($id, $this->table, $this->primary_key);
            if (!$current_data) {
                return [
                    'status' => false,
                    'message' => 'Data pengguna tidak ditemukan'
                ];
            }

            $data_to_save = [
                'username' => $post_data['username'],
                'email' => $post_data['email'],
                'phone' => $post_data['phone'],
                'bio' => $post_data['bio'],
                'address' => $post_data['address'],
                'gender' => $post_data['gender'],
                'job' => $post_data['job']
            ];

            // Proses Avatar
            if (!empty($file_data['avatar']['tmp_name'])) {
                $avatar = $file_data['avatar'];
                $avatar_extension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));

                if (!in_array($avatar_extension, $allowed_extension)) {
                    return [
                        'status' => false,
                        'message' => 'Format file avatar tidak diizinkan'
                    ];
                }

                if ($avatar['size'] > 3000000) {
                    return [
                        'status' => false,
                        'message' => 'Ukuran file avatar tidak boleh lebih dari 3MB'
                    ];
                }

                $new_avatar_name = random_int(1000, 9999) . "_" . time() . "." . $avatar_extension;

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                if (!move_uploaded_file($avatar['tmp_name'], $upload_path . $new_avatar_name)) {
                    return [
                        'status' => false,
                        'message' => 'Gagal mengupload avatar'
                    ];
                }

                $data_to_save['avatar'] = $new_avatar_name;

                // Hapus avatar lama jika ada
                if (!empty($current_data['avatar']) && file_exists($upload_path . $current_data['avatar'])) {
                    unlink($upload_path . $current_data['avatar']);
                }
            }

            // Proses Banner
            if (!empty($file_data['banner']['tmp_name'])) {
                $banner = $file_data['banner'];
                $banner_extension = strtolower(pathinfo($banner['name'], PATHINFO_EXTENSION));

                if (!in_array($banner_extension, $allowed_extension)) {
                    return [
                        'status' => false,
                        'message' => 'Format file banner tidak diizinkan'
                    ];
                }

                if ($banner['size'] > 3000000) {
                    return [
                        'status' => false,
                        'message' => 'Ukuran file banner tidak boleh lebih dari 3MB'
                    ];
                }

                $new_banner_name = random_int(1000, 9999) . "_" . time() . "." . $banner_extension;

                if (!file_exists($upload_path_banner)) {
                    mkdir($upload_path_banner, 0777, true);
                }

                if (!move_uploaded_file($banner['tmp_name'], $upload_path_banner . $new_banner_name)) {
                    return [
                        'status' => false,
                        'message' => 'Gagal mengupload banner'
                    ];
                }

                $data_to_save['banner'] = $new_banner_name;

                // Hapus banner lama jika ada
                if (!empty($current_data['banner']) && file_exists($upload_path_banner . $current_data['banner'])) {
                    unlink($upload_path_banner . $current_data['banner']);
                }
            }

            // Update data pengguna
            $result = parent::update_data($id, $data_to_save, $this->table, $this->primary_key);

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Profil pengguna berhasil diperbarui',
                    'data' => $result
                ];
            }

            return [
                'status' => false,
                'message' => 'Gagal memperbarui profil pengguna'
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }


    public function register($datas)
    {

        if (empty($datas['email']) || empty($datas['password']) || empty($datas['username'])) {
            return [
                'status' => false,
                'message' => 'Data tidak boleh kosong'
            ];
        }

        $email = mysqli_real_escape_string($this->db, $datas['email']);
        $password = mysqli_real_escape_string($this->db, $datas['password']);
        $username = mysqli_real_escape_string($this->db, $datas['username']);
        $notelp = mysqli_real_escape_string($this->db, $datas['phone']);

        $sql = "SELECT * FROM $this->table WHERE email = '$email'";
        $result = mysqli_query($this->db, $sql);

        if (mysqli_num_rows($result) > 0) {
            return [
                'status' => false,
                'message' => 'Email sudah terdaftar'
            ];
        }

        $pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table (username, email, password, phone) VALUES ('$username', '$email', '$pass', '$notelp')";
        $result = mysqli_query($this->db, $sql);

        try {
            if (!$result) {
                return [
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . mysqli_error($this->db)
                ];
            }
            if ($result) {
                $user = mysqli_insert_id($this->db);
                $_SESSION['id_user'] = $user;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $notelp;

                $full_data = [
                    'username' => $username,
                    'email' => $email,
                    'phone' => $notelp
                ];

                return [
                    'status' => true,
                    'message' => 'Register Berhasil',
                    'data' => $full_data
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function login($datas)
    {
        $email = $datas['email'];
        $password = $datas['password'];


        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];

                return [
                    'status' => true,
                    'message' => 'Login Berhasil'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Password salah'
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => 'Email tidak ditemukan'
            ];
        }
    }

    public function logout()
    {
        session_destroy();
        return [
            'status' => true,
            'message' => 'Logout Berhasil'
        ];
    }

    public function top_user()
    {
        $sql = "SELECT
    users.*,
    SUM(blog_posts.views) AS total_views,
    COUNT(blog_posts.id_post) AS total_posts
FROM
    users
LEFT JOIN blog_posts ON users.id_user = blog_posts.user_id
GROUP BY
    users.id_user
ORDER BY
    total_posts
DESC LIMIT 4";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
