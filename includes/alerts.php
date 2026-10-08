<?php
if(isset($_SESSION['success_message'])){
    echo '<div class="alert alert-success alert-dismissible fade show text-white fw-bold shadow-lg border-0" role="alert" style="position:fixed; top:20px; right:20px; z-index:9999; background: rgba(16, 185, 129, 0.9); backdrop-filter: blur(10px);">
            <i class="fas fa-check-circle me-2"></i> ' . $_SESSION['success_message'] . '
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['success_message']);
}

if(isset($_SESSION['error_message'])){
    echo '<div class="alert alert-danger alert-dismissible fade show text-white fw-bold shadow-lg border-0" role="alert" style="position:fixed; top:20px; right:20px; z-index:9999; background: rgba(220, 38, 38, 0.9); backdrop-filter: blur(10px);">
            <i class="fas fa-exclamation-triangle me-2"></i> ' . $_SESSION['error_message'] . '
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['error_message']);
}
?>
<script>
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Apply fade out transition
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = "0";
            // Remove from DOM after fade out completes
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 2000);
</script>
