<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Model\attendance;
use College\Ddcollege\Model\database;
use College\Ddcollege\Model\getusers;
use Exception;

class Logincontroller
{
    private getusers $users;
    private database $db;
    private notificationcontroller $notification;
    private attendancecontroller $attendance;        //controller attendance


    public function __construct()
    {
        $this->users = new getusers();
        //controller attendance
        $this->attendance = new attendancecontroller();
        $this->notification = new notificationcontroller();
        $this->db = new database();

    }

    public function login($username, $password)
    {
        $username = $this->users->getusersdata($username);
        $password = password_verify($password, $username[0]['password']);
        if ($username && $password) {
            // Authentication successful, set session and redirect to home page

            $_SESSION['username'] = $username[0]['username'];
            $_SESSION['user_id'] = $username[0]['user_id'];
            $_SESSION['user_role'] = $username[0]['user_role'];
//            if ($this->CheckUserResigned()) {
//                $this->notification->ThrowErrorNotification("Login has been disabled! Please contact to Administrator for more details.", "Failed To Login");
//                session_unset();
//                session_destroy();
//                // Redirect to login page
//                return;
//            }
            if ($this->attendance->insert_attendance()) {
                $this->attendance->latearrivals();
            }
            header("Location: /");
            exit();
        } else {
            // Authentication failed, you might want to set an error message here
            echo "Invalid username or password";
        }
    }

    /**
     * @throws Exception
     */
    public function logout()
    {
        $this->attendance->calculatelogout();
        // Destroy session variables
        session_unset();
        session_destroy();
        // Redirect to login page
        header("Location: ../login");
        exit();
    }

    public function CheckUserResigned()
    {
        $faculty_id = $_SESSION["user_id"];
        $date = date("Y-m-d");
        $is_user_resigned = $this->db->viewdata("users", "status,resigned_date", "user_id='$faculty_id'")[0];
        if ($is_user_resigned["status"] === "Resigned" && $is_user_resigned["resigned_date"] <= $date) {
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    protected function CheckDefaultPassword($currentpassword)
    {
        $user_id = $_SESSION["user_id"];
        $defaultpassword = $this->db->viewdata("users", "password", "user_id='$user_id'")[0];
        $passwordverify = password_verify($currentpassword, $defaultpassword["password"]);
        if ($defaultpassword['password'] != $passwordverify) {
            throw new Exception("The default password does not match the current password. 
            Please ensure you have entered the correct default password.");
        }
    }

    /**
     * @throws Exception
     */
    protected function CheckConfirmPassword($newpassword, $confirmpassword)
    {
        if ($newpassword != $confirmpassword) {
            throw new Exception("Please ensure entering the correct password.");
        }
    }

    /**
     * @throws Exception
     */
    protected function SetNewPassword($currentpassword, $newpassword, $confirmpassword)
    {
        try {
            $user_id = $_SESSION["user_id"];
            $this->CheckConfirmPassword($newpassword, $confirmpassword);
            $this->CheckDefaultPassword($currentpassword);
            if ($newpassword == $confirmpassword) {
                $hashed_password = password_hash($confirmpassword, PASSWORD_DEFAULT);
                if ($this->db->update_database("users", array('password' => $hashed_password), "user_id='$user_id'")) {
                    $this->notification->ThrowSuccessNotification("Change Password Successfully", "Password Change!");
                }
            }
        } catch (Exception $e) {
            $this->notification->ThrowErrorNotification($e->getMessage(), "Error Password");
        }
    }

    /**
     * @throws Exception
     */
    public function ChangePasswordForm()
    {
        ?>
        <div class="modal fade" id="changePassword">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Current Password</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="current-password"
                                           id="current-password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email-address">New Password</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="new-password" id="new-password"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone-no">Confirm Password</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="confirm-password"
                                           id="confirm-password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit-password-new" class="btn btn-lg btn-primary">Change
                                    Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['submit-password-new'])) {
            $currentpass = $_POST['current-password'];
            $newpass = $_POST['new-password'];
            $confirmpass = $_POST['confirm-password'];
            $this->SetNewPassword($currentpass, $newpass, $confirmpass);
        }
    }
}


