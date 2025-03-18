<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$leavesection = new \College\Ddcollege\Controller\leavecontroller();
$result = new \College\Ddcollege\Model\database();
$status = new \College\Ddcollege\Model\status();
?>
<!doctype html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">

<?= $component->script("Leave Request"); ?>
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
                                            <h4 class="nk-block-title" id="leave_request_page">Leave Request</h4>
                                        </div>
                                    </div>

                                    <?php
                                    $leavesection->leaverequestbutton();
                                    $leavesection->leaveform();
                                    $leavesection->admin_approve_request();
                                    $leavesection->admin_reject_request();
                                    $leavesection->faculty_cancel_request();
                                    ?>

                                    <div class="nk-block nk-block-lg">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                <table class="datatable-init-export table table-hover"
                                                       data-export-title="Export">
                                                    <thead class="table-light">
                                                    <tr>
                                                        <th hidden="">Leave Id</th>
                                                        <th>Faculty Id</th>
                                                        <th>Leave Name</th>
                                                        <th>Leave Type</th>
                                                        <th>Total Days</th>
                                                        <th>Applied On</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Requested By</th>
                                                        <th>Status</th>
                                                        <th>Description</th>
                                                        <th>Reason</th>
                                                        <th>Session</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if (!$result->is_table_empty("leaverequests") && is_array($leavesection->viewleaverequests())) {
                                                        foreach ($leavesection->viewleaverequests() as $leave) {
                                                            ?>
                                                            <tr>
                                                                <td hidden=""><?= $leave['leave_id'] ?></td>
                                                                <td><?= $leave['faculty_id'] ?></td>
                                                                <td><?= $leave['leave_name'] ?></td>
                                                                <td><?= $leave['leave_type'] ?></td>
                                                                <td><?= $leave['total_days'] ?></td>
                                                                <td><?= $leave['leave_applied_on'] ?></td>
                                                                <td><?= $leave['leave_from'] ?></td>
                                                                <td><?= $leave['leave_to'] ?></td>
                                                                <td><?= $leave['leave_requested_by'] ?></td>
                                                                <td><?= $status->get_status($leave['status']) ?></td>
                                                                <td><?= $leave['description'] ?></td>
                                                                <td><?= $leave['reason'] ?></td>
                                                                <td class="nk-tb-col tb-col-md">
                                                                    <span class="tb-status text-info"><?= $leave["financial_year"]; ?></span>
                                                                </td>
                                                                <td><?= $leavesection->leave_action_buttons($leave['status']) ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div> <!-- nk-block -->

                                </div> <!-- nk-block -->
                            </div> <!-- nk-block -->
                        </div> <!-- nk-block -->
                    </div> <!-- nk-block -->
                </div> <!-- nk-block -->
            </div> <!-- nk-block -->
        </div> <!-- nk-block -->
    </div> <!-- nk-block -->
</div> <!-- nk-block -->

<?= $component->OtherJavaScript(); ?>
<?php

?>
</body>
</html>