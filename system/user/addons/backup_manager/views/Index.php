<div class="box add-mrg-bottom">
    <?php echo ee('CP/Alert')->getAllInlines(); ?>
</div>
<div class="box table-list-wrap">
<!--    <fieldset class="tbl-search right">-->
<!--        <a class="btn tn action" href="--><?php //echo ee('CP/URL')->make('addons/settings/login_alert/create'); ?><!--">--><?php //echo lang('la.create.new'); ?><!--</a>-->
<!--    </fieldset>-->
    <?php echo form_open($base_url, 'class="tbl-ctrls"'); ?>
    <h1><?php echo lang('bm.backup_manager_header'); ?></h1>
    <div class="app-notice-wrap">
        <?php echo ee('CP/Alert')->get('items-table'); ?>
    </div>

    <?php $this->embed('ee:_shared/table', $table); ?>
    <?php echo $pagination; ?>
    <?php echo form_close(); ?>
</div>