<?php 
include 'includes/head.php'; 

// Fetch basic stats
$total_users = 0; $total_vendors = 0; $total_revenue = 0; $total_bookings = 0;

$stmt = $admin->ret("SELECT count(*) as count FROM `users`");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row) $total_users = $row['count'];

$stmt = $admin->ret("SELECT count(*) as count FROM `vendors`");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row) $total_vendors = $row['count'];

$stmt = $admin->ret("SELECT sum(amount) as total FROM `payments` WHERE `payment_status`='Completed'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row && $row['total']) $total_revenue = $row['total'];

$stmt = $admin->ret("SELECT count(*) as count FROM `bookings`");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row) $total_bookings = $row['count'];
?>

<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-info">
                    <h6>Total Bookings</h6>
                    <h3><?php echo number_format($total_bookings); ?></h3>
                    <span class="metric-trend"><span class="positive">+55%</span> than last week</span>
                </div>
                <div class="metric-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-info">
                    <h6>Users</h6>
                    <h3><?php echo number_format($total_users); ?></h3>
                    <span class="metric-trend"><span class="positive">+12%</span> than last month</span>
                </div>
                <div class="metric-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="metric-card">
                <div class="metric-info">
                    <h6>Revenue</h6>
                    <h3>₹<?php echo number_format($total_revenue, 2); ?></h3>
                    <span class="metric-trend"><span class="positive">+8%</span> than last month</span>
                </div>
                <div class="metric-icon">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="metric-card">
                <div class="metric-info">
                    <h6>Vendors</h6>
                    <h3><?php echo number_format($total_vendors); ?></h3>
                    <span class="metric-trend">Just updated</span>
                </div>
                <div class="metric-icon">
                    <i class="fas fa-store"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Recent Bookings</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-check text-info" aria-hidden="true"></i>
                            <span class="font-weight-bold ms-1">Just updated</span> recent records
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7">User</th>
                                <th class="text-secondary opacity-7 text-center">Event Date</th>
                                <th class="text-secondary opacity-7 text-center">Amount</th>
                                <th class="text-secondary opacity-7 text-center">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $b_stmt = $admin->ret("SELECT b.*, u.full_name as user_name FROM `bookings` b INNER JOIN `users` u ON b.user_id = u.user_id ORDER BY b.booking_id DESC LIMIT 5");
                            while($b_row = $b_stmt->fetch(PDO::FETCH_ASSOC)) {
                                $amt = number_format($b_row['total_price'], 2);
                                $date = date('d M Y', strtotime($b_row['event_date']));
                                $status = $b_row['payment_status'];
                                $badge_class = ($status == 'Completed') ? 'badge-active' : (($status == 'Pending') ? 'badge-pending' : 'badge-inactive');
                                echo "<tr>
                                    <td><div class='d-flex px-3 py-1'><div class='d-flex flex-column justify-content-center'><h6 class='mb-0 text-sm'>{$b_row['user_name']}</h6><p class='text-xs text-secondary mb-0'>Booking #{$b_row['booking_id']}</p></div></div></td>
                                    <td class='align-middle text-center text-sm'><span class='text-xs font-weight-bold'>{$date}</span></td>
                                    <td class='align-middle text-center text-sm'><span class='text-xs font-weight-bold'>₹ {$amt}</span></td>
                                    <td class='align-middle text-center text-sm'><span class='badge {$badge_class}'>{$status}</span></td>
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
