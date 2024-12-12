<?php
require_once __DIR__ . '/../Classes/Category.php';

$user = "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'";
$result = mysqli_query($conn, $user);
$row = mysqli_fetch_assoc($result);

if ($row['role'] != 'admin') {
    echo "<script>
        window.location.href = './../no_permission.html';
    </script>";
    exit();
}


$category = new Category();
$id = $_GET['id'];

$categories = $category->find($id);
if (isset($_POST["submit"])) {
    if(!empty($_FILES["category_img"]["name"])){
        $result = $category->edit($id, $_POST, $_FILES);
    }else{
        $result = $category->edit($id, $_POST);
    }
}

?>
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Edit Category</h2>
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
                                Edit Category
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
    <div class="row">
        <div class="col-lg-6">
            <div class="card-style mb-30">
                <img src="./../assets/icons/edit.gif" alt="" class="img-fluid">
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-6">
            <form class="card-style mb-30" action="" method="post" enctype="multipart/form-data">
                <h6 class="mb-25">Edit Category</h6>
                <div class="input-style-1">
                    <label>Category Name</label>
                    <input type="text" placeholder="Category Name" name="name_category" value="<?= $categories[0]['name_category']; ?>" />
                </div>
                <div class="input-style-1">
                    <label class="form-label">Image</label>
                    <div class="mb-3">
                        <div class="mt-3 <?php $categories[0]['category_img'] != null ? 'd-block' : 'd-none'; ?>" id="image-preview">
                            <div class="card" style="max-width: 200px;">
                                <img src="<?= $categories[0]['category_img'] != null ? '../../public/img/category_img/' . $categories[0]['category_img'] : ''; ?>" class="card-img-top" id="preview" alt="Preview">
                                <div class="card-body p-2">
                                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeImage()">
                                        <i class="lni lni-trash-can"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input class="form-control" type="file" name="category_img" id="categoryImage" accept="image/*" onchange="previewImage(this)">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="main-btn primary-btn btn-hover " name="submit">Update Category</button>
                </div>
            </form>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>
<!-- end container -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Definisikan Toast di luar kondisi
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
            setTimeout(function() {
                window.location.href = "./../views/index-category.php";
            }, 2200);
        <?php endif; ?>
    <?php endif; ?>

    function previewImage(input) {
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.classList.remove('d-none');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('categoryImage');
        const imagePreview = document.getElementById('image-preview');
        const preview = document.getElementById('preview');

        input.value = '';
        preview.src = '';
    }
</script>