<!DOCTYPE html>
<html>

<head>
    <title>Register | GamifyTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="./css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="./css/registration.css">
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }

        a {
            color: #fff;
        }

        #li-login:hover {
            color: dodgerblue;
        }
    </style>
</head>

<body>
    <div class="padding-all">
        <div class="header">
            <h1><img src="./images/5.png"> Gaming Registration Form</h1>
        </div>

        <div class="design-w3l">
            <div class="mail-form-agile">
                <form name="registrationForm" onsubmit="return validateForm()" action="./registrationCode.php" method="POST">
                    <div>
                        <input type="text" name="first_name" placeholder="First Name..." required />
                    </div>
                    <p id="firstNameError" class="error">

                    </p>
                    <div>
                        <input type="text" name="last_name" placeholder="Last Name..." required />
                    </div>
                    <p id="lastNameError" class="error"></p>

                    <div class="gender-dob-container">
                        <label for="gender" class="styled-label">Gender :</label>
                        <select name="gender" id="gender" class="styled-gender-select">
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                        <br><br>
                        <label for="dob" class="styled-label">Birth Day :</label>
                        <div class="dob-container">
                            <select name="day" class="styled-dob-select" required>
                                <option value="">Day</option>
                                <?php
                                for ($day = 1; $day <= 32; $day++) {
                                    echo "<option value='$day'>$day</option>";
                                }
                                ?>
                            </select>

                            <select name="month" class="styled-dob-select" required>
                                <option value="">Month</option>
                                <?php
                                for ($month = 1; $month <= 12; $month++) {
                                    echo "<option value='$month'>$month</option>";
                                }
                                ?>
                            </select>

                            <select name="year" class="styled-dob-select" required>
                                <option value="">Year</option>
                                <?php
                                $currentYear = date("Y");
                                for ($year = $currentYear; $year >= 1900; $year--) {
                                    echo "<option value='$year'>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <input type="text" name="address" placeholder="Address..." required />
                        <p id="addressError" class="error"></p>
                        <input type="text" name="phone_number" placeholder="Phone Number..." required />
                        <p id="phoneError" class="error"></p>
                    </div>
                    <div>
                        <input type="text" name="email" placeholder="Email..." required />
                        <p id="emailError" class="error"></p>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password..." required />
                        <p id="passwordError" class="error"></p>
                        <input type="password" name="conformpassword" placeholder="Confirm Password..." required />
                        <p id="passwordError" class="error"></p>
                    </div>

                    <br><br>
                    <input type="submit" name="submit" value="Registration">
                    <br><br>
                    <a  href="./login.php">Do you have an account!<samp id="li-login"> Click here!</samp></a>
                </form>
            </div>
            <div class="clear"> </div>
        </div>

        
    </div>

    <script type="application/x-javascript">
        function validateForm() {
            let isValid = true;

            const firstName = document.forms["registrationForm"]["first_name"];
            const lastName = document.forms["registrationForm"]["last_name"];
            const address = document.forms["registrationForm"]["address"];
            const phoneNumber = document.forms["registrationForm"]["phone_number"];
            const email = document.forms["registrationForm"]["email"];
            const password = document.forms["registrationForm"]["password"];
            const confirmPassword = document.forms["registrationForm"]["conformpassword"];

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            if (firstName.value.length < 3 || firstName.value.length > 12) {
                document.getElementById('firstNameError').textContent = "First name must be between 3 and 12 characters.";
                isValid = false;
            }

            if (lastName.value.length < 3 || lastName.value.length > 12) {
                document.getElementById('lastNameError').textContent = "Last name must be between 3 and 12 characters.";
                isValid = false;
            }

            if (address.value.length < 5 || address.value.length > 30) {
                document.getElementById('addressError').textContent = "Address must be between 5 and 30 characters.";
                isValid = false;
            }

            if (phoneNumber.value.length < 10 || phoneNumber.value.length > 15 || isNaN(phoneNumber.value)) {
                document.getElementById('phoneError').textContent = "Phone number must be between 10 and 15 digits.";
                isValid = false;
            }

            if (email.value.length < 10 || email.value.length > 70) {
                document.getElementById('emailError').textContent = "Email must be between 10 and 50 characters.";
                isValid = false;
            }

            const passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/;
            if (!passwordRegex.test(password.value)) {
                document.getElementById('passwordError').textContent = "Password must be at least 8 characters long and include A/a/1/@/#.";
                isValid = false;
            }

            if (password.value !== confirmPassword.value) {
                document.getElementById('passwordError').textContent = "Passwords do not match.";
                isValid = false;
            }

            return isValid;
        }
    </script>

</body>

</html>