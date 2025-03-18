<?php

namespace College\Ddcollege\Model;

class profile
{
    private $profile;

    public function __construct()
    {
        $this->profile = new database();
    }

    public function FacultyInfo($faculty_id)
    {
        $faculty_info = $this->profile->viewdata("employee_details", "employee_name,designation,employee_email,phone_number,dob,aadhar_no,gender,address1
        ,address2,city,pincode,state", "faculty_id='$faculty_id'");
        if (empty($faculty_info)) {
            return null;
        } else {
            return $faculty_info;
        }
    }
}