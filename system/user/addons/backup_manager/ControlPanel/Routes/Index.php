<?php

namespace Mithra62\BackupManager\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use ExpressionEngine\Library\CP\Table;

class Index extends AbstractRoute
{
    /**
     * @var string
     */
    protected $addon_name = 'backup_manager';

    /**
     * @var string
     */
    protected $route_path = 'index';

    /**
     * @var string
     */
    protected $cp_page_title = 'Index';

    /**
     * @var string
     */
    protected $base_url = 'addons/settings/backup_manager';

    /**
     * @param false $id
     * @return AbstractRoute
     */
    public function process($id = false)
    {
        $sort_col = ee('Request')->get('sort_col') ?: 'bm.id';
        $sort_dir = ee('Request')->get('sort_dir') ?: 'desc';
        $this->per_page = ee('Request')->get('perpage') ?: $this->per_page;

        $query = [
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
        ];

        $base_url = ee('CP/URL')->make($this->base_url . '/index', $query);
        $table = ee('CP/Table', [
            'lang_cols' => true,
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
            'class' => 'backup_manager',
            'limit' => $this->per_page,
        ]);

        $vars['cp_page_title'] = lang('la.title');
        $table->setColumns([
            'bm.id' => 'id',
            'bm.name' => 'name',
            'bm.type' => ['sort' => false],
            'bm.status' => ['encode' => false, 'sort' => false],
            'bm.manage' => [
                'type' => Table::COL_TOOLBAR,
            ],
        ]);

        $table->setNoResultsText(sprintf(lang('no_found'), lang('la.alerts')));

        $backups = ee('backup_manager:BackupsService')->getBackups();

        $page = ((int)ee('Request')->get('page')) ?: 1;
        $offset = ($page - 1) * $this->per_page; // Offset is 0 indexed

        // Handle Pagination
        $totalBackups = $backups->count();

        $backups->limit($this->per_page)
            ->offset($offset);

        $data = [];
        $sort_map = [
            'la.id' => 'id',
            'la.name' => 'name',
        ];

        $backups->order($sort_map[$sort_col], $sort_dir);
        foreach ($backups->all() as $backup) {
            $url = $this->url( 'edit/' . $alert->getId());
            $data[] = [
                [
                    'content' => $alert->getId(),
                    'href' => $url,
                ],
                $alert->name,
                $alert->log_into,
                '',
                ['toolbar_items' => [
                    'edit' => [
                        'href' => $url,
                        'title' => lang('la.edit_alert'),
                    ],
                    'remove' => [
                        'href' => $this->url( 'delete/' . $alert->getId()),
                        'title' => lang('la.remove_alert'),
                    ],
                ]],
            ];
        }

        $table->setData($data);

        $vars['pagination'] = ee('CP/Pagination', $totalAlerts)
            ->perPage($this->per_page)
            ->currentPage($page)
            ->render($base_url);
        $vars['table'] = $table->viewData($base_url);
        $vars['base_url'] = $base_url;

        $this->setBody('index', $vars);
        return $this;
    }
}
