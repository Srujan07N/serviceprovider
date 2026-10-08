<?php include 'includes/head.php'; $vid = $_SESSION['vendor_id']; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title">Event Payments Verification</h5>
                <p class="card-category">Verify the payment from client bookings before approving your job.</p>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table w-100">
                        <thead class="text-primary">
                            <tr>
                                <th class="ps-4">Booking Info</th>
                                <th>Service Package</th>
                                <th class="text-center">Total Value</th>
                                <th class="text-center">Advance Paid</th>
                                <th class="text-center">Pending Balance</th>
                                <th class="text-center">PG / TXN Id</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="min-width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Joining multiple tables to get rich details
                            $query = "SELECT p.*, b.event_date, b.event_type, b.status as booking_status, b.total_price, b.payment_status as master_p_status, u.full_name 
                                      FROM `payments` p 
                                      JOIN `bookings` b ON p.booking_id = b.booking_id 
                                      JOIN `users` u ON p.user_id = u.user_id 
                                      WHERE p.vendor_id = '$vid'
                                      ORDER BY p.payment_id DESC";
                            $stmt = $admin->ret($query);
                            
                            if ($stmt->rowCount() == 0) {
                                echo "<tr><td colspan='8' class='text-center py-4 text-muted'>No payments recorded for your packages yet.</td></tr>";
                            }
                            
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['payment_status'];
                                $badge = ($status == 'Completed' || $status == 'Accepted') ? 'badge-active' : (($status == 'Pending') ? 'badge-pending' : 'badge-inactive');
                                
                                $pending_balance = ($row['master_p_status'] == 'Fully Paid') ? 0 : ($row['total_price'] - $row['amount']);

                                echo "<tr>
                                    <td class='ps-4'>
                                        <div class='d-flex flex-column justify-content-center'>
                                            <h6 class='mb-0 text-dark' style='font-size: 0.95rem;'>BK ID: #{$row['booking_id']}</h6>
                                            <p class='text-muted mb-0' style='font-size: 0.85rem;'>By: {$row['full_name']}</p>
                                            <p class='text-muted mb-0' style='font-size: 0.85rem;'>Date: {$row['event_date']}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class='text-dark font-weight-bold mb-0' style='font-size: 0.95rem;'>Event: {$row['event_type']}</p>
                                    </td>
                                    <td class='align-middle text-center'>
                                        <p class='text-dark font-weight-bold mb-0'>₹ " . number_format($row['total_price'], 2) . "</p>
                                    </td>
                                    <td class='align-middle text-center'>
                                        <p class='text-success font-weight-bold mb-0'>₹ " . number_format($row['amount'], 2) . "</p>
                                    </td>
                                    <td class='align-middle text-center'>
                                        <p class='text-warning font-weight-bold mb-0'>₹ " . number_format($pending_balance, 2) . "</p>
                                    </td>
                                    <td class='align-middle text-center'>
                                        <p class='font-weight-bold mb-0 text-dark' style='font-size: 0.85rem;'>{$row['payment_method']}</p>
                                        <p class='text-muted mb-0' style='font-size: 0.85rem;'>{$row['transaction_id']}</p>
                                    </td>
                                    <td class='align-middle text-center'>
                                        <span class='badge {$badge}'>{$status}</span>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        ";
                                    
                                if ($status == 'Pending') {
                                    echo "
                                        <form action='../controller/servicep-approve-payment.php' method='POST' class='d-flex gap-2 justify-content-center'>
                                            <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                                            <input type='hidden' name='payment_id' value='{$row['payment_id']}'>
                                            <button type='submit' name='action' value='Approve' class='btn btn-sm btn-success mb-0 py-1' title='Approve'><i class='fas fa-check'></i> Approve</button>
                                            <button type='submit' name='action' value='Reject' class='btn btn-sm btn-danger mb-0 py-1' title='Reject'><i class='fas fa-times'></i> Reject</button>
                                            <input type='hidden' name='approve_payment' value='1'>
                                        </form>
                                    ";
                                } else {
                                    echo "<span class='font-weight-bold text-muted' style='font-size: 0.85rem;'>Action Recorded</span>";
                                }

                                echo "
                                        <form action='../controller/servicep-approve-payment.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this specific payment transaction Record?\");' class='mt-2'>
                                            <input type='hidden' name='payment_id' value='{$row['payment_id']}'>
                                            <button type='submit' name='delete_payment' class='btn btn-xs btn-outline-danger w-100 py-1' style='font-size: 0.7rem;'><i class='fas fa-trash-alt me-1'></i> Delete Entry</button>
                                        </form>
                                    </td>
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
