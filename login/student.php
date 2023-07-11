<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUPSRC-OTMS - Student Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../bg.css">
    <script src="https://kit.fontawesome.com/fe96d845ef.js" crossorigin="anonymous"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../sign_up_dropdown.js"></script>
</head>
<body>
    <?php
    session_start();
    include "../conn.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentNo = $_POST['studentNumber'];
        $password = $_POST['password'];

        $query = "SELECT user_id, student_no, first_name, last_name, password FROM users WHERE student_no = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $studentNo);
        $stmt->execute();
        $stmt->bind_result($userId, $dbStudentNo, $dbFirstName, $dbLastName, $dbPassword);
        $stmt->fetch();

        if ($dbStudentNo && password_verify($password, $dbPassword)) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['student_no'] = $dbStudentNo;
            $_SESSION['first_name'] = $dbFirstName;
            $_SESSION['last_name'] = $dbLastName;
            $_SESSION['user_role'] = 1;
            header("Location: ../student/home.php");
            exit();
        } else {
                $loginMessage = "Invalid credentials. Please try again.";
            }
    
            $stmt->close();
            $connection->close();
        }

    ?>
    <div class="jumbotron bg-white d-flex">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center">
                    <img src="/assets/pup-logo.png" alt="PUP Logo" width="100">
                    <h2 class="fw-normal mt-2"><b>O</b>nline <b>T</b>ransaction <b>M</b>anagement <b>S</b>ystem</h2>
                    <p class="lead">Sign in as PUP student</p>

                    <form method="POST" class="d-flex flex-column gap-2" action="">
                        <div class="form-group col-12">
                            <input type="text" class="form-control" name="studentNumber" id="studentNumber" placeholder="Student Number" maxlength="15" required>
                        </div>
                        <div class="form-group col-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="8" maxlength="100" required>
                        </div>
                        <?php if (isset($loginMessage)) { ?>
                        <p style="color: #800000; font-weight: 600;"><?php echo $loginMessage; ?></p>
                        <?php } ?>
                        <div class="col-12">
                            Don't have an account yet? <a href="#" data-bs-toggle="modal" data-bs-target="#Register">Sign up</a>
                        </div>
                        <div class="col-12">
                            <a href="forgot_password.php">I forgot my password</a>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <p class="mb-0"><small>By using this service, you understood and agree to the PUPSRC-OTMS <a href="https://www.pup.edu.ph/terms" target="_blank">Terms of Use</a> and <a href="https://www.pup.edu.ph/privacy" target="_blank">Privacy Statement</a></small></p>
                        </div>
                        <div class="mb-3 d-flex w-100 justify-content-between p-1">
                            <a class="btn btn-outline-primary px-4" href="http://localhost/index.php">
                                <i class="fa-solid fa-arrow-left"></i> Back
                            </a>
                            <input id="submitBtn" value="Login" type="submit" class="btn btn-primary w-25" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up Modal -->
    <form action="../create_account.php" id="signupForm" method="POST">
        <div class="modal fade" id="Register" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true"> 
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">Create New Account</p> 
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                        <input type="hidden" class="form-control font-weigth-light" id="hfDepartment" name="hfDepartment">
                        <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 pt-1 pb-2">
                            <label><b>Personal Details</b></label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">  
                            <div class="row">
                                <div class="form-group">
                                    <label class="mb-0 pb-1">Student Number <code>*</code></label>
                                    <div class="input-group mb-0 mt-0">
                                        <input type="text" name="StudentNo" value="" id="StudentNo" placeholder="Student Number" pattern="\d{4}-\d{5}-SR-\d" maxlength="15" size="50" autocomplete="on" class="form-control" required>
                                    </div>
                                    <div id="studentNoValidationMessage" class="text-danger"></div>
                                </div>
                                <div class="form-group col-6">
                                    <label class="mb-0 pb-1">Last Name <code>*</code></label>
                                    <div class="input-group mb-0 mt-0">
                                        <input type="text" name="LName" value="" id="LName" placeholder="Last Name" pattern="[a-zA-Z0-9Ññ\_\-\'\ \.]*" maxlength="100" size="100" autocomplete="on" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label class="mb-0 pb-1">First Name <code>*</code></label>
                                    <div class="input-group mb-0 mt-0">
                                        <input type="text" name="FName" value="" id="FName" placeholder="First Name" pattern="[a-zA-Z0-9Ññ\_\-\'\ \.]*" maxlength="100" size="100" autocomplete="on" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label class="mb-0 pb-1">Middle Name</label>
                                    <div class="input-group mb-0">
                                        <input type="text" name="MName" value="" id="MName" placeholder="Middle Name" pattern="[a-zA-Z0-9Ññ\_\-\'\ \.]*" maxlength="100" size="100" autocomplete="on" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label class="mb-0 pb-1">Extension Name <font class="small">(Jr./Sr./III Etc..)</font></label>
                                    <div class="input-group mb-0">
                                        <input type="text" name="EName" value="" id="EName" placeholder="Extension Name" pattern="[a-zA-Z0-9Ññ\_\-\'\ \.]*" maxlength="11" size="11" autocomplete="on" class="form-control">
                                    </div>
                                </div>                           
                                </div>
                                <div class="row">
                                <div class="form-group col-12">
                                    <label>Contact Number <code>*</code></label>
                                    <div class="input-group mb-0">
                                        <input type="text" name="ContactNumber" value="" id="ContactNumber" placeholder="Eg. 0901-234-5678" pattern="^090\d{1}-\d{3}-\d{4}$" maxlength="13" size="20" autocomplete="on" class="form-control" required>
                                    </div>
                                    <div id="contactNoValidationMessage" class="text-danger"></div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Birthdate <code>*</code></label>
                                    <div data-target="#Birthday" data-toggle="datetimepicker">
                                        <input type="date" name="Birthday" id="Birthday" class="form-control datetimepicker-input" data-target="#Birthday" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="text-danger" id="birthdateError" style="display: none;">Invalid birth date.</div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Sex  <code>*</code></label><br>
                                    <div class="form-check">
                                    <label class="form-check-label col-3">
                                        <input class="form-check-input" type="radio" id="GenderM" name="Gender" value="1" checked=""> Male
                                    </label>
                                    <label class="form-check-label col-3 px-3">
                                        <input class="form-check-input" type="radio" id="GenderF" name="Gender" value="0"> Female
                                    </label>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Home Address <code>*</code></label>
                                    <div class="input-group mb-0">
                                        <input type="text" name="Address" value="" id="Address" placeholder="Address" minlength="2" maxlength="255" size="255" autocomplete="on" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Province <code>*</code></label>
                                    <div class="input-group mb-0">
                                        <select name="Province" id="Province" class="form-control form-select" required>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group col-6">
                                    <label>City <code>*</code></label>
                                    <div class="input-group mb-0">
                                        <select name="City" id="City" class="form-control form-select" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Barangay <code>*</code></label>
                                    <div class="input-group mb-0">
                                        <input type="text" name="Barangay" value="" id="Barangay" placeholder="Barangay" maxlength="100" size="100" autocomplete="on" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Zip Code</label>
                                    <div class="input-group mb-0">
                                        <input type="text" name="ZipCode" value="" id="ZipCode" placeholder="Zip Code" pattern="[0-9]{4,6}" maxlength="6" size="6" autocomplete="on" class="form-control">
                                    </div>
                                    <div id="zipCodeError" class="text-danger"></div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 pt-3 pb-2">
                                <label><b>Account Details</b></label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">  
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputEmail1">Email <code>*</code></label>
                                        <div class="input-group mb-0">
                                            <input type="text" name="Email" value="" id="Email" placeholder="Complete Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" minlength="11" maxlength="50" size="50" autocomplete="on" class="form-control" required>
                                        </div>
                                        <div class="text-danger" id="emailError" style="display: none;">Invalid email address.</div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleInputEmail1">Password <code>*</code></label>
                                        <div class="input-group mb-0">
                                        <input type="password" name="Password" value="" id="Password" placeholder="Password" minlength="8" maxlength="80" size="80" autocomplete="on" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleInputEmail1">Confirm Password <code>*</code></label>
                                        <div class="input-group mb-0">
                                        <input type="password" name="ConfirmPassword" value="" id="ConfirmPassword" placeholder="Retype Password" minlength="8" maxlength="80" size="80" autocomplete="on" class="form-control" required>
                                        </div>
                                    </div>
                                    <ul id="passwordChecklist"></ul>
                                    <div class="form-group mt-3">
                                        <div class="alert alert-info alert-dismissible text-xs" style="height: 90%">
                                            <h4>Data Privacy Notice</h4>
                                            <p>
                                            <img style="float: right; margin-left: 3px; filter: invert(100%);" src="//i.imgur.com/1fWC7sz.png" title="QR code">Thank you for providing your data at Polytechnic University of the Philippines (PUP). We respect and value your rights as a data subject under the Data Privacy Act (DPA). PUP is committed to protecting the personal data you provide in accordance with the requirements under the DPA and its IRR. In this regard, PUP implements reasonable and appropriate security measures to maintain the confidentiality, integrity and availability of your personal data. For more detailed Privacy Statement, you may visit <a href="https://www.pup.edu.ph/privacy/" target="_blank">https://www.pup.edu.ph/privacy/</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input type="submit" value="Sign Up" id="submitBtn" name="studentSignup" class="btn btn-primary" />
                    </div>
                </div>
            </div>
        </div>            
    </form>
    <!-- End of sign up modal -->
    <!-- Success alert modal -->
    <div id="successModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Account has been created successfully.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of success alert modal -->
    <!-- Account already exists modal -->
    <div id="accountExistsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="accountExistsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountExistsModalLabel">Create Account Failed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The account details you provided already exists. Please try again.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of account already exists modal -->
    <!-- Create account failed modal -->
    <div id="createAccountFailedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createAccountFailedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAccountFailedModalLabel">Create Account Failed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Failed to create an account. Please try again.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of create account failed modal -->
    <?php 
    if (isset($_SESSION['account_created']) && $_SESSION['account_created']) {
        echo "
        <script>
        $(window).on('load', function() {
            $('#successModal').modal('show');
        });
        </script>
        ";
    }
    if (isset($_SESSION['account_exists']) && $_SESSION['account_exists']) {
        echo "
        <script>
        $(window).on('load', function() {
            $('#accountExistsModal').modal('show');
        });
        </script>
        ";
    }
    if (isset($_SESSION['account_failed']) && $_SESSION['account_failed']) {
        echo "
        <script>
        $(window).on('load', function() {
            $('#createAccountFailedModal').modal('show');
        });
        </script>
        ";
    }

    unset($_SESSION['account_created']);
    unset($_SESSION['account_exists']);
    unset($_SESSION['account_failed']);
    ?>
    <!-- End of success alert modal -->

    <!-- JS validation for form fields -->
    <script>
        const studentNoInput = document.getElementById('StudentNo');
        const contactNoInput = document.getElementById('ContactNumber');
        const studentNoValidationMessage = document.getElementById('studentNoValidationMessage');
        const contactNoValidationMessage = document.getElementById('contactNoValidationMessage');
        const emailInput = document.getElementById('Email');
        const emailError = document.getElementById('emailError');
        const zipCodeInput = document.getElementById('ZipCode');
        const zipCodeError = document.getElementById('zipCodeError');
        const birthdateInput = document.getElementById('Birthday');
        const birthdateError = document.getElementById('birthdateError');
        var passwordInput = document.getElementById("Password");
        var confirmPasswordInput = document.getElementById("ConfirmPassword");
        var submitButton = document.getElementById("submitBtn");

        const passwordPattern = /^(?=.*\d).{8,}$/;

        // Validation event listeners
        studentNoInput.addEventListener('input', () => {
            const studentNo = studentNoInput.value.trim();
            const studentNoValidPattern = /^\d{4}-\d{5}-SR-\d$/;

            if (!studentNoValidPattern.test(studentNo)) {
                studentNoValidationMessage.textContent = 'Invalid student number. The format must be xxxx-xxxxx-SR-x';
                studentNoInput.classList.add('is-invalid');
            } else {
                studentNoValidationMessage.textContent = '';
                studentNoInput.classList.remove('is-invalid');
            }
        });

        contactNoInput.addEventListener('input', () => {
            const contactNo = contactNoInput.value.trim();
            const contactNoValidPattern = /^0\d{3}-\d{3}-\d{4}$/;

            // Remove any dashes from the current input value
            const cleanedContactNo = contactNo.replace(/-/g, '');

            // Format the contact number with dashes
            let formattedContactNo = '';
            for (let i = 0; i < cleanedContactNo.length; i++) {
                if (i === 4 || i === 7) {
                    formattedContactNo += '-';
                }
                formattedContactNo += cleanedContactNo[i];
            }

            // Update the input value with the formatted contact number
            contactNoInput.value = formattedContactNo;

            if (!contactNoValidPattern.test(formattedContactNo)) {
                contactNoValidationMessage.textContent = 'Invalid contact number. The format must be 0xxx-xxx-xxxx';
                contactNoInput.classList.add('is-invalid');
            } else {
                contactNoValidationMessage.textContent = '';
                contactNoInput.classList.remove('is-invalid');
            }
        });

        birthdateInput.addEventListener('input', function() {
            validateBirthdate(this.value);
        });

        emailInput.addEventListener('input', validateEmail);
        zipCodeInput.addEventListener('input', validateZipCode);

        // Validation functions
        function validateBirthdate(birthdate) {
            const currentDate = new Date();
            const selectedDate = new Date(birthdate);

            if (selectedDate < new Date('1900-01-01') || selectedDate > currentDate) {
                birthdateError.style.display = 'block';
                birthdateInput.classList.add('is-invalid');
            } else {
                birthdateError.style.display = 'none';
                birthdateInput.classList.remove('is-invalid');
            }
            }

        function validateEmail() {
            const email = emailInput.value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (emailPattern.test(email)) {
                emailInput.classList.remove('is-invalid');
                emailError.style.display = 'none';
            } else {
                emailInput.classList.add('is-invalid');
                emailError.style.display = 'block';
            }
        }

        function validateZipCode() {
            const zipCode = zipCodeInput.value.trim();
            const validZipCodePattern = /^[0-9]{4,6}$/;

            if (!validZipCodePattern.test(zipCode)) {
                zipCodeError.textContent = 'Zip Code must be 4 to 6 digits long';
                zipCodeInput.classList.add('is-invalid');
            } else {
                zipCodeError.textContent = '';
                zipCodeInput.classList.remove('is-invalid');
            }
        }

        function validatePassword() {
            const password = passwordInput.value.trim();
            const confirmPassword = confirmPasswordInput.value.trim();

            // Check if the password meets the requirements
            const isPasswordValid = passwordPattern.test(password);
            const isPasswordMatch = password === confirmPassword;

            // Update the validation messages and styles
            if (password === '' || !isPasswordValid) {
                passwordInput.classList.remove('is-valid');
                passwordInput.classList.add('is-invalid');
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
            }

            if (confirmPassword === '' || !isPasswordMatch) {
                confirmPasswordInput.classList.remove('is-valid');
                confirmPasswordInput.classList.add('is-invalid');
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordInput.classList.add('is-valid');
            }

            // Update the checklist message
            const passwordChecklist = document.getElementById('passwordChecklist');
            passwordChecklist.innerHTML = '';

            if (password === '') {
                passwordChecklist.innerHTML += '<li class="text-danger">Password is required</li>';
            } else if (password.length >= 8) {
                passwordChecklist.innerHTML += '<li class="text-success">At least 8 characters &#10004;</li>';
            } else {
                passwordChecklist.innerHTML += '<li class="text-danger">At least 8 characters &#10006;</li>';
            }

            if (passwordPattern.test(password)) {
                passwordChecklist.innerHTML += '<li class="text-success">Contains a number &#10004;</li>';
            } else {
                passwordChecklist.innerHTML += '<li class="text-danger">Contains a number &#10006;</li>';
            }

            if (confirmPassword === '') {
                passwordChecklist.innerHTML += '<li class="text-danger">Confirm password is required</li>';
            } else if (isPasswordMatch) {
                passwordChecklist.innerHTML += '<li class="text-success">Passwords match &#10004;</li>';
            } else {
                passwordChecklist.innerHTML += '<li class="text-danger">Passwords do not match &#10006;</li>';
            }
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);
    </script>
</body>
</html>