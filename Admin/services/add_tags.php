<?php
require_once __DIR__ . '/../Classes/init.php';

$tag = new Tag();
$user = "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'";
$result = mysqli_query($conn, $user);
$row = mysqli_fetch_assoc($result);

if ($row['role'] != 'admin') {
    echo "<script>
        window.location.href = './../no_permission.html';
    </script>";
    exit();
}

if (isset($_POST["submit"])) {
    $datas = [
        'name_tag' => $_POST['name_tag']
    ];
    $result = $tag->create($datas);
}

?>
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Add Tag</h2>
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
                                Add Tag
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
                <img src="./../assets/icons/add-file.gif" alt="" class="img-fluid">
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-6">
            <form class="card-style mb-30" action="" method="post">
                <h6 class="mb-25">Add Tag</h6>
                <div class="input-style-1">
                    <label>Tag Name</label>
                    <input type="text" placeholder="Tag Name" name="name_tag" />
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="main-btn primary-btn btn-hover " name="submit">Add Tag</button>
                </div>
            </form>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>
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
                title: "<?= $result['message']; ?>"
            });
        <?php else: ?>
            Toast.fire({
                icon: "success",
                title: "<?= $result['message']; ?>"
            });
            setTimeout(function(){
                window.location.href = "./index-tags.php";
            }, 2200)
        <?php endif; ?>
    <?php endif; ?>
</script>