<?php
require_once __DIR__ . '/../Classes/init.php';

if (isset($_POST["submit"])) {
    $user = new User();
    $result = $user->register($_POST);
}
?>
<div class="container-fluid">
    <div class="row g-0 auth-row">
        <div class="col-lg-6">
            <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                    <div class="title text-center">
                        <h1 class="text-primary mb-10">Get Started</h1>
                        <p class="text-medium">
                            Mulai bagikan cerita serumu 
                            <br class="d-sm-block" />
                            di blog ini
                        </p>
                    </div>
                    <div class="cover-image">
                        <img src="./../assets/images/auth/signin-image.svg" alt="" />
                    </div>
                    <div class="shape-image">
                        <img src="./../assets/images/auth/shape.svg" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-6">
            <div class="signup-wrapper">
                <div class="form-wrapper">
                    <h2 class="mb-15 title">Sign Up Sekarang</h2>
                    <p class="text-sm mb-25">
                        Buat akun dulu cuy sebelum bikin postingan
                    </p>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Name</label>
                                    <input type="text" name="username" placeholder="Name" />
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="phone-input">Phone number</label>
                                    <input type="tel" id="phone-input" name="phone" placeholder="Enter your phone number" />
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password" />
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-12">
                                <div class="button-group d-flex justify-content-center flex-wrap">
                                    <button name="submit" type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                        Sign Up
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </form>
                    <div class="singup-option pt-40">
                        <p class="text-sm text-medium text-dark text-center">
                            Already have an account? <a href="auth-page.php">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
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
                window.location.href = "./auth-page.php";
            }, 2200);
        <?php endif; ?>
    <?php endif; ?>
</script>