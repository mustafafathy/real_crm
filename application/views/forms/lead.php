<?php defined('BASEPATH') or exit('No direct script access allowed');


?>
<div class="panel_s mtop25">
    <div class="panel-body">
        <h4 class="pull-left">
            <?php echo e($lead->name); ?><br /><small><?php echo e(get_option('companyname')); ?></small>
        </h4>

        <?php if (get_option('gdpr_data_portability_leads') == '1') { ?>
            <?php echo form_open($this->uri->uri_string()); ?>
            <?php echo form_hidden('export', true); ?>
            <button type="submit" class="btn btn-primary pull-right"><?php echo _l('dt_button_export'); ?></button>
            <?php echo form_close(); ?>
        <?php } ?>
        <?php if (get_option('gdpr_lead_enable_right_to_be_forgotten') == '1') { ?>
            <a href="#" data-toggle="modal" data-target="#dataRemoval"
                class="btn btn-primary pull-right mright5"><?php echo _l('request_data_removal'); ?></a>
        <?php } ?>
        <?php if (get_option('gdpr_enable_consent_for_leads') == '1') { ?>
            <a href="<?php echo lead_consent_url($lead->id); ?>" class="btn btn-success pull-right mright5" target="_blank">
                <?php echo _l('gdpr_consent'); ?>
            </a>
        <?php } ?>
        <div class="clearfix"></div>
        <hr />
        <?php echo form_open($this->uri->uri_string()); ?>
        <div class="row">
            <div class="col-md-6">
                <?php echo form_hidden('update', true); ?>
                <?php echo render_input('name', 'lead_add_edit_name', $lead->name); ?>
                <?php echo render_input('title', 'lead_title', $lead->title); ?>
                <?php echo render_input('email', 'lead_add_edit_email', $lead->email); ?>

                <?php echo render_input('phonenumber', 'lead_add_edit_phonenumber', $lead->phonenumber); ?>
                <?php echo render_input('company', 'lead_company', $lead->company); ?>
            </div>
            <div class="col-md-6">
                <?php echo render_textarea('address', 'lead_address', $lead->address, ['rows' => 2]); ?>
                <?php echo render_input('city', 'lead_city', $lead->city); ?>
                <?php echo render_input('state', 'lead_state', $lead->state); ?>

                <?php echo render_input('zip', 'lead_zip', $lead->zip); ?>
            </div>

            <?php if (get_option('gdpr_show_lead_custom_fields_on_public_form') == '1') { ?>
                <div class="col-md-12" id="">
                    <?php
                    if (!empty($selectedPipeline)) {

                        $CI =& get_instance();

                        $CI->load->library('session');
                        $selectedPipeline = $CI->session->userdata('account_category');
                        echo render_custom_fields('leads', $lead->id, pipeline: $selectedPipeline);
                    } else {
                        if (isset($_SESSION['account_category'])) {

                            $selectedPipeline = $_SESSION['account_category'];

                            echo render_custom_fields('leads', $lead->id, pipeline: $selectedPipeline);
                        }
                    }
                    ?>

                </div>
            <?php } ?>
            <?php if (get_option('gdpr_lead_attachments_on_public_form') == '1') {
                if (count($lead->attachments) > 0) {
                    echo '<div class="col-md-12 mtop20 mbot15"><h4>' . _l('lead_attachments') . '</h4></div>';
                    $data = '';
                    foreach ($lead->attachments as $key => $attachment) {
                        $attachment_url = site_url('download/file/l_attachment_key/' . $attachment['attachment_key']);
                        if (!empty($attachment['external'])) {
                            $attachment_url = $attachment['external_link'];
                        }
                        $data .= '<div class="display-block lead-attachment-wrapper">';
                        $data .= '<div class="col-md-12">';
                        $data .= '<div class="pull-left"><i class="' . get_mime_class($attachment['filetype']) . '"></i></div>';
                        $data .= '<a href="' . $attachment_url . '" target="_blank">' . $attachment['file_name'] . '</a>';
                        $data .= '<div class="checkbox">
    <input type="checkbox" name="remove_attachments[' . $attachment['attachment_key'] . ']" id="att_' . $key . '">
    <label for="att_' . $key . '">' . _l('remove_file') . '</label>
    </div>';
                        $data .= '</div>';
                        $data .= '<div class="clearfix"></div><hr/ class="hr-10">';
                        $data .= '</div>';
                    }
                    echo $data;
                }
            } ?>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo _l('save'); ?></button>
        <?php echo form_close(); ?>
    </div>
</div>
<?php if (is_gdpr() && get_option('gdpr_lead_enable_right_to_be_forgotten') == '1') { ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="dataRemoval">
        <div class="modal-dialog" role="document">
            <?php echo form_open(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> <?php echo _l('request_data_removal'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?php echo form_hidden('removal_request', true); ?>
                        <label for="removal_description"
                            class="control-label"><?php echo _l('explanation_for_data_removal'); ?></label>
                        <textarea name="removal_description" id="removal_description" class="form-control" rows="4"
                            placeholder="<?php echo _l('briefly_describe_why_remove_data'); ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="" class="btn btn-primary"><?php echo $selectedPipeline; ?></button>
                </div>
            </div><!-- /.modal-content -->
            <?php echo form_close(); ?>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php } ?>