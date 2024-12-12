<?php
require_once __DIR__ . '/Model.php';

class Tag extends Model
{
    protected $table = 'tags';
    protected $primary_key = 'tags_id';


    public function create($datas)
    {
        if (empty($datas['name_tag'])) {
            return [
                'status' => false,
                'message' => 'Nama tag tidak boleh kosong!'
            ];
        }

        $result = parent::create_data($datas, $this->table);

        if ($result) {
            return [
                'status' => true,
                'message' => 'Tag berhasil ditambahkan',
                'data' => $result
            ];
        }
    }

    public function all()
    {
        return parent::all_data($this->table);
    }

    public function find($id)
    {
        return parent::find_data($id, $this->table, $this->primary_key);
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
        $keyword = "WHERE name_tag LIKE '%$keyword%' $queryLimit";
        return parent::search_data($keyword, $this->table);
    }

    public function edit($id, $datas)
    {
        if (empty($datas['name_tag'])) {
            return [
                'status' => false,
                'message' => 'Nama tag tidak boleh kosong!'
            ];
        }

        $result = parent::update_data($id, $datas, $this->table, $this->primary_key);

        if ($result) {
            return [
                'status' => true,
                'message' => 'Tag berhasil diubah',
                'data' => $result
            ];
        }

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Tag gagal diubah'
            ];
        }
    }

    public function delete($id)
    {
        $result = parent::delete_data($id, $this->table, $this->primary_key);

        if ($result) {
            return [
                'status' => true,
                'message' => 'Tag berhasil dihapus',
                'data' => $result
            ];
        }

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Tag gagal dihapus'
            ];
        }
    }

    public function popular_tag()
    {
        $sql = "SELECT
    tags.name_tag AS nama_tag,
    COUNT(pivot_post_tags.post_id_pivot) AS total_articles
FROM
    tags
LEFT JOIN pivot_post_tags ON tags.tags_id = pivot_post_tags.tag_id_pivot
LEFT JOIN blog_posts ON pivot_post_tags.post_id_pivot = blog_posts.id_post
GROUP BY
    tags.name_tag
ORDER BY
    total_articles
DESC
LIMIT 4";
 $result = mysqli_query($this->db, $sql);
        return parent::convert_data($result);
    }
}
