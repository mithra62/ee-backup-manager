<?php

use Mithra62\BackupManager\Services\BackupsService;

return [
    'name'              => 'Backup Manager',
    'description'       => 'Adds management and download capabilities to ExpressionEngine backups',
    'version'           => '1.0.0',
    'author'            => 'mithra62',
    'author_url'        => 'https://github.com/mithra62/ee-backup-manager',
    'namespace'         => 'Mithra62\BackupManager',
    'settings_exist'    => true,
    'services' => [
        'BackupsService' => function ($addon) {
            return new BackupsService();
        },
    ],
];
