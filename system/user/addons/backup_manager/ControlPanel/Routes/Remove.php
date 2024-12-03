<?php

namespace Mithra62\BackupManager\ControlPanel\Routes;

use Mithra62\BackupManager\Forms\Backups\Remove as BackupDeleteForm;
use Mithra62\BackupManager\Forms\Backups\Remove AS RemoveForm;

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
        $id = ee()->input->get('id');
        $path = ee('backup_manager:BackupsService')->getBackup($id);
        if (is_null($path)) {
            ee()->functions->redirect(ee('CP/URL')->make($this->base_url));
        }

        $form = new RemoveForm;

        if (!empty($_POST) && ee()->input->post('confirm') == 'y') {
            ee('backup_manager:BackupsService')->deleteBackup($path);
            ee('CP/Alert')->makeInline('shared-form')
                ->asSuccess()
                ->withTitle(lang('bm.backup_deleted'))
                ->defer();

            ee()->functions->redirect($this->url('index'));
        }

        $vars = [
            'cp_page_title' => lang('bm.header.remove_backup'),
            'base_url' => $this->url('remove/', true, ['id' => $id]),
            'save_btn_text' => lang('bm.remove'),
            'save_btn_text_working' => lang('bm.removing'),
            'alert' => $alert,
        ];

        $vars += $form->generate();

        $this->addBreadcrumb($this->url('edit'), 'bm.header.remove_backup');
        $this->setBody('Remove', $vars);
        $this->setHeading('bm.header.remove_backup');
        return $this;
    }
}
