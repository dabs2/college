<?php

namespace College\Ddcollege\Model;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Controller\notificationcontroller;
use DateTime;
use Exception;

class halfday
{
    private database $db;
    private helper $help;
    private notificationcontroller $notify;

    public function __construct()
    {
        $this->db = new database();
        $this->help = new helper();
        $this->notify = new notificationcontroller();
    }

    public function IsHalfDayExist()
    {
        $date = date("Y-m-d");
        $faculty_id = $_SESSION["user_id"];
        $financial_year = $this->help->GetFinancialYear($date);
        $halfday_date = $this->db->viewdata("half_days",
            "DATE(date) as halfday_date", "faculty_id = '$faculty_id' AND DATE(date) = '$date' AND financial_year='$financial_year'");
        if (!empty($halfday_date)) {
            return true;
        }
        return false;
    }

    public function EmergencyLogout($reason)
    {
        if ($_SESSION["user_role"] != "admin") {
            $date = date("Y-m-d");
            $faculty_id = $_SESSION["user_id"];
            $faculty_name = $this->db->viewdata("faculty_details", "faculty_name", "faculty_id='$faculty_id'")[0]["faculty_name"];
            $financial_year = $this->help->GetFinancialYear($date);
            date_default_timezone_set('Asia/Kolkata');
            if (!$this->IsHalfDayExist()) {
                return $this->db->insert("half_days",
                    array("faculty_id" => $faculty_id, "faculty_name" => $faculty_name, "date" => date("Y-m-d H:i:s"), "is_halfday" => false, "status" => "N/A", "on_emergency" => true, "reason" => $reason, "financial_year" => $financial_year));
            }
            $this->notify->ThrowErrorNotification("Cannot Apply Half-day on same Date again!", "Wrong Date!");
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function CheckPreviousDate($date)
    {
        $currentday = date("Y-m-d");
        if ($date < $currentday) {
            throw new Exception("Cannot apply Halfday on Back Date!");
        }
    }

    /**
     * @throws Exception
     */
    public function NormalHalfday($date, $reason)
    {
        try {
            if ($_SESSION["user_role"] != "admin") {
                $today_date = date("Y-m-d H:i:s");
                $faculty_id = $_SESSION["user_id"];
                $faculty_name = $this->db->viewdata("faculty_details", "faculty_name", "faculty_id='$faculty_id'")[0]["faculty_name"];
                $financial_year = $this->help->GetFinancialYear($today_date);
                date_default_timezone_set('Asia/Kolkata');
                $this->CheckPreviousDate($date);
                $datetime = date("Y-m-d H:i:s");
                $date1 = new DateTime($date);
                $combinedDateTime = $date1->format("Y-m-d") . ' ' . date("H:i:s", strtotime($datetime));
                if (!$this->IsHalfDayExist()) {
                    return $this->db->insert("half_days",
                        array("faculty_id" => $faculty_id, "faculty_name" => $faculty_name, "date" => $combinedDateTime, "is_halfday" => true, "status" => "Pending", "on_emergency" => false, "reason" => $reason, "financial_year" => $financial_year));
                }
                $this->notify->ThrowErrorNotification("Cannot Apply Half-day on same Date again!", "Wrong Date!");
            }
        } catch (Exception $E) {
            $this->notify->ThrowErrorNotification($E->getMessage(), "Failed");
        }
        return false;
    }

    public function ViewHalfday()
    {
        if ($_SESSION["user_role"] != "admin") {
            $userid = $_SESSION["user_id"];
            return $this->db->viewdata("half_days", "", "faculty_id= '$userid'");
        }
        return $this->db->viewdata("half_days");
    }
}