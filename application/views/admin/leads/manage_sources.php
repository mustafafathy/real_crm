<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tw-mb-2 sm:tw-mb-4">
                    <a href="#" onclick="new_source(); return false;" class="btn btn-primary">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('lead_new_source'); ?>
                    </a>
                </div>
                <div class="panel_s">
                    <div class="panel-body panel-table-full">
                        <?php if (count($sources) > 0) { ?>
                        <table class="table dt-table" data-order-col="1" data-order-type="asc">
                            <thead>
                                <th><?php echo _l('id'); ?></th>
                                <th><?php echo _l('leads_sources_table_name'); ?></th>
                                <th><?php echo _l('Account'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                            </thead>
                            <tbody>
                                <?php
                                $accounts = [1 => 'Real State', 2 => 'Solar'];
                                ?>
                                <?php foreach ($sources as $source) { ?>
                                <tr>
                                    <td><?php echo e($source['id']); ?></td>
                                    <td><a href="#"
                                            onclick="edit_source(this,<?php echo e($source['id']); ?>); return false"
                                            data-name="<?php echo e($source['name']); ?>"
                                
                                            data-target="<?php echo e($source['target']); ?>"
                                            data-active="<?php echo e($source['active']); ?>"><?php echo e($source['name']); ?></a><br />
                                        <span class="text-muted">
                                            <?php echo _l('leads_table_total', total_rows(db_prefix() . 'leads', ['source' => $source['id']])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $accounts[$source['account']]; ?>
                                    </td>
                                    <td>
                                        <div class="tw-flex tw-items-center tw-space-x-3">
                                            <a href="#"
                                                onclick="edit_source(this,<?php echo e($source['id']); ?>); return false"
                                                data-name="<?php echo e($source['name']); ?>"
                                
                                                data-target="<?php echo e($source['target']); ?>"
                                                data-active="<?php echo e($source['active']); ?>"
                                                class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700">
                                                <i class="fa-regular fa-pen-to-square fa-lg"></i>
                                            </a>
                                            <a href="<?php echo admin_url('leads/delete_source/' . $source['id']); ?>"
                                                class="tw-mt-px tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700 _delete">
                                                <i class="fa-regular fa-trash-can fa-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                        <p class="no-margin"><?php echo _l('leads_sources_not_found'); ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="source" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('leads/source')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_source'); ?></span>
                    <span class="add-title"><?php echo _l('lead_new_source'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('name', 'leads_source_add_edit_name'); ?>
                        <?php echo render_input('target', 'Target'); ?>
                       	<div class="form-group">
                			<label for="active"><?php echo _l('Status'); ?></label>
                			<select name="active" id="active" class="form-control">
                    			<option value="1"><?php echo _l('Active'); ?></option>
                    			<option value="0"><?php echo _l('Inactive'); ?></option>
                			</select>
            			</div>
                        <div class="form-group">
                			<label for="account"><?php echo _l('Account'); ?></label>
                			<select name="account" id="account" class="form-control">
                    			<option value="1"><?php echo _l('Real State'); ?></option>
                    			<option value="2"><?php echo _l('Solar'); ?></option>
                			</select>
            			</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php init_tail(); ?>
<script>
$(function() {
    appValidateForm($('form'), {
        name: 'required',
        target: {
            required: true,
            number: true,
            min: 1
        }
    }, manage_leads_sources);
    $('#source').on('hidden.bs.modal', function(event) {
        $('#additional').html('');
        $('#source input[name="name"]').val('');
        $('#source input[name="target"]').val('');
        $('#source input[name="active"]').val('');
        $('.add-title').removeClass('hide');
        $('.edit-title').removeClass('hide');
    });
});

function manage_leads_sources(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
        window.location.reload();
    });
    return false;
}

function new_source() {
    $('#source').modal('show');
    $('.edit-title').addClass('hide');
}

function edit_source(invoker, id) {
    var name = $(invoker).data('name');
    $('#additional').append(hidden_input('id', id));
    $('#source input[name="name"]').val(name);

	var target = $(invoker).data('target');
    $('#source input[name="target"]').val(target);

	var active = $(invoker).data('active');
    $('#source select[name="active"]').val(active);

    $('#source').modal('show');
    $('.add-title').addClass('hide');
}
</script>
</body>

</html>