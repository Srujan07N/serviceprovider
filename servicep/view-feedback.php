<?php include 'includes/head.php'; $vid = $_SESSION['vendor_id']; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <h5 class="card-title">Customer Feedback & Ratings</h5>
                <p class="card-category">See what clients say about your services and packages.</p>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table w-100">
                        <thead class="text-primary">
                            <tr>
                                <th class="ps-4">Reviewer</th>
                                <th>Booking Info</th>
                                <th class="text-center">Rating</th>
                                <th style="min-width: 250px;">Review Provided</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $admin->ret("SELECT f.*, u.full_name, p.package_name FROM `feedbacks` f JOIN `users` u ON f.user_id = u.user_id LEFT JOIN `packages` p ON f.package_id = p.package_id WHERE f.vendor_id='$vid' ORDER BY f.feedback_id DESC");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $user = ($row['is_anonymous'] == 1) ? 'Anonymous User' : $row['full_name'];
                                $pack = !empty($row['package_name']) ? $row['package_name'] : 'N/A';
                                
                                $stars = "";
                                for($i=1; $i<=5; $i++){
                                    if($i <= $row['rating']) $stars .= "<i class='fas fa-star text-warning'></i> ";
                                    else $stars .= "<i class='far fa-star text-muted'></i> ";
                                }

                                $flag_span = ($row['is_flagged'] == 1) ? "<br><span class='badge badge-inactive mt-1'>Flagged by Admin</span>" : "";

                                echo "<tr>
                                    <td class='ps-4'><strong>{$user}</strong></td>
                                    <td>
                                        BK_ID: {$row['booking_id']}<br>
                                        <span class='text-muted' style='font-size:0.85rem;'>{$pack}</span>
                                    </td>
                                    <td class='text-center'>{$stars}</td>
                                    <td>
                                        <strong>{$row['review_title']}</strong><br>
                                        <p class='text-muted mb-0' style='font-size:0.85rem;'>{$row['review_comment']}</p>
                                        {$flag_span}
                                    </td>
                                    <td class='text-muted' style='font-size:0.85rem;'>".date('d M Y', strtotime($row['created_at']))."</td>
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
