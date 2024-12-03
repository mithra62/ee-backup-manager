<?php

namespace Mithra62\BackupManager\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;

class Download extends AbstractRoute
{
    /**
     * @var string
     */
    protected $route_path = 'download';

    /**
     * @var string
     */
    protected $cp_page_title = 'Download';

    /**
     * @param false $id
     * @return AbstractRoute
     */
    public function process($id = false)
    {
        $path = ee('backup_manager:BackupsService')->getBackup(ee()->input->get('id'));

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
        ob_clean(); flush();
        readfile($path);
        exit;
    }
}
