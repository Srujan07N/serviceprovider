<?php 
include 'includes/header.php'; 

$package_id = isset($_GET['package_id']) ? $_GET['package_id'] : null;
$vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] : null;

$where = "WHERE 1=1";
if($package_id) $where .= " AND f.package_id = '$package_id'";
if($vendor_id) $where .= " AND f.vendor_id = '$vendor_id'";

$query = "SELECT f.*, p.package_name, u.full_name, v.business_name 
          FROM `feedbacks` f 
          LEFT JOIN `packages` p ON f.package_id = p.package_id 
          LEFT JOIN `users` u ON f.user_id = u.user_id
          LEFT JOIN `vendors` v ON f.vendor_id = v.vendor_id
          $where 
          ORDER BY f.created_at DESC";

$stmt = $admin->ret($query);
?>

<section class="py-5 bg-main" style="min-height: 80vh;">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="hero-title">Client <span>Testimonials</span></h1>
            <p class="text-muted">Real experiences from users who booked our expert services.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if($stmt->rowCount() > 0): ?>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-lg-8">
                        <div class="glass-card p-4 p-md-5 mb-4 position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 p-4 opacity-10">
                                <i class="fas fa-quote-right fs-1 text-warning"></i>
                            </div>
                            
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['full_name']); ?>&background=random" class="rounded-circle me-3 border border-secondary" width="60" height="60" alt="User">
                                <div>
                                    <h5 class="text-white mb-0"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                                    <div class="text-warning">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="<?php echo ($i <= $row['rating']) ? 'fas' : 'far'; ?> fa-star fa-xs"></i>
                                        <?php endfor; ?>
                                        <span class="text-muted ms-2 text-xs"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="feedback-content mb-4">
                                <?php if($row['review_title']): ?>
                                    <h6 class="text-white font-weight-bold mb-2">"<?php echo htmlspecialchars($row['review_title']); ?>"</h6>
                                <?php endif; ?>
                                <p class="text-muted" style="line-height: 1.8; font-style: italic;">
                                    <?php echo nl2br(htmlspecialchars($row['review_comment'])); ?>
                                </p>
                            </div>

                            <div class="pt-3 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-sm">
                                        <span class="text-muted">Package:</span>
                                        <a href="package-details.php?id=<?php echo $row['package_id']; ?>" class="text-warning text-decoration-none ms-1"><?php echo htmlspecialchars($row['package_name']); ?></a>
                                    </div>
                                    <div class="text-sm text-end">
                                        <span class="text-muted">Provided by:</span>
                                        <span class="text-white ms-1 font-weight-bold"><?php echo htmlspecialchars($row['business_name']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-lg-6 text-center py-5">
                    <div class="glass-card p-5">
                        <i class="far fa-comment-dots fs-1 text-warning mb-3"></i>
                        <h4 class="text-white">No Feedback Yet</h4>
                        <p class="text-muted">Once clients complete their events and leave reviews, they will appear here.</p>
                        <a href="index.php" class="btn btn-warning-custom mt-3 px-4">Back to Home</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
