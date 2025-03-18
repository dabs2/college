<?php
require __DIR__ . '/../vendor/autoload.php';
$component = new \College\Ddcollege\Controller\viewcontroller();
$faculty_control = new \College\Ddcollege\Controller\facultycontroller();
$result = new \College\Ddcollege\Model\database();
?>
    <!doctype html>
    <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
          data-menu-styles="dark" data-toggled="close">

<?= $component->script("Manage Faculty") ?>
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
                            <h4 class="nk-block-title">Manage Faculty</h4>
                        </div>
                    </div>
                    <div class="card card-bordered card-preview w-auto">
                        <div class="card-inner">
                            <table class="datatable-init-export table table-hover"
                                   data-export-title="Export"
                                   data-auto-responsive="false">
                                <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </th>
                                    <th class="nk-tb-col" hidden=""><span class="sub-text">Id</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Name</span>
                                    </th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Email</span>
                                    </th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Department</span>
                                    </th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Phone</span>
                                    </th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Gender</span>
                                    </th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Joining</span>
                                    </th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end">Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!$result->is_table_empty("faculty_details") && is_array($faculty_control->view_manage_employees()) && $_SESSION["user_role"] == "admin") {
                                    foreach ($faculty_control->view_manage_employees() as $control_faculty) {
                                        ?>
                                        <tr class="nk-tb-item">
                                            <td class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="uid1">
                                                    <label class="custom-control-label" for="uid1"></label>
                                                </div>
                                            </td>
                                            <td class="" hidden="">
                                                <span class="text-white"><?= $control_faculty["faculty_id"] ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                        <span><?= substr($control_faculty["faculty_name"], 0, 1) ?></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="tb-lead"><?= $control_faculty["faculty_name"] ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-mb">
                                                <ul class="list-status">
                                                    <li><em class="icon text-success ni ni-check-circle"></em>
                                                        <span><?= $control_faculty["faculty_email"] ?></span>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-status text-white"><?= $control_faculty["department"] ?></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-status text-white"><?= $control_faculty["phone"] ?></span>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-status text-white"><?= $control_faculty["gender"] ?></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                                <span><?= $control_faculty["joining"] ?></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-status text-success">Active</span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <div class="drodown">
                                                            <a href="#"
                                                               class="dropdown-toggle btn btn-icon btn-trigger"
                                                               data-bs-toggle="dropdown"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#" data-bs-toggle="offcanvas"
                                                                           data-bs-target="#viewfaculty"
                                                                           aria-controls="viewfaculty"
                                                                           onclick="new Jsfunctions().get_profile_data(this.closest('tr'))"><em
                                                                                    class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><em
                                                                                    class="icon ni ni-shield-star"></em><span>Reset Pass</span></a>
                                                                    </li>
                                                                    <li><a href="#"><em
                                                                                    class="icon ni ni-na"></em><span>Suspend User</span></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr><!-- .nk-tb-item  -->
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>

                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div>
            </div>
        </div>
    </div>
<?= $component->OtherJavaScript(); ?>


<?php
$faculty_control->view_faculty_detail_popup();
?>