<?php

namespace Mithra62\BackupManager\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;

class Remove extends AbstractRoute
{
    /**
     * @var string
     */
    protected $route_path = 'remove';

    /**
     * @var string
     */
    protected $cp_page_title = 'Remove';

    /**
     * @param false $id
     * @return AbstractRoute
     */
    public function process($id = false)
    {
        $this->addBreadcrumb('remove', 'Remove');

        $variables = [
            'name' => 'My Name',
            'color' => 'Green'
        ];

        $this->setBody('Remove', $variables);

        return $this;
    }
}
