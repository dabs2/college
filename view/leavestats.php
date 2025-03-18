<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$leavestats = new \College\Ddcollege\Controller\leavecontroller();
$result = new \College\Ddcollege\Model\database();
?>
<!doctype html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">

<?= $component->script("Leave Stats"); ?>
<body>
<!-- Layout wrapper -->

<!-- Menu -->
<!-- Layout container -->


<?= $component->rendersidebar(); ?>

<div class="nk-wrap ">
    <?= $component->topbar(); ?>

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    <div class="nk-block nk-block-lg">

                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Leave Stats</h4>
                                        </div>
                                    </div>
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                            <table class="datatable-init-export table table-hover nk-tb-list nk-tb-ulist"
                                                   data-export-title="Export">
                                                <thead class="table-light">
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th>
                                                    <th class="nk-tb-col"><span class="sub-text">Faculty Name</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-mb"><span
                                                                class="sub-text">Total Leave</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span
                                                                class="sub-text">Leaves Taken</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span
                                                                class="sub-text">Leave Remaining</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span
                                                                class="sub-text">Unpaid Leaves</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-lg"><span
                                                                class="sub-text">Username</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-md"><span
                                                                class="sub-text">Financial Year</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (!empty($leavestats->viewleavestats())) {
                                                    foreach ($leavestats->viewleavestats() as $leaves_stats) {
                                                        ?>
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col nk-tb-col-check">
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           id="uid13">
                                                                    <label class="custom-control-label"
                                                                           for="uid13"></label>
                                                                </div>
                                                            </td>
                                                            <td class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-avatar bg-dark d-none d-sm-flex">
                                                                        <span><?= substr($leaves_stats["faculty_name"], 0, 1) ?></span>
                                                                    </div>
                                                                    <div class="user-info">
                                                                        <span class="tb-lead"><?= $leaves_stats["faculty_name"]; ?><span
                                                                                    class="dot dot-success d-md-none ms-1"></span></span>
                                                                        <?php
                                                                        $user_id = $_SESSION['user_id'];
                                                                        if ($_SESSION["user_role"] != "admin") {
                                                                            ?>
                                                                            <span><?= $result->viewdata("faculty_details", "faculty_email", "faculty_id='$user_id'")[0]['faculty_email'] ?></span>
                                                                            <?php
                                                                        } else {
                                                                            $facultyname = $leaves_stats["faculty_name"];
                                                                            ?>
                                                                            <span><?= $result->viewdata("faculty_details", "faculty_email", "faculty_name='$facultyname'")[0]['faculty_email'] ?></span>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status"><?= $leaves_stats["total_leaves"]; ?></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status"><?= $leaves_stats["leaves_taken"]; ?></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status"><?= $leaves_stats["leaves_remaining"]; ?></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status"><?= $leaves_stats["unpaid_leaves"]; ?></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status"><?= $leaves_stats["username"]; ?></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status text-info"><?= $leaves_stats["financial_year"]; ?></span>
                                                            </td>

                                                        </tr><!-- .nk-tb-item  -->
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- .card-preview -->
                                </div> <!-- nk-block -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $component->OtherJavaScript(); ?>
<?php

?>
</body>
</html>


