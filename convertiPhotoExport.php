<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);


function iterate(string $dir)
{
    $d       = parseDate(basename($dir));
    $dirdate = $d
             ? \DateTime::createFromFormat('F j, Y', $d)
             : null;

    foreach (scandir($dir) as $f) {
        if (substr($f, 0, 1) != '.') {
            $path = "$dir/$f";
            $ext  = strtolower(substr($f, -3));
            if (is_dir($path)) {
                iterate($path);
            }

            if (is_file($path)) {
                echo "$path\n";
                $exif    = ($ext == 'jpg')
                         ? exif_read_data($path)
                         : [];
                $date    = extractDatetime($exif, $dirdate ? $dirdate : null);
                $out_dir = "./output/{$date->format('Y/m/d')}";
                if (!is_dir($out_dir)) { mkdir($out_dir, 0777, true); }
                copy($path, "$out_dir/$f");
            }
        }
    }
}

function extractDatetime(array $exif, ?DateTime $fallback=null): \DateTime
{
    $possibleKeys = ['DateTime', 'Date and Time', 'FileDateTime'];
    foreach ($possibleKeys as $k) {
        if (!empty($exif[$k])) {
            $d = is_numeric($exif[$k])
                ? \DateTime::createFromFormat('U', (string)$exif[$k])
                : new \DateTime($exif[$k]);
            if ($d) { return $d; }
        }
    }

    if ($fallback) {
        return $fallback;
    }
    print_r($exif);
    exit();
    throw new \Exception('missingDateTime');
}

function parseDate(string $string): ?string
{
    $matches = [];
    preg_match('/[a-zA-Z]+\s\d{1,2},\s\d{4}/', $string, $matches);
    return $matches[0] ?? null;
}

iterate('./export');
