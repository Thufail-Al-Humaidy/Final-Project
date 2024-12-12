<?php
if (isset($_SESSION["id_user"])) {

    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'"));

    $username = $user['username'];
    $email = $user['email'];
    $no_telp = $user['phone'];
    $alamat = $user['address'];
    $bio = $user['bio'];
    $profile = $user['avatar'];
    $gender = $user['gender'];
}
?>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-15">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex">
                        <form action="#">
                            <input type="text" placeholder="Search..." />
                            <button><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- notification start -->
                    <div class="notification-box ml-15 d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 20.1667C9.88317 20.1667 8.88718 19.63 8.23901 18.7917H13.761C13.113 19.63 12.1169 20.1667 11 20.1667Z"
                                    fill="" />
                                <path
                                    d="M10.1157 2.74999C10.1157 2.24374 10.5117 1.83333 11 1.83333C11.4883 1.83333 11.8842 2.24374 11.8842 2.74999V2.82604C14.3932 3.26245 16.3051 5.52474 16.3051 8.24999V14.287C16.3051 14.5301 16.3982 14.7633 16.564 14.9352L18.2029 16.6342C18.4814 16.9229 18.2842 17.4167 17.8903 17.4167H4.10961C3.71574 17.4167 3.5185 16.9229 3.797 16.6342L5.43589 14.9352C5.6017 14.7633 5.69485 14.5301 5.69485 14.287V8.24999C5.69485 5.52474 7.60672 3.26245 10.1157 2.82604V2.74999Z"
                                    fill="" />
                            </svg>
                            <span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                            <li>
                                <a href="#0">
                                    <div class="image">
                                        <img src="assets/images/lead/lead-6.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>
                                            John Doe
                                            <span class="text-regular">
                                                comment on a product.
                                            </span>
                                        </h6>
                                        <p>
                                            Lorem ipsum dolor sit amet, consect etur adipiscing
                                            elit Vivamus tortor.
                                        </p>
                                        <span>10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <div class="image">
                                        <img src="./../assets/images/lead/lead-1.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>
                                            Jonathon
                                            <span class="text-regular">
                                                like on a product.
                                            </span>
                                        </h6>
                                        <p>
                                            Lorem ipsum dolor sit amet, consect etur adipiscing
                                            elit Vivamus tortor.
                                        </p>
                                        <span>10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- notification end -->
                    <!-- message start -->
                    <div class="header-message-box ml-15 d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="message" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.74866 5.97421C7.91444 5.96367 8.08162 5.95833 8.25005 5.95833C12.5532 5.95833 16.0417 9.4468 16.0417 13.75C16.0417 13.9184 16.0364 14.0856 16.0259 14.2514C16.3246 14.138 16.6127 14.003 16.8883 13.8482L19.2306 14.629C19.7858 14.8141 20.3141 14.2858 20.129 13.7306L19.3482 11.3882C19.8694 10.4604 20.1667 9.38996 20.1667 8.25C20.1667 4.70617 17.2939 1.83333 13.75 1.83333C11.0077 1.83333 8.66702 3.55376 7.74866 5.97421Z"
                                    fill="" />
                                <path
                                    d="M14.6667 13.75C14.6667 17.2938 11.7939 20.1667 8.25004 20.1667C7.11011 20.1667 6.03962 19.8694 5.11182 19.3482L2.76946 20.129C2.21421 20.3141 1.68597 19.7858 1.87105 19.2306L2.65184 16.8882C2.13062 15.9604 1.83338 14.89 1.83338 13.75C1.83338 10.2062 4.70622 7.33333 8.25004 7.33333C11.7939 7.33333 14.6667 10.2062 14.6667 13.75ZM5.95838 13.75C5.95838 13.2437 5.54797 12.8333 5.04171 12.8333C4.53545 12.8333 4.12504 13.2437 4.12504 13.75C4.12504 14.2563 4.53545 14.6667 5.04171 14.6667C5.54797 14.6667 5.95838 14.2563 5.95838 13.75ZM9.16671 13.75C9.16671 13.2437 8.7563 12.8333 8.25004 12.8333C7.74379 12.8333 7.33338 13.2437 7.33338 13.75C7.33338 14.2563 7.74379 14.6667 8.25004 14.6667C8.7563 14.6667 9.16671 14.2563 9.16671 13.75ZM11.4584 14.6667C11.9647 14.6667 12.375 14.2563 12.375 13.75C12.375 13.2437 11.9647 12.8333 11.4584 12.8333C10.9521 12.8333 10.5417 13.2437 10.5417 13.75C10.5417 14.2563 10.9521 14.6667 11.4584 14.6667Z"
                                    fill="" />
                            </svg>
                            <span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="message">
                            <li>
                                <a href="#0">
                                    <div class="image">
                                        <img src="./../assets/images/lead/lead-5.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>Jacob Jones</h6>
                                        <p>Hey!I can across your profile and ...</p>
                                        <span>10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <div class="image">
                                        <img src="./../assets/images/lead/lead-3.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>John Doe</h6>
                                        <p>Would you mind please checking out</p>
                                        <span>12 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <div class="image">
                                        <img src="./../assets/images/lead/lead-2.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>Anee Lee</h6>
                                        <p>Hey! are you available for freelance?</p>
                                        <span>1h ago</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- message end -->
                    <!-- Home -->
                    <div class="header-message-box ml-15 d-none d-md-flex">
                        <button onclick="window.location.href='../../index.php'" class="d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20" height="20" fill="none"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                            </svg>
                        </button>
                    </div>
                    <!-- profile start -->
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <div class="image">
                                        <img
                                            src="<?php echo isset($profile) ? "../../public/img/profile/$profile" : "./../assets/images/profile/no-profile.png"; ?>"
                                            alt="Profile Avatar"
                                            class="img-fluid"
                                            style="width: 100%; height: 100%; object-fit: cover;" />
                                    </div>
                                    <div>
                                        <h6 class="fw-500"><?= $username ?></h6>
                                        <p>Admin</p>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <li>
                                <div class="author-info flex items-center !p-1">
                                    <div class="image">
                                        <img src="<?php echo isset($profile) ? "../../public/img/profile/$profile" : "./../assets/images/profile/no-profile.png"; ?>" alt="image">
                                    </div>
                                    <div class="content">
                                        <h4 class="text-sm"><?= $username ?></h4>
                                        <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#"><?= $email ?></a>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="?pg=profile">
                                    <i class="lni lni-user"></i> View Profile
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <i class="lni lni-alarm"></i> Notifications
                                </a>
                            </li>
                            <li>
                                <a href="#0"> <i class="lni lni-inbox"></i> Messages </a>
                            </li>
                            <li>
                                <a href="?pg=edit-profile"> <i class="lni lni-cog"></i> Settings </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="" class="logout"><i class="lni lni-exit"></i> Sign Out </a>
                            </li>
                        </ul>
                    </div>
                    <!-- profile end -->
                </div>
            </div>
        </div>
    </div>
</header>
<script src="./../assets/js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.logout', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "./../services/logout.php";
                }
            });
        });
    });
</script>