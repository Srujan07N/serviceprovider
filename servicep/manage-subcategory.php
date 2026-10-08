<?php include 'includes/head.php'; ?>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title">Add Sub Category</h5>
            </div>
            <div class="card-body">
                <form action="../controller/manage-subcategory.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label class="form-label">Parent Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php 
                            $c_stmt = $admin->ret("SELECT * FROM `categories` WHERE `status`='Active'");
                            while($c_row = $c_stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$c_row['category_id']}'>{$c_row['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" name="sub_category_name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Image (Upload)</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="add_subcategory" class="btn btn-primary-custom w-100">Add Sub Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between">
                <h5 class="card-title">Sub Categories List</h5>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table text-center w-100">
                        <thead class="text-primary">
                            <tr>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT s.*, c.category_name FROM `sub_categories` s JOIN `categories` c ON s.category_id=c.category_id ORDER BY s.sub_category_id DESC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $img = !empty($row['image']) ? "../uploads/subcategories/" . $row['image'] : "https://via.placeholder.com/50";
                                $badge = ($row['status'] == 'Active') ? 'badge-active' : 'badge-inactive';
                                echo "<tr>
                                    <td class='align-middle text-sm'>{$row['category_name']}</td>
                                    <td class='align-middle text-sm'>{$row['sub_category_name']}</td>
                                    <td class='align-middle'><img src='{$img}' width='45' height='45' class='rounded' style='object-fit:cover'></td>
                                    <td class='align-middle'><span class='badge {$badge}'>{$row['status']}</span></td>
                                    <td class='align-middle d-flex justify-content-center gap-2'>
                                        <button class='btn btn-sm btn-outline-dark mb-0 py-1 px-3' onclick='editSubcategory(".json_encode($row).")'>Edit</button>
                                        <form action='../controller/manage-subcategory.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this Sub-category?\");' class='m-0'>
                                            <input type='hidden' name='sub_category_id' value='{$row['sub_category_id']}'>
                                            <button type='submit' name='delete_subcategory' class='btn btn-sm btn-danger mb-0 py-1 px-3'>Delete</button>
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

<!-- Edit Sub Category Modal -->
<div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Sub Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../controller/manage-subcategory.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="hidden" name="sub_category_id" id="edit_sub_category_id">
            <div class="form-group mb-3">
                <label class="form-label">Parent Category</label>
                <select name="category_id" id="edit_category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php 
                    $c_stmt2 = $admin->ret("SELECT * FROM `categories` WHERE `status`='Active'");
                    while($c_row2 = $c_stmt2->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$c_row2['category_id']}'>{$c_row2['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Sub Category Name</label>
                <input type="text" name="sub_category_name" id="edit_sub_category_name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Image (Optional - Keep blank to persist old image)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
            </div>
            <div class="form-group mb-4">
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-control" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update_subcategory" class="btn btn-primary-custom">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    function editSubcategory(data) {
        document.getElementById('edit_sub_category_id').value = data.sub_category_id;
        document.getElementById('edit_category_id').value = data.category_id;
        document.getElementById('edit_sub_category_name').value = data.sub_category_name;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_description').value = data.description;
        
        var editModal = new bootstrap.Modal(document.getElementById('editSubCategoryModal'));
        editModal.show();
    }
</script>

<?php include 'includes/foot.php'; ?>
