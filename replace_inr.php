<?php
$files = [
    'c:\xampp\htdocs\serviceprovider\servicep\manage-payments.php',
    'c:\xampp\htdocs\serviceprovider\servicep\index.php',
    'c:\xampp\htdocs\serviceprovider\payment.php',
    'c:\xampp\htdocs\serviceprovider\service.php',
    'c:\xampp\htdocs\serviceprovider\my-bookings.php',
    'c:\xampp\htdocs\serviceprovider\package-details.php',
    'c:\xampp\htdocs\serviceprovider\index.php',
    'c:\xampp\htdocs\serviceprovider\book.php',
    'c:\xampp\htdocs\serviceprovider\admin\manage-payments.php',
    'c:\xampp\htdocs\serviceprovider\admin\index.php',
    'c:\xampp\htdocs\serviceprovider\servicep\manage-bookings.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $content = str_replace("<p class='text-success font-weight-bold mb-0'>$ \" . number_format", "<p class='text-success font-weight-bold mb-0'>₹ \" . number_format", $content);
        $content = str_replace(">$\"", ">₹\"", $content);
        $content = str_replace("'$'.number_format", "'₹'.number_format", $content);
        $content = str_replace("'$\'.number_format", "'₹'.number_format", $content);
        $content = str_replace("'$'.number_format", "'₹'.number_format", $content);
        $content = str_replace("'$'.", "'₹'.", $content); // might be risky
        $content = str_replace('>$<?php echo number_format($t_revenue, 2); ?></h3>', '>₹<?php echo number_format($t_revenue, 2); ?></h3>', $content);
        $content = str_replace('<td class=\'text-end\'>$".number_format', '<td class=\'text-end\'>₹".number_format', $content);
        $content = str_replace('<h2 class="text-white mb-0">$<?php echo number_format', '<h2 class="text-white mb-0">₹<?php echo number_format', $content);
        $content = str_replace('"? <del class=\'text-muted fs-6\'>$".number_format', '"? <del class=\'text-muted fs-6\'>₹".number_format', $content);
        $content = str_replace('</del> $".number_format', '</del> ₹".number_format', $content);
        $content = str_replace(': "$".number_format', ': "₹".number_format', $content);
        $content = str_replace('d-block pb-1\'>$".number_format', 'd-block pb-1\'>₹".number_format', $content);
        $content = str_replace('<h2 class="text-warning mb-0">$<?php echo number_format', '<h2 class="text-warning mb-0">₹<?php echo number_format', $content);
        $content = str_replace("<p class='text-sm font-weight-bold mb-0'>$ \" . number_format", "<p class='text-sm font-weight-bold mb-0'>₹ \" . number_format", $content);
        $content = str_replace('>$<?php echo number_format($total_revenue, 2); ?></h3>', '>₹<?php echo number_format($total_revenue, 2); ?></h3>', $content);
        $content = str_replace('<td>$ {$row[\'total_price\']}<br>', '<td>₹ {$row[\'total_price\']}<br>', $content);
        $content = str_replace('<td>$ {$row["total_price"]}<br>', '<td>₹ {$row["total_price"]}<br>', $content);
        $content = str_replace('$ {$row', '₹ {$row', $content);
        $content = str_replace('>$<?php', '>₹<?php', $content);
        
        // Let's do regex targeted replacements
        $content = preg_replace('/(\>|\"|\')\$\"\.number_format/', '$1₹".number_format', $content);
        $content = preg_replace('/(\>|\"|\')\$ \'\.number_format/', '$1₹ \'.number_format', $content);
        $content = preg_replace('/(\>|\"|\')\$ \" \. number_format/', '$1₹ " . number_format', $content);
        $content = str_replace("'$'.number_format", "'₹'.number_format", $content);
        $content = str_replace('"$".number_format', '"₹".number_format', $content);
        
        file_put_contents($file, $content);
    }
}
echo "Done";
?>
