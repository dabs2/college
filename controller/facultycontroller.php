<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\helper;
use College\Ddcollege\Model\adduser;
use College\Ddcollege\Model\database;
use College\Ddcollege\Model\getusers;
use College\Ddcollege\Model\leave;
use Exception;


class facultycontroller
{
    private $adduser;
    private database $selfdataresult;
    private getusers $user;
    private $leave;

    public function __construct()
    {
        $this->selfdataresult = new database();
        $this->user = new getusers();
        $this->adduser = new adduser();
        $this->leave = new leavecontroller();
    }

    public function selfdata($username)
    {
        $datarequest = $this->selfdataresult->viewdata("users", "", "username = '$username'");
        if ($datarequest[0]["user_role"] == "faculty") {
            return $datarequest;
        } else {
            return false;
        }
    }

    public function addemployee(
        $name, $email, $dob, $phone_no, $gender, $designation, $department, $type, $joining_date,
        $aadhar, $address1, $address2, $city, $pincode, $state, $end_date
    )
    {
        //$errorMessage = '';
        try {
            if (empty($end_date)) {
                $end_date = null;
            }
            if (empty($address2)) {
                $address2 = null;
            }

            $startYear = date("Y");
            $endYear = date("Y", strtotime("+1 year"));

            if (!$this->user->getusersdata($name)) {

                $username = $name . "_" . mt_rand(100, 999);
                $password = "123";


                $this->adduser = $this->adduser->adduser($username, $password, $department);
                //user_id required for the view
            }

            $user_id = $this->user->getuser_id($username);

//            if (!(new leaverequests())->is_username_leavedata_exists($username)) {
//                (new leaverequests())->set_default_leave($user_id, $name, $username);
//            }

// has to be closed for the first time for the employee that already exist in the company but the joining month , year and date can be any
// so it has to be closed for the first time...

            $currentMonth_joined = date("n", strtotime($joining_date));
//            $current_session = (new holidays())->getfinanicialyear(date("Y-m-d"));
//            $startMonth = 4;
//            //why to pass current session and how?
//            $joining_session = (new holidays())->getfinanicialyear($joining_date);

//function has to checked first right now it's auto complete

            if ($this->selfdataresult->insert('faculty_details', array(
                'faculty_id' => $user_id,
                'faculty_name' => $name,
                'faculty_email' => $email,
                'dob' => $dob,
                'phone' => $phone_no,
                'gender' => $gender,
                'designation' => $designation,
                'department' => $department,
                'faculty_type' => $type,
                'joining' => $joining_date,
                'aadhar' => $aadhar,
                'address1' => $address1,
                'address2' => $address2,
                'city' => $city,
                'pincode' => $pincode,
                'state' => $state,
                'end_date' => $end_date
            ))) {
                $this->leave->insert_leave_stats($user_id, $name, $username);
//                if ($currentMonth_joined > $startMonth && $current_session == $joining_session) {
//                    (new report_controller())->generate_between_data($startYear, $endYear, $user_id, $currentMonth_joined);
//
//                } elseif ($currentMonth_joined == $startMonth) {
//                    (new report_controller())->auto_generate_data($startYear, $endYear, $user_id);
//
//                }
                return array('success' => true);
            }
        } catch
        (Exception $e) {
            // Catching generic exception, but not displaying the notification here
            return array('success' => false, 'error' => $e->getMessage());
        }

        return array('success' => false, 'error' => 'Error adding Details There might be some duplicate entries');

    }

    public function view_manage_employees()
    {
        if ($_SESSION["user_role"] == "admin") {
            return $this->selfdataresult->viewdata("faculty_details",
                "faculty_id,faculty_name,faculty_email,department,phone,gender,joining");
        }
        return false;
    }

    //used in js
    public function view_faculty_profile($id)
    {
        $leave_stats = $this->leave->return_leave_stats($id);
        $details_faculty = $this->selfdataresult->viewdata("faculty_details",
            "faculty_id,faculty_name,faculty_email,department,aadhar,faculty_type,address2,city,state,pincode,end_date,address1,designation,phone,gender,joining", "faculty_id='$id'");
        if (!empty($leave_stats) && !empty($details_faculty)) {
            return array_merge($details_faculty, $leave_stats);
        }
    }

    public function view_faculty_detail_popup()
    {
        ?>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="viewfaculty"
             aria-labelledby="viewfaculty" style="width: 1100px;">
            <div class="offcanvas-header bg-light">
                <h5 class="offcanvas-title text-white text-lg-start badge bg-primary rounded-pill ucap"
                    id="faculty_name_title"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body bg-light">

                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-lg-4 col-xl-4 col-xxl-3">
                                <div class="card card-bordered">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="user-card user-card-s2">
                                                <div class="user-avatar lg bg-primary">
                                                    <img src="./images/avatar/b-sm.jpg" alt="">
                                                </div>
                                                <div class="user-info">
                                                    <div class="badge bg-light rounded-pill ucap">DD College</div>
                                                    <h5 id="faculty_name"></h5>
                                                    <span class="sub-text" id="faculty_email"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner card-inner-sm">
                                            <ul class="btn-toolbar justify-center gx-1">
                                                <li><a href="#" class="btn btn-trigger btn-icon"><em
                                                                class="icon ni ni-shield-off"></em></a></li>
                                                <li><a href="#" class="btn btn-trigger btn-icon"><em
                                                                class="icon ni ni-mail"></em></a></li>
                                                <li><a href="#" class="btn btn-trigger btn-icon"><em
                                                                class="icon ni ni-bookmark"></em></a></li>
                                                <li><a href="#" class="btn btn-trigger btn-icon text-danger"><em
                                                                class="icon ni ni-na"></em></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-inner">
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="profile-stats">
                                                        <span class="amount" id="total_leaves"></span>
                                                        <span class="sub-text">Total Leaves</span>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="profile-stats">
                                                        <span class="amount" id="leaves_taken"></span>
                                                        <span class="sub-text">Leaves Taken</span>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="profile-stats">
                                                        <span class="amount" id="leaves_remaining"></span>
                                                        <span class="sub-text">Leaves Left</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                            <h6 class="overline-title mb-2">Short Details</h6>
                                            <div class="row g-3">
                                                <div class="col-sm-6 col-md-4 col-lg-12">
                                                    <span class="sub-text">User ID:</span>
                                                    <span id="faculty_id"></span>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-12">
                                                    <span class="sub-text">Designation</span>
                                                    <span id="designation"></span>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-12">
                                                    <span class="sub-text">Type:</span>
                                                    <span id="faculty_type"></span>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-12">
                                                    <span class="sub-text">Aadhar:</span>
                                                    <span id="aadhar"
                                                          class="lead-text text-success"></span>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-12">
                                                    <span class="sub-text">Resigned On:</span>
                                                    <span id="end_date"></span>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div>
                                </div>
                            </div><!-- .col -->
                            <div class="col-lg-8 col-xl-8 col-xxl-9">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="nk-block">
                                            <div class="overline-title-alt mb-2 mt-2">In Account</div>
                                            <div class="profile-balance">
                                                <div class="profile-balance-group gx-4">
                                                    <div class="profile-balance-sub">
                                                        <div class="profile-balance-amount">
                                                            <div class="number">32,237.89 <small
                                                                        class="currency currency-usd">₹</small></div>
                                                        </div>
                                                        <div class="profile-balance-subtitle">Salary</div>
                                                    </div>
                                                    <div class="profile-balance-sub">
                                                        <span class="profile-balance-plus text-soft"><em
                                                                    class="icon ni ni-plus"></em></span>
                                                        <div class="profile-balance-amount">
                                                            <div class="number">1,643</div>
                                                        </div>
                                                        <div class="profile-balance-subtitle">Credit Points</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block">
                                            <h6 class="lead-text mb-3">Other Details</h6>
                                            <div class="row g-3">
                                                <div class="col-xl-12 col-xxl-6">
                                                </div><!-- .col -->
                                                <div class="col-xl-12 col-xxl-6">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                                                        <h6 class="sub-text">Address :</h6>
                                                                        <span id="address1"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-xl-12 col-xxl-6">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                                                        <h6 class="sub-text">Address 2 :</h6>
                                                                        <span id="address2"></span>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-xl-12 col-xxl-6">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                                                        <h6 class="sub-text">State :</h6>
                                                                        <span id="state"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-xl-12 col-xxl-6">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                                                        <h6 class="sub-text">City :</h6>
                                                                        <span id="city"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-xl-12 col-xxl-6">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                                                        <h6 class="sub-text">Pincode :</h6>
                                                                        <span id="pincode"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-xl-12 col-xxl-6">
                                                    <div class="card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                                                        <h6 class="sub-text">Contact :</h6>
                                                                        <span id="phone"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .col -->
                                            </div><!-- .row -->
                                        </div>

                                    </div><!-- .card-inner -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                </div>

            </div>
        </div>
        <?php
    }
}