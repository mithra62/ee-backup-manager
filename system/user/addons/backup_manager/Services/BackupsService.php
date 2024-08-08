<?php
namespace Mithra62\BackupManager\Services;

class BackupsService
{
    /**
     * @return array
     */
    public function getBackups(): array
    {
        $return = [];
        $db_name = ee()->db->database;
        if(is_dir(PATH_CACHE)) {
            $files = scandir(PATH_CACHE);
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