<?php

$dir = __DIR__ . '/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($files as $file) {
    if ($file->getExtension() !== 'blade.php') continue;
    
    $content = file_get_contents($file->getPathname());
    
    // Replace single quotes with double quotes inside @php ... @endphp blocks that contain json_encode
    $newContent = preg_replace_callback(
        '/@php\s+(\$\w+Detail)\s*=\s*json_encode\(\[(.*?)\]\s*\)\s*;\s*@endphp/s',
        function ($m) {
            $var = $m[1];
            $inner = $m[2];
            // Replace single-quoted keys/values with double-quoted
            $inner = preg_replace("/'([^']*)'\s*=>\s*/", '"$1" => ', $inner);
            return "@php $var = json_encode([$inner]); @endphp";
        },
        $content
    );
    
    if ($newContent !== $content) {
        file_put_contents($file->getPathname(), $newContent);
        echo "Fixed: {$file->getPathname()}\n";
    }
}
echo "Done.\n";
