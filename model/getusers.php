<?php

namespace College\Ddcollege\Model;
class getusers
{
    private database $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function getusersdata($username)
    {
        $userdata = $this->database->viewdata("users", "", "username = '$username'");
        return $userdata;
    }

    public function getuser_id($username): int
    {
        $get_userid = $this->database->viewdata("users", "user_id", "username='$username'")[0]["user_id"];
        return intval($get_userid);
    }

    public function get_employee_names()
    {
        $employeenames = $this->database->viewdata("employee_details", "employee_name");
        asort($employeenames);
        return $employeenames;
    }

    public function changepassword($currentpassword, $newpassword, $confirmpassword, $otp)
    {
        $username = $_SESSION["username"];

        $sp = $this->database->viewdata("users", "password", "username = '$username'");
        $passwordverify = password_verify($currentpassword, $sp[0]["password"]);
        $number = (new getusers())->get_phone_no();
        if ((new sms_controller())->check_otp($otp, $number)) {
            if ($passwordverify) {
                if ($newpassword == $confirmpassword) {
                    $hashedPassword = password_hash($confirmpassword, PASSWORD_BCRYPT);
                    return $this->database->update_database("users", array("password" => $hashedPassword),
                        "username = '$username'");
                }
            }
            return false;
        }
        return (new notificationcontroller())->throw_error_notification("Entered Wrong OTP. Try Again!");
    }

    public function get_employee_name($faculty_id)
    {
        return $this->database->viewdata("faculty_details", "faculty_name", "faculty_id= '$faculty_id'")[0]["faculty_name"];
    }

    public function fetch_employee_name()
    {
        $session = $_SESSION["username"];
        $faculty_id = (new getusers())->getuser_id($session);
        if ($_SESSION["user_role"] != "admin") {
            return $this->database->viewdata("faculty_details", "faculty_name", "faculty_id='$faculty_id'")[0]["faculty_name"];
        }
        return "Administrator";
    }

    public function get_employee_id(): int
    {
        if ($_SESSION["user_role"] != "admin") {
            $username = $_SESSION["username"];
            return $this->getuser_id($username);
        }
        return false;
    }

    public function get_admin_id(): int
    {
        if ($_SESSION["user_role"] == "admin") {
            $username = $_SESSION["username"];
            return (new getusers())->getuser_id($username);
        }
        return false;
    }

    public function return_gender($employee_id)
    {
        return $this->database->viewdata("employee_details", "gender",
            "employee_id='$employee_id'")[0]["gender"];
    }

    public function get_username($employee_id)
    {
        return $this->database->viewdata("users", "username", "user_id='$employee_id'")[0]["username"];
    }

    public function get_phone_no()
    {
        $user_id = $_SESSION['user_id'];
        $employee_id = $this->get_employee_id();
        if ($employee_id) {
            return $this->database->viewdata("employee_details", "phone_number", "employee_id ='$employee_id'")[0]["phone_number"];
        } else {
            if ($_SESSION["user_role"] == "admin")
                return $this->database->viewdata("users", "admin_phn_no", "user_id ='$user_id'")[0]["admin_phn_no"];
        }
        return false;
    }
}