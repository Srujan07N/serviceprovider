<?php 
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$uid = $_SESSION['user_id'];
?>

<section class="py-5 bg-main" style="min-height: 80vh;">
    <div class="container py-4">
        <h2 class="text-white font-weight-bold mb-5"><i class="fas fa-layer-group text-warning me-2"></i> Client Dashboard</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="glass-card mb-4 text-center sticky-lg-top" style="top: 100px;">
                    <?php 
                    $ustmt = $admin->ret("SELECT * FROM `users` WHERE `user_id`='$uid'");
                    $usr = $ustmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($usr['full_name']); ?>&background=random" alt="user" class="rounded-circle mb-3 border border-secondary" width="100" height="100">
                    <h5 class="text-white"><?php echo $usr['full_name']; ?></h5>
                    <p class="text-muted text-sm mb-4"><?php echo $usr['email']; ?></p>
                    
                    <ul class="list-unstyled text-start w-100 px-3 border-top pt-3" style="border-color: rgba(255,255,255,0.05) !important;">
                        <li class="mb-3"><a href="controller/user-logout.php" class="text-muted text-decoration-none"><i class="fas fa-sign-out-alt me-2"></i> Secure Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="glass-card p-4 p-md-5">
                    <h4 class="text-white mb-4">Booking Activity History</h4>

                    <div class="table-responsive">
                        <table class="table text-center table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="text-start">Package Details</th>
                                    <th>Event Specs</th>
                                    <th>Cost Status</th>
                                    <th>Advance Payment</th>
                                    <th>Final Settlement</th>
                                    <th>Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $admin->ret("SELECT b.*, p.package_name, v.business_name FROM `bookings` b JOIN `packages` p ON b.package_id=p.package_id JOIN `vendors` v ON b.vendor_id=v.vendor_id WHERE b.user_id='$uid' ORDER BY b.booking_id DESC");
                                if($stmt->rowCount() == 0){
                                    echo "<tr><td colspan='6' class='py-4 text-muted'>You haven't initiated any bookings yet.</td></tr>";
                                }
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $bstats = $row['status'];
                                    $pstats = $row['payment_status'];
                                    $bbadge = "badge-".str_replace(' ','',$bstats); // Remove spaces for CSS
                                    $pbadge = "badge-".str_replace(' ','',$pstats);

                                    echo "<tr>
                                        <td class='text-start'>
                                            <strong class='text-white d-block'>{$row['package_name']}</strong>
                                            <span class='text-muted text-sm'>v. {$row['business_name']}</span>
                                        </td>
                                        <td>
                                            <span class='badge bg-dark border border-secondary'>{$row['event_date']}</span><br>
                                            <span class='text-muted text-sm'>{$row['number_of_guests']} Guests</span>
                                        </td>
                                        <td>
                                            <strong class='text-warning d-block pb-1'>₹".number_format($row['total_price'],2)."</strong>
                                            <span class='badge {$pbadge}'>{$pstats}</span>
                                        </td>
                                        <td>
                                            <div class='mb-2'><span class='badge {$bbadge} text-uppercase px-3'>{$bstats}</span></div>";
 
                                    if(($bstats == 'Approved' || $bstats == 'Payment Pending') && ($pstats == 'Pending' || $pstats == 'Rejected' || trim($pstats) == '')) {
                                        echo "<button type='button' onclick='openPaymentModal({$row['booking_id']}, {$row['vendor_id']}, " . ($row['total_price']/2) . ", \"Advance Payment\")' class='btn btn-sm btn-primary-custom py-1'>Pay Advance</button>";
                                    } else if ($pstats == 'Advance Paid' || $pstats == 'Fully Paid' || $pstats == 'Completed' || $bstats == 'Advance Paid' || $bstats == 'Completed') {
                                        echo "<span class='text-success text-sm'><i class='fas fa-check-circle'></i> Advance Locked</span>";
                                    } else if($bstats == 'Rejected') {
                                        echo "<span class='text-muted text-sm' title='".htmlentities((string)$row['rejection_reason'], ENT_QUOTES)."'>Rejected</span>";
                                    } else {
                                        echo "<span class='text-muted text-sm'>Awaiting Approval</span>";
                                    }
                                    echo "</td><td>";

                                    if ($pstats == 'Advance Paid') {
                                        echo "<button type='button' onclick='openPaymentModal({$row['booking_id']}, {$row['vendor_id']}, " . ($row['total_price']/2) . ", \"Remaining Balance\")' class='btn btn-sm btn-warning-custom py-1 w-100'>Pay Balance</button>";
                                    } else if ($pstats == 'Fully Paid' || $pstats == 'Completed' || $bstats == 'Completed') {
                                        echo "<span class='text-success text-sm'><i class='fas fa-check-circle'></i> Fully Settled</span>";
                                    } else if (($pstats == 'Pending' || $pstats == 'Accepted') && $bstats == 'Advance Paid') {
                                        echo "<span class='text-info-custom text-sm'><i class='fas fa-clock'></i> Verifying...</span>";
                                    } else {
                                        echo "<span class='text-muted text-sm'>Locked</span>";
                                    }
                                    echo "</td><td>";

                                    if ($bstats == 'Completed') {
                                        // Check if feedback exists
                                        $fstmt = $admin->ret("SELECT * FROM `feedbacks` WHERE `booking_id`='{$row['booking_id']}'");
                                        if($fstmt->rowCount() == 0) {
                                            echo "<a href='feedback.php?id={$row['booking_id']}' class='btn btn-sm btn-outline-light py-1' style='border-radius:20px;'><i class='far fa-star'></i> Review</a>";
                                        } else {
                                            echo "<span class='text-success text-sm'><i class='fas fa-check-circle'></i> Reviewed</span>";
                                        }
                                    } else {
                                        echo "<span class='text-muted text-sm'>No Action</span>";
                                    }

                                    echo "</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Embedded Payment Gateway Modal Framework -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-main shadow" style="border: 1px solid rgba(255,165,0,0.3); border-radius:15px;">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title text-white font-weight-bold" id="modalPayTitle">Secure Checkout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="controller/user-payment.php" method="POST">
        <div class="modal-body text-center pt-2">
            <p class="text-light text-sm mb-4">Please scan the QR code below using any UPI compatible application to fulfill the required transaction.</p>
            
            <div class="p-3 bg-white d-inline-block rounded-3 mb-4 shadow">
                 <!-- Generate Dynamic QR -->
                 <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=UPI_SYSTEM_TEST_MODE" alt="Payment QR" width="150" height="auto">
            </div>

            <div class="bg-dark p-3 rounded-3 mb-4 mx-auto border" style="border-color: rgba(255,255,255,0.1) !important; max-width: 250px;">
                <span class="text-white opacity-75 d-block mb-1 text-sm" id="modalPaySub" style="letter-spacing: 1px;">Required Amount</span>
                <h3 class="text-warning mb-0" id="modalPayAmountDisp" style="font-weight: 700;">₹0.00</h3>
            </div>

            <!-- Internal Mapping Hooks -->
            <input type="hidden" name="booking_id" id="modal_bid">
            <input type="hidden" name="vendor_id" id="modal_vid">
            <input type="hidden" name="amount" id="modal_amount">
            <input type="hidden" name="payment_method" value="UPI">

            <div class="form-group text-start">
                <label class="form-label text-white font-weight-bold mb-2" style="font-size: 0.9rem;">12-Digit UPI Reference ID</label>
                <input type="text" name="transaction_id" class="form-control form-control-lg bg-dark text-white border-secondary" required placeholder="e.g. 238129381293" pattern="[0-9]{8,15}" title="Enter valid physical transaction digits" style="font-size: 1rem;">
                <small class="text-black opacity-100 mt-2 d-block" style="font-size: 0.8rem;">You will receive this ID from your Banking application after scanning.</small>
            </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
          <button type="submit" name="submit_payment" class="btn btn-warning-custom w-100 py-3" style="border-radius: 30px;">Verify Internal Ledger</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openPaymentModal(bid, vid, amt, titleType) {
    document.getElementById('modal_bid').value = bid;
    document.getElementById('modal_vid').value = vid;
    document.getElementById('modal_amount').value = amt;
    
    document.getElementById('modalPayTitle').innerText = titleType + " Gateway";
    document.getElementById('modalPaySub').innerText = titleType + " Due";
    document.getElementById('modalPayAmountDisp').innerText = "₹" + parseFloat(amt).toFixed(2);
    
    var pModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    pModal.show();
}
</script>

<?php include 'includes/footer.php'; ?>
