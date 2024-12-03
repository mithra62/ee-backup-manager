<?php
namespace Mithra62\BackupManager\Services;

class BackupsService
{
    /**
     * @param string $path
     * @return bool
     */
    public function deleteBackup(string $path): bool
    {
        return @unlink($path);
    }

    /**
     * @param string $hash
     * @return string|null
     */
    public function getBackup(string $hash): ?string
    {
        $path = ee('Encrypt')->decode($hash);
        $return = null;
        if($path) {
            $full = realpath(rtrim(PATH_CACHE, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $path);
            if(file_exists($full)) {
                $return = $full;
            }
        }

        return $return;
    }

    /**
     * @return array
     */
    public function getBackups(): array
    {
        $return = [];
        $db_name = ee()->db->database;
        if(is_dir(PATH_CACHE)) {
            $files = scandir(PATH_CACHE, SCANDIR_SORT_DESCENDING,);
            foreach($files as $file) {
                if(str_starts_with($file, $db_name)) {
                    $path = realpath(PATH_CACHE . '/' . $file);
                    $details = stat($path);
                    $return[$file] = [
                        'filename' => $file,
                        'full_path' => $path,
                        'size' => $details['size'],
                        'date' => $details['mtime'],
                        'hash' => ee('Encrypt')->encode($file)
                    ];
                }
            }
        }

        return $return;
    }
}