<?php 
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
if(!isset($_GET['id'])) { header('Location: my-bookings.php'); exit; }

$bid = $_GET['id'];
$uid = $_SESSION['user_id'];
$stmt = $admin->ret("SELECT b.*, p.package_name FROM `bookings` b JOIN `packages` p ON b.package_id=p.package_id WHERE b.booking_id='$bid' AND b.user_id='$uid' AND (b.status='Confirmed' OR b.status='Completed')");

if($stmt->rowCount() == 0) {
    echo "<div class='container py-5 text-center mt-5 text-white'><h2>Invalid Feedback Request or not authorized.</h2></div>"; include 'includes/footer.php'; exit;
}
$b = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if already fed back
$c_stmt = $admin->ret("SELECT * FROM `feedbacks` WHERE `booking_id`='$bid'");
if($c_stmt->rowCount() > 0){
    echo "<div class='container py-5 text-center mt-5 text-white'><h2>Feedback already submitted for this booking!</h2><a href='my-bookings.php' class='btn btn-outline-light mt-3'>Return to Dashboard</a></div>"; include 'includes/footer.php'; exit;
}
?>

<section class="py-5 bg-main" style="min-height: 80vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="glass-card p-5">
                    <h3 class="text-white mb-2">Leave a Rating</h3>
                    <p class="text-muted mb-4 pb-4 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                        How was your experience for <strong><?php echo $b['package_name']; ?></strong>?
                    </p>

                    <form action="controller/user-feedback.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="booking_id" value="<?php echo $b['booking_id']; ?>">
                        <input type="hidden" name="package_id" value="<?php echo $b['package_id']; ?>">
                        <input type="hidden" name="vendor_id" value="<?php echo $b['vendor_id']; ?>">

                        <div class="mb-4">
                            <label class="form-label d-block text-center">Quality Rating (1 to 5 Stars)</label>
                            <div class="rating-stars justify-content-center mt-2">
                                <input type="radio" id="star5" name="rating" value="5" required />
                                <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Review Headline</label>
                            <input type="text" name="review_title" class="form-control" required placeholder="E.g. Excellent service, highly recommend!">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Detailed Comments</label>
                            <textarea name="review_comment" class="form-control" rows="4" required placeholder="Describe what went well and what could be improved..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Proof / Image (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-5 form-check ms-2">
                            <input type="checkbox" name="is_anonymous" class="form-check-input border-secondary" id="anon" value="1" style="cursor:pointer;">
                            <label class="form-check-label text-muted" for="anon">Submit review anonymously</label>
                        </div>

                        <button type="submit" name="submit_feedback" class="btn btn-primary-custom w-100 py-3 fs-5">Publish Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
