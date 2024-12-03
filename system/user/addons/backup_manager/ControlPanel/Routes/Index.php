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

        $vars['cp_page_title'] = lang('bm.title');
        $table->setColumns([
            'bm.file_name' => ['sort' => false],
            'bm.date' => ['sort' => false],
            'bm.size' => ['sort' => false],
            'bm.manage' => [
                'type' => Table::COL_TOOLBAR,
            ],
        ]);

        $table->setNoResultsText(sprintf(lang('no_found'), lang('bm.backups')));

        $backups = ee('backup_manager:BackupsService')->getBackups();

        $page = ((int)ee('Request')->get('page')) ?: 1;
        $offset = ($page - 1) * $this->per_page; // Offset is 0 indexed

        // Handle Pagination
        $totalBackups = 0;// count($backups);

        $data = [];
        $sort_map = [
            'la.id' => 'id',
            'la.name' => 'name',
        ];

        foreach ($backups as $backup) {
            $data[] = [
                $backup['filename'],
                ee('backup_manager:DateService')->format($backup['date']),
                ee('backup_manager:FilesService')->format($backup['size']),
                ['toolbar_items' => [
                    'download' => [
                        'href' => $this->url( 'download', true, ['id' => $backup['hash']]),
                        'title' => lang('bm.download'),
                    ],
                    'remove' => [
                        'href' => $this->url( 'remove', true, ['id' => $backup['hash']]),
                        'title' => lang('bm.remove'),
                    ],
                ]],
            ];
        }

        $table->setData($data);

        $vars['pagination'] = ee('CP/Pagination', $totalBackups)
            ->perPage($this->per_page)
            ->currentPage($page)
            ->render($base_url);
        $vars['table'] = $table->viewData($base_url);
        $vars['base_url'] = $base_url;

        $this->setBody('index', $vars);
        return $this;
    }
}
