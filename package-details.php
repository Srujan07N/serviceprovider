<?php 
include 'includes/header.php';
if(!isset($_GET['id'])) { header('Location: service.php'); exit; }

$pid = $_GET['id'];
$stmt = $admin->ret("SELECT p.*, v.business_name, v.experience_years, v.profile_image, c.category_name, s.sub_category_name 
                      FROM `packages` p 
                      JOIN `vendors` v ON p.vendor_id=v.vendor_id 
                      JOIN `categories` c ON p.category_id=c.category_id 
                      JOIN `sub_categories` s ON p.sub_category_id=s.sub_category_id
                      WHERE p.package_id='$pid' AND p.status='Active'");
if($stmt->rowCount() == 0) {
    echo "<div class='container py-5 text-center mt-5 text-white'><h2>Package Not Found or Inactive.</h2></div>";
    include 'includes/footer.php'; exit;
}
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$v_img = !empty($row['profile_image']) ? "uploads/vendors/profiles/".$row['profile_image'] : "https://ui-avatars.com/api/?name=".urlencode($row['business_name']);

// Get Images
$images = [];
$img_stmt = $admin->ret("SELECT image_path FROM `package_images` WHERE `package_id`='$pid'");
while($img_row = $img_stmt->fetch(PDO::FETCH_ASSOC)) {
    $images[] = "uploads/packages/".$img_row['image_path'];
}
if(empty($images)) {
    $images = [
        'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=1469&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1470&auto=format&fit=crop'
    ]; // Dummy array fallback
}
?>

<section class="py-5 bg-main">
    <div class="container py-4">
        <!-- Breadcrumb equivalent -->
        <p class="text-muted"><a href="service.php" class="text-muted text-decoration-none">Services</a> &gt; <?php echo $row['category_name']; ?> &gt; <?php echo $row['sub_category_name']; ?></p>

        <div class="row">
            <div class="col-lg-8 mb-5">
                <div class="glass-card mb-4 p-0" style="border-radius: 20px; overflow:hidden;">
                    <div id="packageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach($images as $key => $img): ?>
                                <div class="carousel-item <?php echo $key==0?'active':''; ?>">
                                    <img src="<?php echo $img; ?>" class="d-block w-100" alt="Package" style="height: 500px; object-fit: cover;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if(count($images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#packageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#packageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <h1 class="font-weight-bold text-white mb-4"><?php echo $row['package_name']; ?></h1>
                
                <div class="mb-5 border-bottom pb-4" style="border-color: rgba(255,255,255,0.05) !important;">
                    <h5 class="text-white mb-3">Package Description</h5>
                    <p class="text-muted" style="line-height:2.1; font-size:1.05rem;"><?php echo nl2br($row['description']); ?></p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <h5 class="text-white mb-3"><i class="fas fa-check-circle text-success me-2"></i> What's Included</h5>
                        <ul class="list-unstyled text-muted">
                            <?php 
                            $incs = explode("\n", trim($row['inclusions']));
                            foreach($incs as $inc) if(!empty(trim($inc))) echo "<li class='mb-2'>&bull; {$inc}</li>";
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h5 class="text-white mb-3"><i class="fas fa-times-circle text-danger me-2"></i> Exclusions</h5>
                        <ul class="list-unstyled text-muted">
                            <?php 
                            $excs = explode("\n", trim($row['exclusions']));
                            foreach($excs as $exc) if(!empty(trim($exc))) echo "<li class='mb-2'>&nbsp;- {$exc}</li>";
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="glass-card mb-4" style="background-color:var(--bg-card); border-color:var(--border-color);">
                    <div class="row text-center text-md-start">
                        <div class="col-md-4 mb-3 mb-md-0 border-end border-secondary" style="border-color: rgba(255,255,255,0.05) !important;">
                            <strong class="d-block text-white mb-1">Max Capacity/Guests</strong>
                            <span class="text-warning fs-5"><?php echo $row['max_capacity']; ?></span>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0 border-end border-secondary" style="border-color: rgba(255,255,255,0.05) !important;">
                            <strong class="d-block text-white mb-1">Service Duration</strong>
                            <span class="text-warning fs-5"><?php echo $row['service_duration']; ?> Hours</span>
                        </div>
                        <div class="col-md-4">
                            <strong class="d-block text-white mb-1">Available Days</strong>
                            <span class="text-warning fs-5"><?php echo $row['available_days']; ?></span>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="col-lg-4">
                <div class="glass-card position-sticky shadow-lg border-warning" style="top: 100px; border-color: rgba(249, 115, 22, 0.4) !important;">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                        <img src="<?php echo $v_img; ?>" alt="vendor" class="rounded-circle me-3" width="60" height="60" style="object-fit:cover; border:2px solid var(--accent-orange);">
                        <div>
                            <h6 class="text-white mb-1"><?php echo $row['business_name']; ?></h6>
                            <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> Trusted Vendor</span>
                            <span class="text-muted d-block mt-1" style="font-size:0.8rem;"><?php echo $row['experience_years']; ?> YRS Experience</span>
                        </div>
                    </div>
                    
                    <h3 class="text-white font-weight-bold mb-1">
                        <?php echo $row['discount_price'] ? "<del class='text-muted fs-6'>₹".number_format($row['price'], 2)."</del> ₹".number_format($row['discount_price'], 2) : "₹".number_format($row['price'], 2); ?>
                    </h3>
                    <p class="text-muted text-sm mb-4">Total flat rate cost</p>

                    <div class="mb-4">
                        <strong class="text-white d-block mb-1">Refund Policy:</strong>
                        <span class="text-muted text-sm"><?php echo $row['refund_policy']; ?></span>
                    </div>

                    <?php if(!empty(trim($row['blackout_dates']))): ?>
                    <div class="mb-4">
                        <strong class="text-white d-block mb-1">Blackout Dates:</strong>
                        <span class="text-muted text-sm"><?php echo $row['blackout_dates']; ?></span>
                    </div>
                    <?php endif; ?>

                    <a href="book.php?id=<?php echo $row['package_id']; ?>" class="btn btn-primary-custom w-100 py-3 d-flex justify-content-center align-items-center gap-2">
                        <span>Book Now</span> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
