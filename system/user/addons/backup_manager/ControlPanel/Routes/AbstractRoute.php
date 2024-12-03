<?php

namespace Mithra62\BackupManager\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute as BaseRoute;

abstract class AbstractRoute extends BaseRoute
{
    /**
     * @var string
     */
    protected $base_url = 'addons/settings/backup_manager';

    public function __construct()
    {
        if (! ee('Permission')->can('access_utilities') && ! ee('Permission')->can('edit_channel_fields')) {
            show_error(lang('unauthorized_access'), 403);
        }

        parent::__construct();
    }
}