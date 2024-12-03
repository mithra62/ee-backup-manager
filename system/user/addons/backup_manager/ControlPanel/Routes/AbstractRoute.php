<?php

namespace Mithra62\BackupManager\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute as BaseRoute;

abstract class AbstractRoute extends BaseRoute
{
    /**
     * @var string
     */
    protected $base_url = 'addons/settings/backup_manager';
}