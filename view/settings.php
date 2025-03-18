<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$db = new \College\Ddcollege\Model\database();
$settingcontroller = new \College\Ddcollege\Controller\settingcontroller();
$logincontroller = new \College\Ddcollege\Controller\Logincontroller();
$status = new \College\Ddcollege\Model\status();
?>
    <!doctype html>
    <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
          data-menu-styles="dark" data-toggled="close">

<?= $component->script("Settings") ?>
<body>
<!-- Layout wrapper -->

<!-- Menu -->
<!-- Layout container -->
<?= $component->rendersidebar() ?>

<div class="nk-wrap ">

    <?= $component->topbar() ?>


    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview">

                        <?= $settingcontroller->update_profile_popup(); ?>
                        <?= $logincontroller->ChangePasswordForm(); ?>

                    </div><!-- .code-block -->
                </div>
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="title nk-block-title">Settings</h4>
                        </div>
                    </div>
                    <div class="card card-bordered card-preview">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="user-card w-20">
                                    <div class="user-avatar bg-primary">
                                        <span><?= substr($_SESSION["username"], 0, 1); ?></span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text"><?= $_SESSION["username"] ?></span>
                                        <span class="sub-text"><?php
                                            if ($_SESSION["user_role"] != "admin") {
                                                $faculty_id = $_SESSION["user_id"];
                                                echo $db->viewdata("faculty_details", "faculty_email", "faculty_id='$faculty_id'")[0]["faculty_email"];
                                            }
                                            ?></span>
                                    </div>
                                    <div class="user-action">
                                        <div class="dropdown">
                                            <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown"
                                               href="#"><em class="icon ni ni-more-v"></em></a>
                                            <div class="dropdown-menu">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a>
                                                    </li>
                                                    <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->

                            <div class="card-inner">

                                <div class="row g-gs">
                                    <div class="col-md-4">
                                        <ul class="nav link-list-menu border border-light round m-0">
                                            <li>
                                                <a class="active" data-bs-toggle="tab" id="settingpanel-1"
                                                   href="#tabItem17"><em
                                                            class="icon ni ni-user"></em><span>Personal</span></a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tab" id="settingpanel-2" href="#tabItem18"><em
                                                            class="icon ni ni-lock-alt"></em><span>Security</span></a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tab" id="settingpanel-3" href="#tabItem19"><em
                                                            class="icon ni ni-bell"></em><span>Notifications</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabItem17">
                                                <div class="nk-block-head nk-block-head-lg">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <h4 class="nk-block-title">Personal Information</h4>
                                                            <div class="nk-block-des">
                                                                <p>Basic info, like your name and address, that you use
                                                                    on Nio Platform.</p>
                                                            </div>
                                                        </div>
                                                        <?= $settingcontroller->buttonforedit(); ?>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                                               data-target="userAside"><em
                                                                        class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="nk-data data-list">
                                                        <div class="data-head">
                                                            <h6 class="overline-title">PERSONAL</h6>
                                                        </div>

                                                        <div class="data-item">
                                                            <span class="data-label">Full Name</span>
                                                            <span class="data-value setting-user-full-name data-request-full-name"></span>
                                                        </div>
                                                        <div class="data-item">
                                                            <span class="data-label">User Name</span>
                                                            <span class="data-value setting-user-name data-request-user-name"></span>
                                                        </div>
                                                        <?php
                                                        if ($_SESSION["user_role"] != "admin") {
                                                            ?>
                                                            <div class="data-item">
                                                                <span class="data-label">Email</span>
                                                                <span class="data-value setting-user-email data-request-email"></span>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="data-item">
                                                            <span class="data-label">Phone Number</span>
                                                            <span class="data-value text-soft setting-user-phone-number data-request-phone-number"></span>
                                                        </div>
                                                        <?php
                                                        if ($_SESSION["user_role"] != "admin") {
                                                            ?>
                                                            <div class="data-item">
                                                                <span class="data-label">Date of Birth</span>
                                                                <span class="data-value setting-user-dob data-request-dob"></span>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($_SESSION["user_role"] != "admin") {
                                                            ?>
                                                            <div class="data-item">
                                                                <span class="data-label">Address</span>
                                                                <span class="data-value setting-user-address-1 data-request-address-1"></span>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($_SESSION["user_role"] != "admin") {
                                                            ?>
                                                            <div class="data-item">
                                                                <span class="data-label">Address 2</span>
                                                                <span class="data-value setting-user-address-2 data-request-address-2"></span>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                    </div><!-- data-list -->
                                                </div><!-- .nk-block -->
                                            </div>
                                            <div class="tab-pane" id="tabItem18">
                                                <div class="nk-block-head nk-block-head-lg">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <h4 class="nk-block-title">Security Settings</h4>
                                                            <div class="nk-block-des">
                                                                <p>These settings are helps you keep your account
                                                                    secure.</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" id="save-security-settings"
                                                                name="save-security-settings">Save
                                                        </button>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                                               data-target="userAside"><em
                                                                        class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner-group">
                                                            <div class="card-inner">
                                                                <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                                    <div class="nk-block-text">
                                                                        <h6>Save my Activity Logs</h6>
                                                                        <p>You can save your all activity logs including
                                                                            unusual activity detected.</p>
                                                                    </div>
                                                                    <div class="nk-block-actions">
                                                                        <ul class="align-center gx-3">
                                                                            <li class="order-md-last">
                                                                                <div class="custom-control custom-switch me-n2">
                                                                                    <input type="checkbox"
                                                                                           class="custom-control-input"
                                                                                           checked="" id="activity-log">
                                                                                    <label class="custom-control-label"
                                                                                           for="activity-log"></label>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .card-inner -->
                                                            <div class="card-inner">
                                                                <div class="between-center flex-wrap g-3">
                                                                    <div class="nk-block-text">
                                                                        <h6>Change Password</h6>
                                                                        <p>Set a unique password to protect your
                                                                            account.</p>
                                                                    </div>
                                                                    <div class="nk-block-actions flex-shrink-sm-0">
                                                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                                            <li class="order-md-last">
                                                                                <button type="button"
                                                                                        class="btn btn-primary"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#changePassword">
                                                                                    Change Password
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .card-inner -->
                                                            <div class="card-inner">
                                                                <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                                    <div class="nk-block-text">
                                                                        <h6>2 Factor Auth &nbsp; <span
                                                                                    class="badge bg-success ms-0">Enabled</span>
                                                                        </h6>
                                                                        <p>Secure your account with 2FA security. When
                                                                            it is activated you will need to enter not
                                                                            only your password, but also a special code
                                                                            using app. You can receive this code by in
                                                                            mobile app. </p>
                                                                    </div>
                                                                    <div class="nk-block-actions">
                                                                        <a href="#" class="btn btn-primary">Disable</a>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .card-inner -->
                                                        </div><!-- .card-inner-group -->
                                                    </div><!-- .card -->
                                                </div><!-- .nk-block -->
                                            </div>
                                            <div class="tab-pane" id="tabItem19">
                                                <div class="nk-block-head nk-block-head-lg">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <h4 class="nk-block-title">Notification Settings</h4>
                                                            <div class="nk-block-des">
                                                                <p>You will get only notification what have enabled.</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" id="save-notification"
                                                                name="save-notification">Save
                                                        </button>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                                               data-target="userAside"><em
                                                                        class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block-head nk-block-head-sm">
                                                    <div class="nk-block-head-content">
                                                        <h6>Security Alerts</h6>
                                                        <p>You will get only those email notification what you want.</p>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block-content">
                                                    <div class="gy-3">
                                                        <div class="g-item">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked id="unusual-activity">
                                                                <label class="custom-control-label"
                                                                       for="unusual-activity">Email me whenever
                                                                    encounter unusual activity</label>
                                                            </div>
                                                        </div>
                                                        <div class="g-item">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="new-browser">
                                                                <label class="custom-control-label" for="new-browser">Email
                                                                    me if new browser is used to sign in</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-content -->
                                                <div class="nk-block-head nk-block-head-sm">
                                                    <div class="nk-block-head-content">
                                                        <h6>News</h6>
                                                        <p>You will get only those email notification what you want.</p>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block-content">
                                                    <div class="gy-3">
                                                        <div class="g-item">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked id="latest-sale">
                                                                <label class="custom-control-label" for="latest-sale">Notify
                                                                    me by email about sales and latest news</label>
                                                            </div>
                                                        </div>
                                                        <div class="g-item">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="feature-update">
                                                                <label class="custom-control-label"
                                                                       for="feature-update">Email me about new features
                                                                    and updates</label>
                                                            </div>
                                                        </div>
                                                        <div class="g-item">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked id="account-tips">
                                                                <label class="custom-control-label" for="account-tips">Email
                                                                    me about tips on using account</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-content -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-preview -->
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                new Jsfunctions().show_settings();
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $component->OtherJavaScript(); ?>