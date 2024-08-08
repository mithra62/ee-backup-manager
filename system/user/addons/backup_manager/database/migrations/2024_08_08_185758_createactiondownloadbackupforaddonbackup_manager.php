<?php

use ExpressionEngine\Service\Migration\Migration;

class CreateactiondownloadbackupforaddonbackupManager extends Migration
{
    /**
     * Execute the migration
     * @return void
     */
    public function up()
    {
        ee('Model')->make('Action', [
            'class' => 'Backup_manager',
            'method' => 'DownloadBackup',
            'csrf_exempt' => false,
        ])->save();
    }

    /**
     * Rollback the migration
     * @return void
     */
    public function down()
    {
        ee('Model')->get('Action')
            ->filter('class', 'Backup_manager')
            ->filter('method', 'DownloadBackup')
            ->delete();
    }
}
