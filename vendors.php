<?php 
include 'includes/header.php'; 

$sub_category_id = isset($_GET['sub_category_id']) ? $_GET['sub_category_id'] : '';
$subcat_name = "Selected Subcategory";

if (!empty($sub_category_id)) {
    $stmt = $admin->ret("SELECT sub_category_name FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row) $subcat_name = $row['sub_category_name'];
}
?>

<section class="py-5 bg-main" style="min-height: 80vh;">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="hero-title">Vendors for <span><?php echo htmlspecialchars($subcat_name); ?></span></h1>
            <p class="text-muted">Choose an expert vendor to view their specific service packages.</p>
        </div>

      <style>
/* Glass Card Improved */
.glass-card {
    background: rgba(255, 255, 255, 0.06);
    border-radius: 20px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
    color: #fff;
}

.glass-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

/* Fix text visibility */
.text-muted {
    color: #d1d1d1 !important;
    font-size: 14px;
}

.text-sm {
    font-size: 14px;
}

/* Heading */
.vendor-title {
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
}

/* Button styling */
.btn-warning-custom {
    background: linear-gradient(135deg, #f7b733, #fc4a1a);
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 10px;
}

.btn-warning-custom:hover {
    opacity: 0.9;
}

/* Selected vendor highlight */
.border-warning {
    border: 2px solid #ffc107 !important;
}

.shadow-orange-glow {
    box-shadow: 0 0 20px rgba(255, 193, 7, 0.4);
}

/* Avatar styling */
.vendor-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.2);
}

/* Empty state */
.empty-box {
    text-align: center;
    padding: 40px;
}
</style>


<div class="row g-4 mt-2">
<?php
// Fetch distinct vendors who have active packages in this subcategory
$sql = "SELECT DISTINCT v.* FROM `vendors` v 
        JOIN `packages` p ON v.vendor_id = p.vendor_id 
        WHERE p.sub_category_id = '$sub_category_id' AND p.status='Active' AND v.status='Approved'";

$stmt = $admin->ret($sql);

if($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $img_path = "https://ui-avatars.com/api/?name=".urlencode($row['business_name'])."&background=random&color=fff&size=128";
        $is_selected = (isset($_GET['vendor_id']) && $_GET['vendor_id'] == $row['vendor_id']) ? 'border-warning shadow-orange-glow' : '';

        echo "
        <div class='col-lg-4 col-md-6'>
            <div class='glass-card h-100 d-flex flex-column text-center p-4 {$is_selected}'>
                
                <img src='{$img_path}' alt='Vendor' class='rounded-circle mx-auto mb-3 shadow vendor-img'>
                
                <h4 class='vendor-title mb-2'>{$row['business_name']}</h4>
                
                <p class='text-muted mb-2'>
                    <i class='fas fa-envelope text-warning me-1'></i>
                    {$row['email']}
                </p>
                
                <p class='text-muted mb-4 flex-grow-1'>
                    <i class='fas fa-phone text-info me-1'></i>
                    {$row['phone_number']}
                </p>
                
                <div class='mt-auto pt-3 border-top' style='border-color: rgba(255,255,255,0.1);'>
                    <a href='vendors.php?sub_category_id={$sub_category_id}&vendor_id={$row['vendor_id']}#results' 
                       class='btn btn-warning-custom w-100 rounded-pill'>
                       Select Expert 
                       <i class='fas fa-chevron-down ms-2'></i>
                    </a>
                </div>
            </div>
        </div>";
    }
} else {
    echo "
    <div class='col-12'>
        <div class='glass-card empty-box mx-auto' style='max-width: 500px;'>
            <i class='fas fa-store-slash fs-1 text-warning mb-3'></i>
            <h4 class='text-white mb-2'>No Vendors Found</h4>
            <p class='text-muted mb-0'>
                No approved vendors currently offer active packages under this subcategory.
            </p>
        </div>
    </div>";
}
?>
</div>

        <?php if(isset($_GET['vendor_id'])): ?>
            <div id="results" class="mt-5 pt-5 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                <?php 
                $vid = $_GET['vendor_id'];
                $vname_stmt = $admin->ret("SELECT business_name FROM `vendors` WHERE `vendor_id`='$vid'");
                $vname = $vname_stmt->fetch(PDO::FETCH_ASSOC)['business_name'];
                ?>
                <div class="text-center mb-5">
                    <h2 class="text-white">Active Packages by <span class="text-warning"><?php echo htmlspecialchars($vname); ?></span></h2>
                    <p class="text-muted">Choose your preferred service package from this expert.</p>
                </div>

                <div class="row g-4">
                    <?php 
                    $p_sql = "SELECT p.*, s.sub_category_name 
                            FROM `packages` p 
                            JOIN `sub_categories` s ON p.sub_category_id = s.sub_category_id 
                            WHERE p.vendor_id='$vid' AND p.status='Active'";
                    $p_stmt = $admin->ret($p_sql);
                    
                    while($p_row = $p_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $p_img_stmt = $admin->ret("SELECT image_path FROM `package_images` WHERE `package_id`='{$p_row['package_id']}' LIMIT 1");
                        $p_img = $p_img_stmt->fetch(PDO::FETCH_ASSOC);
                        $p_img_path = $p_img ? "uploads/packages/".$p_img['image_path'] : "assets/img/package-placeholder.webp";
                        
                        echo "
                        <div class='col-lg-4 col-md-6 mb-4'>
                            <div class='glass-card h-100 overflow-hidden d-flex flex-column'>
                                <div class='position-relative overflow-hidden' style='height: 200px;'>
                                    <img src='{$p_img_path}' class='w-100 h-100' style='object-fit:cover;' alt='Package'>
                                    <div class='position-absolute top-0 end-0 m-3'>
                                        <span class='badge bg-warning text-dark px-3 py-2' style='border-radius: 20px; font-weight: 700;'>₹" . number_format($p_row['price'], 2) . "</span>
                                    </div>
                                </div>
                                <div class='p-4 d-flex flex-column flex-grow-1'>
                                    <div class='d-flex justify-content-between align-items-center mb-3'>
                                        <span class='text-muted text-sm'><i class='fas fa-users me-1'></i> Up to {$p_row['max_capacity']} Pax</span>
                                        <span class='text-muted text-sm'><i class='fas fa-clock me-1'></i> {$p_row['service_duration']} Hrs</span>
                                    </div>
                                    <h5 class='text-white mb-2' style='font-weight: 700;'>{$p_row['package_name']}</h5>
                                    <p class='text-muted text-sm mb-4' style='display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;'>{$p_row['description']}</p>
                                    
                                    <div class='mt-auto pt-3 border-top d-flex gap-2' style='border-color: rgba(255,255,255,0.05) !important;'>
                                        <a href='package-details.php?id={$p_row['package_id']}' class='btn btn-outline-light flex-grow-1' style='border-radius: 30px; border-color: rgba(255,255,255,0.1);'>Details</a>
                                        <a href='book.php?id={$p_row['package_id']}' class='btn btn-warning-custom flex-grow-1' style='border-radius: 30px;'>Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
