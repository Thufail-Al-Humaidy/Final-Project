<?php
require_once __DIR__ . '/../Classes/init.php';

if (isset($_POST["submit"])) {
    $user = new User();
    $result = $user->login($_POST);
}
?>
<div class="container-fluid">
    <div class="row g-0 auth-row">
        <div class="col-lg-6">
            <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                    <div class="title text-center">
                        <h1 class="text-primary mb-10">Welcome Back</h1>
                        <p class="text-medium">
                            Sign in to your Existing account to continue
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
            <div class="signin-wrapper">
                <div class="form-wrapper">
                    <div class="button-group d-flex mb-2">
                        <button onclick="window.location.href = '../../index.php'" class="main-btn primary-btn btn-hover text-center">
                        <i class="fa-solid fa-caret-left"></i>
                        </button>
                    </div>
                    <h2 class="mb-15 title">Sign In</h2>
                    <p class="text-sm mb-25">
                        Sign in ke akun mu untuk liat perkembangan Blog mu!
                    </p>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Email" />
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
                            <div class="col-xxl-6 col-lg-12 col-md-6">
                                <div class="form-check checkbox-style mb-30">
                                    <input class="form-check-input" type="checkbox" value="" id="checkbox-remember" />
                                    <label class="form-check-label" for="checkbox-remember">
                                        Remember me next time</label>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-xxl-6 col-lg-12 col-md-6">
                                <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                                    <a href="reset-password.html" class="hover-underline">
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-12">
                                <div class="button-group d-flex justify-content-center flex-wrap">
                                    <button name="submit" type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                        Sign In
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </form>
                    <div class="singin-option pt-40">
                        <p class="text-sm text-medium text-dark text-center">
                            Don’t have any account yet?
                            <a href="./../views/auth-page.php?pg=signup">Create an account</a>
                        </p>
                    </div>
                </div>
            </div>
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
        timer: 2500,
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
                window.location.href = "index.php";
            }, 2600);
        <?php endif; ?>
    <?php endif; ?>
</script>