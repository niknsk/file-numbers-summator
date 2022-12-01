<?php
declare(strict_types=1);

require_once "./FileNumbersSummator.php";

try {
    if (!$cwd = \getcwd()) {
        throw new \RuntimeException('Failed to get current working directory.');
    }

    $sum = (new FileNumbersSummator())->getDirectoryFileNumbersSum($cwd . DIRECTORY_SEPARATOR . 'test', 'count');

    echo "Sum of all numbers: {$sum}" . PHP_EOL;
} catch (\RuntimeException $e) {
    echo "Failed to calculate sum of all numbers: {$e->getMessage()}." . PHP_EOL;
}
