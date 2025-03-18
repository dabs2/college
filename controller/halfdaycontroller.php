<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Model\database;
use College\Ddcollege\Model\halfday;
use College\Ddcollege\Model\holiday;
use College\Ddcollege\Model\status;

class halfdaycontroller
{
    private database $db;
    private halfday $halfday;
    private notificationcontroller $notify;
    private status $status;
    private Logincontroller $logincontroller;
    private helper $help;


    public function __construct()
    {
        $this->db = new database();
        $this->halfday = new halfday();
        $this->notify = new notificationcontroller();
        $this->status = new status();
        $this->logincontroller = new Logincontroller();
        $this->help = new helper();


    }

    public function viewhalfday()
    {
        return $this->halfday->ViewHalfday();
    }

    public function checkstatusofhalfday($STATUS)
    {
        if ($STATUS == "N/A") {
            $STATUS = "Emergency Halfday";
        } else {
            $STATUS = "Halfday";
        }
        return $this->status->get_other_status($STATUS);
    }

    public function applyemergency($reason)
    {
        return $this->halfday->EmergencyLogout($reason);
    }

    public function applyhalfday($date, $reason)
    {
        return $this->halfday->NormalHalfday($date, $reason);
    }

    /**
     * @throws \Exception
     */
    public function popupforemergencyhalfday()
    {
        ?>
        <!-- Modal Tabs -->
        <div class="modal fade" tabindex="-1" role="dialog" id="modalTabs">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <form method="post" action="#">
                        <div class="modal-body modal-body-md">
                            <h4 class="title text-danger">Emergency Half-day</h4>
                            <ul class="nk-nav nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Note</a>
                                </li>
                            </ul>

                            <div class="form-group my-2">
                                <label class="form-label">Emergency Reason</label>
                                <div class="input-group">
                                    <textarea class="form-control"
                                              placeholder="Reason for Emergency" name="emergencyhalfdayreason"
                                              required></textarea>
                                </div>
                            </div>

                            <div class="tab-content">

                                <div class="p-2">
                                    <a href="#collapse-link" class="fw-semibold" data-bs-toggle="collapse">
                                        Please read instructions before applying....Once you applied or willing to
                                        apply Emergency
                                        Half-day!
                                    </a>

                                    <div class="collapse" id="collapse-link">
                                        <div class="mt-3">
                                            <p> You can apply for a maximum of 3 half days per month.</p>
                                            <p> Once you've applied, your attendance for that period will be considered
                                                complete & your current time will be recorded.</p>
                                            <p> Applying for more than 3 half days per month is not permitted.</p>
                                            <p> Apply only if it's very urgent instead of using it unnecessarily.</p>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="submitemergencyhalfday" class="btn btn-lg btn-danger my-2">
                                    Apply Halfday
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- .modal -->
        <?php
        $day = date("Y-m-d");
        $financial_year = $this->help->GetFinancialYear($day);
        $faculty_id = $_SESSION["user_id"];
        if (isset($_POST["submitemergencyhalfday"])) {
            $reason = $_POST["emergencyhalfdayreason"];
            if ($this->applyemergency($reason)) {
                $this->db->update_database("attendance", array("status" => "Emergency Halfday"),
                    "faculty_id='$faculty_id' AND financial_year='$financial_year' AND attendance_date='$day'");
                $this->logincontroller->logout();
                $this->notify->ThrowSuccessNotification("Successfully sent the Emergency Half-day to Admin!", "Emergency Halfday");
            }
        }
    }

    public function halfdaybuttonforapply()
    {
        if ($_SESSION["user_role"] != "admin") {
            ?>
            <li class="my-2" style="display: flex; justify-content: flex-end; align-items: center;">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#halfdaybutton">
                    Apply Half-day
                </button>
            </li><?php

        }
    }

    public function popupforhalfday()
    {
        ?>
        <!-- Modal Form -->
        <div class="modal fade" id="halfdaybutton">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Apply Half-day</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post">
                            <div class="form-group my-2">
                                <label class="form-label">Reason</label>
                                <div class="input-group">
                                    <textarea class="form-control"
                                              placeholder="Reason for Half-day" name="halfdayreason"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                        </div>
                                        <label>
                                            <input type="text" name="date" class="form-control date-picker"
                                                   data-date-format="yyyy-mm-dd" required>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group my-2 float-end">
                                <button type="submit" class="btn btn-lg btn-primary" name="submithalfday">Apply</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Half-day</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["submithalfday"])) {
            $date = $_POST["date"];
            $reason = $_POST["halfdayreason"];
            if ($this->applyhalfday($date, $reason)) {
                $this->notify->ThrowSuccessNotification("Successfully sent the Half-day to Admin.", "Wait for the Approval!");
            }
        }
    }

    public function actionbuttons($status)
    {
        if ($_SESSION["user_role"] == "admin") {
            if ($status == "Pending") {
                ?>
                <ul class="btn-group" style="margin-bottom: ;">
                    <li class="preview-item">
                        <button type="submit" onclick="new Jsfunctions().for_half_day(this.closest('tr'))"
                                class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#approvehalfday">
                            Approve
                        </button>
                    </li>
                    <li class="preview-item">
                        <button type="submit"
                                onclick="new Jsfunctions().for_half_day(this.closest('tr'))" class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#rejecthalfday">
                            Reject
                        </button>
                    </li>
                </ul>
                <?php
            }
        } else {
            if ($status == "Pending") {
                ?>
                <li>
                    <button type="submit" onclick="new Jsfunctions().for_half_day(this.closest('tr'))"
                            class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#cancelhalfday">
                        Cancel
                    </button>
                </li>
                <?php
            }
        }
    }

    public function cancelhalfday()
    {
        ?>
        <!-- Modal Alert 2 -->
        <div class="modal fade" tabindex="-1" id="cancelhalfday">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon ni ni-trash-alt bg-danger"></em>
                            <form method="post" action="#">
                                <input type="text" placeholder="Cancel Id" class="form-control" id="cancel_halfday_id"
                                       name="cancel_halfday_id" hidden>
                                <h4 class="nk-modal-title">Cancel Halfday!</h4>
                                <div class="nk-modal-text">
                                    <p class="lead">Are you sure you want to cancel the Half-day you applied?</p>
                                </div>
                                <div class="nk-modal-action mt-5">
                                    <button type="submit" class="btn btn-lg btn-mw btn-danger"
                                            name="cancel_the_half_day"
                                            id="cancel_the_half_day"
                                            data-bs-dismiss="modal">Yes, Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div><!-- .modal-body -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["cancel_the_half_day"])) {
            $halfday_id = $_POST["cancel_halfday_id"];
            if ($this->db->deletedata("half_days", "halfday_id='$halfday_id'")) {
                $this->notify->ThrowSuccessNotification("Cancelled the Half-day", "Cancelled Half-day");
            }
        }
    }

    public function approvehalfday()
    {
        ?>
        <!-- Modal Alert -->
        <div class="modal fade" tabindex="-1" id="approvehalfday">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="#">
                        <input type="text" placeholder="Approve Id" class="form-control" id="approve_id_for_js"
                               name="approve_id_for_js" hidden>
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                        <div class="modal-body modal-body-lg text-center">
                            <div class="nk-modal">
                                <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                                <h4 class="nk-modal-title">Approve Request!</h4>
                                <div class="nk-modal-text">
                                    <span class="sub-text-sm">Approve Halfday Request of User.</span>
                                </div>
                                <div class="nk-modal-action">
                                    <button href="#" class="btn btn-lg btn-mw btn-success"
                                            name="approve_request_of_the_user" data-bs-dismiss="modal">
                                        Approve
                                    </button>
                                </div>
                            </div>
                        </div><!-- .modal-body -->
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["approve_request_of_the_user"])) {
            $half_day_id = $_POST["approve_id_for_js"];
            if ($this->db->update_database("half_days", array("status" => "Approved"), "halfday_id='$half_day_id'")) {
                $this->notify->ThrowSuccessNotification("Approved the Halfday Request of the user.", "Approved!");
            }
        }
    }

    public function rejecthalfday()
    {
        ?>
        <!-- Modal Alert 2 -->
        <div class="modal fade" tabindex="-1" id="rejecthalfday">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-lg text-center">
                        <form action="#" method="post">
                            <input type="text" placeholder="Reject Id" class="form-control" id="rejection_id_for_js"
                                   name="rejection_id_for_js" hidden>
                            <div class="nk-modal">
                                <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                                <h4 class="nk-modal-title">Reject Halfday!</h4>
                                <p>Are you sure you want to cancel the Half-day?</p>
                                <div class="form-group my-2">
                                    <label class="form-label">Reject Reason</label>
                                    <div class="input-group">
                                    <textarea class="form-control"
                                              placeholder="Reason for Rejection" name="reject_reason_halfday"
                                              required></textarea>
                                    </div>
                                </div>
                                <div class="nk-modal-action mt-5">
                                    <button type="submit" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal"
                                            name="reject_the_halfday_of_user" id="reject_the_halfday_of_user">Reject
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- .modal-body -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["reject_the_halfday_of_user"])) {
            $reject_halfday_id = $_POST["rejection_id_for_js"];
            $reason = $_POST["reject_reason_halfday"];
            if ($this->db->update_database("half_days", array("status" => "Rejected", "rejection" => $reason), "halfday_id='$reject_halfday_id'")) {
                $this->notify->ThrowSuccessNotification("Reject the Halfday of the user", "Rejected!");
            }
        }
    }
}