<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Model\database;

class adminview
{
    private viewcontroller $RenderView;
    private attendancecontroller $attendancecontroller;
    private database $db;
    private helper $help;
    private holidaycontroller $holiday;

    public function __construct()
    {
        $this->RenderView = new viewcontroller();
        $this->attendancecontroller = new attendancecontroller();
        $this->db = new database();
        $this->help = new helper();
        $this->holiday = new holidaycontroller();
    }

    public function view_admin()
    {
        ?>
        <!doctype html>
        <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
              data-menu-styles="dark" data-toggled="close">

        <?= $this->RenderView->script("Dashboard"); ?>
        <body>
        <!-- Layout wrapper -->

        <!-- Menu -->
        <!-- Layout container -->


        <?= $this->RenderView->rendersidebar(); ?>

        <div class="nk-wrap ">
            <?= $this->RenderView->topbar(); ?>

            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Dashboard</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>Welcome to Portal.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                               data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li>
                                                        <div class="dropdown">
                                                            <a href="#"
                                                               class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                                               data-bs-toggle="dropdown"><em
                                                                        class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span
                                                                            class="d-none d-md-inline">Last</span> 30 Days</span><em
                                                                        class="dd-indc icon ni ni-chevron-right"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><span>Last 30 Days</span></a></li>
                                                                    <li><a href="#"><span>Last 6 Months</span></a></li>
                                                                    <li><a href="#"><span>Last 1 Years</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nk-block-tools-opt"><a data-bs-toggle="offcanvas"
                                                                                      data-bs-target="#latearrival"
                                                                                      class="btn btn-danger"><em
                                                                    class="icon ni ni-reports"></em><span>Late Arrivals</span></a>
                                                    </li>
                                                    <?php
                                                    $this->view_late_arrivals();
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-xxl-6">
                                        <div class="row g-gs">
                                            <div class="col-lg-6 col-xxl-12">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Attendance</h6>
                                                                <p>This month
                                                                    Attendance <?php echo cal_days_in_month(CAL_GREGORIAN, date("m"), date("y")); ?>
                                                                    days</p>
                                                            </div>
                                                            <li><a href="/attendance"><span>View</span></a></li>
                                                        </div>
                                                        <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                                            <div class="nk-sale-data-group flex-md-nowrap g-4">
                                                                <div class="nk-sale-data">
                                                                    <span class="amount"><?php
                                                                        $date = date("Y-m-d");
                                                                        $faculty_id = $_SESSION["user_id"];
                                                                        if ($_SESSION['user_role'] != "admin") {
                                                                            $attendanceData = $this->db->viewdata("attendance", "", "attendance_date='$date' AND faculty_id='$faculty_id'");
                                                                        } else {
                                                                            $attendanceData = $this->db->viewdata("attendance", "", "attendance_date='$date'");
                                                                        }
                                                                        if ($attendanceData !== false) {
                                                                            echo count($attendanceData);
                                                                        } else {
                                                                            echo '0';
                                                                        }
                                                                        ?><span
                                                                                class="change down text-danger"><em
                                                                                    class="icon ni ni-arrow-long-down"></em>16.93%</span></span>
                                                                    <span class="sub-title">Today</span>
                                                                </div>
                                                                <div class="nk-sale-data">
                                                                    <span class="amount"><?php
                                                                        $currentMonth = date("Y-m");
                                                                        if ($_SESSION['user_role'] != "admin") {
                                                                            $attendanceData = $this->db->viewdata("attendance", "", "attendance_date LIKE '$currentMonth%' AND faculty_id='$faculty_id'");
                                                                        } else {
                                                                            $attendanceData = $this->db->viewdata("attendance", "", "attendance_date LIKE '$currentMonth%'");
                                                                        }
                                                                        if ($attendanceData !== false) {
                                                                            echo count($attendanceData);
                                                                        } else {
                                                                            echo '0';
                                                                        }
                                                                        ?><span
                                                                                class="change up text-success"><em
                                                                                    class="icon ni ni-arrow-long-up"></em>4.26%</span></span>
                                                                    <span class="sub-title">This Month</span>
                                                                </div>
                                                            </div>
                                                            <div class="nk-sales-ck sales-revenue">
                                                                <canvas class="sales-bar-chart"
                                                                        id="salesRevenue"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                            <div class="col-lg-6 col-xxl-12">
                                                <div class="row g-gs">
                                                    <div class="col-sm-6 col-lg-12 col-xxl-6">
                                                        <div class="card card-bordered">
                                                            <div class="card-inner">
                                                                <div class="card-title-group align-start mb-2">
                                                                    <div class="card-title">
                                                                        <h6 class="title">Leave Requests</h6>
                                                                        <?php
                                                                        if ($_SESSION['user_role'] == 'admin') {
                                                                            ?>
                                                                            <p>Check the Leave request by the
                                                                                user.</p>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <p>Check Leaves status.</p>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <li><a href="/leavesection"><span>View</span></a>
                                                                    </li>

                                                                </div>
                                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                    <div class="nk-sale-data">
                                                                        <span class="amount"><?php
                                                                            $user_id = $_SESSION['user_id'];
                                                                            if ($_SESSION['user_role'] == 'admin') {
                                                                                $leaves = $this->db->viewdata("leaverequests", "", "status='Pending'");
                                                                            } else {
                                                                                $leaves = $this->db->viewdata("leaverequests", "", "faculty_id='$user_id' AND status='Pending'");
                                                                            }
                                                                            if ($leaves !== false) {
                                                                                echo '<p class="text-danger">' . count($leaves) . '</p>';
                                                                            } else {
                                                                                echo '<p class="text-success">0</p>';
                                                                            }
                                                                            ?></span>
                                                                        <span class="sub-title"><span
                                                                                    class="change down text-danger"><em
                                                                                        class="icon ni ni-arrow-long-down"></em>1.93%</span>since last month</span>
                                                                    </div>
                                                                    <div class="nk-sales-ck">
                                                                        <canvas class="sales-bar-chart"
                                                                                id="activeSubscription"></canvas>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .card -->
                                                    </div><!-- .col -->
                                                    <div class="col-sm-6 col-lg-12 col-xxl-6">
                                                        <div class="card card-bordered">
                                                            <div class="card-inner">
                                                                <div class="card-title-group align-start mb-2">
                                                                    <div class="card-title">
                                                                        <h6 class="title">Holiday</h6>
                                                                    </div>
                                                                    <li><a href="/holidayview"><span>View</span></a>
                                                                </div>
                                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                    <div class="nk-sale-data">
                                                                        <span class="amount"><?php
                                                                            print_r($this->holiday->checklatestholiday());
                                                                            $date = date('Y-m-d');
                                                                            $fy = $this->help->GetFinancialYear($date);
                                                                            $holidays = $this->db->viewdata("holidays", "", "financial_year='$fy'");
                                                                            if ($holidays !== false) {
                                                                                echo '<br> ' . count($holidays) . ' Holidays';
                                                                            } else {
                                                                                echo '0';
                                                                            }
                                                                            ?></span>
                                                                        <span class="sub-title"><span
                                                                                    class="change up text-success"><em
                                                                                        class="icon ni ni-arrow-long-up"></em>2.45%</span>since last week</span>
                                                                    </div>
                                                                    <div class="nk-sales-ck">
                                                                        <canvas class="sales-bar-chart"
                                                                                id="totalSubscription"></canvas>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .card -->
                                                    </div><!-- .col -->
                                                </div><!-- .row -->
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-6">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start gx-3 mb-3">
                                                    <div class="card-title">
                                                        <h6 class="title">Attendance Stats</h6>
                                                        <p>In 30 days sales of product subscription. <a href="#">See
                                                                Details</a></p>
                                                    </div>
                                                    <div class="card-tools">
                                                        <div class="dropdown">
                                                            <a href="#"
                                                               class="btn btn-primary btn-dim d-none d-sm-inline-flex"
                                                               data-bs-toggle="dropdown"><em
                                                                        class="icon ni ni-download-cloud"></em><span><span
                                                                            class="d-none d-md-inline">Download</span> Report</span></a>
                                                            <a href="#"
                                                               class="btn btn-icon btn-primary btn-dim d-sm-none"
                                                               data-bs-toggle="dropdown"><em
                                                                        class="icon ni ni-download-cloud"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li>
                                                                        <a href="#"><span>Download Mini Version</span></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#"><span>Download Full Version</span></a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><em
                                                                                    class="icon ni ni-opt-alt"></em><span>More Options</span></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                    <div class="nk-sale-data">
                                                        <span class="amount">$82,944.60</span>
                                                    </div>
                                                    <div class="nk-sale-data">
                                                        <span class="amount sm">1,937 <small>Subscribers</small></span>
                                                    </div>
                                                </div>
                                                <div class="nk-sales-ck large pt-4">
                                                    <canvas class="sales-overview-chart" id="salesOverview"></canvas>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-8">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title"><span class="me-2">Transaction</span> <a
                                                                    href="#" class="link d-none d-sm-inline">See
                                                                History</a></h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li><a href="#"><span>Paid</span></a></li>
                                                            <li><a href="#"><span>Pending</span></a></li>
                                                            <li class="active"><a href="#"><span>All</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner p-0 border-top">
                                                <div class="nk-tb-list nk-tb-orders">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span>Order No.</span></div>
                                                        <div class="nk-tb-col tb-col-sm"><span>Customer</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                        <div class="nk-tb-col tb-col-lg"><span>Ref</span></div>
                                                        <div class="nk-tb-col"><span>Amount</span></div>
                                                        <div class="nk-tb-col"><span
                                                                    class="d-none d-sm-inline">Status</span></div>
                                                        <div class="nk-tb-col"><span>&nbsp;</span></div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95954</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-purple">
                                                                    <span>AB</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">abhishek baluni</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">02/11/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2309232</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">4,596.75 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-success">Paid</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                   data-bs-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Print</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95850</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-azure">
                                                                    <span>DE</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Desiree Edwards</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">02/02/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2309154</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">596.75 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-danger">Canceled</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                   data-bs-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Remove</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95812</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-warning">
                                                                    <img src="./images/avatar/b-sm.jpg" alt="">
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Blanca Schultz</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">02/01/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2309143</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">199.99 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-success">Paid</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                   data-bs-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Print</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95256</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-purple">
                                                                    <span>NL</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Naomi Lawrence</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">01/29/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2305684</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">1099.99 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-success">Paid</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                   data-bs-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Print</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead"><a href="#">#95135</a></span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <div class="user-card">
                                                                <div class="user-avatar user-avatar-sm bg-success">
                                                                    <span>CH</span>
                                                                </div>
                                                                <div class="user-name">
                                                                    <span class="tb-lead">Cassandra Hogan</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">01/29/2020</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span class="tb-sub text-primary">SUB-2305564</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="tb-sub tb-amount">1099.99 <span>USD</span></span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="badge badge-dot badge-dot-xs bg-warning">Due</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                   data-bs-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#">View</a></li>
                                                                        <li><a href="#">Invoice</a></li>
                                                                        <li><a href="#">Notify</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner-sm border-top text-center d-sm-none">
                                                <a href="#" class="btn btn-link btn-block">See History</a>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-xxl-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Recent Activities</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li><a href="#"><span>Cancel</span></a></li>
                                                            <li class="active"><a href="#"><span>All</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-activity">
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-success"><img
                                                                src="./images/avatar/c-sm.jpg" alt=""></div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Keith Jensen requested to Widthdrawl.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-warning">HS</div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Harry Simpson placed a Order.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-azure">SM</div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Stephanie Marshall got a huge bonus.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-purple"><img
                                                                src="./images/avatar/d-sm.jpg" alt=""></div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Nicholas Carr deposited funds.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-pink">TM</div>
                                                    <div class="nk-activity-data">
                                                        <div class="label">Timothy Moreno placed a Order.</div>
                                                        <span class="time">2 hours ago</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <?php
                                    if ($_SESSION['user_role'] == 'admin') {
                                        ?>
                                        <div class="col-md-6 col-xxl-4">
                                            <div class="card card-bordered card-full">
                                                <div class="card-inner-group">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Users</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <a href="/managefaculty" class="link">View
                                                                    All</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-inner card-inner-md">
                                                        <div class="user-card">
                                                            <ul class="nk-activity">
                                                                <?php
                                                                foreach ($this->db->viewdata("faculty_details", "faculty_name,faculty_email") as $details) {
                                                                    ?>
                                                                    <li class="nk-activity-item">
                                                                        <div class="nk-activity-media user-avatar bg-indigo"><?= substr($details["faculty_name"], 0, 1) ?>
                                                                        </div>
                                                                        <div class="nk-activity-data">
                                                                            <div class="label text-success"><?= $details["faculty_name"] ?>
                                                                            </div>
                                                                            <span class="time"><?= $details["faculty_email"] ?></span>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <?php
                                    }
                                    ?>
                                    <div class="col-lg-6 col-xxl-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Support Requests</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <a href="#" class="link">All Tickets</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-support">
                                                <li class="nk-support-item">
                                                    <div class="user-avatar">
                                                        <img src="./images/avatar/a-sm.jpg" alt="">
                                                    </div>
                                                    <div class="nk-support-content">
                                                        <div class="title">
                                                            <span>Vincent Lopez</span><span
                                                                    class="badge badge-dot badge-dot-xs bg-warning ms-1">Pending</span>
                                                        </div>
                                                        <p>Thanks for contact us with your issues...</p>
                                                        <span class="time">6 min ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-support-item">
                                                    <div class="user-avatar bg-purple-dim">
                                                        <span>DM</span>
                                                    </div>
                                                    <div class="nk-support-content">
                                                        <div class="title">
                                                            <span>Daniel Moore</span><span
                                                                    class="badge badge-dot badge-dot-xs bg-info ms-1">Open</span>
                                                        </div>
                                                        <p>Thanks for contact us with your issues...</p>
                                                        <span class="time">2 Hours ago</span>
                                                    </div>
                                                </li>
                                                <li class="nk-support-item">
                                                    <div class="user-avatar">
                                                        <img src="./images/avatar/b-sm.jpg" alt="">
                                                    </div>
                                                    <div class="nk-support-content">
                                                        <div class="title">
                                                            <span>Larry Henry</span><span
                                                                    class="badge badge-dot badge-dot-xs bg-success ms-1">Solved</span>
                                                        </div>
                                                        <p>Thanks for contact us with your issues...</p>
                                                        <span class="time">3 Hours ago</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-lg-6 col-xxl-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Notifications</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <a href="#" class="link">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner">
                                                <div class="timeline">
                                                    <h6 class="timeline-head">November, 2019</h6>
                                                    <ul class="timeline-list">
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-primary is-outline"></div>
                                                            <div class="timeline-date">13 Nov <em
                                                                        class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Submited KYC Application</h6>
                                                                <div class="timeline-des">
                                                                    <p>Re-submitted KYC Application form.</p>
                                                                    <span class="time">09:30am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-primary"></div>
                                                            <div class="timeline-date">13 Nov <em
                                                                        class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Submited KYC Application</h6>
                                                                <div class="timeline-des">
                                                                    <p>Re-submitted KYC Application form.</p>
                                                                    <span class="time">09:30am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-pink"></div>
                                                            <div class="timeline-date">13 Nov <em
                                                                        class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Submited KYC Application</h6>
                                                                <div class="timeline-des">
                                                                    <p>Re-submitted KYC Application form.</p>
                                                                    <span class="time">09:30am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                </div><!-- .row -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
            <!-- footer @s -->
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; 2023 DashLite. Template by <a
                                    href="https://softnio.com" target="_blank">Softnio</a>
                        </div>
                        <div class="nk-footer-links">
                            <ul class="nav nav-sm">
                                <li class="nav-item dropup">
                                    <a href="#"
                                       class="dropdown-toggle dropdown-indicator has-indicator nav-link text-base"
                                       data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                        <ul class="language-list">
                                            <li>
                                                <a href="#" class="language-item">
                                                    <span class="language-name">English</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="language-item">
                                                    <span class="language-name">Español</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="language-item">
                                                    <span class="language-name">Français</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="language-item">
                                                    <span class="language-name">Türkçe</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a data-bs-toggle="modal" href="#region" class="nav-link"><em
                                                class="icon ni ni-globe"></em><span
                                                class="ms-1">Select Region</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
        </div>
        <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- select region modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="region">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-md">
                        <h5 class="title mb-4">Select Your Country</h5>
                        <div class="nk-country-region">
                            <ul class="country-list text-center gy-2">
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/arg.png" alt="" class="country-flag">
                                        <span class="country-name">Argentina</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/aus.png" alt="" class="country-flag">
                                        <span class="country-name">Australia</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/bangladesh.png" alt="" class="country-flag">
                                        <span class="country-name">Bangladesh</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/canada.png" alt="" class="country-flag">
                                        <span class="country-name">Canada <small>(English)</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/china.png" alt="" class="country-flag">
                                        <span class="country-name">Centrafricaine</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/china.png" alt="" class="country-flag">
                                        <span class="country-name">China</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/french.png" alt="" class="country-flag">
                                        <span class="country-name">France</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/germany.png" alt="" class="country-flag">
                                        <span class="country-name">Germany</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/iran.png" alt="" class="country-flag">
                                        <span class="country-name">Iran</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/italy.png" alt="" class="country-flag">
                                        <span class="country-name">Italy</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/mexico.png" alt="" class="country-flag">
                                        <span class="country-name">México</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/philipine.png" alt="" class="country-flag">
                                        <span class="country-name">Philippines</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/portugal.png" alt="" class="country-flag">
                                        <span class="country-name">Portugal</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/s-africa.png" alt="" class="country-flag">
                                        <span class="country-name">South Africa</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/spanish.png" alt="" class="country-flag">
                                        <span class="country-name">Spain</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/switzerland.png" alt="" class="country-flag">
                                        <span class="country-name">Switzerland</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/uk.png" alt="" class="country-flag">
                                        <span class="country-name">United Kingdom</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="country-item">
                                        <img src="./images/flags/english.png" alt="" class="country-flag">
                                        <span class="country-name">United States</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-content -->
            </div><!-- .modla-dialog -->
        </div><!-- .modal -->
        <!-- JavaScript -->
        <script src="../assets/js/bundle.js?ver=3.2.2"></script>
        <script src="../assets/js/scripts.js?ver=3.2.2"></script>
        <script src="../assets/js/charts/gd-default.js?ver=3.2.2"></script>
        </body>

        </html>
        <?php
    }

    public
    function view_late_arrivals()
    {
        ?>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="latearrival"
             aria-labelledby="latearrival" style="width: 600px;">
            <div class="offcanvas-header bg-light">
                <h5 class="offcanvas-title text-white text-lg-start badge bg-primary rounded-pill ucap"
                    id="late_arrival_title"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body bg-light">

                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="title nk-block-title">Late Arrivals List</h4>
                            <p>The following list show <strong class="text-primary">Late User , late arrivals
                                    list</strong> related filed.</p>
                            <p><?= date("Y-m-d") ?> - <strong class="text-primary"><?= date("l") ?></strong></p>
                        </div>
                    </div>
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-bordered card-full">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">ARRIVALS</h6>
                                                    </div>
                                                    <div class="card-title">
                                                        <h6 class="title">DELAY TIME</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= $this->attendancecontroller->viewlatearrivals(); ?>

                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            </div>
                        </div>
                    </div><!-- .card-preview -->
                </div>

                <div class="nk-content-body">
                    <div class="nk-block">

                    </div><!-- .row -->
                </div><!-- .nk-block -->
            </div>
        </div>
        <?php
    }

}