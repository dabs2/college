<?php
require __DIR__ . '/../vendor/autoload.php';

$component = new \College\Ddcollege\Controller\viewcontroller();
$addfaculty = new \College\Ddcollege\Controller\facultycontroller();
$db = new \College\Ddcollege\Model\database();
$settingscontroller = new \College\Ddcollege\Controller\settingcontroller();
$notify = new \College\Ddcollege\Controller\notificationcontroller();
?>
<!doctype html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">

<?= $component->script("Register") ?>
<body>
<!-- Layout wrapper -->

<!-- Menu -->
<!-- Layout container -->
<?= $component->rendersidebar() ?>

<div class="nk-wrap ">

    <?= $component->topbar() ?>


    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">

                        <div class="nk-block nk-block-lg">

                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="title nk-block-title">Register</h4>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview">
                                <form method="post" action="#">
                                    <div class="card-inner">
                                        <div class="preview-block">
                                            <span class="preview-title-lg overline-title">Faculty Info</span>
                                            <div class="row gy-4">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-01">Name</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="faculty_name" class="form-control"
                                                                   id="default-01"
                                                                   placeholder="Faculty Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-05">Email</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni ni-mail"></em>
                                                            </div>
                                                            <div class="form-text-hint">
                                                                <!--                                                            <span class="overline-title">Usd</span>-->
                                                            </div>
                                                            <input type="text" name="email" class="form-control"
                                                                   id="default-05"
                                                                   placeholder="example@gmail.com" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-03">Date of Birth</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-user"></em>
                                                            </div>
                                                            <input type="date" name="dob" class="form-control"
                                                                   id="default-03" placeholder="DOB" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label" for="default-04">Phone Number</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="number" class="form-control"
                                                                   id="phone_number"
                                                                   placeholder="+91-999999999" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function () {
                                                        new Jsfunctions().validate_number();
                                                    });
                                                </script>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-06">Faculty Type</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-select">
                                                                <select class="form-control" id="default-06"
                                                                        name="faculty_type" required>
                                                                    <option value="Probation">Probation</option>
                                                                    <option value="Permanent">Permanent
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-04">Joining</label>
                                                        <div class="form-control-wrap">
                                                            <input type="date" name="joining" class="form-control"
                                                                   id="default-04" placeholder="Joining Date" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-06">Gender</label>
                                                        <div class="form-control-wrap ">
                                                            <div class="form-control-select">
                                                                <select class="form-control" name="gender"
                                                                        id="default-06"
                                                                        required>
                                                                    <option value="">Select</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-06">Designation</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-select">
                                                                <select class="form-control" id="default-06"
                                                                        name="designation" required>
                                                                    <option value="">Select</option>
                                                                    <option value="TGT">TGT</option>
                                                                    <option value="Senior Accountant">Senior
                                                                        Accountant
                                                                    </option>
                                                                    <option value="Junior Accountant">Junior
                                                                        Accountant
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-07">Department</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-select-multiple">
                                                                <select class="form-select" id="default-07"
                                                                        name="department" required>
                                                                    <option value="Faculty">Faculty</option>
                                                                    <option value="Manager">Manager</option>
                                                                    <option value="Accountant">Accountant</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <hr class="preview-hr">
                                            <span class="preview-title-lg overline-title">Personal Info</span>
                                            <div class="row gy-4">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-1-01">Aadhaar</label>
                                                        <input type="text" name="aadhaar" class="form-control focus"
                                                               id="default-1-01"
                                                               placeholder="XXXX-XXXX-XXXX" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-1-02">Address</label>
                                                        <input type="text" name="address" class="form-control"
                                                               id="default-1-02"
                                                               placeholder="Address" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="default-1-04">Address 2</label>
                                                        <input type="text" name="address2" class="form-control error"
                                                               id="default-1-04"
                                                               placeholder="Address">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="state">State</label>
                                                        <select name="state" id="state" class="form-control" required>
                                                            <option value="">Select State</option>
                                                            <option value="Andaman and Nicobar Islands">Andaman and
                                                                Nicobar
                                                                Islands
                                                            </option>
                                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                            <option value="Assam">Assam</option>
                                                            <option value="Bihar">Bihar</option>
                                                            <option value="Chandigarh">Chandigarh</option>
                                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                                            <option value="Dadra and Nagar Haveli">Dadra and Nagar
                                                                Haveli
                                                            </option>
                                                            <option value="Daman and Diu">Daman and Diu</option>
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Goa">Goa</option>
                                                            <option value="Gujarat">Gujarat</option>
                                                            <option value="Haryana">Haryana</option>
                                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                            <option value="Jharkhand">Jharkhand</option>
                                                            <option value="Karnataka">Karnataka</option>
                                                            <option value="Kerala">Kerala</option>
                                                            <option value="Ladakh">Ladakh</option>
                                                            <option value="Lakshadweep">Lakshadweep</option>
                                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                            <option value="Maharashtra">Maharashtra</option>
                                                            <option value="Manipur">Manipur</option>
                                                            <option value="Meghalaya">Meghalaya</option>
                                                            <option value="Mizoram">Mizoram</option>
                                                            <option value="Nagaland">Nagaland</option>
                                                            <option value="Odisha">Odisha</option>
                                                            <option value="Puducherry">Puducherry</option>
                                                            <option value="Punjab">Punjab</option>
                                                            <option value="Rajasthan">Rajasthan</option>
                                                            <option value="Sikkim">Sikkim</option>
                                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                                            <option value="Telangana">Telangana</option>
                                                            <option value="Tripura">Tripura</option>
                                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                            <option value="Uttarakhand">Uttarakhand</option>
                                                            <option value="West Bengal">West Bengal</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="city-dropdown">City</label>
                                                        <select class="form-control" id="city-dropdown" name="city"
                                                                required>
                                                            <option value="Dehradun">Dehradun</option>
                                                            <option value="Mumbai">Mumbai</option>
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Bangalore">Bangalore</option>
                                                            <option value="Hyderabad">Hyderabad</option>
                                                            <option value="Chennai">Chennai</option>
                                                            <option value="Kolkata">Kolkata</option>
                                                            <option value="Pune">Pune</option>
                                                            <option value="Ahmedabad">Ahmedabad</option>
                                                            <option value="Jaipur">Jaipur</option>
                                                            <option value="Surat">Surat</option>
                                                            <!-- Add more cities here -->
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label" for="default-1-02">Pincode</label>
                                                        <input type="text" name="pincode" class="form-control"
                                                               id="default-1-02" placeholder="pincode" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-primary">Submit
                                                    </button>
                                                </div>
                                </form>
                            </div>
                            <hr class="preview-hr">
                            <!--                            <div class="row gy-4 align-center">-->
                            <!--                                <div class="col-12">-->
                            <!--                                    <p class="text-soft">Use <code>.form-control-lg</code> or-->
                            <!--                                        <code>.form-control-sm</code>-->
                            <!--                                        with <code>.form-control</code> for large or small input box.-->
                            <!--                                    </p>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                    </div>
                </div><!-- .card-preview -->


            </div> <!-- nk-block -->
        </div>
    </div>
</div>
<?= $component->OtherJavaScript() ?>
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['faculty_name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $phone_no = $_POST['number'];
    $gender = $_POST['gender'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $type = $_POST['faculty_type'];
    $joining_date = $_POST['joining'];
    $aadhar = $_POST['aadhaar'];
    $address1 = $_POST['address'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    if ($addfaculty->addemployee($name, $email, $dob, $phone_no, $gender,
        $designation, $department, $type, $joining_date, $aadhar, $address1, $address2, $city, $pincode, $state, "")) {
        $settingscontroller->insert_settings_default($name, $email, $phone_no, $dob, $address1, $address2);
        $notify->ThrowSuccessNotification("Created a new account for the user!", "Success Creating Account");
    }
}
?>
</body>
</html>
