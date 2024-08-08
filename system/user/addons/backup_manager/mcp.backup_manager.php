<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use ExpressionEngine\Service\Addon\Mcp;

class Backup_manager_mcp extends Mcp
{
    protected $addon_name = 'backup_manager';
}
