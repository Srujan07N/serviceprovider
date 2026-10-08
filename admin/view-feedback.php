<?php include 'includes/head.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h6 class="mb-0">Platform Feedbacks and Reviews</h6>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-secondary text-start ps-4">Review Info</th>
                                <th class="text-secondary text-center">Rating</th>
                                <th class="text-secondary text-start">Comment</th>
                                <th class="text-secondary text-center">Flag Status</th>
                                <th class="text-secondary text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT f.*, u.full_name, v.business_name 
                                      FROM `feedbacks` f 
                                      JOIN `users` u ON f.user_id = u.user_id 
                                      LEFT JOIN `vendors` v ON f.vendor_id = v.vendor_id 
                                      ORDER BY f.feedback_id DESC";
                            $stmt = $admin->ret($query);
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $user = ($row['is_anonymous'] == 1) ? 'Anonymous User' : $row['full_name'];
                                $vendor_target = !empty($row['business_name']) ? "Vendor: ".$row['business_name'] : "General Platform";
                                
                                // Star rendering
                                $stars = "";
                                for($i=1; $i<=5; $i++){
                                    if($i <= $row['rating']) $stars .= "<i class='fas fa-star text-warning'></i> ";
                                    else $stars .= "<i class='far fa-star text-secondary'></i> ";
                                }

                                $flagged = $row['is_flagged'] == 1;

                                echo "<tr>
                                    <td class='ps-4'>
                                        <div class='d-flex flex-column justify-content-center'>
                                            <h6 class='mb-0 text-sm'>{$user}</h6>
                                            <p class='text-xs text-secondary mb-0'>{$vendor_target}</p>
                                            <p class='text-xs text-secondary mb-0'>Date: {$row['created_at']}</p>
                                        </div>
                                    </td>
                                    <td class='align-middle text-center text-sm'>
                                        {$stars}
                                    </td>
                                    <td class='align-middle text-start text-sm' style='max-width:300px; white-space: normal;'>
                                        <span class='font-weight-bold d-block mb-1'>{$row['review_title']}</span>
                                        <p class='text-xs mb-0 text-secondary'>{$row['review_comment']}</p>
                                    </td>
                                    <td class='align-middle text-center text-sm'>";
                                        if($flagged) {
                                            echo "<span class='badge badge-inactive'>Flagged (Inappropriate)</span>";
                                        } else {
                                            echo "<span class='badge badge-active'>Clean</span>";
                                        }
                                echo "</td>
                                    <td class='align-middle text-center text-sm'>";
                                    if (!$flagged) {
                                        echo "
                                        <form action='../controller/admin-flag-feedback.php' method='POST' class='m-0'>
                                            <input type='hidden' name='feedback_id' value='{$row['feedback_id']}'>
                                            <button type='submit' name='flag_feedback' class='btn btn-sm btn-outline-danger mb-0 py-1' title='Flag as inappropriate'><i class='fas fa-flag'></i> Flag</button>
                                        </form>";
                                    } else {
                                        echo "<button class='btn btn-sm btn-secondary mb-0 py-1' disabled>Flagged</button>";
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
