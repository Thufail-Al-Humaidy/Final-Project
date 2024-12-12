<?php
require_once __DIR__ . '/../DB/connections.php';

class Model extends Connection
{
    public function create_data($datas, $table)
    {
        //var_dump($data);
        $key = array_keys($datas);
        $val = array_values($datas);

        $key = implode(",", $key);
        $val = implode("','", $val);

        $query = "INSERT INTO $table ($key) VALUES ('$val')";
        $result = mysqli_query($this->db, $query);

        if ($result) {
            return $datas;
        } else {
            return false;
        }
    }

    public function all_data($table, $limit = null)
    {
        // Validasi nama tabel untuk mencegah SQL Injection
        $table = mysqli_real_escape_string($this->db, $table);

        $sql_limit = "";
        if (isset($limit) && !empty($limit)) {
            $sql_limit = " LIMIT " . intval($limit); // Konversi ke integer untuk keamanan
        }

        $query = "SELECT * FROM `$table` $sql_limit"; // Gunakan backtick untuk nama tabel
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Error: " . mysqli_error($this->db)); // Debugging jika query gagal
        }

        return $this->convert_data($result);
    }


    public function update_data($id, $datas, $table, $column)
    {
        $key = array_keys($datas);
        $val = array_values($datas);

        $query = "UPDATE $table SET ";

        for ($i = 0; $i < count($key); $i++) {
            $query .= $key[$i] . " = '" . $val[$i] . "'";
            if ($i != count($key) - 1) {
                $query .= " , ";
            }
        }

        $query .= " WHERE {$column} = $id";
        $result = mysqli_query($this->db, $query);
        if ($result) {
            return $datas;
        } else {
            return false;
        }
    }

    public function find_data($id, $table, $column)
    {
        $query = "SELECT * FROM $table WHERE {$column} = $id";
        $result = mysqli_query($this->db, $query);
        $data = $this->convert_data($result);
        if ($result->num_rows > 0) {
            return $data;
        } else {
            echo "ga ada data dengan id $id ";
        }
    }

    public function convert_data($datas)
    {
        $data = [];
        while ($row = mysqli_fetch_assoc($datas)) {
            $data[] = $row;
        }
        return $data;
    }

    public function delete_data($id, $table, $column)
    {
        $query = "DELETE FROM $table WHERE {$column} = $id";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function search_data($keyword, $table)
    {
        $sql = "SELECT * FROM $table $keyword";
        $result = mysqli_query($this->db, $sql);

        return $this->convert_data($result);
    }

    public function paginate_data($limit, $start, $table)
    {
        $query = "SELECT * FROM $table LIMIT $limit, $start";
        $result = mysqli_query($this->db, $query);

        return $this->convert_data($result);
    }

    public function all_filter($id_user, $table, $newwst = null, $views = null)
    {
        // Validasi parameter
        $allowed_sort_columns = ['created_at', 'views', 'updated_at']; // Contoh kolom yang diizinkan
        $allowed_views = ['ASC', 'DESC'];

        // Pastikan `$newwst` valid
        if ($newwst !== null && !in_array($newwst, $allowed_sort_columns)) {
            $newwst = null;
        }

        // Pastikan `$views` valid
        if ($views !== null && !in_array($views, $allowed_views)) {
            $views = null;
        }

        // Query dasar
        $query = "SELECT * FROM $table WHERE user_id = '$id_user'";

        // Tambahkan pengurutan jika diperlukan
        if ($newwst !== null) {
            $query .= " ORDER BY $newwst";
            if ($views !== null) {
                $query .= " $views";
            }
        }

        $result = mysqli_query($this->db, $query);

        // Periksa jika query gagal
        if (!$result) {
            die("Query gagal: " . mysqli_error($this->db));
        }

        return $this->convert_data($result);
    }

    public function cek_atmin()
    {
        $sql = "SELECT * FROM users WHERE id_user = 10 AND role = 'admin'";
        $result = mysqli_query($this->db, $sql);

        return $this->convert_data($result);
    }
}
