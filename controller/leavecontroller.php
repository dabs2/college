<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Model\database;
use College\Ddcollege\Model\leave;
use Exception;

class leavecontroller
{
    private leave $leave;
    private database $result;
    private helper $help;
    private notificationcontroller $notify;

    public function __construct()
    {
        $this->leave = new leave();
        $this->result = new database();
        $this->help = new helper();
        $this->notify = new notificationcontroller();
    }

    public function insert_leave_stats($faculty_id, $faculty_name, $username)
    {
        return json_encode($this->leave->InsertFacultyLeave($faculty_id, $faculty_name, $username));
    }

    public function viewleavestats()
    {
        return $this->leave->ViewLeaveStats();
    }

    /**
     * @throws Exception
     */
    public function leave_request($leavename, $leave_type, $fromdate, $todate, $description)
    {
        try {
            if (json_encode($this->leave->RequestLeave($leavename, $leave_type, $fromdate, $todate, $description))) {
                $this->notify->ThrowSuccessNotification("Successfully Submitted! the Leave Request", "Leave");
            }
        } catch (Exception $e) {
            $this->notify->ThrowErrorNotification($e->getMessage(), "Error Occurred");
        }
        return false;
    }

    public function viewleaverequests()
    {
        return $this->leave->ViewLeaveRequest();
    }

    public function unpaid_leave()
    {
        $date = date("Y-m-d");
        $financial_year = $this->help->GetFinancialYear($date);
        $faculty_id = $_SESSION["user_id"];
        $unpaid_leave = $this->result->viewdata("leaves",
            "leaves_taken,total_leaves", "faculty_id='$faculty_id' AND financial_year='$financial_year'")[0];
        if ($unpaid_leave["total_leaves"] <= $unpaid_leave["leaves_taken"]) {
            return true;
        }
        return false;
    }

    public function leaverequestbutton()
    {
        if ($_SESSION['user_role'] != 'admin') {
            if ($this->checkleaveremaining() > 0) {
                ?>
                <li class="my-2" style="display: flex; justify-content: flex-end; align-items: center;">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyLeave">Apply
                        Leave</a>
                </li>
                <?php
            } elseif ($this->checkleaveremaining() <= 0 && $this->unpaid_leave()) {
                ?>
                <li class="my-2"
                    style="display: flex; justify-content: flex-end; align-items: center;">
                    <a href="#" class="btn btn-primary bg-danger" id="unpaid_leave_btn" data-bs-toggle="modal"
                       data-bs-target="#applyLeave">Apply
                        Unpaid
                        Leave</a>
                </li><?php
            }
        }
    }

    //when the leave is approve update leaves tats
    public function UpdateLeaveStats($leave_id, $faculty_id): void
    {
        $date = date("Y-m-d");
        $financial_year = $this->help->GetFinancialYear($date);

        $existingLeaves = $this->result->viewdata("leaves",
            "total_leaves,leaves_taken,leaves_remaining,unpaid_leaves", "faculty_id ='$faculty_id' AND financial_year='$financial_year'")[0];

        $existingTotalDays = $this->result->viewdata("leaverequests", "total_days,leave_type",
            "faculty_id ='$faculty_id' AND financial_year='$financial_year' AND leave_id='$leave_id'")[0];


        $leave_remaining = $existingLeaves["leaves_remaining"] - $existingTotalDays["total_days"];
        $leaves_taken = $existingLeaves["leaves_taken"] + $existingTotalDays["total_days"];

        if ($existingTotalDays["total_days"] > 24 || $existingTotalDays["leave_type"] == "Unpaid Leave") {
            $unpaid_leaves = ($existingLeaves["leaves_taken"] + $existingTotalDays["total_days"]) - $existingLeaves["total_leaves"];
            $this->result->update_database("leaves",
                array("leaves_taken" => $leaves_taken, "leaves_remaining" => 0, "unpaid_leaves" => $unpaid_leaves),
                "faculty_id ='$faculty_id' AND financial_year='$financial_year'"
            );
        } else {
            $this->result->update_database("leaves",
                array("leaves_taken" => $leaves_taken, "leaves_remaining" => $leave_remaining),
                "faculty_id ='$faculty_id' AND financial_year='$financial_year'");
        }

    }

    public function checkleaveremaining()
    {
        $date = date("Y-m-d");
        $finanacial_year = $this->help->GetFinancialYear($date);
        $faculty_id = $_SESSION["user_id"];
        if ($_SESSION["user_role"] != "admin") {
            return $this->result->viewdata("leaves", "leaves_remaining", "faculty_id='$faculty_id' AND financial_year='$finanacial_year'")[0]['leaves_remaining'];
        }
        return $this->result->viewdata("leaves", "leaves_remaining", "faculty_id='$faculty_id' AND financial_year='$finanacial_year'");
    }

    /**
     * @throws Exception
     */
    public function leaveform()
    {
        ?>
        <div class="modal fade" id="applyLeave">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Request</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" class="form-validate is-alter">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Leave Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" placeholder="Leave Name" id="full-name"
                                           name="leavename" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Leave Date</label>
                                <div class="form-control-wrap">
                                    <div class="input-daterange date-picker-range input-group">
                                        <input type="text" placeholder="From Date" name="from" class="form-control"/>
                                        <div class="input-group-addon">TO</div>
                                        <input type="text" placeholder="To Date" name="to" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="leave-dropdown">Leave Type</label>
                                <select class="form-control" id="leave-dropdown" name="leavetype"
                                        required>
                                    <?php
                                    if ($this->checkleaveremaining() > 0) {
                                        ?>
                                        <option value="Select">Select</option>
                                        <option value="Personal Leave">Personal Leave</option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="Unpaid Leave">Unpaid Leave</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Leave Description</label>
                                <div class="input-group">
                                    <textarea class="form-control"
                                              placeholder="Leave Description" name="leavedescription"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary" id="apply_leave_btn" name="submit">
                                    Apply
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Applying Leave</span>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let call = new Jsfunctions();
                call.change_button();
            })
        </script>
        <?php
        if (isset($_POST["submit"])) {
            $leavename = $_POST["leavename"];
            $from = $this->help->DataBaseDateFormat($_POST["from"]);
            $to = $this->help->DataBaseDateFormat($_POST["to"]);
            $leavetype = $_POST["leavetype"];
            $leavedescription = $_POST["leavedescription"];
            return $this->leave_request($leavename, $leavetype, $from, $to, $leavedescription);
        }
        return false;
    }

    public function leave_action_buttons($status)
    {
        if ($status == "Pending") {
            if ($_SESSION['user_role'] == "admin") {
                ?>
                <div class="dropdown">
                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                       data-bs-toggle="dropdown"><em
                                class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                        <ul class="link-list-plain">
                            <li>
                                <a href="#" data-bs-toggle="modal"
                                   onclick="new Jsfunctions().get_id(this.closest('tr'),'leave_id')"
                                   id="get_approve" data-bs-target="#approve">Approve</a>
                            </li>
                            <li><a href="#" data-bs-toggle="modal"
                                   onclick="new Jsfunctions().get_id(this.closest('tr'),'reject_leave_id')"
                                   id="get_reject" data-bs-target="#reject">Reject</a></li>
                        </ul>
                    </div>
                </div>
                <?php
            } elseif ($_SESSION["user_role"] != "admin") {
                ?>
                <div class="dropdown">
                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                       data-bs-toggle="dropdown"><em
                                class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                        <ul class="link-list-plain">
                            <li><a href="#" data-bs-toggle="modal"
                                   onclick="new Jsfunctions().get_id(this.closest('tr'),'cancel_leave_id')"
                                   id="get_cancelled" data-bs-target="#cancel">Cancel</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }
        }
    }

    public function admin_approve_request()
    {
        ?>
        <div class="modal fade" id="approve">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Request</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="approve_leave_form" method="post" class="form-validate is-alter">
                            <div class="form-group">
                                <input type="hidden" name="leave_id" id="leave_id" value="">
                                <input type="hidden" name="leave_id_faculty" id="leave_id_faculty" value="">
                                <p class="confirm-message">Are you sure you want to approve this leave
                                    request?</p>
                                <!--                                <p class="confirm-message text-center">Are you sure you want to approve this leave-->
                                <!--                                    request?</p>-->
                                <button type="submit" class="btn btn-lg btn-primary" name="approve">Approve
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Approve Leave</span>
                    </div>
                </div>
            </div>
        </div>
        <?php

        if (isset($_POST["approve"])) {
            $leave = $_POST['leave_id'];
            $faculty_id = $_POST["leave_id_faculty"];
            $date = date("Y-m-d");
            $financial_year = $this->help->GetFinancialYear($date);
            if ($this->result->update_database("leaverequests", array("status" => "Approved"), "leave_id='$leave' AND financial_year = '$financial_year'")) {
                $this->UpdateLeaveStats($leave, $faculty_id);
            }
        }
    }

    public function admin_reject_request()
    {
        ?>
        <div class="modal fade" id="reject">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Request</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="reject_leave_form" method="post" class="form-validate is-alter">
                            <div class="form-group">
                                <label class="form-label">Reject Reason</label>
                                <div class="input-group">
                                    <textarea class="form-control"
                                              placeholder="Reject Reason" name="rejectreason"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="leave_id" id="reject_leave_id" value="">
                                <button type="submit" class="btn btn-lg btn-primary" name="reject">Reject</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Reject Leave</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["reject"])) {
            $leave = $_POST['leave_id'];
            $reason = $_POST['rejectreason'];
            $date = date("Y-m-d");
            $financial_year = $this->help->GetFinancialYear($date);
            $this->result->update_database("leaverequests", array("status" => "Rejected", "reason" => $reason), "leave_id='$leave' AND financial_year = '$financial_year'");
        }
    }

    public function faculty_cancel_request()
    {
        ?>
        <div class="modal fade" id="cancel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Request</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" class="form-validate is-alter">
                            <div class="form-group">
                                <input type="hidden" id="cancel_leave_id" name="cancel_leave_id">
                                <button type="submit" class="btn btn-lg btn-primary" name="cancel">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Cancel Leave</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["cancel"])) {
            $cancel_id = $_POST["cancel_leave_id"];
            $date = date("Y-m-d");
            $financial_year = $this->help->GetFinancialYear($date);
            $this->result->deletedata("leaverequests", "leave_id='$cancel_id' AND financial_year = '$financial_year' AND status ='Pending'");
        }
    }

    public function return_leave_stats($id)
    {
        return $this->result->viewdata("leaves", "total_leaves,leaves_taken,leaves_remaining", "faculty_id = '$id'");
    }
}