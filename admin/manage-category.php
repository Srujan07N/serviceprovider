<?php include 'includes/head.php'; ?>

<div class="row">
    <!-- Add Category Form -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h6 class="mb-0">Add New Category</h6>
            </div>
            <div class="card-body">
                <form action="../controller/manage-category.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" class="form-control" name="display_order" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image (Optional)</label>
                        <input type="file" class="form-control" name="category_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (Optional)</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary-custom w-100">Add Category</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories List -->
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h6 class="mb-0">Categories List</h6>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 text-center w-100">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7">ID</th>
                                <th class="text-secondary opacity-7 text-start">Category Name</th>
                                <th class="text-secondary opacity-7 text-center">Image</th>
                                <th class="text-secondary opacity-7 text-center">Order</th>
                                <th class="text-secondary opacity-7 text-center">Status</th>
                                <th class="text-secondary opacity-7 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT * FROM `categories` ORDER BY `display_order` ASC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $img = !empty($row['category_image']) ? "../uploads/categories/" . $row['category_image'] : "https://via.placeholder.com/50";
                                $badge = ($row['status'] == 'Active') ? 'badge-active' : 'badge-inactive';
                                echo "<tr>
                                    <td><p class='text-xs font-weight-bold mb-0'>{$row['category_id']}</p></td>
                                    <td class='text-start'><p class='text-xs font-weight-bold mb-0'>{$row['category_name']}</p></td>
                                    <td><img src='{$img}' alt='img' class='rounded' width='50' height='50' style='object-fit: cover;'></td>
                                    <td><p class='text-xs font-weight-bold mb-0'>{$row['display_order']}</p></td>
                                    <td><span class='badge {$badge}'>{$row['status']}</span></td>
                                    <td class='d-flex justify-content-center gap-2'>
                                        <button class='btn btn-sm btn-outline-dark mb-0' onclick='editCategory(".json_encode($row).")'>Edit</button>
                                        <form action='../controller/manage-category.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this category?\");'>
                                            <input type='hidden' name='category_id' value='{$row['category_id']}'>
                                            <button type='submit' name='delete_category' class='btn btn-sm btn-danger mb-0'>Delete</button>
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

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../controller/manage-category.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="hidden" name="category_id" id="edit_category_id">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" class="form-control" name="category_name" id="edit_category_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status" id="edit_status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Display Order</label>
                <input type="number" class="form-control" name="display_order" id="edit_display_order">
            </div>
            <div class="mb-3">
                <label class="form-label">Image (Optional - Keep blank to persist old image)</label>
                <input type="file" class="form-control" name="category_image" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Description (Optional)</label>
                <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update_category" class="btn btn-primary-custom">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    function editCategory(data) {
        document.getElementById('edit_category_id').value = data.category_id;
        document.getElementById('edit_category_name').value = data.category_name;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_display_order').value = data.display_order;
        document.getElementById('edit_description').value = data.description;
        
        var editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        editModal.show();
    }
</script>

<?php include 'includes/foot.php'; ?>
