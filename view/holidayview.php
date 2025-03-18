<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$holidaycontroller = new \College\Ddcollege\Controller\holidaycontroller();
$status = new \College\Ddcollege\Model\status();
?>
<!doctype html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">

<?= $component->script("Holiday") ?>
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
                                    <h4 class="nk-block-title">Holiday's</h4>
                                </div>
                            </div>
                            <?= $holidaycontroller->holidaybutton(); ?>
                            <?= $holidaycontroller->addhholiday(); ?>
                            <?= $holidaycontroller->editholiday(); ?>
                            <?= $holidaycontroller->deleteholiday(); ?>
                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="datatable-init-export table table-hover table-bordered"
                                           data-export-title="Export">
                                        <thead>
                                        <tr>
                                            <th hidden>Holiday Id</th>
                                            <th>Holiday Name</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Day</th>
                                            <th>Financial Year</th>
                                            <?= $holidaycontroller->action(); ?>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($holidaycontroller->viewholiday()) && is_array($holidaycontroller->viewholiday())) {
                                            foreach ($holidaycontroller->viewholiday() as $viewholiday): ?>
                                                <tr>
                                                    <td hidden><?= $viewholiday["holiday_id"] ?></td>
                                                    <td><?= $viewholiday["holiday_name"] ?></td>
                                                    <td><?= $viewholiday["date"] ?></td>
                                                    <td><?= $holidaycontroller->checkstatus($viewholiday["date"]) ?></td>
                                                    <td><?= $viewholiday["type"] ?></td>
                                                    <td><?= $viewholiday["day"] ?></td>
                                                    <td><?= $viewholiday["financial_year"] ?></td>
                                                    <?= $holidaycontroller->actionbuttons(); ?>
                                                </tr>
                                            <?php endforeach;
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
<?= $component->OtherJavaScript(); ?>

