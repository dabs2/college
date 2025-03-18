<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$resigncontroller = new \College\Ddcollege\Controller\resignationcontroller();
$status = new \College\Ddcollege\Model\status();
?>
    <!doctype html>
    <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
          data-menu-styles="dark" data-toggled="close">

<?= $component->script("Resignation") ?>
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
                                    <h4 class="nk-block-title">Manage Resignation</h4>
                                    <div class="nk-block-des">
                                    </div>
                                </div>
                            </div>

                            <?= $resigncontroller->requestbutton(); ?>
                            <?= $resigncontroller->requestform(); ?>
                            <?= $resigncontroller->resignationformforadmin(); ?>
                            <?= $resigncontroller->cancel_resignation(); ?>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="datatable-init-export table table-hover table-bordered"
                                           data-export-title="Export">
                                        <thead>
                                        <tr>
                                            <th hidden>Resignation Id</th>
                                            <th>Faculty Id</th>
                                            <th>Faculty Name</th>
                                            <th>Username</th>
                                            <th>Applied On</th>
                                            <th>Status</th>
                                            <th>Resignation Date</th>
                                            <th>Reason</th>
                                            <th>Notice Period</th>
                                            <th>Financial Year</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($resigncontroller->viewresignation()) && is_array($resigncontroller->viewresignation())) {
                                            foreach ($resigncontroller->viewresignation() as $ResignView) {
                                                ?>
                                                <tr>
                                                    <td hidden id="resignidforjs"><?= $ResignView["resignation_id"] ?></td>
                                                    <td><?= $ResignView["faculty_id"] ?></td>
                                                    <td><?= $ResignView["faculty_name"] ?></td>
                                                    <td><?= $ResignView["username"] ?></td>
                                                    <td><?= $ResignView["applied_on"] ?></td>
                                                    <td><?= $status->get_status($ResignView["status"]) ?></td>
                                                    <td><?= $ResignView["resignation_date"] ?></td>
                                                    <td><?= $ResignView["reason"] ?></td>
                                                    <td><?= $ResignView["notice_period"] ?></td>
                                                    <td class="tb-status text-info"><?= $ResignView["financial_year"] ?></td>
                                                    <?= $resigncontroller->actionbuttons($ResignView["resignation_id"]) ?>
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

                    </div><!-- .card-preview -->
                </div><!-- .card-preview -->
            </div> <!-- nk-block -->
        </div>
    </div>

</div>
<?= $component->OtherJavaScript(); ?>

