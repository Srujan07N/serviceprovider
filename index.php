<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Seamless Services.<br><span>Observable in real-time.</span></h1>
                <p class="hero-subtitle">Connect with top-rated local vendors, book packages dynamically, and track your events without any hassle.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="service.php" class="btn btn-primary-custom px-4 py-3"><i class="fas fa-search me-2"></i> Find a Service</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 position-relative">
               <!-- Mockup dashboards graphics representing the user reference -->
               <img src="https://kerisys.com/wp-content/uploads/2023/07/AdobeStock_603529245-scaled.jpeg" alt="Dashboard Preview" class="img-fluid rounded-4 shadow-lg border border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
               
               <div class="position-absolute glass-card p-3 shadow-lg" style="bottom: -20px; left: -30px; border-color:rgba(249, 115, 22, 0.5);">
                   <div class="d-flex align-items-center gap-3">
                       <i class="fas fa-shield-alt fs-2 text-warning"></i>
                       <div>
                           <h6 class="mb-0 text-white font-weight-bold">100% Secure</h6>
                           <small class="text-muted">Verified Vendors</small>
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Snippet -->




<!-- Call to action mimicking the orange stripe in the image -->
<section class="py-5" style="background: linear-gradient(135deg, var(--accent-orange) 0%, #db2777 100%); position:relative; overflow:hidden;">
    <div class="bg-pattern opacity-50"></div>
    <div class="container text-center py-5">
        <h2 class="text-white font-weight-bold mb-4" style="font-size: 3rem;">Get Started Today</h2>
        <p class="text-white opacity-75 mb-4 mx-auto" style="max-width: 600px;">
            Join thousands of users organizing their events, fixing their homes, and experiencing premium services tracked seamlessly.
        </p>
        <a href="register.php" class="btn btn-light px-5 py-3 text-dark fw-bold" style="border-radius: 30px;">Book a Service</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
