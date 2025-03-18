<?php

namespace College\Ddcollege\Components;


use College\Ddcollege\Model\database;

class helper
{
    private $help;

    public function __construct()
    {
        $this->help = new database();
    }

    public function HumanDateFormat($date)
    {
        $date = strtotime($date);
        $newdate = date("d-m-Y", $date);
        return $newdate;
    }

    public function DataBaseDateFormat($date)
    {
        $date = strtotime($date);
        $newdate = date("Y-m-d", $date);
        return $newdate;
    }

    function GetFinancialYear($date)
    {
        // Convert date string to timestamp
        $timestamp = strtotime($date);

        // Get year from the timestamp
        $year = date('Y', $timestamp);

        // Check if the month is before April (start of financial year)
        if (date('n', $timestamp) < 4) {
            // If before April, return previous year followed by a slash and current year
            return ($year - 1) . '-' . $year;
        } else {
            // If after April, return current year followed by a slash and next year
            return $year . '-' . ($year + 1);
        }
    }
}
