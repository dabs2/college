<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$halfdaycontroller = new \College\Ddcollege\Controller\halfdaycontroller();
$status = new \College\Ddcollege\Model\status();
?>
    <!doctype html>
    <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
          data-menu-styles="dark" data-toggled="close">

<?= $component->script("Halfday") ?>
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
                                    <h4 class="nk-block-title">Halfday Management</h4>
                                </div>
                            </div>

                            <?= $halfdaycontroller->halfdaybuttonforapply() ?>
                            <?= $halfdaycontroller->popupforhalfday() ?>
                            <?= $halfdaycontroller->cancelhalfday() ?>
                            <?= $halfdaycontroller->approvehalfday() ?>
                            <?= $halfdaycontroller->rejecthalfday() ?>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="datatable-init-export table table-hover table-bordered"
                                           data-export-title="Export">
                                        <thead>
                                        <tr>
                                            <th hidden>Halfday Id</th>
                                            <th>Faculty Id</th>
                                            <th>Faculty Name</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                            <th>Rejection</th>
                                            <th>Financial Year</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($halfdaycontroller->viewhalfday()) && is_array($halfdaycontroller->viewhalfday())) {
                                            foreach ($halfdaycontroller->viewhalfday() as $halfday) {
                                                ?>
                                                <tr>
                                                    <td hidden><?= $halfday["halfday_id"] ?></td>
                                                    <td><?= $halfday["faculty_id"] ?></td>
                                                    <td><?= $halfday["faculty_name"] ?></td>
                                                    <td><?= $halfday["date"] ?></td>
                                                    <td><?= $halfdaycontroller->checkstatusofhalfday($halfday["status"]) ?></td>
                                                    <td><?= $status->get_status($halfday["status"]) ?></td>
                                                    <td><?= $halfday["reason"] ?></td>
                                                    <td><?= $halfday["rejection"] ?></td>
                                                    <td><?= $halfday["financial_year"] ?></td>
                                                    <td><?= $halfdaycontroller->actionbuttons($halfday["status"]) ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $component->OtherJavaScript(); ?>