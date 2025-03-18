<?php

namespace College\Ddcollege\Model;

use College\Ddcollege\Components\helper;
use DateTime;
use Exception;

class attendance
{
    private database $db;
    private getusers $users;
    private helper $help;

    public function __construct()
    {
        $this->db = new database();
        $this->users = new getusers();
        $this->help = new helper();
    }

    public function HasPreviousLogin()
    {
        $date = date("Y-m-d");
        $faculty_id = $_SESSION["user_id"];
        $attendance_date = $this->db->viewdata("attendance", "attendance_date", "faculty_id='$faculty_id' AND attendance_date='$date'");
        if ($attendance_date && is_array($attendance_date)) {
            return true;
        }
        return false;
    }

    public function HasPreviousLogOut()
    {
        $date = date("Y-m-d");
        $faculty_id = $_SESSION["user_id"];
        $out_time = $this->db->viewdata("attendance", "out_time", "faculty_id='$faculty_id' AND attendance_date='$date'");
        if ($out_time && is_array($out_time) && isset($out_time[0]["out_time"])) {
            return true;
        }
        return false;
    }

    public function InsertAttendance()
    {
        if ($_SESSION["user_role"] != "admin") {
            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d");
            $financial_date = $date;
            $financial_year = $this->help->GetFinancialYear($financial_date);
            $date = date("Y-m-d H:i:s");
            $username = $_SESSION["username"];
            $faculty_id = $_SESSION["user_id"];
            $faculty_name = $this->users->get_employee_name($faculty_id);
            return $this->db->insert("attendance", array("faculty_id" => $faculty_id, "faculty_name" => $faculty_name, "shift_hours" => "8.00", "in_time" => $date
            , "status" => "Present", "attendance_date" => date("Y-m-d"), "username" => $username, "financial_year" => $financial_year));
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function LogoutOutTime()
    {
        if ($_SESSION['user_role'] != "admin") {
            date_default_timezone_set("Asia/Kolkata");
            $faculty_id = $_SESSION["user_id"];
            $current_Date = date("Y-m-d");
            $intime = $this->db->viewdata("attendance", "in_time", "attendance_date='$current_Date' AND faculty_id='$faculty_id'")[0]["in_time"];
            $outtime = date("Y-m-d H:i:s");
            $intime = new DateTime($intime);
            $outtime = new DateTime($outtime);
            $workhours = $intime->diff($outtime);
            $workhours = $workhours->format('%H' . '.' . '%i');
            $overtime = "0.00";
            if (floatval($workhours) > floatval("8.00")) {
                $overtime = $workhours - 8.00;
            }
            return $this->db->update_database("attendance", array("out_time" => date("Y-m-d H:i:s"), "work_hours" => $workhours, "overtime" => $overtime),
                "faculty_id='$faculty_id' AND attendance_date='$current_Date'");
        }
        return false;
    }

    public function ViewAttendance()
    {
        $faculty_id = $_SESSION["user_id"];
        if ($_SESSION["user_role"] != "admin") {
            return $this->db->viewdata("attendance", "", "faculty_id='$faculty_id'", "attendance_date DESC");
        }
        return $this->db->viewdata("attendance", "", "", "attendance_date DESC");
    }

    /**
     * @throws Exception
     */
    public function CheckLateArrivals()
    {
        if ($_SESSION["user_role"] != "admin") {
            $date = date("Y-m-d");
            $financial_year = $this->help->GetFinancialYear($date);
            $faculty_id = $_SESSION["user_id"];
            $in_time = $this->db->viewdata("attendance", "in_time,faculty_name",
                "attendance_date='$date' AND faculty_id='$faculty_id' AND financial_year='$financial_year'")[0];
            $late_arrivals = $this->db->viewdata("late_arrivals",
                "attendance_date", "attendance_date='$date' AND faculty_id = '$faculty_id' AND financial_year='$financial_year'");

            $faculty_timing = new DateTime($in_time["in_time"]);
            $Intime_format = $faculty_timing->format("H:i");

            $college_timing = new DateTime('8:00');
            $college_timing_Format = $college_timing->format("H:i");

            if ($Intime_format > $college_timing_Format) {
                if (!$late_arrivals) {
                    $time_diff_delay = $faculty_timing->diff($college_timing);
                    $hours = $time_diff_delay->h;
                    $minutes = $time_diff_delay->i;
                    $delay_time = $hours . ":" . $minutes;

                    $this->db->insert("late_arrivals",
                        array("faculty_name" => $in_time["faculty_name"],
                            "faculty_id" => $faculty_id,
                            "attendance_date" => $date,
                            "in_time" => $in_time["in_time"],
                            "delay" => $delay_time,
                            "financial_year" => $financial_year));

                    return true;
                }
            }
        }
        return false;
    }

    public
    function ViewLateArrivals()
    {
        $date = date("Y-m-d");
        $financial_year = $this->help->GetFinancialYear($date);
        $faculty_id = $_SESSION["user_id"];
        if ($_SESSION["user_role"] != "admin") {
            return $this->db->viewdata("late_arrivals", "faculty_name,in_time,delay", "faculty_id='$faculty_id' AND attendance_date = '$date' AND financial_year='$financial_year'");
        }
        return $this->db->viewdata("late_arrivals", "faculty_name,in_time,delay", "attendance_date = '$date' AND financial_year='$financial_year'");

    }
}
