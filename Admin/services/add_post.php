<?php
require_once __DIR__ . '/../Classes/init.php';

$category = new Category();
$tag = new Tag();

$categories = $category->all();
$tags = $tag->all();
if (isset($_POST["submit"])) {
    $post = new Post();
    $result = $post->create($_POST, $_FILES);
}

?>
<style>
    .select2-container,
    .select2-selection {
        width: 100% !important;
    }

    .selection {
        width: 100% !important;
    }
</style>
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Create Post</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create Post
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->
    <div class="form-editor-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    <form action="" id="editor-form" method="post" enctype="multipart/form-data">
                        <div class="input-style-1">
                            <h6 class="mb-10">Judul Artikel</h6>
                            <input type="text" placeholder="Judul Artikel" name="title" />
                        </div>
                        <div class="input-style-1">
                            <h6 class="mb-10">Gambar Artikel</h6>
                            <div class="mb-3 w-100 <?= $post_id[0]['image_url'] != null ? 'd-block' : 'd-none'; ?>" id="preview-image">
                                <img src="<?= $post_id[0]['image_url'] != null ? '../../public/img/post_img/' . $post_id[0]['image_url'] : ''; ?>"
                                    alt="Preview Image"
                                    id="preview"
                                    style="width: 100%; max-width: 100%; height: 200px;">
                            </div>
                            <input class="form-control" type="file" name="image_url" id="postImage" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="select-style-1">
                            <h6 class="mb-10">Kategori Artikel</h6>
                            <div class="select-position">
                                <select class="light-bg" name="id_category">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['category_id']; ?>"><?= $category['name_category']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="select-style-1">
                            <label for="multiple-select-custom-field">Pilih Tag</label>
                            <select name="tags[]" multiple="multiple" id="multiple-select-custom-field" data-placeholder="Pilih Tag">
                                <?php foreach ($tags as $tag) : ?>
                                    <option value="<?= $tag['tags_id']; ?>"><?= $tag['name_tag']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="title d-flex justify-content-between align-items-center mt-10">
                            <h6 class="mb-30">Tulis Artikel</h6>
                        </div>
                        <div id="quill-toolbar">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-direction" value="rtl"></button>
                                <select class="ql-align"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean"></button>
                            </span>
                        </div>
                        <div id="quill-editor"></div>
                        <input type="hidden" name="content" id="content">
                        <div class="d-flex justify-content-end mt-30 gap-3">
                            <a href="index-post.php" class="main-btn light-btn btn-hover">Gak Jadi</a>
                            <button type="submit" class="main-btn primary-btn btn-hover" name="submit">Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- ========== form-editor-wrapper end ========== -->
</div>
<script src="./../assets/js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editor = new Quill("#quill-editor", {
            modules: {
                toolbar: "#quill-toolbar",
            },
            placeholder: "Type something",
            theme: "snow",
        });

        document.getElementById("editor-form").addEventListener("submit", function(event) {
            const quillContent = editor.root.innerHTML;
            document.getElementById("content").value = quillContent;
        });

        $('#multiple-select-custom-field').select2({
            theme: "classic",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
            closeOnSelect: false,
            tokenSeparators: [',', ' '],
            tags: true
        });

        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }



        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        <?php if (isset($result)): ?>
            <?php if (!$result['status']): ?>
                Toast.fire({
                    icon: "error",
                    title: "<?php echo $result['message']; ?>"
                });
            <?php else: ?>
                Toast.fire({
                    icon: "success",
                    title: "<?php echo $result['message']; ?>"
                });
                // setTimeout(function() {
                //     window.location.href = "./index-post.php";
                // }, 2200);
            <?php endif; ?>
        <?php endif; ?>
    });
</script>