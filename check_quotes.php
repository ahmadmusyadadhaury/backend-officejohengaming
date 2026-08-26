<?php

$dir = __DIR__ . '/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($files as $file) {
    if ($file->getExtension() !== 'blade.php') continue;
    
    $content = file_get_contents($file->getPathname());
    
    // Find @php blocks
    preg_match_all('/@php(.*?)@endphp/s', $content, $matches);
    
    foreach ($matches[0] as $block) {
        if (strpos($block, 'json_encode') !== false && strpos($block, "'") !== false) {
            echo "FOUND in {$file->getPathname()}: " . substr($block, 0, 80) . "...\n";
        }
    }
}
