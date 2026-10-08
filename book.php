<?php 
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
if(!isset($_GET['id'])) { header('Location: service.php'); exit; }

$pid = $_GET['id'];
$stmt = $admin->ret("SELECT p.*, v.business_name FROM `packages` p JOIN `vendors` v ON p.vendor_id=v.vendor_id WHERE p.package_id='$pid'");
$pkg = $stmt->fetch(PDO::FETCH_ASSOC);

$price = $pkg['discount_price'] ? $pkg['discount_price'] : $pkg['price'];
?>

<section class="py-5 bg-main" style="min-height: 80vh;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="hero-title pt-3">Finalize your <span style="color:var(--accent-orange)">Booking</span></h1>
                    <p class="text-muted">You are booking <strong><?php echo $pkg['package_name']; ?></strong> with <strong><?php echo $pkg['business_name']; ?></strong></p>
                </div>

                <div class="glass-card p-5 border-warning" style="border-color: rgba(249, 115, 22, 0.3) !important;">
                    <form action="controller/user-book-package.php" method="POST" enctype="multipart/form-data">
                        <!-- Hidden inputs -->
                        <input type="hidden" name="package_id" value="<?php echo $pid; ?>">
                        <input type="hidden" name="vendor_id" value="<?php echo $pkg['vendor_id']; ?>">
                        <input type="hidden" name="total_price" value="<?php echo $price; ?>">
                        
                        <!-- Custom Bootstrap UI Alert -->
                        <div id="custom-alert" class="alert alert-danger d-none alert-dismissible fade show shadow" role="alert" style="border-radius: 10px; border-left: 5px solid #dc3545;">
                            <i class="fas fa-exclamation-triangle me-2"></i><strong id="custom-alert-text"></strong>
                            <button type="button" class="btn-close btn-close-white" style="filter: invert(1);" onclick="document.getElementById('custom-alert').classList.add('d-none')"></button>
                        </div>
                        
                        <div class="row">
                            <h5 class="text-white mb-4 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">Event & Pricing Logistics</h5>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Event Date</label>
                                <input type="date" name="event_date" class="form-control hover-border" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            
                            <!-- Dynamic Available Days Info -->
                            <div class="col-md-6 mb-4 align-self-end text-end text-muted text-sm">
                                <em>Provider availability: <?php echo $pkg['available_days']; ?></em><br>
                                <em>Blackout Dates: <?php echo !empty($pkg['blackout_dates']) ? $pkg['blackout_dates'] : 'None'; ?></em>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Start Time</label>
                                <input type="hidden" name="start_time" id="start_time_hidden">
                                <div class="input-group">
                                    <select id="start_hh" class="form-select time-calc" required>
                                        <option value="">HH</option>
                                        <?php for($i=1; $i<=12; $i++) { $v = str_pad($i, 2, '0', STR_PAD_LEFT); echo "<option value='$v'>$v</option>"; } ?>
                                    </select>
                                    <select id="start_mm" class="form-select time-calc" required>
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                    <select id="start_ampm" class="form-select time-calc" required>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label">End Time</label>
                                <input type="hidden" name="end_time" id="end_time_hidden">
                                <div class="input-group">
                                    <select id="end_hh" class="form-select time-calc" required>
                                        <option value="">HH</option>
                                        <?php for($i=1; $i<=12; $i++) { $v = str_pad($i, 2, '0', STR_PAD_LEFT); echo "<option value='$v'>$v</option>"; } ?>
                                    </select>
                                    <select id="end_mm" class="form-select time-calc" required>
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                    <select id="end_ampm" class="form-select time-calc" required>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                                <small class="text-muted">Max duration approx <?php echo $pkg['service_duration']; ?> hrs</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Event Type</label>
                                <select name="event_type" class="form-select" required>
                                    <option value="">Select Event Mode</option>
                                    <option value="Home Maintenance">Home Maintenance / Repair</option>
                                    <option value="Wedding / Engagement">Wedding / Engagement</option>
                                    <option value="Corporate Event">Corporate Event</option>
                                    <option value="Birthday / Party">Birthday / Party</option>
                                    <option value="Consultation / Professional">Consultation / Professional</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Number of Guests / Size</label>
                                <input type="number" name="number_of_guests" class="form-control" max="<?php echo $pkg['max_capacity']; ?>" value="<?php echo $pkg['max_capacity']; ?>" readonly required placeholder="Up to <?php echo $pkg['max_capacity']; ?>">
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Event Address / Location details</label>
                                <textarea name="event_address" class="form-control" rows="2" required placeholder="Full address including zip code"></textarea>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Special Requirements / Notes <span class="text-muted">(Optional)</span></label>
                                <textarea name="special_requirements" class="form-control" rows="3" placeholder="Any specific tools needed, allergies, or specific demands to the vendor?"></textarea>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label">Reference Image Upload <span class="text-muted">(Optional)</span></label>
                                <input type="file" name="reference_image" class="form-control" accept="image/*">
                                <small class="text-muted">Upload an inspirational reference, floor plan, or broken pipe image.</small>
                            </div>

                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="p-3 rounded-top text-center" style="background-color:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-bottom: none;">
                                    <h6 class="text-muted mb-0">Total Package Value: <span class="text-white">₹<?php echo number_format($price, 2); ?></span></h6>
                                </div>
                                <div class="p-4 rounded-bottom d-flex justify-content-between align-items-center" style="background-color:var(--bg-card); border: 1px dashed var(--border-color);">
                                    <div>
                                        <h6 class="text-white mb-1"><i class="fas fa-shield-alt text-success me-2"></i>Advance Payment Required:</h6>
                                        <p class="text-muted text-sm mb-0">A 50% deposit is needed upfront to lock your slot.</p>
                                    </div>
                                    <h2 class="text-success mb-0">₹<?php echo number_format($price / 2, 2); ?></h2>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 pt-3 border-top text-end" style="border-color: rgba(255,255,255,0.05) !important;">
                            <button type="submit" name="book_package" class="btn btn-primary-custom px-5 py-3 fs-5 w-100">Proceed to Application <i class="fas fa-check-circle ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function format24(h, m, ampm) {
    let hh = parseInt(h, 10);
    if(ampm === 'PM' && hh < 12) hh += 12;
    if(ampm === 'AM' && hh === 12) hh = 0;
    return hh.toString().padStart(2, '0') + ':' + m;
}

document.querySelectorAll('.time-calc').forEach(el => {
    el.addEventListener('change', function() {
        let shh = document.getElementById('start_hh').value;
        let smm = document.getElementById('start_mm').value;
        let sampm = document.getElementById('start_ampm').value;
        if(shh && smm && sampm) {
            document.getElementById('start_time_hidden').value = format24(shh, smm, sampm);
        }
        
        let ehh = document.getElementById('end_hh').value;
        let emm = document.getElementById('end_mm').value;
        let eampm = document.getElementById('end_ampm').value;
        if(ehh && emm && eampm) {
            document.getElementById('end_time_hidden').value = format24(ehh, emm, eampm);
        }
    });
});

document.querySelector('form').addEventListener('submit', function(e) {
    let startVal = document.getElementById('start_time_hidden').value;
    let endVal = document.getElementById('end_time_hidden').value;
    
    if (startVal && endVal) {
        let startTime = new Date('1970-01-01T' + startVal + 'Z');
        let endTime = new Date('1970-01-01T' + endVal + 'Z');
        
        if (endTime < startTime) {
            endTime.setDate(endTime.getDate() + 1);
        }
        
        let diffHours = (endTime - startTime) / (1000 * 60 * 60);
        
        if (diffHours > 8) {
            e.preventDefault();
            let alertBox = document.getElementById('custom-alert');
            document.getElementById('custom-alert-text').innerText = 'Warning: Duration cannot exceed 8 hours. Please adjust your AM/PM times carefully.';
            alertBox.classList.remove('d-none');
            window.scrollTo({ top: alertBox.offsetTop - 100, behavior: 'smooth' });
        }
    } else {
        e.preventDefault();
        let alertBox = document.getElementById('custom-alert');
        document.getElementById('custom-alert-text').innerText = 'Please fully select both Start and End times.';
        alertBox.classList.remove('d-none');
        window.scrollTo({ top: alertBox.offsetTop - 100, behavior: 'smooth' });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
