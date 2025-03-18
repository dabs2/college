<?php

namespace College\Ddcollege\Model;

use College\Ddcollege\Components\helper;
use DateTime;
use Exception;

class holiday
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
    public function InsertHoliday($holiday_name, $date, $type)
    {
        if ($_SESSION["user_role"] == "admin") {
            $financial_year = $this->help->GetFinancialYear($date);
            $day = new DateTime($date);
            $dayName = $day->format('l');
            return $this->db->insert("holidays",
                array("holiday_name" => $holiday_name, "date" => $date, "status" => "Active", "type" => $type, "day" => $dayName, "financial_year" => $financial_year));
        }
        return false;
    }

    public function ViewHoliday()
    {
        return $this->db->viewdata("holidays", "", "", "date DESC");
    }

    /**
     * @throws Exception
     */
    public function CheckInputHolidayEdit($holiday_id, $holiday_name, $date, $type)
    {
        $storearr = array();
        $holiday_edit = $this->db->viewdata("holidays", "holiday_name,date,type", "holiday_id='$holiday_id'")[0];

        if ($holiday_edit) {

            if ($holiday_edit["holiday_name"] != $holiday_name) {
                $storearr['holiday_name'] = $holiday_name;
            }
            if ($holiday_edit["date"] != $date) {
                $day = new DateTime($date);
                $dayName = $day->format('l');
                $new_date = $date;
                $financial_year = $this->help->GetFinancialYear($new_date);
                $storearr['date'] = $date;
                $storearr["financial_year"] = $financial_year;
                $storearr["day"] = $dayName;
            }
            if ($holiday_edit["type"] != $type) {
                $storearr['type'] = $type;
            }
        }

        return $storearr;
    }

    public function CheckStatus($holidaydate)
    {
        $date = date("Y-m-d");

        if ($holidaydate < $date) {
            return "In Active";
        }
        return "Active";

    }

}