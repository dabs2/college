<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Model\database;
use College\Ddcollege\Model\holiday;
use College\Ddcollege\Model\status;
use Exception;

class holidaycontroller
{
    private database $db;
    private holiday $holiday;
    private notificationcontroller $notification;
    private status $status;
    private helper $help;

    public function __construct()
    {
        $this->db = new database();
        $this->holiday = new holiday();
        $this->notification = new notificationcontroller();
        $this->status = new status();
        $this->help = new helper();
    }

    /**
     * @throws Exception
     */
    public function insertholiday($holiday_name, $date, $type)
    {
        return $this->holiday->InsertHoliday($holiday_name, $date, $type);
    }

    public function viewholiday()
    {
        $viewholiday = $this->holiday->ViewHoliday();
        if (!empty($viewholiday) && is_array($viewholiday) && !$this->db->is_table_empty("holidays")) {
            return $viewholiday;
        }
        return false;
    }

    public function checkstatus($date)
    {
        $status = $this->holiday->CheckStatus($date);
        return $this->status->get_status($status);
    }

    /**
     * @throws Exception
     */
    public function updateholidayedit($holiday_id, $holiday_name, $date, $type)
    {
        $edited_holiday = $this->holiday->CheckInputHolidayEdit($holiday_id, $holiday_name, $date, $type);
        return $this->db->update_database("holidays", $edited_holiday, "holiday_id='$holiday_id'");
    }

    public function action()
    {
        if ($_SESSION["user_role"] === "admin") {
            ?>
            <th>Actions</th>
            <?php
        }
    }

    public function actionbuttons()
    {
        if ($_SESSION["user_role"] === "admin") {
            ?>
            <td>
                <ul class="btn-group" style="margin-bottom: ;">
                    <li class="preview-item">
                        <button type="button" onclick="new Jsfunctions().holidayDataEdit_id(this.closest('tr'))"
                                class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editholiday">
                            Edit
                        </button>
                    </li>
                    <li class="preview-item">
                        <button type="button" onclick="new Jsfunctions().holiday_Delete_id(this.closest('tr'))"
                                class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteholiday">
                            Delete
                        </button>
                    </li>
                </ul>
            </td>
            <?php
        }
    }

    public function holidaybutton()
    {
        if ($_SESSION["user_role"] === "admin") {
            ?>
            <li class="preview-item">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addholidayform">+
                    holiday
                </button>
            </li><?php
        }
    }

    /**
     * @throws Exception
     */
    public function addhholiday()
    {
        ?>
        <!-- Modal Form -->
        <div class="modal fade" id="addholidayform">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Holiday Details</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="form-validate is-alter" method="post">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Holiday Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" placeholder="Holiday Name" class="form-control" id="full-name"
                                           name="holiday_name" required>
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
                                                   data-date-format="yyyy-mm-dd">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-3">
                                <label class="form-label">Type</label>
                                <ul class="custom-control-group g-3 align-center">
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="radio" class="custom-control-input" name="type"
                                                   id="com-email" value="Public Holiday" required>
                                            <label class="custom-control-label" for="com-email">Public Holiday</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="radio" class="custom-control-input" name="type"
                                                   id="com-sms" value="Internal Holiday" required>
                                            <label class="custom-control-label" for="com-sms">Internal Holiday</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group float-end">
                                <button type="submit" name="submit" class="btn btn-lg btn-primary">Add Holiday</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Holiday Form</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["submit"])) {
            $name = $_POST["holiday_name"];
            $date = $_POST["date"];
            $type = $_POST["type"];
            if ($this->insertholiday($name, $date, $type)) {
                $this->notification->ThrowSuccessNotification("Added $name in the Holiday\'s", "Holiday Added");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editholiday()
    {
        ?>
        <!-- Modal Form -->
        <div class="modal fade" id="editholiday">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Holiday Details</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="form-validate is-alter" method="post">
                            <input type="text" placeholder="Holiday Id" class="form-control" id="holiday_id"
                                   name="holiday_id" hidden>
                            <div class="form-group">
                                <label class="form-label" for="full-name">Holiday Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" placeholder="Holiday Name" class="form-control" id="holiday_name"
                                           name="holiday_name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left ">
                                            <!--                                            <em class="icon ni ni-calendar"></em>-->
                                        </div>
                                        <label>
                                            <input type="text" name="date" id="date" class="form-control date-picker"
                                                   data-date-format="yyyy-mm-dd">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-3">
                                <label class="form-label">Type</label>
                                <ul class="custom-control-group g-3 align-center">
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="radio" class="custom-control-input" name="type_1"
                                                   id="type_1" value="Public Holiday" required>
                                            <label class="custom-control-label" for="type_1">Public Holiday</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="radio" class="custom-control-input" name="type_1"
                                                   id="type_2" value="Internal Holiday" required>
                                            <label class="custom-control-label" for="type_2">Internal Holiday</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group float-end">
                                <button type="submit" name="editholiday"
                                        onclick="new Jsfunctions().holidayDataEdit_id(this.closest('tr'))"
                                        class="btn btn-lg btn-primary">Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <span class="sub-text">Edit Holiday</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["editholiday"])) {
            $holiday_id = $_POST["holiday_id"];
            $holiday_name = $_POST["holiday_name"];
            $date = $_POST["date"];
            $type = $_POST["type_1"];
            if ($this->updateholidayedit($holiday_id, $holiday_name, $date, $type)) {
                $this->notification->ThrowSuccessNotification("Edited $holiday_name in the Holiday\'s", "Holiday Edited");
            }
        }
    }

    public function deleteholiday()
    {
        ?>
        <!-- Modal Alert 2 -->
        <div class="modal fade" tabindex="-1" id="deleteholiday">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon ni ni-trash-alt bg-danger"></em>
                            <form method="post" action="#">
                                <input type="text" placeholder="Holiday Id" class="form-control" id="delete_holiday_id"
                                       name="delete_holiday_id" hidden>
                                <h4 class="nk-modal-title">Delete Holiday!</h4>
                                <div class="nk-modal-text">
                                    <p class="lead">Are you certain about removing this cherished holiday from our
                                        calendar?</p>
                                    <p class="text-soft">"Should you require assistance, please don't hesitate. Instead
                                        of
                                        outright deletion, consider the option to edit the holiday to better suit your
                                        needs."</p>
                                </div>
                                <div class="nk-modal-action mt-5">
                                    <button type="submit" class="btn btn-lg btn-mw btn-danger" name="delete" id="delete"
                                            data-bs-dismiss="modal">Delete!
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div><!-- .modal-body -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["delete"])) {
            $delete_id = $_POST["delete_holiday_id"];
            if ($this->db->deletedata("holidays", "holiday_id='$delete_id'")) {
                $this->notification->ThrowErrorNotification("Holiday has been Deleted!", "Deleted Holiday");
            }
        }
    }

    public function checklatestholiday()
    {
        $date = date("Y-m-d");
        $current_month = date("m");
        $financial_year = $this->help->GetFinancialYear($date);
        $holiday_date = $this->db->viewdata("holidays", "holiday_name",
            "MONTH(date) = '$current_month' AND financial_year='$financial_year'", "date ASC");
        if (empty($holiday_date)) {
            return '<span class="text-success">No Holidays this Month!</span>';
        }
        return '<span class="text-info">' . $holiday_date[0]['holiday_name'] . '</span>';
    }
}