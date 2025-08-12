<?php
namespace Mithra62\BackupManager\Forms\Backups;


use ExpressionEngine\Library\CP\Form\AbstractForm;
use ExpressionEngine\Library\CP\Form;

class Remove extends AbstractForm
{
    public function generate(): array
    {
        $form = new Form;
        $field_group = $form->getGroup('bm.form.header.remove_backup');
        $field_set = $field_group->getFieldSet('bm.form.confirm_remove_backup');
        $field_set->setDesc('bm.form.desc.confirm_delete');
        $field_set->getField('confirm', 'yes_no');

        return $form->toArray();
    }
}