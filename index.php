<?php

echo 'Enter file name that you want find:'.PHP_EOL;
$filename = trim(fgets(STDIN));
echo 'Enter directory where to search:'.PHP_EOL;
$dirname = trim(fgets(STDIN));

if (!is_dir($dirname)) {
    echo "Can't find directory $dirname".PHP_EOL;
    exit(1);
}
$files = searchFiles($filename, $dirname);

if (0 === count($files)) {
    echo 'File not found'.PHP_EOL;
    exit(1);
}

echo "File '$filename' found in:".PHP_EOL;
foreach ($files as $file) {
    echo $file.PHP_EOL;
}
exit(0);

function searchFiles($file, $dir)
{
    $filepath = $dir.'/'.$file;
    $files = [];
    if (file_exists($filepath)) {
        $files[] = realpath(__DIR__.'/'.$filepath);
    }

    $filesDirs = scandir($dir, SCANDIR_SORT_ASCENDING);
    foreach ($filesDirs as $value) {
        if ('.' === $value || '..' === $value) {
            continue;
        }
        if (is_dir($dir.'/'.$value)) {
            $files = array_merge($files, searchFiles($file, $dir.'/'.$value));
        }
    }

    return $files;
}
