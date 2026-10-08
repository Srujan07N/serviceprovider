<?php 
include 'includes/head.php'; 
$vid = $_SESSION['vendor_id'];

// Mock up real dashboard metrics
$t_packs = 0; $t_bookings = 0; $t_revenue = 0; $t_feedbacks = 0;

$stmt = $admin->ret("SELECT count(*) as c FROM `packages` WHERE `vendor_id`='$vid'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row) $t_packs = $row['c'];

$stmt = $admin->ret("SELECT count(*) as c FROM `bookings` WHERE `vendor_id`='$vid'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row) $t_bookings = $row['c'];

$stmt = $admin->ret("SELECT sum(amount) as t FROM `payments` WHERE `vendor_id`='$vid' AND `payment_status`='Completed'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row && $row['t']) $t_revenue = $row['t'];

$stmt = $admin->ret("SELECT count(*) as c FROM `feedbacks` WHERE `vendor_id`='$vid'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row) $t_feedbacks = $row['c'];
?>

<div class="row mb-3">
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-icon text-warning-custom">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="metric-info text-end">
                    <h6>Capacity</h6>
                    <h3><?php echo number_format($t_packs); ?> Packs</h3>
                </div>
            </div>
            <div class="metric-footer">
                
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-icon text-success-custom">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="metric-info text-end">
                    <h6>Revenue</h6>
                    <h3>₹<?php echo number_format($t_revenue, 2); ?></h3>
                </div>
            </div>
            <div class="metric-footer">
               
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-icon text-danger-custom">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="metric-info text-end">
                    <h6>Bookings</h6>
                    <h3><?php echo number_format($t_bookings); ?></h3>
                </div>
            </div>
            <div class="metric-footer">
                
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-icon text-info-custom">
                    <i class="far fa-comment-dots"></i>
                </div>
                <div class="metric-info text-end">
                    <h6>Feedbacks</h6>
                    <h3><?php echo number_format($t_feedbacks); ?></h3>
                </div>
            </div>
            <div class="metric-footer">
               
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title" style="color: #66615b; font-weight:400;">Global Sales & Recent Bookings</h5>
                <p class="card-category">All pending tasks from users directly</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th>Booking ID</th>
                                <th>Client Name</th>
                                <th>Date Of Event</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT b.*, u.full_name as client FROM `bookings` b JOIN `users` u ON b.user_id = u.user_id WHERE b.vendor_id='$vid' ORDER BY b.booking_id DESC LIMIT 5");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['payment_status'];
                                $badge = ($status == 'Completed') ? 'badge-active' : (($status == 'Pending') ? 'badge-pending' : 'badge-inactive');
                                echo "<tr>
                                    <td>#{$row['booking_id']}</td>
                                    <td>{$row['client']}</td>
                                    <td>{$row['event_date']}</td>
                                    <td class='text-end'>₹".number_format($row['total_price'],2)."</td>
                                    <td class='text-end'><span class='badge {$badge}'>{$status}</span></td>
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

<?php include 'includes/foot.php'; ?>
