<?php include 'includes/head.php'; $vid = $_SESSION['vendor_id']; ?>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title">Add Package Listing</h5>
            </div>
            <div class="card-body">
                <form action="../controller/manage-package.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control" required id="cat_select">
                                <option value="">Select Category</option>
                                <?php 
                                $c_stmt = $admin->ret("SELECT * FROM `categories` WHERE `status`='Active'");
                                while($c_row = $c_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$c_row['category_id']}'>{$c_row['category_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sub Category</label>
                            <select name="sub_category_id" class="form-control" required id="sub_cat_select">
                                <option value="">Select Category First</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Package Name</label>
                            <input type="text" name="package_name" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Discount Price ($)</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control" placeholder="Optional">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Max Capacity / Guests</label>
                            <input type="number" name="max_capacity" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Service Duration (hrs)</label>
                            <input type="number" name="service_duration" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Detailed Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Inclusions (What's included)</label>
                            <textarea name="inclusions" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exclusions</label>
                            <textarea name="exclusions" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cancellation Policy</label>
                            <textarea name="cancellation_policy" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Refund Policy</label>
                            <input type="text" name="refund_policy" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Blackout Dates (e.g. 25 Dec, 1 Jan)</label>
                            <input type="text" name="blackout_dates" class="form-control" placeholder="Comma separated">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Available Days (Select Minimum 1)</label>
                            <div>
                                <input type="checkbox" name="available_days[]" value="Mon"> Mon
                                <input type="checkbox" name="available_days[]" value="Tue"> Tue
                                <input type="checkbox" name="available_days[]" value="Wed"> Wed
                                <input type="checkbox" name="available_days[]" value="Thu"> Thu
                                <input type="checkbox" name="available_days[]" value="Fri"> Fri
                                <input type="checkbox" name="available_days[]" value="Sat"> Sat
                                <input type="checkbox" name="available_days[]" value="Sun"> Sun
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Upload Images (Multiple Allowed)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" name="add_package" class="btn btn-primary-custom w-100" style="max-width: 300px;">Publish Package</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Packages -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title">Your Packages</h5>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table text-center w-100">
                        <thead class="text-primary">
                            <tr>
                                <th>Package Name & Pricing</th>
                                <th>Target Capacity</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Listing Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT * FROM `packages` WHERE `vendor_id`='$vid' ORDER BY `package_id` DESC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $badge = ($row['status'] == 'Active') ? 'badge-active' : 'badge-inactive';
                                $discount = !empty($row['discount_price']) ? "<br><span class='text-success-custom ' style='font-size:0.8rem;'>Discounted: $".$row['discount_price']."</span>" : "";
                                
                                echo "<tr>
                                    <td>
                                        <strong>{$row['package_name']}</strong><br>
                                        <span class='text-muted' style='font-size: 0.85rem;'>Total Value: ₹{$row['price']}</span> {$discount}<br>
                                        <span class='text-success' style='font-size: 0.85rem;'><i class='fas fa-shield-alt me-1'></i>Advance Req: ₹" . number_format($row['price']/2, 2) . " (50%)</span>
                                    </td>
                                    <td class='align-middle'>{$row['max_capacity']} Guests</td>
                                    <td class='align-middle'>{$row['service_duration']} Hrs</td>
                                    <td class='align-middle'><span class='badge {$badge}'>{$row['status']}</span></td>
                                    <td class='align-middle text-muted' style='font-size:0.85rem;'>".date('d M Y', strtotime($row['created_at']))."</td>
                                    <td class='align-middle'>
                                        <div class='d-flex flex-column gap-2'>
                                            <button class='btn btn-sm btn-outline-dark mb-0' onclick='editPackage(".htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').")'>Edit</button>
                                            <form action='../controller/manage-package.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this specific Package?\");' class='m-0'>
                                                <input type='hidden' name='package_id' value='{$row['package_id']}'>
                                                <button type='submit' name='delete_package' class='btn btn-sm btn-danger w-100 mb-0'>Delete</button>
                                            </form>
                                        </div>
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

<!-- Edit Package Modal -->
<div class="modal fade" id="editPackageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Package Configuration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../controller/manage-package.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="hidden" name="package_id" id="edit_package_id">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required id="edit_cat_select">
                        <option value="">Select Category</option>
                        <?php 
                        $c_stmt2 = $admin->ret("SELECT * FROM `categories` WHERE `status`='Active'");
                        while($c_row2 = $c_stmt2->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$c_row2['category_id']}'>{$c_row2['category_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Sub Category</label>
                    <select name="sub_category_id" class="form-control" required id="edit_sub_cat_select">
                        <option value="">Select Category First</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Package Name</label>
                    <input type="text" name="package_name" id="edit_package_name" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Discount Price ($)</label>
                    <input type="number" step="0.01" name="discount_price" id="edit_discount_price" class="form-control" placeholder="Optional">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Max Capacity / Guests</label>
                    <input type="number" name="max_capacity" id="edit_max_capacity" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Service Duration (hrs)</label>
                    <input type="number" name="service_duration" id="edit_service_duration" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Detailed Description</label>
                    <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Inclusions (What's included)</label>
                    <textarea name="inclusions" id="edit_inclusions" class="form-control" rows="3" required></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Exclusions</label>
                    <textarea name="exclusions" id="edit_exclusions" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cancellation Policy</label>
                    <textarea name="cancellation_policy" id="edit_cancellation_policy" class="form-control" rows="3" required></textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Refund Policy</label>
                    <input type="text" name="refund_policy" id="edit_refund_policy" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Blackout Dates</label>
                    <input type="text" name="blackout_dates" id="edit_blackout_dates" class="form-control" placeholder="Comma separated">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Available Days</label>
                    <div id="edit_days_container">
                        <input type="checkbox" name="available_days[]" value="Mon" class="edit-day-chk"> Mon
                        <input type="checkbox" name="available_days[]" value="Tue" class="edit-day-chk"> Tue
                        <input type="checkbox" name="available_days[]" value="Wed" class="edit-day-chk"> Wed
                        <input type="checkbox" name="available_days[]" value="Thu" class="edit-day-chk"> Thu
                        <input type="checkbox" name="available_days[]" value="Fri" class="edit-day-chk"> Fri
                        <input type="checkbox" name="available_days[]" value="Sat" class="edit-day-chk"> Sat
                        <input type="checkbox" name="available_days[]" value="Sun" class="edit-day-chk"> Sun
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Upload Additional/New Images (Optional)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update_package" class="btn btn-warning-custom">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editPackage(data) {
    document.getElementById('edit_package_id').value = data.package_id;
    document.getElementById('edit_cat_select').value = data.category_id;
    
    // Trigger subcategory load manually
    let subCatSelect = document.getElementById('edit_sub_cat_select');
    subCatSelect.innerHTML = '<option value="">Loading...</option>';
    fetch('../controller/get-subcategories.php?category_id=' + data.category_id)
        .then(response => response.text())
        .then(options => {
            subCatSelect.innerHTML = options;
            subCatSelect.value = data.sub_category_id; // Select the correct matching value
        });

    document.getElementById('edit_package_name').value = data.package_name;
    document.getElementById('edit_price').value = data.price;
    document.getElementById('edit_discount_price').value = data.discount_price || '';
    document.getElementById('edit_max_capacity').value = data.max_capacity;
    document.getElementById('edit_service_duration').value = data.service_duration;
    document.getElementById('edit_description').value = data.description;
    document.getElementById('edit_inclusions').value = data.inclusions;
    document.getElementById('edit_exclusions').value = data.exclusions;
    document.getElementById('edit_cancellation_policy').value = data.cancellation_policy;
    document.getElementById('edit_refund_policy').value = data.refund_policy;
    document.getElementById('edit_blackout_dates').value = data.blackout_dates || '';
    document.getElementById('edit_status').value = data.status;

    // Reset all checkboxes 
    let checkboxes = document.querySelectorAll('.edit-day-chk');
    checkboxes.forEach(cb => cb.checked = false);

    // Re-check relevant boxes
    if(data.available_days) {
        let days = data.available_days.split(',');
        checkboxes.forEach(cb => {
            if(days.includes(cb.value)) {
                cb.checked = true;
            }
        });
    }

    var editModal = new bootstrap.Modal(document.getElementById('editPackageModal'));
    editModal.show();
}

document.getElementById('edit_cat_select').addEventListener('change', function() {
    let catId = this.value;
    let subCatSelect = document.getElementById('edit_sub_cat_select');
    if (catId) {
        subCatSelect.innerHTML = '<option value="">Loading...</option>';
        fetch('../controller/get-subcategories.php?category_id=' + catId)
        .then(response => response.text())
        .then(data => { subCatSelect.innerHTML = data; })
        .catch(error => { subCatSelect.innerHTML = '<option value="">Error</option>'; });
    } else {
        subCatSelect.innerHTML = '<option value="">Select Category First</option>';
    }
});

document.getElementById('cat_select').addEventListener('change', function() {
    let catId = this.value;
    let subCatSelect = document.getElementById('sub_cat_select');
    
    if (catId) {
        subCatSelect.innerHTML = '<option value="">Loading...</option>';
        fetch('../controller/get-subcategories.php?category_id=' + catId)
        .then(response => response.text())
        .then(data => {
            subCatSelect.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching subcategories:', error);
            subCatSelect.innerHTML = '<option value="">Error Loading Subcategories</option>';
        });
    } else {
        subCatSelect.innerHTML = '<option value="">Select Category First</option>';
    }
});
</script>

<?php include 'includes/foot.php'; ?>
