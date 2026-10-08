<?php
$dir = 'c:\xampp\htdocs\serviceprovider\controller';
$files = scandir($dir);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
        $path = $dir . '\\' . $file;
        $content = file_get_contents($path);

        // Pattern for window.location.href
        $content = preg_replace_callback(
            '/echo\s+"<script>alert\(\'([^\']+)\'\);\s*window\.location\.href=\'([^\']+)\';<\/script>";/i',
            function($m) {
                $msg = $m[1];
                $url = $m[2];
                $type = (stripos($msg, 'invalid') !== false || stripos($msg, 'blocked') !== false || stripos($msg, 'login') !== false || stripos($msg, 'sorry') !== false || stripos($msg, 'error') !== false || stripos($msg, 'exists') !== false) ? 'error_message' : 'success_message';
                return '$_SESSION[\'' . $type . '\'] = "' . addslashes($msg) . '"; header("Location: ' . $url . '"); exit;';
            },
            $content
        );

        // Pattern for window.history.back()
        $content = preg_replace_callback(
            '/echo\s+"<script>alert\(\'([^\']+)\'\);\s*window\.history\.back\(\);\<\/script>";/i',
            function($m) {
                $msg = $m[1];
                // Always treat back() alerts as errors
                return '$_SESSION[\'error_message\'] = "' . addslashes($msg) . '"; header("Location: " . $_SERVER[\'HTTP_REFERER\']); exit;';
            },
            $content
        );

        // Raw echo "<script>alert('Login Successful'); window.location... might not have window location in one line
        $content = preg_replace_callback(
            '/alert\(\'([^\']+)\'\);/i',
            function($m) {
                // If it's a raw alert inside a block that does something else, let's target specifically
                return $m[0]; // Wait, let's not break standalone alerts without location.href
            },
            $content
        );
        
        file_put_contents($path, $content);
    }
}
echo "Alerts replaced in controllers\n";
?>
