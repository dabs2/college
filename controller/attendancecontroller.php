<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Model\attendance;
use College\Ddcollege\Model\database;
use Exception;

class attendancecontroller
{
    private $db;
    private $attendance;

    public function __construct()
    {
        $this->db = new database();
        $this->attendance = new attendance();
    }

    public function insert_attendance()
    {
        if (!$this->attendance->HasPreviousLogin()) {
            return $this->attendance->InsertAttendance();
        }
        return false;
    }

    public function viewattendance()
    {
        return $this->attendance->ViewAttendance();
    }

    public function latearrivals()
    {
        return $this->attendance->CheckLateArrivals();
    }

    public function viewlatearrivals()
    {
        $late_arrival = $this->attendance->ViewLateArrivals();
        if (!empty($late_arrival) && is_array($late_arrival) && !$this->db->is_table_empty("late_arrivals")) {
            foreach ($late_arrival as $latefaculty) {
                ?>
                <div class="card-inner card-inner-md">
                    <div class="user-card">
                        <div class="user-avatar bg-primary-dim">
                            <span><?= substr($latefaculty["faculty_name"], 0, 1) ?></span>
                        </div>
                        <div class="user-info">
                            <span class="lead-text"><?= $latefaculty["faculty_name"]; ?></span>
                            <span class="sub-text"><?= $latefaculty["in_time"]; ?></span>
                        </div>
                        <div class="user-action">
                            <div class="drodown">
                                <span class="badge bg-danger rounded-pill ucap  lead-text"><?= $latefaculty["delay"]; ?></span>
                                <!--                                                            --><?php //= $this->attendancecontroller->viewlatearrivals()[0]["delay"];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="example-alert">
                                                            <div class="alert alert-success alert-icon">
                                                                <em class="icon ni ni-cross-circle"></em> <strong>No Faculty Founded</strong>! in Late Arrival Zone. <button class="close" data-bs-dismiss="alert"></button>
                                                            </div>
                                                        </div>';
        }
    }

    /**
     * @throws Exception
     */
    public function calculatelogout()
    {
        if (!$this->attendance->HasPreviousLogOut()) {
            return $this->attendance->LogoutOutTime();
        }
        return false;
    }

    public function logoutprompt()
    {
        if ($_SESSION["user_role"] != "admin") {
            ?>
            <div id="logout_prompt2" class="modal fade" tabindex="-1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body modal-body-lg text-center">
                            <div class="nk-modal">
                                <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                                <h4 class="nk-modal-title">Are you sure you want to log out?</h4>
                                <div class="nk-modal-text">
                                    <p class="lead">Attendance out time will be recorded upon confirmation!</p>
                                </div>
                                <form action="#" method="post">
                                    <div class="nk-modal-action mt-5">
                                        <button name="logout" class="btn mx-3 btn-lg btn-mw btn-light"
                                                data-bs-dismiss="modal">Proceed
                                        </button>
                                        <a class="btn btn-lg btn-mw btn-light"
                                           data-bs-dismiss="modal">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div><!-- .modal-body -->
                    </div>
                </div>
            </div>
            <?php
        }
    }
}