<?php include 'includes/head.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between">
                <h6 class="mb-0">Manage Vendors</h6>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7 text-start ps-4">Vendor details</th>
                                <th class="text-secondary opacity-7">Contact / PAN & GST</th>
                                <th class="text-secondary opacity-7 text-center">Service Area</th>
                                <th class="text-secondary opacity-7 text-center">Status</th>
                                <th class="text-secondary opacity-7 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT * FROM `vendors` ORDER BY `vendor_id` DESC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $img = !empty($row['profile_image']) ? "../uploads/vendors/profiles/" . $row['profile_image'] : "https://ui-avatars.com/api/?name=".urlencode($row['business_name']);
                                $status = $row['status'];
                                $badge = ($status == 'Approved') ? 'badge-active' : (($status == 'Pending') ? 'badge-pending' : 'badge-inactive');
                                
                                echo "<tr>
                                    <td class='ps-4'>
                                        <div class='d-flex px-2 py-1'>
                                            <div><img src='{$img}' class='me-3 rounded-circle' width='48' height='48' alt='vendor'></div>
                                            <div class='d-flex flex-column justify-content-center'>
                                                <h6 class='mb-0 text-sm'>{$row['business_name']}</h6>
                                                <p class='text-xs text-secondary mb-0'>Owner: {$row['owner_name']}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class='text-xs font-weight-bold mb-0'>{$row['email']} | {$row['phone_number']}</p>
                                        <p class='text-xs text-secondary mb-0'>GST: {$row['gst_number']} | PAN: {$row['pan_number']}</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <p class='text-xs font-weight-bold mb-0'>{$row['city']}, {$row['state']}</p>
                                        <p class='text-xs font-weight-bold mb-0'>Area: {$row['service_area']}</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <span class='badge {$badge}'>{$status}</span>
                                    </td>
                                    <td class='align-middle text-center'>
                                        <button class='btn btn-sm btn-primary-custom mb-0 py-1' onclick='updateStatus({$row['vendor_id']}, \"{$status}\")'>Update</button>
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

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-header">
                <h5 class="modal-title">Update Vendor Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controller/manage-vendor.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="vendor_id" id="modal_vendor_id">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="modal_status" class="form-select" required onchange="toggleRejection(this.value)">
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Blocked">Blocked</option>
                        </select>
                    </div>
                    <div class="mb-3" id="rejection_div" style="display:none;">
                        <label class="form-label" style="color:red;">Rejection Reason (Required if Rejected)</label>
                        <textarea class="form-control" name="rejection_reason" id="modal_reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_vendor_status" class="btn btn-primary-custom">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateStatus(id, current_status) {
        document.getElementById('modal_vendor_id').value = id;
        document.getElementById('modal_status').value = current_status;
        toggleRejection(current_status);
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    }
    
    function toggleRejection(status) {
        if(status === 'Rejected') {
            document.getElementById('rejection_div').style.display = 'block';
            document.getElementById('modal_reason').setAttribute('required', 'true');
        } else {
            document.getElementById('rejection_div').style.display = 'none';
            document.getElementById('modal_reason').removeAttribute('required');
        }
    }
</script>

<?php include 'includes/foot.php'; ?>
