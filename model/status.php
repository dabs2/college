<?php

namespace College\Ddcollege\Model;
class status
{
    public function get_status($status)
    {
        $green = '<span class="badge border bg-success bg-opacity-10 text-success">Approved</span>';
        $present = '<span class="badge border bg-success bg-opacity-10 text-success">Present</span>';
        $red = '<span class="badge border bg-danger bg-opacity-10 text-danger">Rejected</span>';
        $absent = '<span class="badge border bg-danger bg-opacity-10 text-danger">Absent</span>';
        $orange = '<span class="badge border bg-warning bg-opacity-10 text-warning">Pending</span>';
        $missed = '<span class="badge border bg-purple bg-opacity-10 text-purple">Missed</span>';
        $onleave = '<span class="badge border bg-purple bg-opacity-10 text-purple">On Leave</span>';
        $holiday = '<span class="badge border bg-purple bg-opacity-10 text-purple">Holiday</span>';
        $sunday = '<span class="badge border bg-purple bg-opacity-10 text-danger">Sunday</span>';
        $adjusted = '<span class="badge border bg-info bg-opacity-10 text-indigo">Adjusted</span>';
        $cancelled = '<span class="badge border bg-info bg-opacity-10 text-danger">Cancelled</span>';
        $active = '<span class="badge border bg-success bg-opacity-10 text-success">Active</span>';
        $in_active = '<span class="badge border bg-indigo bg-opacity-10 text-white">In Active</span>';
        $in_process = '<span class="badge border bg-success bg-opacity-10 text-success">In Process</span>';
        $completed = '<span class="badge border bg-success bg-opacity-10 text-success">Completed</span>';
        $Resigned = '<span class="badge border bg-warning bg-opacity-10 text-danger">Resigned</span>';


        return match ($status) {
            "Approved" => $green,
            "Present" => $present,
            "Rejected" => $red,
            "Absent" => $absent,
            "Pending" => $orange,
            "Missed" => $missed,
            "On Leave" => $onleave,
            "Holiday" => $holiday,
            "Sunday" => $sunday,
            "Adjusted" => $adjusted,
            "Cancelled" => $cancelled,
            "In Process" => $in_process,
            "Active" => $active,
            "In Active" => $in_active,
            "Completed" => $completed,
            "Resigned" => $Resigned,
            default => "N/A",
        };
    }

    public function get_other_status($status)
    {
        $low = '<span class="badge bg-success bg-opacity-30 text-white">Low</span>';
        $moderate = '<span class="badge bg-warning bg-opacity-30 text-white">Moderate</span>';
        $high = '<span class="badge bg-danger bg-opacity-30 text-white">Critical</span>';
        $emergency = '<span class="badge bg-danger bg-opacity-30 text-white">Emergency Halfday</span>';
        $halfday = '<span class="badge bg-danger bg-opacity-30 text-white">Halfday</span>';


        return match ($status) {
            "Low" => $low,
            "Moderate" => $moderate,
            "Critical" => $high,
            "Emergency Halfday" => $emergency,
            "Halfday" => $halfday,
            default => "N/A",
        };
    }

    public function get_repair_status($status)
    {
        $green = '<span class="badge bg-success border bg-opacity-10 text-success">Resolved</span>';
        $InProgress = '<span class="badge bg-success border bg-opacity-10 text-info">In-Progress</span>';
        $Rejected = '<span class="badge bg-danger border bg-opacity-20 text-danger">Rejected</span>';
        $orange = '<span class="badge bg-info border bg-opacity-20 text-black">Unresolved</span>';

        return match ($status) {
            "Resolved" => $green,
            "In-Progress" => $InProgress,
            "Rejected" => $Rejected,
            default => $orange
        };
    }
}



