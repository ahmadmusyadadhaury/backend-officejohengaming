<?php
$root = getcwd();
$path = 'avatars/1_1782284961.jpg';
$fullPath = $root . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $path;
echo 'Full path: ' . $fullPath . PHP_EOL;
echo 'File exists: ' . (file_exists($fullPath) ? 'YES' : 'NO') . PHP_EOL;
echo 'Symlink exists: ' . (file_exists($root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'storage') ? 'YES' : 'NO') . PHP_EOL;
