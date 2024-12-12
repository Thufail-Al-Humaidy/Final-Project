<?php
require_once __DIR__ . '/../Classes/init.php';

if (isset($_SESSION["id_user"])) {
    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));

    $name = $user['username'];
    $email = $user['email'];
    $no_telp = $user['phone'];
    $alamat = $user['address'];
    $bio = $user['bio'];
    $profile = $user['avatar'];
    $gender = $user['gender'];
    $job = $user['job'];
}
if (isset($_POST["submit"])) {
    // var_dump($_POST);
    //  var_dump($_FILES['banner']);
    // die();
    $user = new User();
    if (!empty($_FILES)) {
        $result = $user->update_profile($_SESSION["id_user"], $_POST, $_FILES);
    } else {
        $result = $user->update_profile($_SESSION["id_user"], $_POST);
    }
}
?>
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Settings</h2>
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
                            <li class="breadcrumb-item"><a href="#0">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Profile
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
        <div class="col-lg-4">
            <div class="card-style settings-card-1 mb-30">
                <div class="title mb-30 d-flex justify-content-between align-items-center">
                    <h6>My Photo Profile</h6>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <div class="mt-3 d-block" id="image-preview">
                            <div class="card" style="max-width: 200px;">
                                <img src="<?= isset($profile) ? "../../public/img/profile/$profile" : ""; ?>" class="card-img-top" id="preview" alt="Preview">
                            </div>
                        </div>
                        <div class="card-body pt-2">
                            <label for="categoryImage" class="btn btn-success btn-sm w-100" onclick="removeImage()">
                                Change
                            </label>
                            <input class="form-control d-none" type="file" name="avatar" id="categoryImage" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="card-body pt-2">
                            <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeImage()">
                                <i class="lni lni-trash-can"></i> Remove
                            </button>
                        </div>
                    </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-8">
            <div class="card-style settings-card-2 mb-30">
                <div class="title mb-30">
                    <h6>My Profile</h6>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Banner</label>
                            <input type="file" name="banner">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Full Name</label>
                            <input type="text" name="username" placeholder="Full Name" value="<?= $name ?>" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Job</label>
                            <input type="text" name="job" placeholder="Job" value="<?= $job ?>" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Bio</label>
                            <textarea placeholder="Tulis sesuatu tentang dirimu" name="bio" rows="6"><?= $bio ?></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email" value="<?= $email ?>" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>no telp</label>
                            <input type="telp" name="phone" placeholder="no telp" value="<?= $no_telp ?>" />
                        </div>
                    </div>
                    <div class="input-style-1">
                        <label>Alamat</label>
                        <textarea name="address" placeholder="alamat mu :0" id="" cols="10" rows="5"><?= $alamat ?></textarea>
                    </div>
                    <div class="select-style-1">
                        <label>Gender</label>
                        <div class="select-position">
                            <select name="gender">
                                <option value=""></option>
                                <option value="laki-laki" <?php if ($gender == "laki-laki") echo "selected"; ?>>Laki-laki</option>
                                <option value="perempuan" <?php if ($gender == "perempuan") echo "selected"; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="?pg=profile" class="main-btn light-btn btn-hover">
                            Gak Jadi
                        </a>
                        <button name="submit" class="main-btn primary-btn btn-hover">
                            Update Profile
                        </button>
                    </div>
                </div>
                </form>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- end container -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
                window.location.href = "./../views/index.php?pg=profile";
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
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('categoryImage');
        const imagePreview = document.getElementById('image-preview');
        const preview = document.getElementById('preview');

        input.value = '';
        preview.src = './../assets/images/profile/no-profile.png';
    }
</script>