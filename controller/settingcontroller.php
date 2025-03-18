<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Model\database;
use College\Ddcollege\Model\settings;
use Exception;

class settingcontroller
{
    private database $db;
    private settings $setting;

    public function __construct()
    {
        $this->db = new database();
        $this->setting = new settings();
    }

    public function updatesetting($tabname, $postarr = array())
    {
        try {
            $this->setting->EditedInsertSettings($postarr);
            $existingsetting = $this->setting->CheckExistingSettings($tabname);
            $updatearr = array();
            if ($existingsetting) {
                foreach ($existingsetting as $previous_key) {//database
                    foreach ($postarr as $key => $value) { //postarray
                        if ($previous_key["field_name"] == $key) {
                            if ($value == $previous_key["value"]) {
                                unset($postarr[$key]);
                                continue;
                            }
                            if ($value != $previous_key["value"]) {
                                if ($key == 'user-name') {
                                    $this->setting->CheckUserName($value);

                                }
                                $updatearr[$key] = $value;
                                unset($postarr[$key]);
                            }
                        }
                    }
                }
            }
            if (!empty($postarr)) {
                $this->setting->UpdateWhenIf($tabname, false, $postarr);
            }

            if (!empty($updatearr)) {
                $this->setting->UpdateWhenIf($tabname, true, $updatearr);
            }
            return true;
        } catch
        (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function viewsettings()
    {
        return $this->setting->ViewSettings();
    }

    public function insert_settings_default($full_name, $email, $phone_number, $dob, $address1, $address2)
    {
        $this->setting->InsertRegisterDetailsInSettings($full_name, $email, $phone_number, $dob, $address1, $address2);
    }

    public function buttonforedit()
    {
        ?>
        <button class="btn btn-primary" data-bs-toggle="modal"
                onclick="new Jsfunctions().get_settings()"
                data-bs-target="#profile-edit" xmlns="http://www.w3.org/1999/html"> Edit
        </button>
        <?php

    }

    public function update_profile_popup()
    {
        ?>
        <div class="modal fade" role="dialog" id="profile-edit">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-lg">
                        <h5 class="title">Update Profile</h5>
                        <ul class="nk-nav nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal</a>
                            </li>
                            <?php
                            if ($_SESSION["user_role"] != "admin") {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#address">Address</a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul><!-- .nav-tabs -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal">
                                <form method="post" id="personal-form-settings">
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="full-name">Full Name</label>
                                                <input type="text" name="full-name" class="form-control form-control-lg"
                                                       id="popup-setting-full-name"
                                                       placeholder="Enter Full name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="display-name">User Name</label>
                                                <input type="text" name="user-name"
                                                       class="form-control form-control-lg"
                                                       id="popup-setting-user-name"
                                                       placeholder="Enter display name" readonly>
                                            </div>
                                        </div>

                                        <?php
                                        if ($_SESSION["user_role"] != "admin") {
                                            ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="display-name">Email</label>
                                                    <input type="text" name="email" class="form-control form-control-lg"
                                                           id="popup-setting-email"
                                                           placeholder="Enter Email">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone-no">Phone Number</label>
                                                <input type="text" name="phone-number"
                                                       class="form-control form-control-lg"
                                                       id="popup-setting-phone-no"
                                                       placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <?php
                                        if ($_SESSION["user_role"] != "admin") {
                                            ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="birth-day">Date of Birth</label>
                                                    <input type="text" name="dob"
                                                           class="form-control form-control-lg date-picker"
                                                           placeholder="Enter your birth date" id="popup-setting-dob">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-lg btn-primary"
                                                            id="update-profile"
                                                            name="update-profile"
                                                            onclick="new Jsfunctions().update_setting('personal-form-settings')">
                                                        Update
                                                        Profile
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="#" data-bs-dismiss="modal"
                                                       class="link link-light">Cancel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- .tab-pane -->

                            <div class="tab-pane" id="address">
                                <form method="post" id="address-form">
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address-l1">Address Line 1</label>
                                                <input type="text" name="address-1" class="form-control form-control-lg"
                                                       id="popup-setting-address-l1" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address-l2">Address Line 2</label>
                                                <input type="text" name="address-2" class="form-control form-control-lg"
                                                       id="popup-setting-address-l2" required>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" name="update-address"
                                                            class="btn btn-lg btn-primary"
                                                            onclick="new Jsfunctions().update_setting('address-form')">
                                                        Update
                                                        Address
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="#" data-bs-dismiss="modal"
                                                       class="link link-light">Cancel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- .tab-pane -->
                        </div><!-- .tab-content -->
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div><!-- .modal -->
        <?php
    }
}