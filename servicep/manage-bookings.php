<?php include 'includes/head.php'; $vid = $_SESSION['vendor_id']; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title">Event Bookings Tracking</h5>
                <p class="card-category">Accept or Reject your upcoming service appointments</p>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table w-100">
                        <thead class="text-primary">
                            <tr>
                                <th class="ps-4">Booking Specs (Client)</th>
                                <th>Package & Requests</th>
                                <th>Date & Timing</th>
                                <th>Cost Status</th>
                                <th>Action / Overall Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT b.*, u.full_name, u.phone_number, p.package_name FROM `bookings` b JOIN `users` u ON b.user_id = u.user_id JOIN `packages` p ON b.package_id = p.package_id WHERE b.vendor_id='$vid' ORDER BY b.booking_id DESC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['status'];
                                $pstats = $row['payment_status'];
                                $badge = ($status == 'Completed' || $status == 'Confirmed') ? 'badge-active' : (($status == 'Rejected' || $status == 'Cancelled') ? 'badge-inactive' : 'badge-pending');
                                
                                // Clean background class for "Advance Paid" status
                                if ($status == 'Advance Paid') $badge = 'badge-active bg-info';
                                
                                echo "<tr>
                                    <td class='ps-4'>
                                        <strong>{$row['full_name']}</strong><br>
                                        <span class='text-muted' style='font-size:0.85rem;'>{$row['phone_number']}</span><br>
                                        <span class='text-muted' style='font-size:0.85rem;'>Guests: {$row['number_of_guests']}</span>
                                    </td>
                                    <td>
                                        {$row['package_name']}<br>
                                        <span class='text-info-custom' style='font-size:0.85rem;'>{$row['event_type']}</span>
                                        <p class='text-muted mt-1 mb-0' style='font-size:0.8rem;'><i>{$row['special_requirements']}</i></p>
                                    </td>
                                    <td>
                                        <span class='badge badge-dark'>{$row['event_date']}</span><br>
                                        <span class='text-muted' style='font-size:0.85rem;'>{$row['start_time']} - {$row['end_time']}</span>
                                    </td>
                                    <td>
                                        <span style='font-size: 0.95rem; font-weight:600;'>Total: ₹{$row['total_price']}</span><br>
                                        <span class='text-success' style='font-size: 0.85rem;'><i class='fas fa-check-circle me-1'></i>Adv Paid: ₹" . number_format($row['total_price']/2, 2) . "</span><br>
                                        <span class='text-warning' style='font-size: 0.85rem;'><i class='fas fa-clock me-1'></i>Balance: ₹" . number_format($row['total_price']/2, 2) . "</span><br>
                                        <small class='text-muted'>P_Status: {$row['payment_status']}</small>
                                    </td>
                                    <td>
                                        <div class='mb-2'><span class='badge {$badge}'>{$status}</span></div>";

                                if ($status == 'Pending' || $status == 'Payment Pending') {
                                    echo "
                                        <form action='../controller/servicep-manage-booking.php' method='POST' class='d-flex gap-2' id='form_{$row['booking_id']}'>
                                            <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                                            <input type='hidden' name='update_booking' value='1'>
                                            
                                            <select name='status' class='form-select form-select-sm w-auto' required onchange='tReason(this.value, {$row['booking_id']})'>
                                                <option value=''>Choose</option>
                                                <option value='Approved'>Approve</option>
                                                <option value='Rejected'>Reject</option>
                                            </select>
                                            <textarea name='rejection_reason' id='reason_{$row['booking_id']}' class='form-control form-control-sm' placeholder='Reason' style='display:none;'></textarea>
                                            <button type='submit' class='btn btn-sm btn-primary-custom px-3 py-1 m-0'>Go</button>
                                        </form>
                                    ";
                                } else if ($status == 'Advance Paid') {
                                    echo "
                                        <form action='../controller/servicep-manage-booking.php' method='POST' class='m-0'>
                                            <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                                            <input type='hidden' name='update_booking' value='1'>
                                            <input type='hidden' name='status' value='Completed'>
                                            <button type='submit' class='btn btn-sm btn-success px-3 py-1 m-0 w-100' title='Complete Order Step 8'><i class='fas fa-check-double'></i> Mark as Completed</button>
                                        </form>";
                                }
 
                                echo "
                                    <form action='../controller/servicep-manage-booking.php' method='POST' onsubmit='return confirm(\"Are you sure you want to permanently delete this booking record?\");' class='mt-2'>
                                        <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                                        <button type='submit' name='delete_booking' class='btn btn-sm btn-outline-danger w-100 py-1' style='font-size:0.75rem;'><i class='fas fa-trash-alt me-1'></i> Delete Record</button>
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

<script>
function tReason(val, bid) {
    if(val === 'Rejected') {
        document.getElementById('reason_' + bid).style.display = 'block';
        document.getElementById('reason_' + bid).setAttribute('required', 'true');
    } else {
        document.getElementById('reason_' + bid).style.display = 'none';
        document.getElementById('reason_' + bid).removeAttribute('required');
    }
}
</script>

<?php include 'includes/foot.php'; ?>
