<?php
namespace College\Ddcollege\Route;

use College\Ddcollege\Controller\Logincontroller;

require_once 'route/session.php';
ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Login | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets/css/dashlite.css?ver=3.2.2">
    <link id="skin-default" rel="stylesheet" href="/assets/css/theme.css?ver=3.2.2">
</head>

<body class="nk-body bg-white npc-general pg-auth">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                <div class="nk-split nk-split-page nk-split-md">
                    <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                        <div class="nk-block nk-block-middle nk-auth-body">
                            <div class="brand-logo pb-5">
                                <a href="/" class="logo-link">
                                    <img class="logo-light logo-img logo-img-lg" src="assets/img/collegemain.webp"
                                         srcset="./images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img logo-img-lg" src="assets/img/collegemain.webp"
                                         srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title">Sign-In</h5>
                                    <div class="nk-block-des">
                                        <p>Access the College panel using your username and passcode.</p>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <form action="#" method="post">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Email or Username</label>
                                        <!--                                        <a class="link link-primary link-sm" tabindex="-1" href="#">Need Help?</a>-->
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" name="username" class="form-control form-control-lg"
                                               placeholder="Enter your username">
                                    </div>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Passcode</label>
                                        <!--                                        <a class="link link-primary link-sm" tabindex="-1"-->
                                        <!--                                           href="html/pages/auths/auth-reset-v3.html">Forgot Code?</a>-->
                                    </div>
                                    <div class="form-control-wrap">
                                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg"
                                           data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" name="password" class="form-control form-control-lg"
                                               placeholder="Enter your passcode">
                                    </div>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign
                                        in
                                    </button>
                                </div>
                            </form><!-- form -->
                        </div><!-- .nk-block -->
                        <div class="nk-block nk-auth-footer">
                            <div class="mt-3">
                                <p>&copy; <?= date('Y') ?> College Portal. All Rights Reserved.</p>
                            </div>
                        </div><!-- .nk-block -->
                    </div><!-- .nk-split-content -->
                    <div>
                        <img src="/assets/img/college-auth.webp" height="702">
                    </div><!-- .nk-split-content -->
                </div><!-- .nk-split -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->


</div>

<!-- .modal -->

<!-- app-root @e -->
<!-- JavaScript -->
<script src="/assets/js/bundle.js?ver=3.2.2"></script>
<script src="/assets/js/scripts.js?ver=3.2.2"></script>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $login = new Logincontroller();
    $login->login($username, $password);
}
ob_end_flush();

?>
</body>
</html>
