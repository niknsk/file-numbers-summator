<?php
declare(strict_types=1);

class FileNumbersSummator
{
    /**
     * Iterates over all directories recursively starting from $path
     * and returns the sum of all numbers in the files $fileName.
     *
     * @throws \RuntimeException
     */
    public function getDirectoryFileNumbersSum(string $path, string $fileName): int|float
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $sum = 0;

        /**
         * @var \SplFileInfo $fileInfo
         */
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getFilename() === $fileName) {
                $sum += $this->getFileNumbersSum($fileInfo);
            }
        }

        return $sum;
    }

    /**
     * Returns sum of all numbers from the file.
     *
     * @throws \RuntimeException
     */
    private function getFileNumbersSum(\SplFileInfo $fileInfo): int|float
    {
        $file = $fileInfo->openFile();
        $sum = 0;

        try {
            while (!$file->eof()) {
                $line = $file->fgets();

                if (\preg_match_all('/0.0|0|(-?[1-9]+\d*([.]\d+)?)|(-?0[.]\d*[1-9]+)/', $line, $matches)) {
                    $sum += \array_sum($matches[0]);
                }
            }
        } finally {
            unset($file);
        }

        return $sum;
    }
}
