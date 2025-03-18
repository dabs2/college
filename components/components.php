<?php

namespace College\Ddcollege\Components;

use College\Ddcollege\Controller\attendancecontroller;
use College\Ddcollege\Controller\halfdaycontroller;
use College\Ddcollege\Controller\leavecontroller;
use College\Ddcollege\Model\database;
use Exception;

require __DIR__ . '/../vendor/autoload.php';


class components
{
    private database $result;
    private attendancecontroller $attendancecontroller;
    private halfdaycontroller $halfdaycontrol;

    public function __construct()
    {
        $this->result = new database();
        $this->attendancecontroller = new attendancecontroller();
        $this->halfdaycontrol = new halfdaycontroller();
    }

    public function SideBar()
    {
        ob_start();
        $this->halfdaycontrol->popupforemergencyhalfday();
        $this->attendancecontroller->logoutprompt();
        ob_end_flush();
        ?>

        <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
            <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-menu-trigger">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                                class="icon ni ni-arrow-left"></em></a>
                    <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                       data-target="sidebarMenu"><em class="icon ni ni-more-h"></em></a>
                </div>
                <div class="nk-sidebar-brand">
                    <a href="/" class="logo-link nk-sidebar-logo">
                        <img class="logo-light logo-img" src="../assets/img/collegemain.webp"
                             srcset="./images/logo2x.png 2x" alt="logo">
                        <img class="logo-dark logo-img" src="../assets/img/collegemain.webp"
                             srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                    </a>
                </div>
            </div><!-- .nk-sidebar-element -->
            <div class="nk-sidebar-element nk-sidebar-body">
                <div class="nk-sidebar-content">
                    <div class="nk-sidebar-menu" data-simplebar>
                        <ul class="nk-menu">
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Overview</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                    <span class="nk-menu-text">Dashboard</span><span class="nk-menu-badge">HOT</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Holiday's Management</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="holidayview" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
                                    <span class="nk-menu-text">Holidays</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Attendance Management</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                    <span class="nk-menu-text">Attendance</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="/attendance" class="nk-menu-link"><span class="nk-menu-text">View Attendance</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="html/transaction-crypto.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Monthly Attendance Stats</span></a>
                                    </li>
                                </ul><!-- .nk-menu-sub -->
                            </li>
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Leave Management</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-eye-off"></em></span>
                                    <span class="nk-menu-text">Leave</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="/leavestats" class="nk-menu-link"><span class="nk-menu-text">Leave Stats</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="/leavesection" class="nk-menu-link"><span
                                                    class="nk-menu-text">Leave Requests</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="/halfday" class="nk-menu-link"><span
                                                    class="nk-menu-text">Halfday</span></a>
                                    </li>
                                </ul><!-- .nk-menu-sub -->
                            </li><!-- .nk-menu-item -->
                            <?php
                            if ($_SESSION["user_role"] == "admin") {
                                ?>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Faculty Management</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                        <span class="nk-menu-text">Faculty</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="managefaculty" class="nk-menu-link"><span
                                                        class="nk-menu-text">Manage Faculty</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="/register" class="nk-menu-link"><span
                                                        class="nk-menu-text">Add Faculty</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="/resignationview" class="nk-menu-link"><span
                                                        class="nk-menu-text">Resignation</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <?php
                            }
                            ?>
                        </ul><!-- .nk-menu -->
                    </div><!-- .nk-sidebar-menu -->
                </div><!-- .nk-sidebar-content -->
            </div><!-- .nk-sidebar-element -->
        </div>

        <?php

    }

    public function script($title)
    {
        ?>
        <head>
            <meta charset="utf-8">
            <meta name="author" content="Softnio">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description"
                  content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
            <!-- Fav Icon  -->
            <link rel="shortcut icon" href="../images/favicon.png">
            <!-- Page Title  -->
            <title><?= $title ?></title>
            <!-- StyleSheets  -->
            <link rel="stylesheet" href="../assets/css/dashlite.css?ver=3.2.2">
            <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=3.2.2">
            <script src="../assets/js/darkmodetoggle.js" defer></script>
            <script src="../assets/js/jsfunctions.js" defer></script>
        </head>

        <?php
    }

    /**
     * @throws Exception
     */
    public function Topbar()
    {


        ?>

        <!-- main header @s -->
        <div class="nk-header nk-header-fixed is-light">
            <div class="container-fluid">
                <div class="nk-header-wrap">
                    <div class="nk-menu-trigger d-xl-none ms-n1">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                                    class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-header-brand d-xl-none">
                        <a href="/" class="logo-link">
                            <img class="logo-light logo-img" src="../assets/img/collgemain.webp"
                                 srcset="../assets/img/collgemain.webp 2x" alt="logo">
                            <img class="logo-dark logo-img" src="../assets/img/collgemain.webp"
                                 srcset="../assets/img/collgemain.webp 2x" alt="logo-dark">
                        </a>
                    </div><!-- .nk-header-brand -->
                    <div class="nk-header-news d-none d-xl-block">
                        <div class="nk-news-list">
                            <a class="nk-news-item" target="_blank" href="https://college.in">
                                <div class="nk-news-icon">
                                    <em class="icon ni ni-card-view"></em>
                                </div>
                                <div class="nk-news-text">
                                    <p>Explore our official website to discover more about us
                                        <span> Click here to learn more.</span>
                                    </p>
                                    <em class="icon ni ni-external"></em>
                                </div>
                            </a>
                        </div>
                    </div><!-- .nk-header-news -->
                    <div class="nk-header-tools">
                        <ul class="nk-quick-nav">
                            <li class="dropdown user-dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                    <div class="user-toggle">
                                        <div class="user-avatar sm">
                                            <em class="icon ni ni-user-alt"></em>
                                        </div>
                                        <div class="user-info d-none d-md-block">
                                            <div class="user-status"><?= $_SESSION["user_role"] ?></div>
                                            <div class="user-name dropdown-indicator"><?= $_SESSION['username'] ?></div>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                    <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                        <div class="user-card">
                                            <div class="user-avatar">
                                                <span><?php echo substr($_SESSION['username'], 0, 1); ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?= $_SESSION['username'] ?></span>
                                                <?php if ($_SESSION["user_role"] == "admin") { ?>
                                                    <span><?= $this->result->viewdata("users", "user_role", "user_role='admin'")[0]["user_role"]; ?></span>
                                                    <?php
                                                } else {
                                                    $user_id = $_SESSION['user_id'];
                                                    ?>
                                                    <span><?= $this->result->viewdata("faculty_details", "faculty_email", "faculty_id=$user_id")[0]['faculty_email']; ?></span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="html/user-profile-regular.html"><em
                                                            class="icon ni ni-user-alt"></em><span>View Profile</span></a>
                                            </li>
                                            <?php
                                            if ($_SESSION["user_role"] != "admin") {
                                                ?>
                                                <li><a data-bs-toggle="modal" data-bs-target="#modalTabs"><em
                                                                class="icon ni ni-alert-fill"></em><span>Emergency Half Day</span></a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($_SESSION["user_role"] != "admin") {
                                                echo '<li><a href="/resignationview"><em
                                                            class="icon ni ni-signout"></em><span>Resignation</span></a>
                                            </li>';
                                            }
                                            ?>
                                            <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a>
                                            </li>
                                            <li><a href="/settings"><em
                                                            class="icon ni ni-account-setting-fill"></em><span>Settings</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li>
                                                <?php
                                                if ($_SESSION["user_role"] == "admin") {
                                                    ?>
                                                    <form action="#" method="post">
                                                        <button type="submit" name="logout" class="btn btn-danger"><em
                                                                    class="icon ni ni-signout "></em><span>Sign out</span>
                                                        </button>
                                                    </form>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#logout_prompt2" class="btn btn-danger"><em
                                                                class="icon ni ni-signout "></em><span>Sign out</span>
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li><!-- .dropdown -->
                            <li class="dropdown notification-dropdown me-n1">
                                <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                    <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                                    <div class="dropdown-head">
                                        <span class="sub-title nk-dropdown-title">Notifications</span>
                                        <a href="#">Mark All as Read</a>
                                    </div>
                                    <div class="dropdown-body">
                                        <div class="nk-notification">
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text">You have requested to
                                                        <span>Widthdrawl</span>
                                                    </div>
                                                    <div class="nk-notification-time">2 hrs ago</div>
                                                </div>
                                            </div>
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text">Your <span>Deposit Order</span> is
                                                        placed
                                                    </div>
                                                    <div class="nk-notification-time">2 hrs ago</div>
                                                </div>
                                            </div>
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text">You have requested to
                                                        <span>Widthdrawl</span>
                                                    </div>
                                                    <div class="nk-notification-time">2 hrs ago</div>
                                                </div>
                                            </div>
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text">Your <span>Deposit Order</span> is
                                                        placed
                                                    </div>
                                                    <div class="nk-notification-time">2 hrs ago</div>
                                                </div>
                                            </div>
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text">You have requested to
                                                        <span>Widthdrawl</span>
                                                    </div>
                                                    <div class="nk-notification-time">2 hrs ago</div>
                                                </div>
                                            </div>
                                            <div class="nk-notification-item dropdown-inner">
                                                <div class="nk-notification-icon">
                                                    <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                </div>
                                                <div class="nk-notification-content">
                                                    <div class="nk-notification-text">Your <span>Deposit Order</span> is
                                                        placed
                                                    </div>
                                                    <div class="nk-notification-time">2 hrs ago</div>
                                                </div>
                                            </div>
                                        </div><!-- .nk-notification -->
                                    </div><!-- .nk-dropdown-body -->
                                    <div class="dropdown-foot center">
                                        <a href="#">View All</a>
                                    </div>
                                </div>
                            </li><!-- .dropdown -->
                        </ul><!-- .nk-quick-nav -->
                    </div><!-- .nk-header-tools -->
                </div><!-- .nk-header-wrap -->
            </div><!-- .container-fliud -->
        </div>

        <?php


    }

    public
    function QuickLinks()
    {
        ?>
        <!-- Quick links  -->
        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
            <a
                    class="nav-link dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                <i class="ti ti-layout-grid-add ti-md"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0">
                <div class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                        <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                        <a
                                href="javascript:void(0)"
                                class="dropdown-shortcuts-add text-body"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Add shortcuts"
                        ><i class="ti ti-sm ti-apps"></i
                            ></a>
                    </div>
                </div>
                <div class="dropdown-shortcuts-list scrollable-container">
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-calendar fs-4"></i>
                          </span>
                            <a href="app-calendar.html" class="stretched-link">Calendar</a>
                            <small class="text-muted mb-0">Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-file-invoice fs-4"></i>
                          </span>
                            <a href="app-invoice-list.html" class="stretched-link">Invoice
                                App</a>
                            <small class="text-muted mb-0">Manage Accounts</small>
                        </div>
                    </div>
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-users fs-4"></i>
                          </span>
                            <a href="app-user-list.html" class="stretched-link">User App</a>
                            <small class="text-muted mb-0">Manage Users</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-lock fs-4"></i>
                          </span>
                            <a href="app-access-roles.html" class="stretched-link">Role
                                Management</a>
                            <small class="text-muted mb-0">Permission</small>
                        </div>
                    </div>
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-chart-bar fs-4"></i>
                          </span>
                            <a href="index.html" class="stretched-link">Dashboard</a>
                            <small class="text-muted mb-0">User Profile</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-settings fs-4"></i>
                          </span>
                            <a href="pages-account-settings-account.html"
                               class="stretched-link">Setting</a>
                            <small class="text-muted mb-0">Account Settings</small>
                        </div>
                    </div>
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-help fs-4"></i>
                          </span>
                            <a href="pages-faq.html" class="stretched-link">FAQs</a>
                            <small class="text-muted mb-0">FAQs & Articles</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                            <i class="ti ti-square fs-4"></i>
                          </span>
                            <a href="modal-examples.html" class="stretched-link">Modals</a>
                            <small class="text-muted mb-0">Useful Popups</small>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <!-- Quick links -->

        <?php
    }

    public
    function Notification()
    {
        ?>
        <!-- Notification -->
        <!-- Start::header-element -->
        <div class="header-element notifications-dropdown">
            <!-- Start::header-link|dropdown-toggle -->
            <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
               data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                <i class="fe fe-bell header-link-icon"></i>
                <span class="badge bg-secondary header-icon-badge pulse pulse-secondary"
                      id="notification-icon-badge">5</span>
            </a>
            <!-- End::header-link|dropdown-toggle -->
            <!-- Start::main-header-dropdown -->
            <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 fs-17 fw-semibold">Notifications</p>
                        <span class="badge bg-secondary rounded-pill" id="notifiation-data">5 Unread</span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled mb-0" id="header-notification-scroll">
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="pe-2">
                                <span class="avatar avatar-md online bg-primary-transparent br-5"><img alt="avatar"
                                                                                                       src="../assets/images/faces/5.jpg"></span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0"><a href="notifications-list.html" class="text-dark">Congratulate
                                            <strong>Olivia James</strong> for New template start</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">Oct 15 12:32pm</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);"
                                       class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i
                                                class="ti ti-x fs-16"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="pe-2">
                                <span class="avatar avatar-md offline bg-secondary-transparent br-5"><img alt="avatar"
                                                                                                          src="../assets/images/faces/2.jpg"></span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0"><a href="notifications-list.html" class="text-dark"><strong>Joshua
                                                Gray</strong> New Message Received</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">Oct 13 02:56am</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);"
                                       class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i
                                                class="ti ti-x fs-16"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="pe-2">
                                <span class="avatar avatar-md online bg-pink-transparent br-5"><img alt="avatar"
                                                                                                    src="../assets/images/faces/3.jpg"></span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0"><a href="notifications-list.html" class="text-dark"><strong>Elizabeth
                                                Lewis</strong> added new schedule realease</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">Oct 12 10:40pm</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);"
                                       class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i
                                                class="ti ti-x fs-16"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="pe-2">
                                <span class="avatar avatar-md online bg-warning-transparent br-5"><img alt="avatar"
                                                                                                       src="../assets/images/faces/5.jpg"></span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0 fw-normal"><a href="notifications-list.html" class="text-dark">Delivered
                                            Successful to <strong>Micky</strong> </a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">Order <span
                                                class="text-warning">ID: #005428</span> had been placed</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);"
                                       class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i
                                                class="ti ti-x fs-16"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="pe-2">
                                <span class="avatar avatar-md offline bg-success-transparent br-5"><img alt="avatar"
                                                                                                        src="../assets/images/faces/1.jpg"></span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0 fw-normal"><a href="notifications-list.html" class="text-dark">You
                                            got 22 requests form <strong>Facebook</strong></a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">Today at 08:08pm</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);"
                                       class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i
                                                class="ti ti-x fs-16"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="p-3 empty-header-item1 border-top">
                    <div class="d-grid">
                        <a href="notifications-list.html" class="btn btn-primary">View All</a>
                    </div>
                </div>
                <div class="p-5 empty-item1 d-none">
                    <div class="text-center">
                                    <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                        <i class="ri-notification-off-line fs-2"></i>
                                    </span>
                        <h6 class="fw-semibold mt-3">No New Notifications</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- End::main-header-dropdown -->
        <!--/ Notification -->
        <?php
    }

    public
    function OtherJavaScript()
    {

        //down script
        ?>
        <script src="../assets/js/bundle.js?ver=3.2.2"></script>
        <script src="../assets/js/scripts.js?ver=3.2.2"></script>
        <script src="../assets/js/libs/datatable-btns.js?ver=3.2.2"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <?php
    }
}