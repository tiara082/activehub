<?php
$dir = new RecursiveDirectoryIterator('d:/activehub/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    $newContent = str_replace(
        ['Pertandingan', 'pertandingan', 'PERTANDINGAN'], 
        ['Permainan', 'permainan', 'PERMAINAN'], 
        $content
    );
    
    if ($newContent !== $content) {
        file_put_contents($path, $newContent);
        echo "Updated: $path\n";
    }
}
echo "Done.\n";
