<?php

namespace College\Ddcollege\Model;

use College\Ddcollege\Components\helper;
use DateTime;
use Exception;

class resign
{
    private database $db;
    private helper $help;

    public function __construct()
    {
        $this->db = new database();
        $this->help = new helper();
    }

    /**
     * @throws Exception
     */
    public function ValidateResignationDate($resignation_Date)
    {
        $date = date("Y-m-d");
        if ($resignation_Date < $date) {
            throw new Exception("Applying resignation on backdate is restricted!");
        }
    }

    public function CheckPreviousResignation()
    {
        $facultyid = $_SESSION["user_id"];
        $faculty_status = $this->db->viewdata("resignation", "status", "faculty_id='$facultyid'");
        if (!$this->db->is_table_empty("resignation") && !empty($faculty_status)) {
            if ($faculty_status[0]["status"] == "Pending" || $faculty_status[0]["status"] == "Resigned") {
                return true;
            }
        }
        return false;
    }


    /**
     * @throws Exception
     */
    public
    function InsertResignation($date, $reason)
    {
        //request resignation
        $today = date("Y-m-d");
        $financial_year = $this->help->GetFinancialYear($date);

        $DateTime = new DateTime($today);
        $DateTime2 = new DateTime($date);

        $notice_period = $DateTime->diff($DateTime2)->d;


        if ($notice_period < 15) {
            throw new Exception("Cannot apply Resignation, The Notice Period is Too Short it should be at-least 15 days!");
        }

        $facultyid = $_SESSION["user_id"];
        $username = $_SESSION["username"];

        $faculty_name = $this->db->viewdata("faculty_details", "faculty_name", "faculty_id='$facultyid'")[0]["faculty_name"];

        if ($_SESSION["user_role"] != "admin") {
            return $this->db->insert("resignation",
                array("faculty_id" => $facultyid, "faculty_name" => $faculty_name, "username" => $username, "applied_on" => $today,
                    "status" => "Pending", "resignation_date" => $date, "reason" => $reason, "notice_period" => $notice_period, "financial_year" => $financial_year));
        }
        return false;
    }

    public
    function ViewResignation()
    {
        $facultyid = $_SESSION["user_id"];
        if ($_SESSION["user_role"] != "admin") {
            return $this->db->viewdata("resignation", "", "faculty_id='$facultyid'");
        }
        return $this->db->viewdata("resignation");
    }
}