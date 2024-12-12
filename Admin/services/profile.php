<?php
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
} else {
    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));
    $name = $user['username'];
    $email = $user['email'];
    $no_telp = $user['phone'];
    $alamat = $user['address'];
    $bio = $user['bio'];
    $profile = $user['avatar'];
    $gender = $user['gender'];
    $job = $user['job'];
    $banner = $user['banner'];
}
?>
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Profile Info</h2>
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
                                Profile
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
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="profile-wrapper mb-30 border rounded shadow">
                <!-- Cover Image -->
                <div class="position-relative profile-cover overflow-hidden rounded-top">
                    <img
                        src="<?= isset($banner) ? "../../public/img/banner/$banner" : "./../assets/images/profile/profile-cover.jpg"; ?>"
                        alt="cover-image"
                        class="w-100 img-fluid"
                        style="max-height: 300px; object-fit: cover;">

                    <!-- Edit Icon for Cover -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <a href="?pg=edit-profile" class="btn btn-light d-grid place-items-center py-2 px-2 shadow" title="Edit Cover Photo">
                            <i class="lni lni-pencil fs-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="position-relative text-center" style="margin-top: -60px;">
                    <div class="d-inline-block">
                        <div class="position-relative">
                            <img src="<?php echo isset($profile) ? "../../public/img/profile/$profile" : "./../assets/images/profile/no-profile.png"; ?>" alt="profile" class="rounded-circle" style="width: 130px; height: 130px;">
                        </div>
                    </div>
                </div>
                <!-- Profile Meta -->
                <div class="text-center mt-4">
                    <h5 class="fw-bold mb-1"><?= $name ?></h5>
                    <p class="text-muted mb-4"><?= $email ?></p>
                </div>
                <!-- About Section -->
                <div class="profile-info p-4">
                    <h1 class="fw-bold mb-3">Bio</h1>
                    <p class="text-muted mb-5 p-3 rounded" style="background-color: white;">
                        <?php if (!isset($bio)) : echo "Bio Belum Diisi";
                        else : echo $bio;
                        endif; ?>
                    </p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-style settings-card-1 mb-30">
                                <div class="profile-info">
                                    <div class="input-style-1">
                                        <label>Email</label>
                                        <input type="email" placeholder="admin@example.com" value="<?= $email ?>" />
                                    </div>
                                    <div class="input-style-1">
                                        <label>Username</label>
                                        <input type="text" placeholder="username" value="<?= $username ?>" />
                                    </div>
                                    <div class="input-style-1">
                                        <label>Job</label>
                                        <input type="text" placeholder="Job" value="<?= $job ?>" />
                                    </div>
                                    <div class="select-style-1">
                                        <label>Gender</label>
                                        <div class="select-position">
                                            <select name="gender">
                                                <option value="<?= $gender ?>" selected><?= $gender ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card-style settings-card-1 mb-30">
                                <div class="profile-info">
                                    <div class="input-style-1">
                                        <label>No Telp</label>
                                        <input type="tel" placeholder="085xxxxx" value="<?= $no_telp ?>" />
                                    </div>
                                    <div class="input-style-1">
                                        <label>Alamat</label>
                                        <textarea name="address" placeholder="Alamat" id="" cols="10" rows="5">
                                            <?php if (!isset($alamat)) : echo "Alamat Belum Diisi";
                                            else : echo $alamat;
                                            endif; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- Social Icons -->
                    <div class="text-center">
                        <ul class="list-inline">
                            <li class="list-inline-item mx-2">
                                <a href="#0" class="py-2 px-3 rounded primary-btn btn-hover"><i class="lni lni-facebook-fill"></i></a>
                            </li>
                            <li class="list-inline-item mx-2">
                                <a href="#0" class="py-2 px-3 rounded primary-btn btn-hover"><i class="lni lni-twitter-fill"></i></a>
                            </li>
                            <li class="list-inline-item mx-2">
                                <a href="#0" class="py-2 px-3 rounded primary-btn btn-hover"><i class="lni lni-instagram-fill"></i></a>
                            </li>
                            <li class="list-inline-item mx-2">
                                <a href="#0" class="py-2 px-3 rounded primary-btn btn-hover"><i class="lni lni-behance-original"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>