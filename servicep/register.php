<?php
require_once '../config.php';
if(isset($_SESSION['vendor_id'])){ header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-wrapper py-5">
        <div class="auth-card" style="max-width: 800px;">
            <h3 class="text-center mb-4 text-dark" style="font-family: 'Montserrat', sans-serif;">Vendor Registration</h3>
            <form action="../controller/servicep-register.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Name</label>
                        <input type="text" class="form-control" name="business_name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Owner Name</label>
                        <input type="text" class="form-control" name="owner_name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone_number" required pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="Please enter exactly 10 digits">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">GST Number</label>
                        <input type="text" class="form-control" name="gst_number" required pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" maxlength="15" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');" title="Please enter a valid 15-character GSTIN">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">PAN Number</label>
                        <input type="text" class="form-control" name="pan_number" required pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');" title="Please enter a valid 10-character PAN number">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Experience (Years)</label>
                        <input type="number" class="form-control" name="experience_years" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Business Address</label>
                        <textarea class="form-control" name="business_address" rows="2" required></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" class="form-control" name="pincode" required pattern="[0-9]{6}" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="Please enter exactly 6 digits">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Service Area</label>
                        <input type="text" class="form-control" name="service_area" placeholder="e.g. Mumbai, Pune" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bank Account Details (A/c No & IFSC)</label>
                        <textarea class="form-control" name="bank_account_details" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">UPI ID</label>
                        <input type="text" class="form-control" name="upi_id" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business License Print (Upload)</label>
                        <input type="file" class="form-control" name="license_upload">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Profile Image / Logo (Upload)</label>
                        <input type="file" class="form-control" name="profile_image">
                    </div>
                    <div class="col-12 mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms_agreement" required>
                        <label class="form-check-label" for="terms">I agree to the terms and conditions.</label>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary-custom w-100">Submit Registration</button>
                <div class="text-center mt-3">
                    <a href="login.php" class="text-muted text-decoration-none">Already have an account? Sign in.</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
