<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Model\database;
use College\Ddcollege\Model\resign;
use Exception;

class resignationcontroller
{
    private database $db;
    private resign $model;
    private helper $help;
    private notificationcontroller $notification;

    public function __construct()
    {
        $this->db = new database();
        $this->model = new resign();
        $this->help = new helper();
        $this->notification = new notificationcontroller();
    }

    public function request_resignation($date, $reason)
    {
        try {
            $this->model->ValidateResignationDate($date);
            if ($this->model->CheckPreviousResignation()) {
                throw new Exception("An existing Request of your Resignation is Either on Pending on Resigned");
            }
            if ($this->model->InsertResignation($date, $reason)) {
                $this->notification->ThrowSuccessNotification("Successfully Sent the Resignation Application to the Admin!", "Applied Resignation");
            }
        } catch (Exception $e) {
            $this->notification->ThrowErrorNotification($e->getMessage(), "Unable to Apply Resignation");
        }
    }

    public function viewresignation()
    {
        return $this->model->ViewResignation();

    }

    public function requestbutton()
    {
        if ($_SESSION["user_role"] != "admin") {
            ?>
            <li class="preview-item">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resignform">
                    Apply Resign
                </button>
            </li>
            <?php
        }
    }

    public function requestform()
    {
        ?>
        <!-- Modal Form -->
        <div class="modal fade" id="resignform">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resignation Form</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="form-validate is-alter" method="post">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Resignation Date</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                        </div>
                                        <label>
                                            <input type="text" id="resign_date" name="resign_date"
                                                   class="form-control date-picker"
                                                   data-date-format="yyyy-mm-dd">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group my-2">
                                    <div class="form-control-wrap">
                                        <label class="form-label">Resignation Reason</label>
                                        <select class="form-select js-select2" data-ui="xl" name="resignation_reason"
                                                id="outlined-select">
                                            <option value="Personal Reason">Personal reasons</option>
                                            <option value="Career Advancement">Seeking career advancement</option>
                                            <option value="Work Life Balance">Improving work-life balance</option>
                                            <option value="Relocation">Relocation</option>
                                            <option value="Health Issues">Health issues</option>
                                            <option value="Better Salary">Better salary offer</option>
                                            <option value="Unhappy Environment">Unhappy with work environment</option>
                                            <option value="Job Dissatisfaction">Job dissatisfaction</option>
                                            <option value="Educational Pursuit">Educational pursuit</option>
                                            <option value="Family Commitments">Family commitments</option>
                                            <option value="Company Culture">Misalignment with company culture</option>
                                            <option value="New Opportunity">Found a new opportunity</option>
                                            <option value="Career Change">Changing career paths</option>
                                            <option value="Retirement">Retirement</option>
                                            <option value="Restructuring">Company restructuring</option>
                                            <option value="Conflict">Conflict with management or colleagues</option>
                                            <option value="Burnout">Experiencing burnout</option>
                                            <option value="Redundancy">Position made redundant</option>
                                            <option value="Lack Growth">Lack of growth opportunities</option>
                                            <option value="Commute">Long commute</option>
                                            <option value="Toxic Workplace">Toxic workplace environment</option>
                                            <option value="Job Insecurity">Feeling job insecurity</option>
                                            <option value="Lack Recognition">Lack of recognition</option>
                                            <option value="Poor Leadership">Poor leadership</option>
                                            <option value="Company Ethics">Disagreement with company ethics</option>
                                            <option value="Other Reason">Other reason</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group float-end my-2">
                                <button type="submit" name="resign" class="btn btn-lg btn-danger">Resign</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Resignation Form</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["resign"])) {
            $resign_date = $_POST["resign_date"];
            $resign_reason = $_POST["resignation_reason"];
            $this->request_resignation($resign_date, $resign_reason);
        }
    }

    public function check_resigned_status($resign_id = null)
    {
        $is_status = $this->db->viewdata("resignation", "status", "resignation_id='$resign_id'")[0];
        if ($is_status["status"] != "Resigned") {
            return false;
        }
        return true;
    }

    public
    function actionbuttons($resign_id)
    {
        if ($_SESSION["user_role"] == "admin") {
            if (!$this->check_resigned_status($resign_id)) {
                ?>
                <td>
                    <ul class="btn-group" style="margin-bottom: ;">
                        <li class="preview-item">
                            <button type="button"
                                    onclick="new Jsfunctions().approve_resignation(this.closest('tr'))"
                                    class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#resign">
                                Approve
                            </button>
                        </li>
                    </ul>
                </td>
                <?php
            } else {
                ?>
                <td>

                </td>
                <?php
            }
        } else if ($this->check_resigned_status($resign_id)) {
            ?>
            <td>
            </td>
            <?php
        } else {
            ?>
            <td>
                <ul class="btn-group" style="margin-bottom: ;">
                    <li class="preview-item">
                        <button type="button"
                                class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#cancelresignation">
                            Cancel
                        </button>
                    </li>
                </ul>
            </td>
            <?php
        }
    }

    public
    function resignationformforadmin()
    {
        ?>
        <!-- Modal Alert 2 -->
        <div class="modal fade" tabindex="-1" id="resign">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon ni ni-trash-alt bg-danger"></em>
                            <form method="post" action="#">
                                <input type="text" placeholder="Resign Id" class="form-control" id="resignation"
                                       name="resignation" hidden>
                                <input type="text" placeholder="Faculty Id" class="form-control"
                                       id="faculty_id_for_resign" name="faculty_id_for_resign" hidden>
                                <input type="text" placeholder="Date Resign" class="form-control"
                                       id="date_id_for_resign" name="date_id_for_resign"
                                       hidden>
                                <h4 class="nk-modal-title">Resign User?</h4>
                                <div class="nk-modal-text">
                                    <p class="lead" id="resign_name_id"></p>
                                </div>
                                <div class="nk-modal-action mt-5">
                                    <button type="submit" class="btn btn-lg btn-mw btn-danger"
                                            name="resign_faculty_from_office" id="resign"
                                            data-bs-dismiss="modal">Yes, Resign!
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div><!-- .modal-body -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["resign_faculty_from_office"])) {
            $resign_id = $_POST["resignation"];
            $date = $_POST["date_id_for_resign"];
            $faculty_id = $_POST["faculty_id_for_resign"];
            if ($this->db->update_database("resignation", array("status" => "Resigned"), "resignation_id='$resign_id' AND faculty_id='$faculty_id'")) {
                $this->db->update_database("faculty_details", array("faculty_status" => "Resigned"), "faculty_id='$faculty_id'");
                $this->db->update_database("users", array("status" => "Resigned", "resigned_date" => $date), "user_id='$faculty_id'");
            }
        }
    }

    public
    function cancel_resignation()
    {
        ?>
        <!-- Modal Alert 2 -->
        <div class="modal fade" tabindex="-1" id="cancelresignation">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon ni ni-shield-alert bg-success"></em>
                            <form method="post" action="#">
                                <input type="text" placeholder="Resign Id" class="form-control"
                                       id="cancel_resignation"
                                       name="cancel_resignation" hidden>
                                <h4 class="nk-modal-title">Cancel Resignation!</h4>
                                <div class="nk-modal-text">
                                    <p class="lead">Click on the down button to cancel the Resignation.</p>
                                </div>
                                <div class="nk-modal-action mt-5">
                                    <button type="submit" class="btn btn-lg btn-mw btn-primary" name="cancelresign"
                                            id="cancelresign"
                                            data-bs-dismiss="modal">Cancel!
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div><!-- .modal-body -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["cancelresign"])) {
            $id = $_SESSION["user_id"];
            if ($this->db->deletedata("resignation", "faculty_id='$id'")) {
                $this->notification->ThrowSuccessNotification("Cancelled the Resignation!", "Cancelled Resignation");
            }
        }
    }
}