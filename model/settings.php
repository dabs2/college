<?php

namespace College\Ddcollege\Model;

use Exception;

class settings
{
    private database $db;
    private getusers $users;

    public function __construct()
    {
        $this->db = new database();
        $this->users = new getusers();
    }

    public function UpdateWhenIf($TabName, $exist = false, $Arr = array())
    {
        $user_id = $_SESSION["user_id"];
        foreach ($Arr as $key => $value) {
            if ($exist) {
                $this->db->update_database("settings", array("value" => $value), "user_id='$user_id' AND field_name='$key'");
            } else {
                $this->db->insert("settings",
                    array("user_id" => $user_id, "value" => $value, "tab_name" => $TabName, "field_name" => $key));
            }
        }
        return false;
    }

    public function CheckExistingSettings($TabName)
    {
        $user_id = $_SESSION["user_id"];
        return $this->db->viewdata("settings", "user_id,field_name,value", "tab_name='$TabName' AND user_id='$user_id'");
    }

    /**
     * @throws Exception
     */
    public function CheckUserName($input_user)
    {
        $user_id = $_SESSION["user_id"];
        $user_name = $this->db->viewdata("users", "username", "user_id='$user_id'")[0];
        if ($user_name["username"] != $input_user) {
            throw new Exception("Once a username has been allocated to your account, it is permanent and cannot be changed.");
        }
    }

    public function ViewSettings()
    {
        $user_id = $_SESSION["user_id"];
        return $this->db->viewdata("settings", "", "user_id='$user_id'");
    }

    public function InsertRegisterDetailsInSettings($full_name, $email, $phone_number, $dob, $address1, $address2)
    {
        $faculty_ids = $this->db->viewdata("faculty_details", "faculty_id", "faculty_email='$email'");

        if (!empty($faculty_ids)) {
            $faculty_id = $faculty_ids[0]["faculty_id"];
            $username = $this->users->get_username($faculty_id);

            $data = array(
                "full-name" => $full_name,
                "user-name" => $username,
                "email" => $email,
                "phone-number" => $phone_number,
                "dob" => $dob,
                "address-1" => $address1,
                "address-2" => $address2
            );

            foreach ($data as $key => $value) {
                $this->db->insert("settings", array("field_name" => $key, "tab_name" => "Personal", "value" => $value, "user_id" => $faculty_id));
            }
        }
    }

    public function CheckExistingFacultyDetails($key)
    {
        $user_id = $_SESSION['user_id'];
        $data = $this->db->viewdata("faculty_details",
            "faculty_name,faculty_email,phone,dob,address1,address2", "faculty_id='$user_id'")[0];

        return match ($key) {
            "full-name" => array('faculty_name' => $data['faculty_name']),
            "email" => array('faculty_email' => $data['faculty_email']),
            "phone-number" => array('phone' => $data['phone']),
            "dob" => array('dob' => $data['dob']),
            "address-1" => array('address1' => $data['address1']),
            "address-2" => array('address2' => $data['address2']),
            default => 'N/A'
        };
    }

    public
    function EditedInsertSettings($UserArr = array())
    {
        $user_id = $_SESSION['user_id'];
        $boolean = false;
        foreach ($UserArr as $key => $value) {
            if ($key == 'phone-number' && isset($value) && $_SESSION['user_role'] == "admin") {
                $this->db->update_database("settings",
                    array("value" => $value), "field_name='$key' AND user_id='$user_id'");
                $this->db->update_database("users",
                    array("admin_phn_no" => $value), "user_id='$user_id'");
            } elseif ($key && isset($value) && $_SESSION['user_role'] != "admin") {
                $this->db->update_database("settings",
                    array("value" => $value), "user_id='$user_id' AND field_name='$key'");
                if (is_array($this->CheckExistingFacultyDetails($key))) {
                    foreach ($this->CheckExistingFacultyDetails($key) as $keys => $values) {
                        if ($value != $this->CheckExistingFacultyDetails($key)[$keys]) {
                            $this->db->update_database("faculty_details",
                                array($keys => $value), "faculty_id='$user_id'");
                            $this->db->update_database("leaves",
                                array($keys => $value), "faculty_id='$user_id'");
                        }
                    }
                }
            }
            $boolean = true;
        }
        if ($boolean) {
            return true;
        }
        return false;
    }
    //UPDATE faculty_details f1
    //JOIN leaves l2 ON f1.faculty_id = l2.faculty_id
    //SET f1.faculty_name = 'array($keys => $value)',
    //    l2.faculty_name = 'array($keys => $value)'
    //WHERE f1.faculty_id = '$user_id';
}