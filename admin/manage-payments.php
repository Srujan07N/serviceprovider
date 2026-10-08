<?php include 'includes/head.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h6 class="mb-0">Advance Payments & Bookings Verification</h6>
                <p class="text-sm">Verify the payment from Vendor bookings before approving.</p>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-secondary text-start ps-4">Booking Info</th>
                                <th class="text-secondary text-start">Vendor & Service</th>
                                <th class="text-secondary text-center">Total Value</th>
                                <th class="text-secondary text-center">Advance Paid</th>
                                <th class="text-secondary text-center">Pending Balance</th>
                                <th class="text-secondary text-center">PG / TXN Id</th>
                                <th class="text-secondary text-center">Status</th>
                                <th class="text-secondary text-center" style="min-width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Joining multiple tables to get rich details
                            $query = "SELECT p.*, b.event_date, b.event_type, b.status as booking_status, b.total_price, b.payment_status as master_p_status, u.full_name, v.business_name 
                                      FROM `payments` p 
                                      JOIN `bookings` b ON p.booking_id = b.booking_id 
                                      JOIN `users` u ON p.user_id = u.user_id 
                                      JOIN `vendors` v ON p.vendor_id = v.vendor_id 
                                      ORDER BY p.payment_id DESC";
                            $stmt = $admin->ret($query);
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['payment_status'];
                                $badge = ($status == 'Completed' || $status == 'Accepted') ? 'badge-active' : (($status == 'Pending') ? 'badge-pending' : 'badge-inactive');
                                
                                $pending_balance = ($row['master_p_status'] == 'Fully Paid') ? 0 : ($row['total_price'] - $row['amount']);

                                echo "<tr>
                                    <td class='ps-4'>
                                        <div class='d-flex flex-column justify-content-center'>
                                            <h6 class='mb-0 text-sm'>BK ID: #{$row['booking_id']}</h6>
                                            <p class='text-xs text-secondary mb-0'>By: {$row['full_name']}</p>
                                            <p class='text-xs text-secondary mb-0'>Date: {$row['event_date']}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class='text-sm font-weight-bold mb-0'>{$row['business_name']}</p>
                                        <p class='text-xs text-secondary mb-0'>Event: {$row['event_type']}</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <p class='text-sm text-dark font-weight-bold mb-0'>₹ " . number_format($row['total_price'], 2) . "</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <p class='text-sm text-success font-weight-bold mb-0'>₹ " . number_format($row['amount'], 2) . "</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <p class='text-sm text-warning font-weight-bold mb-0'>₹ " . number_format($pending_balance, 2) . "</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <p class='text-xs font-weight-bold mb-0'>{$row['payment_method']}</p>
                                        <p class='text-xs text-secondary mb-0'>{$row['transaction_id']}</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <span class='badge {$badge}'>{$status}</span>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        ";
                                    
                                if ($status == 'Pending') {
                                    echo "
                                        <form action='../controller/admin-approve-payment.php' method='POST' class='d-flex gap-2 justify-content-center'>
                                            <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                                            <input type='hidden' name='payment_id' value='{$row['payment_id']}'>
                                            <button type='submit' name='action' value='Approve' class='btn btn-sm btn-success mb-0 py-1' title='Approve'><i class='fas fa-check'></i></button>
                                            <button type='submit' name='action' value='Reject' class='btn btn-sm btn-danger mb-0 py-1' title='Reject'><i class='fas fa-times'></i></button>
                                            <input type='hidden' name='approve_payment' value='1'>
                                        </form>
                                    ";
                                } else {
                                    echo "<span class='text-xs font-weight-bold'>Action Recorded</span>";
                                }

                                echo "
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
