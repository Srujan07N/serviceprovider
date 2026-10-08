<?php include 'includes/header.php'; ?>

<section class="py-5 bg-main" style="min-height: 80vh;">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="hero-title">Explore <span>Sub Categories</span></h1>
            <p class="text-muted">Discover specialized service catalogs offered directly by our expert vendors.</p>
        </div>

        <div class="row g-4 mt-2">
            <?php
            // Fetch Sub Categories joined with Categories
            $sql = "SELECT sc.*, c.category_name FROM `sub_categories` sc 
                    JOIN `categories` c ON sc.category_id = c.category_id 
                    ORDER BY sc.sub_category_id DESC";
            $stmt = $admin->ret($sql);

            if($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $img_path = !empty($row['image']) ? "uploads/subcategories/" . $row['image'] : "https://via.placeholder.com/800x600.png?text=No+Image+Available";
                    
                    // Status Badge Styling
                    $badgeClass = ($row['status'] == 'Active') ? "badge-Approved" : "badge-Rejected";
                    $statusText = $row['status'];

                    echo "
                    <div class='col-lg-4 col-md-6 mb-4'>
                        <div class='glass-card h-100 d-flex flex-column'>
                            <img src='{$img_path}' alt='Subcategory Image' class='package-img' style='height: 220px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;'>
                            
                            <div class='d-flex justify-content-between align-items-start mb-2'>
                                <span class='badge bg-dark border border-secondary text-white'><i class='fas fa-folder me-1 text-warning'></i> {$row['category_name']}</span>
                                <span class='badge {$badgeClass} border'>{$statusText}</span>
                            </div>
                            
                            <h4 class='text-white mb-3 mt-2' style='font-weight: 700;'>{$row['sub_category_name']}</h4>
                            
                            <p class='text-muted text-sm mb-4 flex-grow-1' style='line-height: 1.6;'>
                                ".nl2br(htmlspecialchars($row['description']))."
                            </p>
                            
                            <div class='mt-auto pt-3 border-top' style='border-color: rgba(255,255,255,0.05) !important;'>
                                <a href='vendors.php?sub_category_id={$row['sub_category_id']}' class='btn btn-outline-light w-100' style='border-radius: 30px; border-color: rgba(255,255,255,0.2); transition: 0.3s;'>
                                   View Vendors <i class='fas fa-users ms-2 fs-6'></i>
                                </a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "
                <div class='col-12 text-center py-5'>
                    <div class='glass-card p-5 mx-auto' style='max-width: 600px;'>
                        <i class='fas fa-box-open fs-1 text-warning mb-3'></i>
                        <h4 class='text-white mb-2'>No Subcategories Found</h4>
                        <p class='text-muted mb-0'>Vendors haven't published any dedicated service subcategories yet.</p>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
