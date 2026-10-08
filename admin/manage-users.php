<?php include 'includes/head.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manage Users</h6>
                
                <form class="d-flex align-items-center gap-2 m-0" action="" method="GET">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Name..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="max-width: 200px;">
                    <button type="submit" class="btn btn-sm btn-dark mb-0">Search</button>
                </form>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7 text-start ps-4">User Info</th>
                                <th class="text-secondary opacity-7">Contact / Address</th>
                                <th class="text-secondary opacity-7 text-center">Role</th>
                                <th class="text-secondary opacity-7 text-center">Status</th>
                                <th class="text-secondary opacity-7 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search_query = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = $_GET['search'];
                                $search_query = " AND (`full_name` LIKE '%$search%' OR `email` LIKE '%$search%')";
                            }

                            $stmt = $admin->ret("SELECT * FROM `users` WHERE 1 $search_query ORDER BY `user_id` DESC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['status'];
                                $badge = ($status == 'Active') ? 'badge-active' : 'badge-inactive';
                                
                                echo "<tr>
                                    <td class='ps-4'>
                                        <div class='d-flex flex-column justify-content-center'>
                                            <h6 class='mb-0 text-sm'>{$row['full_name']}</h6>
                                            <p class='text-xs text-secondary mb-0'>Reg: {$row['created_at']}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class='text-xs font-weight-bold mb-0'>{$row['email']} | {$row['phone_number']}</p>
                                        <p class='text-xs text-secondary mb-0'>{$row['city']}, {$row['state']}</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <span class='badge badge-dark'>{$row['role']}</span>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <span class='badge {$badge}'>{$status}</span>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        <form action='../controller/admin-manage-users.php' method='POST' class='m-0'>
                                            <input type='hidden' name='user_id' value='{$row['user_id']}'>
                                            <select name='status' class='form-select form-select-sm d-inline-block w-auto py-1' onchange='this.form.submit()'>
                                                <option value='Active' ".($status=='Active'?'selected':'').">Active</option>
                                                <option value='Blocked' ".($status=='Blocked'?'selected':'').">Block</option>
                                            </select>
                                            <input type='hidden' name='update_user_status' value='1'>
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
