<?php

namespace College\Ddcollege\Model;

use College\Ddcollege\Components\helper;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

class leave
{
    private database $result;
    private helper $helper;


    public function __construct()
    {
        $this->result = new database();
        $this->helper = new helper();
    }

    public function InsertFacultyLeave($faculty_id, $faculty_name, $username)
    {
        $date = date("Y-m-d");
        $financial_year = $this->helper->GetFinancialYear($date);
        $unpaid_leaves = 0;
        $total_leaves = 24;
        $leaves_taken = 0;
        $leaves_remaining = 24;
        return $this->result->insert("leaves", array("faculty_id" => $faculty_id, "faculty_name" => $faculty_name,
            "total_leaves" => $total_leaves, "leaves_taken" => $leaves_taken, "leaves_remaining" => $leaves_remaining, "unpaid_leaves" => $unpaid_leaves, "username" => $username, "financial_year" => $financial_year));
    }

    public function ViewLeaveStats()
    {
        $faculty_id = $_SESSION['user_id'];
        if (!empty($this->result->viewdata("leaves")) || !$this->result->is_table_empty("leaves") || $this->result->viewdata("leaves")) {
            if ($_SESSION['user_role'] == "admin") {
                return $this->result->viewdata("leaves");
            }
            return $this->result->viewdata("leaves", "", "faculty_id='$faculty_id'");
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function CheckLeaveDate($fromdate, $todate)
    {
        $date = date("Y-m-d");
        $financial_year = $this->helper->GetFinancialYear($date);
        $faculty_id = $_SESSION['user_id'];
        $leavedates = $this->result->viewdata("leaverequests", "leave_from,leave_to", "faculty_id=$faculty_id AND financial_year='$financial_year'");

        if (!empty($leavedates)) {
            foreach ($leavedates as $leavedate) {
                if (($fromdate >= $leavedate['leave_from'] && $fromdate <= $leavedate['leave_to']) ||
                    ($todate >= $leavedate['leave_from'] && $todate <= $leavedate['leave_to']) ||
                    ($fromdate <= $leavedate['leave_from'] && $todate >= $leavedate['leave_to'])) {
                    throw new Exception("Duplicate Entry! Another leave request already exists for the same date range. Please choose a different date range.");
                }
            }
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function PreviousMonth($fromdate, $todate)
    {
        $date = date("Y-m-d");
        if ($date > $fromdate || $date > $todate) {
            throw new Exception("Leave application for the previous month is not allowed.");
        }
    }

    public function CheckIfSunday($date)
    {
        $dateobj = new DateTime($date);
        if ($dateobj->format('N') == 7) {
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function RequestLeave($leavename, $leave_type, $fromdate, $todate, $description)
    {
        $faculty_id = $_SESSION['user_id'];
        $date = date("Y-m-d");
        $username = $_SESSION['username'];
        $fiscalyear = $this->helper->GetFinancialYear($date);
        $date1 = new DateTime($fromdate);
        $date2 = new DateTime($todate);
        $total_days = $date1->diff($date2)->days + 1;
        $this->CheckLeaveDate($fromdate, $todate);
        $this->PreviousMonth($fromdate, $todate);
        if ($fromdate == $todate) {
            if ($this->CheckIfSunday($fromdate) && $this->CheckIfSunday($todate)) {
                throw new Exception("Leave cannot be applied on Sunday!");
            }
        }
        $dateInterval = new DateInterval('P1D');
        $dateRange = new DatePeriod($date1, $dateInterval, $date2->modify('+1 day'));

        foreach ($dateRange as $newdate) {
            if ($this->CheckIfSunday($newdate->format('Y-m-d'))) {
                $total_days = $total_days - 1;
            }
        }

        return $this->result->insert("leaverequests", array("faculty_id" => $faculty_id, "leave_name" => $leavename, "leave_type" => $leave_type,
            "total_days" => $total_days, "leave_applied_on" => $date, "leave_from" => $fromdate, "leave_to" => $todate, "leave_requested_by" => $username, "status" => "Pending",
            "description" => $description, "reason" => null, "financial_year" => $fiscalyear));
    }

    public function ViewLeaveRequest()
    {
        if ($_SESSION["user_role"] == "admin") {
            return $this->result->viewdata("leaverequests");
        } else {
            $faculty_id = $_SESSION['user_id'];
            return $this->result->viewdata("leaverequests", "", "faculty_id='$faculty_id'");
        }
    }
}