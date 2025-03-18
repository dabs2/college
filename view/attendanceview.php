<?php

use College\Ddcollege\Controller\attendancecontroller;

require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$attendancecontroller = new attendancecontroller();
$status = new \College\Ddcollege\Model\status();
?>
<!doctype html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">

<?= $component->script("Attendance") ?>
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

                        <div class="nk-block nk-block-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Attendance</h4>
                                </div>
                            </div>
                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="datatable-init-export table table-hover table-bordered"
                                           data-export-title="Export">
                                        <thead class="table-light">
                                        <tr>
                                            <th hidden>Faculty Id</th>
                                            <th>Name</th>
                                            <th>Shift Hours</th>
                                            <th>In-Time</th>
                                            <th>Out-Time</th>
                                            <th>Work Hours</th>
                                            <th>OT</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Year</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($attendancecontroller->viewattendance())) {
                                            foreach ($attendancecontroller->viewattendance() as $attendance): ?>
                                                <tr>
                                                    <td hidden><?= $attendance['faculty_id'] ?></td>
                                                    <td><?= $attendance['faculty_name'] ?></td>
                                                    <td><?= $attendance['shift_hours'] ?></td>
                                                    <td><?= $attendance ['in_time'] ?></td>
                                                    <td><?= $attendance ['out_time'] ?></td>
                                                    <td><?= $attendance ['work_hours'] ?></td>
                                                    <td><?= $attendance ['overtime'] ?></td>
                                                    <td><?php if ($attendance["status"] == "Emergency Halfday") {
                                                            $display_status = $status->get_other_status("Emergency Halfday");
                                                        } else {
                                                            $display_status = $status->get_status($attendance["status"]);
                                                        }
                                                        echo $display_status; ?></td>
                                                    <td><?= $attendance ['attendance_date'] ?></td>
                                                    <td class="tb-status text-info"><?= $attendance ['financial_year'] ?></td>
                                                </tr>
                                            <?php endforeach;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- .card-preview -->
                        </div><!-- .card-preview -->
                    </div><!-- .card-preview -->
                </div> <!-- nk-block -->
            </div>
        </div>
    </div>
</div>
<?= $component->OtherJavaScript(); ?>
