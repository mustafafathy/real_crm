<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-header task-single-header tw-mb-3" data-task-single-id="<?php echo e($task->id); ?>"
    data-status="<?php echo e($task->status); ?>">
    <?php if ($this->input->get('opened_from_lead_id')) { ?>
        <a href="#" onclick="init_lead(<?php echo e($this->input->get('opened_from_lead_id', false)); ?>); return false;"
            class="back-to-from-task" data-placement="left" data-toggle="tooltip"
            data-title="<?php echo _l('back_to_lead'); ?>">
            <i class="fa fa-tty" aria-hidden="true"></i>
        </a>
    <?php } ?>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h4 class="modal-title tw-flex tw-items-center">
        <?php echo e($task->name); ?>
        <!-- <?php
                if ($task->recurring == 1) {
                    echo '<span class="label label-info inline-block tw-ml-5">' . _l('recurring_task') . '</span>';
                }
                echo '<span class="tw-ml-5">' . format_task_status($task->status) . '</span>';
                ?> -->
    </h4>

</div>
<!-- task information panel -->
<div>
    <?php if ($task->billed == 1) { ?>
        <?php echo '<p class="no-margin">' . _l('task_is_billed', '<a href="' . admin_url('invoices/list_invoices/' . $task->invoice_id) . '" target="_blank">' . e(format_invoice_number($task->invoice_id))) . '</a></p>'; ?>
    <?php } ?>
    <?php if ($task->is_public == 0) { ?>
        <div class="full-flex tw-justify-center tasks-section">
            <div class=" tw-items-center tw-px-3 tw-mx-3 tasks_header2">
                <div class="sub-flex page-section">
                    <h3 class="card-header ">Tasks Information</h3>

                    <div class="shrink tool ">

                        <!-- <span class="tab-title"> Tasks Assigned to: </span> -->
                        <div class="tab2-section full-flex tw-items-center  " id="tab_tasks">


                            <div class="tab2-switch tw-text-center left" id="tasks-switcher"
                                data-user="<?php echo e($user_ID); ?>" style="width: 1280px;max-width: 8000px;">
                                <div id="me_tab" data-id="<?php echo htmlspecialchars($user_ID); ?>" class="tab2 active"
                                    tab-direction="left"><?php echo _l('task_is_private'); ?></div>
                                <?php if (staff_can('edit',  'tasks')) { ?>
                                    <div id="oth_tab" data-id="" class="tab2" tab-direction="left">
                                        <a href="#" class="tab2" onclick="make_task_public(<?php echo e($task->id); ?>); return false;">
                                            <?php echo _l('task_view_make_public'); ?>
                                        </a>
                                    </div>
                                <?php } ?>




                                <!-- <div id="dep_tab" data-id="" class="tab" tab-direction="right">Department</div> -->
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <div class="sub-flex shrink tw-justify-between">

                <div>
                    <?php if ($task->billed == 0) {
                        $is_assigned = $task->current_user_is_assigned;
                        if (!$this->tasks_model->is_timer_started($task->id)) { ?>
                            <p class="no-margin pull-left" <?php if (!$is_assigned) { ?> data-toggle="tooltip"
                                data-title="<?php echo _l('task_start_timer_only_assignee'); ?>" <?php } ?>>
                                <a href="#" class=" startbtn  btn<?php if (!$is_assigned || $task->status == Tasks_model::STATUS_COMPLETE) {
                                                                        echo ' disabled button-pr';
                                                                    } else {
                                                                        echo '  button-pr';
                                                                    } ?>" onclick="timer_action(this, <?php echo e($task->id); ?>); return false;">
                                    <i class="fa-solid fa-play"></i> <?php echo _l('task_start_timer  '); ?>
                                </a>
                            </p>
                        <?php } else { ?>
                            <p class="no-margin pull-left">
                                <a href="#" data-toggle="popover" data-placement="<?php echo is_mobile() ? 'bottom' : 'right'; ?>"
                                    data-html="true" data-trigger="manual" data-title="<?php echo _l('note'); ?>"
                                    data-content='<?php echo render_textarea('timesheet_note'); ?><button type="button" onclick="timer_action(this, <?php echo e($task->id); ?>, <?php echo $this->tasks_model->get_last_timer($task->id)->id; ?>);" class="btn btn-primary btn-sm"><?php echo _l('confirm'); ?></button>'
                                    class="btn mbot10 btn-danger<?php if (!$is_assigned) {
                                                                    echo ' disabled';
                                                                } ?>" onclick="return false;">
                                    <i class="fa-regular fa-clock"></i> <?php echo _l('task_stop_timer'); ?>
                                </a>
                            </p>
                        <?php } ?>
                    <?php
                    } ?>
                </div>
                <!-- <?php if (staff_can('create', 'tasks')) { ?>
                    <a href="#" onclick="new_task(<?php if ($this->input->get('project_id')) {
                                                        echo "'" . admin_url('tasks/task?rel_id=' . $this->input->get('project_id') . '&rel_type=project') . "'";
                                                    } ?>); return false;" class="button-pr">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('new_task'); ?>
                    </a>
                <?php } ?> -->
                <!-- <a href="<?php echo admin_url(!$this->input->get('project_id') ? ('tasks/switch_kanban/' . $switch_kanban) : ('projects/view/' . $this->input->get('project_id') . '?group=project_tasks')); ?>"
                    class=" button-pr" data-toggle="tooltip" data-placement="top"
                    style="width: auto;height: inherit;margin: 8px;"
                    data-title="<?php echo $switch_kanban == 1 ? _l('switch_to_list_view') : _l('leads_switch_to_kanban'); ?>">
                    <?php if ($switch_kanban == 1) { ?>
                        <i class="fa-solid fa-table-list"></i>
                    <?php } else { ?>
                        <i class="fa-solid fa-grip-vertical"></i>
                    <?php }; ?>
                </a> -->
            </div>





        </div>
        <!-- <p class="tw-mb-0 tw-mt-1">
            <?php echo _l('task_is_private'); ?>
            <?php if (staff_can('edit',  'tasks')) { ?> -
                <a href="#" class="text-has-action" onclick="make_task_public(<?php echo e($task->id); ?>); return false;">
                    <?php echo _l('task_view_make_public'); ?>
                </a>
            <?php } ?>
        </p> -->
    <?php } ?>
</div>
<div class="widget card2 tw-shadow-lg tw-px-5 tw-mb-3 " style="">


    <div class="widget-content full-flex ">
        <div class=" tw-flex-1 card-element tw-bg-gray-100   tw-text-center full-flex tw-flex-col tw-justify-between"> status
            <?php
            if ($task->recurring == 1) {

                echo '<span class="count2" >' . _l('recurring_task') . '</span> ';
            }
            echo '<span class="count2" > ' . format_task_status2($task->status) . '</span>';
            ?>
        </div>

        <div
            class="tw-flex-1 card-element tw-bg-gray-100   tw-text-center full-flex tw-flex-col tw-justify-between">
            <div class="tw-shrink-0<?php echo $task->status != 5 ? ' tw-grow' : ''; ?>">
                <i class="fa-regular fa-calendar fa-fw fa-lg fa-margin task-info-icon pull-left tw-mt-2"></i>
                <?php echo _l('task_single_start_date'); ?>:
            </div><span class="count2">
                <div class="task-info task-single-inline-wrap task-info-start-date">
                    <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">

                        <?php if (staff_can('edit',  'tasks') && $task->status != 5) { ?>
                            <input name="startdate" tabindex="-1" value="<?php echo e(_d($task->startdate)); ?>"
                                id="task-single-startdate"
                                class="task-info-inline-input-edit datepicker pointer task-single-inline-field tw-text-neutral-800">
                        <?php } else { ?>
                            <span class="tw-text-neutral-800"><?php echo e(_d($task->startdate)); ?></span>
                        <?php } ?>
                    </h5>
                </div>
            </span></span>
        </div>
        <div
            class="tw-flex-1 card-element tw-bg-gray-100   tw-text-center full-flex tw-flex-col tw-justify-between">
            <div class="tw-shrink-0<?php echo $task->status != 5 ? ' tw-grow' : ''; ?>">
                <i class="fa-regular fa-calendar-check fa-fw fa-lg task-info-icon pull-left tw-mt-2"></i>
                <?php echo _l('task_single_due_date'); ?>:
            </div><span class="count2">
                <div class="task-info task-info-due-date task-single-inline-wrap<?php if (!$task->duedate && staff_cant('tasks', 'edit')) {
                                                                                    echo ' hide';
                                                                                } ?>" <?php if (!$task->duedate) {
                                                                                            echo ' style="opacity:0.5;"';
                                                                                        } ?>>
                    <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">

                        <?php if (staff_can('edit',  'tasks') && $task->status != 5) { ?>
                            <input name="duedate" tabindex="-1" value="<?php echo e(_d($task->duedate)); ?>" id="task-single-duedate"
                                class="task-info-inline-input-edit datepicker pointer task-single-inline-field tw-text-neutral-800"
                                autocomplete="off" <?php if ($project_deadline) {
                                                        echo ' data-date-end-date="' . e($project_deadline) . '"';
                                                    } ?>>
                        <?php } else { ?>
                            <span class="tw-text-neutral-800"><?php echo e(_d($task->duedate)); ?></span>
                        <?php } ?>
                    </h5>
                </div>
            </span>
        </div>
        <div
            class="tw-flex-1 card-element tw-bg-gray-100   tw-text-center full-flex tw-flex-col tw-justify-between" style="z-index: 100000;">
            <i class="fa fa-bolt fa-fw fa-lg task-info-icon pull-left"></i>
            <?php echo _l('task_single_priority'); ?>:<span class="count2 ct">
                <div class="task-info task-info-priority">
                    <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">

                        <?php if (staff_can('edit',  'tasks') && $task->status != Tasks_model::STATUS_COMPLETE) { ?>
                            <span class="task-single-menu task-menu-priority">
                                <span class="trigger pointer manual-popover text-has-action"
                                    style="color:<?php echo e(task_priority_color($task->priority)); ?>;">
                                    <?php echo e(task_priority($task->priority)); ?>
                                </span>
                                <span class="content-menu hide">
                                    <ul>
                                        <?php
                                        foreach (get_tasks_priorities() as $priority) { ?>
                                            <?php if ($task->priority != $priority['id']) { ?>
                                                <li>
                                                    <a href="#"
                                                        onclick="task_change_priority(<?php echo e($priority['id']); ?>,<?php echo e($task->id); ?>); return false;"
                                                        class="tw-block">
                                                        <?php echo e($priority['name']); ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </span>
                            </span>
                        <?php } else { ?>
                            <span style="color:<?php echo e(task_priority_color($task->priority)); ?>;">
                                <?php echo e(task_priority($task->priority)); ?>
                            </span>
                        <?php } ?>
                    </h5>
                </div>
            </span>
        </div>
    </div>

</div>

<div class="modal-body">
    <input id="taskid" type="hidden" value="<?php echo $task->id ?>">
    <div class="row">
        <div class="col-md-8 task-single-col-left">
            <?php if (total_rows(db_prefix() . 'taskstimers', ['end_time' => null, 'staff_id !=' => get_staff_user_id(), 'task_id' => $task->id]) > 0) {
                $startedTimers = $this->tasks_model->get_timers($task->id, ['staff_id !=' => get_staff_user_id(), 'end_time' => null]);

                $usersWorking = '';

                foreach ($startedTimers as $t) {
                    $usersWorking .= '<b>' . e(get_staff_full_name($t['staff_id'])) . '</b>, ';
                }

                $usersWorking = rtrim($usersWorking, ', '); ?>
                <div class="alert alert-info">
                    <?php echo _l((count($startedTimers) == 1
                        ? 'task_users_working_on_tasks_single'
                        : 'task_users_working_on_tasks_multiple'), $usersWorking); ?>
                </div>
            <?php
            } ?>
            <?php if (!empty($task->rel_id)) {
                echo '<div class="task-single-related-wrapper">';
                $task_rel_data  = get_relation_data($task->rel_type, $task->rel_id);
                $task_rel_value = get_relation_values($task_rel_data, $task->rel_type);
                echo '<h4 class="bold font-medium mbot15 tw-mt-0">' . _l('task_single_related') . ': <a href="' . e($task_rel_value['link']) . '" target="_blank">' . e($task_rel_value['name']) . '</a>';
                if ($task->rel_type == 'project' && $task->milestone != 0) {
                    echo '<div class="mtop5 mbot20 font-normal">' . _l('task_milestone') . ': ';
                    $milestones = get_project_milestones($task->rel_id);
                    if (staff_can('edit',  'tasks') && count($milestones) > 1) { ?>
                        <span class="task-single-menu task-menu-milestones">
                            <span class="trigger pointer manual-popover text-has-action">
                                <?php echo e($task->milestone_name); ?>
                            </span>
                            <span class="content-menu hide">
                                <ul>
                                    <?php
                                    foreach ($milestones as $milestone) { ?>
                                        <?php if ($task->milestone != $milestone['id']) { ?>
                                            <li>
                                                <a href="#"
                                                    onclick="task_change_milestone(<?php echo e($milestone['id']); ?>,<?php echo e($task->id); ?>); return false;">
                                                    <?php echo e($milestone['name']); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </span>
                        </span>
            <?php } else {
                        echo e($task->milestone_name);
                    }
                    echo '</div>';
                }
                echo '</h4>';
                echo '</div>';
            } ?>
            <div class="clearfix"></div>
            <!-- <?php if ($task->status != Tasks_model::STATUS_COMPLETE && ($task->current_user_is_assigned || staff_can('edit',  'tasks') || $task->current_user_is_creator)) { ?>
                <p class="no-margin pull-left"
                    style="<?php echo 'margin-' . (is_rtl() ? 'left' : 'right') . ':5px !important'; ?>">
                    <a href="#" class="btn btn-primary" id="task-single-mark-complete-btn" autocomplete="off"
                        data-loading-text="<?php echo _l('wait_text'); ?>"
                        onclick="mark_complete(<?php echo e($task->id); ?>); return false;" data-toggle="tooltip"
                        title="<?php echo _l('task_single_mark_as_complete'); ?>">
                        <i class="fa fa-check"></i>
                    </a>
                </p>
            <?php } elseif ($task->status == Tasks_model::STATUS_COMPLETE && ($task->current_user_is_assigned || staff_can('edit',  'tasks') || $task->current_user_is_creator)) { ?>
                <p class="no-margin pull-left"
                    style="<?php echo 'margin-' . (is_rtl() ? 'left' : 'right') . ':5px !important'; ?>">
                    <a href="#" class="btn btn-default" id="task-single-unmark-complete-btn" autocomplete="off"
                        data-loading-text="<?php echo _l('wait_text'); ?>"
                        onclick="unmark_complete(<?php echo e($task->id); ?>); return false;" data-toggle="tooltip"
                        title="<?php echo _l('task_unmark_as_complete'); ?>">
                        <i class="fa fa-check"></i>
                    </a>
                </p>
            <?php } ?> -->
            <!-- <?php if (staff_can('create',  'tasks') && count($task->timesheets) > 0) { ?>
                <p class="no-margin pull-left mright5">
                    <a href="#" class="btn btn-default mright5" data-toggle="tooltip"
                        data-title="<?php echo _l('task_statistics'); ?>"
                        onclick="task_tracking_stats(<?php echo e($task->id); ?>); return false;">
                        <i class="fa fa-bar-chart"></i>
                    </a>
                </p>
            <?php } ?> -->
            <!-- <p class="no-margin pull-left mright5">
                <a href="#" class="btn btn-default mright5" data-toggle="tooltip"
                    data-title="<?php echo _l('task_timesheets'); ?>"
                    onclick="slideToggle('#task_single_timesheets'); return false;">
                    <i class="fa fa-th-list"></i>
                </a>
            </p> -->
            <!-- old startrer -->
            <!-- <?php if ($task->billed == 0) {
                        $is_assigned = $task->current_user_is_assigned;
                        if (!$this->tasks_model->is_timer_started($task->id)) { ?>
                    <p class="no-margin pull-left" <?php if (!$is_assigned) { ?> data-toggle="tooltip"
                        data-title="<?php echo _l('task_start_timer_only_assignee'); ?>" <?php } ?>>
                        <a href="#" class="mbot10 btn<?php if (!$is_assigned || $task->status == Tasks_model::STATUS_COMPLETE) {
                                                            echo ' disabled btn-default';
                                                        } else {
                                                            echo ' btn-success';
                                                        } ?>" onclick="timer_action(this, <?php echo e($task->id); ?>); return false;">
                            <i class="fa-regular fa-clock"></i> <?php echo _l('task_start_timer'); ?>
                        </a>
                    </p>
                <?php } else { ?>
                    <p class="no-margin pull-left">
                        <a href="#" data-toggle="popover" data-placement="<?php echo is_mobile() ? 'bottom' : 'right'; ?>"
                            data-html="true" data-trigger="manual" data-title="<?php echo _l('note'); ?>"
                            data-content='<?php echo render_textarea('timesheet_note'); ?><button type="button" onclick="timer_action(this, <?php echo e($task->id); ?>, <?php echo $this->tasks_model->get_last_timer($task->id)->id; ?>);" class="btn btn-primary btn-sm"><?php echo _l('confirm'); ?></button>'
                            class="btn mbot10 btn-danger<?php if (!$is_assigned) {
                                                            echo ' disabled';
                                                        } ?>" onclick="return false;">
                            <i class="fa-regular fa-clock"></i> <?php echo _l('task_stop_timer'); ?>
                        </a>
                    </p>
                <?php } ?>
            <?php
                    } ?> -->
            <div class="clearfix"></div>
            <!-- <hr class="hr-10" /> -->
            <div id="task_single_timesheets" class="<?php if (!$this->session->flashdata('task_single_timesheets_open')) {
                                                        echo 'hide';
                                                    } ?>">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="tw-text-sm"><?php echo _l('timesheet_user'); ?></th>
                                <th class="tw-text-sm"><?php echo _l('timesheet_start_time'); ?></th>
                                <th class="tw-text-sm"><?php echo _l('timesheet_end_time'); ?></th>
                                <th class="tw-text-sm"><?php echo _l('timesheet_time_spend'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $timers_found = false;
                            foreach ($task->timesheets as $timesheet) { ?>
                                <?php if (staff_can('edit',  'tasks') || staff_can('create',  'tasks') || staff_can('delete',  'tasks') || $timesheet['staff_id'] == get_staff_user_id()) {
                                    $timers_found = true; ?>
                                    <tr>
                                        <td class="tw-text-sm">
                                            <?php if ($timesheet['note']) {
                                                echo '<i class="fa fa-comment" data-html="true" data-placement="right" data-toggle="tooltip" data-title="' . e($timesheet['note']) . '"></i>';
                                            } ?>
                                            <a href="<?php echo admin_url('staff/profile/' . $timesheet['staff_id']); ?>"
                                                target="_blank">
                                                <?php echo e($timesheet['full_name']); ?></a>
                                        </td>
                                        <td class="tw-text-sm"><?php echo e(_dt($timesheet['start_time'], true)); ?></td>
                                        <td class="tw-text-sm">
                                            <?php
                                            if ($timesheet['end_time'] !== null) {
                                                echo e(_dt($timesheet['end_time'], true));
                                            } else {
                                                // Allow admins to stop forgotten timers by staff member
                                                if (!$task->billed && is_admin()) { ?>
                                                    <a href="#" data-toggle="popover" data-placement="bottom" data-html="true"
                                                        data-trigger="manual" data-title="<?php echo _l('note'); ?>"
                                                        data-content='<?php echo render_textarea('timesheet_note'); ?><button type="button" onclick="timer_action(this, <?php echo e($task->id); ?>, <?php echo e($timesheet['id']); ?>, 1);" class="btn btn-primary btn-sm"><?php echo _l('confirm'); ?></button>'
                                                        class="text-danger" onclick="return false;">
                                                        <i class="fa-regular fa-clock"></i>
                                                        <?php echo _l('task_stop_timer'); ?>
                                                    </a>
                                            <?php
                                                }
                                            } ?>
                                        </td>
                                        <td class="tw-text-sm">
                                            <div class="tw-flex">
                                                <div class="tw-grow">
                                                    <?php
                                                    if ($timesheet['time_spent'] == null) {
                                                        echo _l('time_h') . ': ' . e(seconds_to_time_format(time() - $timesheet['start_time'])) . '<br />';
                                                        echo _l('time_decimal') . ': ' . e(sec2qty(time() - $timesheet['start_time'])) . '<br />';
                                                    } else {
                                                        echo _l('time_h') . ': ' . e(seconds_to_time_format($timesheet['time_spent'])) . '<br />';
                                                        echo _l('time_decimal') . ': ' . e(sec2qty($timesheet['time_spent'])) . '<br />';
                                                    } ?>
                                                </div>
                                                <?php
                                                if (!$task->billed) { ?>
                                                    <div
                                                        class="tw-flex tw-items-center tw-shrink-0 tw-self-start tw-space-x-1.5 tw-ml-2">
                                                        <?php
                                                        if (staff_can('delete_timesheet', 'tasks') || (staff_can('delete_own_timesheet', 'tasks') && $timesheet['staff_id'] == get_staff_user_id())) {
                                                            echo '<a href="' . admin_url('tasks/delete_timesheet/' . $timesheet['id']) . '" class="task-single-delete-timesheet text-danger" data-task-id="' . $task->id . '"><i class="fa fa-remove"></i></a>';
                                                        }
                                                        if (staff_can('edit_timesheet', 'tasks') || (staff_can('edit_own_timesheet', 'tasks') && $timesheet['staff_id'] == get_staff_user_id())) {
                                                            echo '<a href="#" class="task-single-edit-timesheet text-info" data-toggle="tooltip" data-title="' . _l('edit') . '" data-timesheet-id="' . $timesheet['id'] . '">
                                    <i class="fa fa-edit"></i>
                                    </a>';
                                                        }
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                </div>
                </td>
                </tr>
                <tr>
                    <td class="timesheet-edit task-modal-edit-timesheet-<?php echo $timesheet['id'] ?> hide"
                        colspan="5">
                        <form class="task-modal-edit-timesheet-form">
                            <input type="hidden" name="timer_id" value="<?php echo $timesheet['id'] ?>">
                            <input type="hidden" name="task_id" value="<?php echo $task->id ?>">
                            <div class="timesheet-start-end-time">
                                <div class="col-md-6">
                                    <?php echo render_datetime_input('start_time', 'task_log_time_start', _dt($timesheet['start_time'], true)); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo render_datetime_input('end_time', 'task_log_time_end', _dt($timesheet['end_time'], true)); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        <?php echo _l('task_single_log_user'); ?>
                                    </label>
                                    <br />
                                    <select name="staff_id" class="selectpicker" data-width="100%">
                                        <?php foreach ($task->assignees as $assignee) {
                                            if ((staff_cant('create', 'task') && staff_cant('edit', 'task') && $assignee['assigneeid'] != get_staff_user_id()) || ($task->rel_type == 'project' && staff_cant('edit', 'projects') && $assignee['assigneeid'] != get_staff_user_id())) {
                                                continue;
                                            }
                                            $selected = '';
                                            if ($assignee['assigneeid'] == $timesheet['staff_id']) {
                                                $selected = ' selected';
                                            } ?>
                                            <option<?php echo e($selected); ?> value="<?php echo e($assignee['assigneeid']); ?>">
                                                <?php echo e($assignee['full_name']); ?>
                                                </option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                                <?php echo render_textarea('note', 'note', $timesheet['note'], ['id' => 'note' . $timesheet['id']]); ?>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="button"
                                    class="btn btn-default edit-timesheet-cancel"><?php echo _l('cancel'); ?></button>
                                <button class="btn btn-success edit-timesheet-submit"></i>
                                    <?php echo _l('submit'); ?></button>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php
                                } ?>
        <?php } ?>
        <?php if ($timers_found == false) { ?>
            <tr>
                <td colspan="5" class="text-center bold"><?php echo _l('no_timers_found'); ?></td>
            </tr>
        <?php } ?>
        <?php if ($task->billed == 0 && ($is_assigned || (count($task->assignees) > 0 && is_admin())) && $task->status != Tasks_model::STATUS_COMPLETE) {
        ?>
            <tr class="odd">
                <td colspan="5" class="add-timesheet">
                    <div class="col-md-12">
                        <p class="font-medium bold mtop5"><?php echo _l('add_timesheet'); ?></p>
                        <hr class="mtop10 mbot10" />
                    </div>
                    <div class="timesheet-start-end-time">
                        <div class="col-md-6">
                            <?php echo render_datetime_input('timesheet_start_time', 'task_log_time_start'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo render_datetime_input('timesheet_end_time', 'task_log_time_end'); ?>
                        </div>
                    </div>
                    <div class="timesheet-duration hide">
                        <div class="col-md-12">
                            <i class="fa-regular fa-circle-question pointer pull-left mtop2" data-toggle="popover"
                                data-html="true" data-content="
                                    :15 - 15 <?php echo _l('minutes'); ?><br />
                                    2 - 2 <?php echo _l('hours'); ?><br />
                                    5:5 - 5 <?php echo _l('hours'); ?> & 5 <?php echo _l('minutes'); ?><br />
                                    2:50 - 2 <?php echo _l('hours'); ?> & 50 <?php echo _l('minutes'); ?><br />
                                    "></i>
                            <?php echo render_input('timesheet_duration', 'project_timesheet_time_spend', '', 'text', ['placeholder' => 'HH:MM']); ?>
                        </div>
                    </div>
                    <div class="col-md-12 mbot15 mntop15">
                        <a href="#" class="timesheet-toggle-enter-type">
                            <span class="timesheet-duration-toggler-text switch-to">
                                <?php echo _l('timesheet_duration_instead'); ?>
                            </span>
                            <span class="timesheet-date-toggler-text hide ">
                                <?php echo _l('timesheet_date_instead'); ?>
                            </span>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">
                                <?php echo _l('task_single_log_user'); ?>
                            </label>
                            <br />
                            <select name="single_timesheet_staff_id" class="selectpicker" data-width="100%">
                                <?php foreach ($task->assignees as $assignee) {
                                    if ((staff_cant('create', 'tasks') && staff_cant('edit', 'tasks') && $assignee['assigneeid'] != get_staff_user_id()) || ($task->rel_type == 'project' && staff_cant('edit', 'projects') && $assignee['assigneeid'] != get_staff_user_id())) {
                                        continue;
                                    }
                                    $selected = '';
                                    if ($assignee['assigneeid'] == get_staff_user_id()) {
                                        $selected = ' selected';
                                    } ?>
                                    <option<?php echo e($selected); ?> value="<?php echo e($assignee['assigneeid']); ?>">
                                        <?php echo e($assignee['full_name']); ?>
                                        </option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <?php echo render_textarea('task_single_timesheet_note', 'note'); ?>
                    </div>
                    <div class="col-md-12 text-right">
                        <?php
                        $disable_button = '';
                        if ($this->tasks_model->is_timer_started_for_task($task->id, ['staff_id' => get_staff_user_id()])) {
                            $disable_button = 'disabled ';
                            echo '<div class="text-right mbot15 text-danger">' . _l('add_task_timer_started_warning') . '</div>';
                        } ?>
                        <button <?php echo e($disable_button); ?>data-task-id="<?php echo e($task->id); ?>"
                            class="btn btn-success task-single-add-timesheet"><i class="fa fa-plus"></i>
                            <?php echo _l('submit'); ?></button>
                    </div>
                </td>
            </tr>
        <?php
        } ?>
        </tbody>
        </table>
            </div>
            <!-- <hr /> -->
        </div>
        <!-- <div class="clearfix"></div> -->
        <!-- <?php hooks()->do_action('before_task_description_section', $task); ?> -->
        <h4 class="th tw-font-semibold tw-text-base mbot15 pull-left"><?php echo _l('task_view_description'); ?>
        </h4>
        <?php if (staff_can('edit',  'tasks')) { ?><a href="#"
                onclick="edit_task_inline_description(this,<?php echo e($task->id); ?>); return false;"
                class="pull-left tw-mt-2.5 mleft5 font-medium-xs"><i class="fa-regular fa-pen-to-square"></i></a>
        <?php } ?>
        <div class="clearfix"></div>
        <?php if (!empty($task->description)) {
            echo '<div class="tc-content"><div id="task_view_description">' . check_for_links($task->description) . '</div></div>';
        } else {
            echo '<div class="no-margin tc-content task-no-description" id="task_view_description"><span class="text-muted">' . _l('task_no_description') . '</span></div>';
        } ?>
        <div class="clearfix"></div>
        <hr />
        <a href="#" onclick="add_task_checklist_item('<?php echo e($task->id); ?>', undefined, this); return false"
            class="mbot10 inline-block">
            <span class="new-checklist-item"><i class="fa fa-plus-circle"></i>
                <?php echo _l('add_checklist_item'); ?>
            </span>
        </a>
        <div class="form-group no-mbot checklist-templates-wrapper simple-bootstrap-select task-single-checklist-templates<?php if (count($checklistTemplates) == 0) {
                                                                                                                                echo ' hide';
                                                                                                                            }  ?>">
            <select id="checklist_items_templates" class="selectpicker checklist-items-template-select"
                data-none-selected-text="<?php echo _l('insert_checklist_templates') ?>" data-width="100%"
                data-live-search="true">
                <option value=""></option>
                <?php foreach ($checklistTemplates as $chkTemplate) { ?>
                    <option value="<?php echo e($chkTemplate['id']); ?>">
                        <?php echo e($chkTemplate['description']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="clearfix"></div>
        <p class="hide text-muted no-margin" id="task-no-checklist-items">
            <?php echo _l('task_no_checklist_items_found'); ?></p>
        <div class="row checklist-items-wrapper">
            <div class="col-md-12 ">
                <div id="checklist-items">
                    <?php $this->load->view(
                        'admin/tasks/checklist_items_template',
                        [
                            'task_id'                 => $task->id,
                            'current_user_is_creator' => $task->current_user_is_creator,
                            'checklists'              => $task->checklist_items,
                        ]
                    );
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php if (count($task->attachments) > 0) { ?>
            <div class="row task_attachments_wrapper">
                <div class="col-md-12" id="attachments">
                    <hr />
                    <h4 class="th tw-font-semibold tw-text-lg mbot15"><?php echo _l('task_view_attachments'); ?></h4>
                    <div class="row">
                        <?php
                        $i = 1;
                        // Store all url related data here
                        $comments_attachments            = [];
                        $attachments_data                = [];
                        $show_more_link_task_attachments = hooks()->apply_filters('show_more_link_task_attachments', 2);
                        foreach ($task->attachments as $attachment) { ?>
                            <?php ob_start(); ?>
                            <div data-num="<?php echo e($i); ?>" data-commentid="<?php echo e($attachment['comment_file_id']); ?>"
                                data-comment-attachment="<?php echo e($attachment['task_comment_id']); ?>"
                                data-task-attachment-id="<?php echo e($attachment['id']); ?>" class="task-attachment-col col-md-6<?php if ($i > $show_more_link_task_attachments) {
                                                                                                                                        echo ' hide task-attachment-col-more';
                                                                                                                                    } ?>">
                                <ul class="list-unstyled task-attachment-wrapper" data-placement="right" data-toggle="tooltip"
                                    data-title="<?php echo e($attachment['file_name']); ?>">
                                    <li class="mbot10 task-attachment<?php if (strtotime($attachment['dateadded']) >= strtotime('-16 hours')) {
                                                                            echo ' highlight-bg';
                                                                        } ?>">
                                        <div class="mbot10 pull-right task-attachment-user">
                                            <?php if ($attachment['staffid'] == get_staff_user_id() || is_admin()) { ?>
                                                <a href="#" class="pull-right"
                                                    onclick="remove_task_attachment(this,<?php echo e($attachment['id']); ?>); return false;">
                                                    <i class="fa fa fa-times"></i>
                                                </a>
                                            <?php }
                                            $externalPreview = false;
                                            $is_image        = false;
                                            $path            = get_upload_path_by_type('task') . $task->id . '/' . $attachment['file_name'];
                                            $href_url        = site_url('download/file/taskattachment/' . $attachment['attachment_key']);
                                            $isHtml5Video    = is_html5_video($path);
                                            if (empty($attachment['external'])) {
                                                $is_image = is_image($path);
                                                $img_url  = site_url('download/preview_image?path=' . protected_file_url_by_path($path, true) . '&type=' . $attachment['filetype']);
                                            } elseif ((!empty($attachment['thumbnail_link']) || !empty($attachment['external']))
                                                && !empty($attachment['thumbnail_link'])
                                            ) {
                                                $is_image        = true;
                                                $img_url         = optimize_dropbox_thumbnail($attachment['thumbnail_link']);
                                                $externalPreview = $img_url;
                                                $href_url        = $attachment['external_link'];
                                            } elseif (!empty($attachment['external']) && empty($attachment['thumbnail_link'])) {
                                                $href_url = $attachment['external_link'];
                                            }
                                            if (!empty($attachment['external']) && $attachment['external'] == 'dropbox' && $is_image) { ?>
                                                <a href="<?php echo e($href_url); ?>" target="_blank" class="" data-toggle="tooltip"
                                                    data-title="<?php echo _l('open_in_dropbox'); ?>"><i class="fa fa-dropbox"
                                                        aria-hidden="true"></i></a>
                                            <?php } elseif (!empty($attachment['external']) && $attachment['external'] == 'gdrive') { ?>
                                                <a href="<?php echo e($href_url); ?>" target="_blank" class="" data-toggle="tooltip"
                                                    data-title="<?php echo _l('open_in_google'); ?>"><i class="fa-brands fa-google"
                                                        aria-hidden="true"></i></a>
                                            <?php }
                                            if ($attachment['staffid'] != 0) {
                                                echo '<a href="' . admin_url('profile/' . $attachment['staffid']) . '" target="_blank">' . e(get_staff_full_name($attachment['staffid'])) . '</a> - ';
                                            } elseif ($attachment['contact_id'] != 0) {
                                                echo '<a href="' . admin_url('clients/client/' . get_user_id_by_contact_id($attachment['contact_id']) . '?contactid=' . $attachment['contact_id']) . '" target="_blank">' . e(get_contact_full_name($attachment['contact_id'])) . '</a> - ';
                                            }
                                            echo '<span class="text-has-action tw-text-sm" data-toggle="tooltip" data-title="' . _dt($attachment['dateadded']) . '">' . e(time_ago($attachment['dateadded'])) . '</span>';
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="<?php if ($is_image) {
                                                        echo 'preview-image';
                                                    } elseif (!$isHtml5Video) {
                                                        echo 'task-attachment-no-preview';
                                                    } ?>">
                                            <?php
                                            // Not link on video previews because on click on the video is opening new tab
                                            if (!$isHtml5Video) { ?>
                                                <a href="<?php echo (!$externalPreview ? $href_url : $externalPreview); ?>"
                                                    target="_blank" <?php if ($is_image) { ?> data-lightbox="task-attachment"
                                                    <?php } ?> class="<?php if ($isHtml5Video) {
                                                                            echo 'video-preview';
                                                                        } ?>">
                                                <?php } ?>
                                                <?php if ($is_image) { ?>
                                                    <img src="<?php echo e($img_url); ?>" class="img img-responsive">
                                                <?php } elseif ($isHtml5Video) { ?>
                                                    <video width="100%" height="100%"
                                                        src="<?php echo site_url('download/preview_video?path=' . protected_file_url_by_path($path) . '&type=' . $attachment['filetype']); ?>"
                                                        controls>
                                                        Your browser does not support the video tag.
                                                    </video>
                                                <?php } else { ?>
                                                    <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i>
                                                    <?php echo e($attachment['file_name']); ?>
                                                <?php } ?>
                                                <?php if (!$isHtml5Video) { ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            $attachments_data[$attachment['id']] = ob_get_contents();
                            if ($attachment['task_comment_id'] != 0) {
                                $comments_attachments[$attachment['task_comment_id']][$attachment['id']] = $attachments_data[$attachment['id']];
                            }
                            ob_end_clean();
                            echo $attachments_data[$attachment['id']];
                            ?>
                        <?php
                            $i++;
                        } ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php if (($i - 1) > $show_more_link_task_attachments) { ?>
                    <div class="col-md-12" id="show-more-less-task-attachments-col">
                        <a href="#" class="task-attachments-more"
                            onclick="slideToggle('.task_attachments_wrapper .task-attachment-col-more', task_attachments_toggle); return false;"><?php echo _l('show_more'); ?></a>
                        <a href="#" class="task-attachments-less hide"
                            onclick="slideToggle('.task_attachments_wrapper .task-attachment-col-more', task_attachments_toggle); return false;"><?php echo _l('show_less'); ?></a>
                    </div>
                <?php } ?>
                <div class="col-md-12 text-center">
                    <hr />
                    <a href="<?php echo admin_url('tasks/download_files/' . $task->id); ?>" class="bold">
                        <?php echo _l('download_all'); ?> (.zip)
                    </a>
                </div>
            </div>
        <?php } ?>
        <hr />
        <!-- <a href="#" id="taskCommentSlide" onclick="slideToggle('.tasks-comments'); return false;">
            <h4 class="mbot20 font-medium"><?php echo _l('task_comments'); ?></h4>
        </a>
        <div class="tasks-comments inline-block full-width simple-editor" <?php if (count($task->comments) == 0) {
                                                                                echo ' style="display:none"';
                                                                            } ?>>
            <?php echo form_open_multipart(admin_url('tasks/add_task_comment'), ['id' => 'task-comment-form', 'class' => 'dropzone dropzone-manual', 'style' => 'min-height:auto;background-color:#fff;']); ?>
            <textarea name="comment" placeholder="<?php echo _l('task_single_add_new_comment'); ?>" id="task_comment"
                rows="3" class="form-control ays-ignore"></textarea>
            <div id="dropzoneTaskComment" class="dropzoneDragArea dz-default dz-message hide task-comment-dropzone">
                <span><?php echo _l('drop_files_here_to_upload'); ?></span>
            </div>
            <div class="dropzone-task-comment-previews dropzone-previews"></div>
            <button type="button" class="btn btn-primary mtop10 pull-right hide" id="addTaskCommentBtn"
                autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"
                onclick="add_task_comment('<?php echo e($task->id); ?>');" data-comment-task-id="<?php echo e($task->id); ?>">
                <?php echo _l('task_single_add_new_comment'); ?>
            </button>
            <?php echo form_close(); ?>
            <div class="clearfix"></div>
            <?php if (count($task->comments) > 0) {
                echo '<hr />';
            } ?>
            <div id="task-comments" class="mtop10">
                <?php
                $comments = '';
                $len      = count($task->comments);
                $i        = 0;
                foreach ($task->comments as $comment) {
                    $comments .= '<div id="comment_' . $comment['id'] . '" data-commentid="' . $comment['id'] . '" data-task-attachment-id="' . $comment['file_id'] . '" class="tc-content task-comment' . (strtotime($comment['dateadded']) >= strtotime('-16 hours') ? ' highlight-bg' : '') . '">';
                    $comments .= '<a data-task-comment-href-id="' . $comment['id'] . '" href="' . admin_url('tasks/view/' . $task->id) . '#comment_' . $comment['id'] . '" class="task-date-as-comment-id"><span class="tw-text-sm"><span class="text-has-action inline-block" data-toggle="tooltip" data-title="' . e(_dt($comment['dateadded'])) . '">' . e(time_ago($comment['dateadded'])) . '</span></span></a>';
                    if ($comment['staffid'] != 0) {
                        $comments .= '<a href="' . admin_url('profile/' . $comment['staffid']) . '" target="_blank">' . staff_profile_image($comment['staffid'], [
                            'staff-profile-image-small',
                            'media-object img-circle pull-left mright10',
                        ]) . '</a>';
                    } elseif ($comment['contact_id'] != 0) {
                        $comments .= '<img src="' . e(contact_profile_image_url($comment['contact_id'])) . '" class="client-profile-image-small media-object img-circle pull-left mright10">';
                    }
                    if ($comment['staffid'] == get_staff_user_id() || is_admin()) {
                        $comment_added = strtotime($comment['dateadded']);
                        $minus_1_hour  = strtotime('-1 hours');
                        if (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 0 || (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 1 && $comment_added >= $minus_1_hour) || is_admin()) {
                            $comments .= '<span class="pull-right tw-mx-1.5"><a href="#" onclick="remove_task_comment(' . $comment['id'] . '); return false;" class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700"><i class="fa fa-trash-can"></i></span></a>';
                            $comments .= '<span class="pull-right mright5"><a href="#" onclick="edit_task_comment(' . $comment['id'] . '); return false;" class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700"><i class="fa-regular fa-pen-to-square"></i></span></a>';
                        }
                    }

                    $comments .= '<div class="media-body comment-wrapper">';
                    $comments .= '<div class="mleft40">';

                    if ($comment['staffid'] != 0) {
                        $comments .= '<a href="' . admin_url('profile/' . $comment['staffid']) . '" target="_blank">' . e($comment['staff_full_name']) . '</a> <br />';
                    } elseif ($comment['contact_id'] != 0) {
                        $comments .= '<span class="label label-info mtop5 mbot5 inline-block">' . _l('is_customer_indicator') . '</span><br /><a href="' . admin_url('clients/client/' . get_user_id_by_contact_id($comment['contact_id']) . '?contactid=' . $comment['contact_id']) . '" class="pull-left" target="_blank">' . e(get_contact_full_name($comment['contact_id'])) . '</a> <br />';
                    }

                    $comments .= '<div data-edit-comment="' . $comment['id'] . '" class="hide edit-task-comment"><textarea rows="5" id="task_comment_' . $comment['id'] . '" class="ays-ignore form-control">' . str_replace('[task_attachment]', '', $comment['content']) . '</textarea>
                  <div class="clearfix mtop20"></div>
                  <button type="button" class="btn btn-primary pull-right" onclick="save_edited_comment(' . $comment['id'] . ',' . $task->id . ')">' . _l('submit') . '</button>
                  <button type="button" class="btn btn-default pull-right mright5" onclick="cancel_edit_comment(' . $comment['id'] . ')">' . _l('cancel') . '</button>
                  </div>';
                    if ($comment['file_id'] != 0) {
                        $comment['content'] = str_replace('[task_attachment]', '<div class="clearfix"></div>' . $attachments_data[$comment['file_id']], $comment['content']);
                        // Replace lightbox to prevent loading the image twice
                        $comment['content'] = str_replace('data-lightbox="task-attachment"', 'data-lightbox="task-attachment-comment-' . $comment['id'] . '"', $comment['content']);
                    } elseif (count($comment['attachments']) > 0 && isset($comments_attachments[$comment['id']])) {
                        $comment_attachments_html = '';
                        foreach ($comments_attachments[$comment['id']] as $comment_attachment) {
                            $comment_attachments_html .= trim($comment_attachment);
                        }
                        $comment['content'] = str_replace('[task_attachment]', '<div class="clearfix"></div>' . $comment_attachments_html, $comment['content']);
                        // Replace lightbox to prevent loading the image twice
                        $comment['content'] = str_replace('data-lightbox="task-attachment"', 'data-lightbox="task-comment-files-' . $comment['id'] . '"', $comment['content']);
                        $comment['content'] .= '<div class="clearfix"></div>';
                        $comment['content'] .= '<div class="text-center download-all">
                   <hr class="hr-10" />
                   <a href="' . admin_url('tasks/download_files/' . $task->id . '/' . $comment['id']) . '" class="bold">' . _l('download_all') . ' (.zip)
                   </a>
                   </div>';
                    }
                    $comments .= '<div class="comment-content mtop10">' . app_happy_text(check_for_links($comment['content'])) . '</div>';
                    $comments .= '</div>';
                    if ($i >= 0 && $i != $len - 1) {
                        $comments .= '<hr class="task-info-separator" />';
                    }
                    $comments .= '</div>';
                    $comments .= '</div>';
                    $i++;
                }
                echo $comments;
                ?>
            </div>
        </div> -->
    </div>
    <!-- <div class="col-md-4 task-single-col-right">
        <div class="pull-right mbot10 task-single-menu task-menu-options">
            <div class="content-menu hide">
                <ul>
                    <?php if (staff_can('edit',  'tasks')) { ?>
                        <li>
                            <a href="#" onclick="edit_task(<?php echo e($task->id); ?>); return false;">
                                <?php echo _l('task_single_edit'); ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (staff_can('create',  'tasks')) { ?>
                        <?php
                        $copy_template = '';
                        if (count($task->assignees) > 0) {
                            $copy_template .= "<div class='checkbox checkbox-primary'><input type='checkbox' name='copy_task_assignees' id='copy_task_assignees' checked><label for='copy_task_assignees'>" . _l('task_single_assignees') . '</label></div>';
                        }
                        if (count($task->followers) > 0) {
                            $copy_template .= "<div class='checkbox checkbox-primary'><input type='checkbox' name='copy_task_followers' id='copy_task_followers' checked><label for='copy_task_followers'>" . _l('task_single_followers') . '</label></div>';
                        }
                        if (count($task->checklist_items) > 0) {
                            $copy_template .= "<div class='checkbox checkbox-primary'><input type='checkbox' name='copy_task_checklist_items' id='copy_task_checklist_items' checked><label for='copy_task_checklist_items'>" . _l('task_checklist_items') . '</label></div>';
                        }
                        if (count($task->attachments) > 0) {
                            $copy_template .= "<div class='checkbox checkbox-primary'><input type='checkbox' name='copy_task_attachments' id='copy_task_attachments'><label for='copy_task_attachments'>" . _l('task_view_attachments') . '</label></div>';
                        }

                        $copy_template .= '<p>' . _l('task_status') . '</p>';
                        $task_copy_statuses = hooks()->apply_filters('task_copy_statuses', $task_statuses);
                        foreach ($task_copy_statuses as $copy_status) {
                            $copy_template .= "<div class='radio radio-primary'><input type='radio' value='" . $copy_status['id'] . "' name='copy_task_status' id='copy_task_status_" . $copy_status['id'] . "'" . ($copy_status['id'] == hooks()->apply_filters('copy_task_default_status', 1) ? ' checked' : '') . "><label for='copy_task_status_" . $copy_status['id'] . "'>" . e($copy_status['name']) . '</label></div>';
                        }

                        $copy_template .= "<div class='text-center'>";
                        $copy_template .= "<button type='button' data-task-copy-from='" . $task->id . "' class='btn btn-success copy_task_action'>" . _l('copy_task_confirm') . '</button>';
                        $copy_template .= '</div>';
                        ?>
                        <li> <a href="#" onclick="return false;" data-placement="bottom" data-toggle="popover"
                                data-content="<?php echo htmlspecialchars($copy_template); ?>"
                                data-html="true"><?php echo _l('task_copy'); ?></span></a></li>
                    <?php } ?>
                    <?php if (staff_can('delete',  'tasks')) { ?>
                        <li>
                            <a href="<?php echo admin_url('tasks/delete_task/' . $task->id); ?>"
                                class="_delete task-delete">
                                <?php echo _l('task_single_delete'); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php if (staff_can('delete',  'tasks') || staff_can('edit',  'tasks') || staff_can('create',  'tasks')) { ?>
                <a href="#" onclick="return false;" class="trigger manual-popover mright5">
                    <i class="fa-regular fa-circle"></i>
                    <i class="fa-regular fa-circle"></i>
                    <i class="fa-regular fa-circle"></i>
                </a>
            <?php } ?>
        </div>
        <h4 class="task-info-heading tw-font-medium tw-text-base tw-mb-0 tw-text-neutral-800">
            <?php echo _l('task_info'); ?>
        </h4>
        <div class="clearfix"></div>
        <p class="tw-mb-0 task-info-created tw-text-sm">
            <?php if (($task->addedfrom != 0 && $task->addedfrom != get_staff_user_id()) || $task->is_added_from_contact == 1) { ?>
                <span
                    class="tw-text-neutral-500"><?php echo _l('task_created_by', '<span class="tw-text-neutral-600">' . ($task->is_added_from_contact == 0 ? e(get_staff_full_name($task->addedfrom)) : e(get_contact_full_name($task->addedfrom))) . '</span>'); ?>
                    <i class="fa-regular fa-clock" data-toggle="tooltip"
                        data-title="<?php echo e(_l('task_created_at', _dt($task->dateadded))); ?>"></i></span>
                <br />
            <?php } else { ?>
                <span
                    class="tw-text-neutral-500"><?php echo _l('task_created_at', '<span class="tw-text-neutral-600">' . e(_dt($task->dateadded)) . '</span>'); ?></span>
            <?php } ?>
        </p>
        <hr class="task-info-separator" />
        <div class="task-info task-status task-info-status">
            <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                <i class="fa-regular fa-star fa-fw fa-lg pull-left task-info-icon"></i><?php echo _l('task_status'); ?>:
                <?php if ($task->current_user_is_assigned || $task->current_user_is_creator || staff_can('edit',  'tasks')) { ?>
                    <span class="task-single-menu task-menu-status">
                        <span class="trigger pointer manual-popover text-has-action tw-text-neutral-800">
                            <?php echo e(format_task_status($task->status, true, true)); ?>
                        </span>
                        <span class="content-menu hide">
                            <ul>
                                <?php
                                $task_single_mark_as_statuses = hooks()->apply_filters('task_single_mark_as_statuses', $task_statuses);
                                foreach ($task_single_mark_as_statuses as $status) { ?>
                                    <?php if ($task->status != $status['id']) { ?>
                                        <li>
                                            <a href="#"
                                                onclick="task_mark_as(<?php echo e($status['id']); ?>,<?php echo e($task->id); ?>); return false;"
                                                class="tw-block">
                                                <?php echo e(_l('task_mark_as', $status['name'])); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </span>
                    </span>
                <?php } else { ?>
                    <span class="tw-text-neutral-800"><?php echo format_task_status($task->status, true); ?></span>
                <?php } ?>
            </h5>
        </div>
        <?php if ($task->status == Tasks_model::STATUS_COMPLETE) { ?>
            <div class="task-info task-info-finished">
                <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                    <i class="fa fa-check fa-fw fa-lg task-info-icon pull-left "></i>
                    <?php echo _l('task_single_finished'); ?>: <span data-toggle="tooltip"
                        data-title="<?php echo e(_dt($task->datefinished)); ?>" data-placement="bottom"
                        class="text-has-action tw-text-neutral-800"><?php echo e(time_ago($task->datefinished)); ?></span>
                </h5>
            </div>
        <?php } ?>
        <div class="task-info task-single-inline-wrap task-info-start-date">
            <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                <div class="tw-shrink-0<?php echo $task->status != 5 ? ' tw-grow' : ''; ?>">
                    <i class="fa-regular fa-calendar fa-fw fa-lg fa-margin task-info-icon pull-left tw-mt-2"></i>
                    <?php echo _l('task_single_start_date'); ?>:
                </div>
                <?php if (staff_can('edit',  'tasks') && $task->status != 5) { ?>
                    <input name="startdate" tabindex="-1" value="<?php echo e(_d($task->startdate)); ?>"
                        id="task-single-startdate"
                        class="task-info-inline-input-edit datepicker pointer task-single-inline-field tw-text-neutral-800">
                <?php } else { ?>
                    <span class="tw-text-neutral-800"><?php echo e(_d($task->startdate)); ?></span>
                <?php } ?>
            </h5>
        </div>
        <div class="task-info task-info-due-date task-single-inline-wrap<?php if (!$task->duedate && staff_cant('tasks', 'edit')) {
                                                                            echo ' hide';
                                                                        } ?>" <?php if (!$task->duedate) {
                                                                                    echo ' style="opacity:0.5;"';
                                                                                } ?>>
            <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                <div class="tw-shrink-0<?php echo $task->status != 5 ? ' tw-grow' : ''; ?>">
                    <i class="fa-regular fa-calendar-check fa-fw fa-lg task-info-icon pull-left tw-mt-2"></i>
                    <?php echo _l('task_single_due_date'); ?>:
                </div>
                <?php if (staff_can('edit',  'tasks') && $task->status != 5) { ?>
                    <input name="duedate" tabindex="-1" value="<?php echo e(_d($task->duedate)); ?>" id="task-single-duedate"
                        class="task-info-inline-input-edit datepicker pointer task-single-inline-field tw-text-neutral-800"
                        autocomplete="off" <?php if ($project_deadline) {
                                                echo ' data-date-end-date="' . e($project_deadline) . '"';
                                            } ?>>
                <?php } else { ?>
                    <span class="tw-text-neutral-800"><?php echo e(_d($task->duedate)); ?></span>
                <?php } ?>
            </h5>
        </div>
        <div class="task-info task-info-priority">
            <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                <i class="fa fa-bolt fa-fw fa-lg task-info-icon pull-left"></i>
                <?php echo _l('task_single_priority'); ?>:
                <?php if (staff_can('edit',  'tasks') && $task->status != Tasks_model::STATUS_COMPLETE) { ?>
                    <span class="task-single-menu task-menu-priority">
                        <span class="trigger pointer manual-popover text-has-action"
                            style="color:<?php echo e(task_priority_color($task->priority)); ?>;">
                            <?php echo e(task_priority($task->priority)); ?>
                        </span>
                        <span class="content-menu hide">
                            <ul>
                                <?php
                                foreach (get_tasks_priorities() as $priority) { ?>
                                    <?php if ($task->priority != $priority['id']) { ?>
                                        <li>
                                            <a href="#"
                                                onclick="task_change_priority(<?php echo e($priority['id']); ?>,<?php echo e($task->id); ?>); return false;"
                                                class="tw-block">
                                                <?php echo e($priority['name']); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </span>
                    </span>
                <?php } else { ?>
                    <span style="color:<?php echo e(task_priority_color($task->priority)); ?>;">
                        <?php echo e(task_priority($task->priority)); ?>
                    </span>
                <?php } ?>
            </h5>
        </div>
        <?php if ($task->current_user_is_creator || staff_can('edit',  'tasks')) { ?>
            <div class="task-info task-info-hourly-rate">
                <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                    <i class="fa-regular fa-clock fa-fw fa-lg task-info-icon pull-left"></i>
                    <?php echo _l('task_hourly_rate'); ?>: <span class="tw-text-neutral-800">
                        <?php if ($task->rel_type == 'project' && $task->project_data->billing_type == 2) {
                            echo e(app_format_number($task->project_data->project_rate_per_hour));
                        } else {
                            echo e(app_format_number($task->hourly_rate));
                        }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="task-info task-info-billable">
                <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                    <i class="fa fa-credit-card fa-fw fa-lg task-info-icon pull-left"></i>
                    <?php echo _l('task_billable'); ?>: <span class="tw-text-neutral-800">
                        <?php echo ($task->billable == 1 ? _l('task_billable_yes') : _l('task_billable_no')) ?>
                        <?php if ($task->billable == 1) { ?>
                            <b>(<?php echo ($task->billed == 1 ? _l('task_billed_yes') : _l('task_billed_no')) ?>)</b>
                        <?php } ?>
                    </span>
                </h5>
                <?php if ($task->rel_type == 'project' && $task->project_data->billing_type == 1) {
                    echo '<br /><span class="tw-ml-5 tw-text-sm">(' . _l('project') . ' ' . _l('project_billing_type_fixed_cost') . ')</span>';
                } ?>
            </div>
            <?php if (
                $task->billable == 1
                && $task->billed == 0
                && ($task->rel_type != 'project' || ($task->rel_type == 'project' && $task->project_data->billing_type != 1))
                && staff_can('create', 'invoices')
            ) { ?>
                <div class="task-info task-billable-amount">
                    <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                        <i class="fa fa-regular fa-file-lines fa-fw fa-lg pull-left task-info-icon"></i>
                        <?php echo _l('billable_amount'); ?>:
                        <span class="tw-font-semibold tw-text-neutral-800">
                            <?php echo e($this->tasks_model->get_billable_amount($task->id)); ?>
                        </span>
                    </h5>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if ($task->current_user_is_assigned || total_rows(db_prefix() . 'taskstimers', ['task_id' => $task->id, 'staff_id' => get_staff_user_id()]) > 0) { ?>
            <div class="task-info task-info-user-logged-time">
                <h5 class="tw-inline-flex tw-items-center">
                    <i class="fa fa-asterisk task-info-icon fa-fw fa-lg" aria-hidden="true"></i>
                    <span class="tw-text-neutral-800">
                        <?php echo _l('task_user_logged_time'); ?>
                        <?php echo e(seconds_to_time_format($this->tasks_model->calc_task_total_time($task->id, ' AND staff_id=' . get_staff_user_id()))); ?>
                    </span>
                </h5>
            </div>
        <?php } ?>
        <?php if (staff_can('create',  'tasks')) { ?>
            <div class="task-info task-info-total-logged-time">
                <h5 class="tw-inline-flex tw-items-center tw-space-x-1.5">
                    <i
                        class="fa-regular fa-clock fa-fw fa-lg task-info-icon"></i><?php echo _l('task_total_logged_time'); ?>
                    <span class="text-success">
                        <?php echo e(seconds_to_time_format($this->tasks_model->calc_task_total_time($task->id))); ?>
                    </span>
                </h5>
            </div>
        <?php } ?>
        <?php $custom_fields = get_custom_fields('tasks');
        foreach ($custom_fields as $field) { ?>
            <?php $value = get_custom_field_value($task->id, $field['id'], 'tasks');
            if ($value == '') {
                continue;
            } ?>
            <div class="task-info">
                <h5
                    class="task-info-custom-field tw-inline-flex tw-items-center tw-space-x-1.5 task-info-custom-field-<?php echo e($field['id']); ?>">
                    <i class="fa-regular fa-circle fa-fw fa-lg task-info-icon"></i>
                    <?php echo e($field['name']); ?>: <span class="tw-text-neutral-800"><?php echo $value; ?></span>
                </h5>
            </div>
        <?php } ?>
        <?php if (staff_can('create',  'tasks') || staff_can('edit',  'tasks')) { ?>
            <div class="mtop10 clearfix"></div>
            <div id="inputTagsWrapper" class="taskSingleTasks task-info-tags-edit">
                <input type="text" class="tagsinput" id="taskTags" data-taskid="<?php echo e($task->id); ?>"
                    value="<?php echo prep_tags_input(get_tags_in($task->id, 'task')); ?>" data-role="tagsinput">
            </div>
            <div class="clearfix"></div>
        <?php } else { ?>
            <div class="mtop5 clearfix"></div>
            <?php echo render_tags(get_tags_in($task->id, 'task')); ?>
            <div class="clearfix"></div>
        <?php } ?>
        <hr class="task-info-separator" />
        <div class="clearfix"></div>
        <?php if ($task->current_user_is_assigned) {
            foreach ($task->assignees as $assignee) {
                if ($assignee['assigneeid'] == get_staff_user_id() && get_staff_user_id() != $assignee['assigned_from'] && $assignee['assigned_from'] != 0 || $assignee['is_assigned_from_contact'] == 1) {
                    if ($assignee['is_assigned_from_contact'] == 0) {
                        echo '<p class="text-muted task-assigned-from">' . _l('task_assigned_from', '<a href="' . admin_url('profile/' . $assignee['assigned_from']) . '" target="_blank">' . e(get_staff_full_name($assignee['assigned_from']))) . '</a></p>';
                    } else {
                        echo '<p class="text-muted task-assigned-from task-assigned-from-contact">' . e(_l('task_assigned_from', get_contact_full_name($assignee['assigned_from']))) . '<br /><span class="label inline-block mtop5 label-info">' . _l('is_customer_indicator') . '</span></p>';
                    }

                    break;
                }
            }
        } ?>
        <h4 class="task-info-heading tw-font-medium tw-text-base tw-flex tw-items-center tw-text-neutral-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
            </svg>
            <?php echo _l('reminders'); ?>
        </h4>
        <a href="#" onclick="new_task_reminder(<?php echo e($task->id); ?>); return false;">
            <?php echo _l('create_reminder'); ?>
        </a>
        <?php if (count($reminders) == 0) { ?>
            <div class="display-block tw-text-neutral-600 tw-text-sm mtop15">
                <?php echo _l('no_reminders_for_this_task'); ?>
            </div>
        <?php } else { ?>
            <ul class="mtop10">
                <?php foreach ($reminders as $rKey => $reminder) {
                ?>
                    <li class="<?php if ($reminder['isnotified'] == '1') {
                                    echo 'text-throught';
                                } ?>" data-id="<?php echo e($reminder['id']); ?>">
                        <div class="mbot15">
                            <div>
                                <p class="bold">
                                    <?php echo e(_l('reminder_for', [
                                        get_staff_full_name($reminder['staff']),
                                        _dt($reminder['date']),
                                    ])); ?>
                                    <?php if ($reminder['creator'] == get_staff_user_id() || is_admin()) { ?>
                                        <?php if ($reminder['isnotified'] == 0) { ?>
                                            <a href="#" class="text-muted tw-ml-2"
                                                onclick="edit_reminder(<?php echo e($reminder['id']); ?>, this); return false;">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php } ?>
                                        <a href="<?php echo admin_url('tasks/delete_reminder/' . $task->id . '/' . $reminder['id']); ?>"
                                            class="text-danger delete-reminder tw-ml-1"><i class="fa fa-remove"></i></a>
                                    <?php } ?>
                                </p>
                                <?php
                                if (!empty($reminder['description'])) {
                                    echo process_text_content_for_display($reminder['description']);
                                } else {
                                    echo '<p class="text-muted no-mbot">' . _l('no_description_provided') . '</p>';
                                } ?>
                            </div>
                            <?php if (count($reminders) - 1 != $rKey) { ?>
                                <hr class="hr-10" />
                            <?php } ?>
                        </div>
                    </li>
                <?php
                } ?>
            </ul>
        <?php } ?>
        <div class="clearfix"></div>
        <div id="newTaskReminderToggle" class="mtop15" style="display:none;">
            <?php echo form_open('', ['id' => 'form-reminder-task']); ?>
            <?php $this->load->view('admin/includes/reminder_fields', ['members' => $staff_reminders, 'id' => $task->id, 'name' => 'task']); ?>
            <button class="btn btn-primary btn-sm pull-right" type="submit" id="taskReminderFormSubmit">
                <?php echo _l('create_reminder'); ?>
            </button>
            <div class="clearfix"></div>
            <?php echo form_close(); ?>
        </div>
        <hr class="task-info-separator" />
        <div class="clearfix"></div>
        <h4 class="task-info-heading tw-font-medium tw-text-base tw-flex tw-items-center tw-text-neutral-800 tw-mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <?php echo _l('task_single_assignees'); ?>
        </h4>
        <?php if (
            staff_can('edit', 'tasks') ||
            ($task->current_user_is_creator && staff_can('create', 'tasks'))
        ) { ?>
            <div class="simple-bootstrap-select tw-mb-2">
                <select data-width="100%" <?php if ($task->rel_type == 'project') { ?>
                    data-live-search-placeholder="<?php echo _l('search_project_members'); ?>" <?php } ?>
                    data-task-id="<?php echo e($task->id); ?>" id="add_task_assignees"
                    class="text-muted task-action-select selectpicker" name="select-assignees" data-live-search="true"
                    title='<?php echo _l('task_single_assignees_select_title'); ?>'
                    data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    <?php
                    $options = '';
                    foreach ($staff as $assignee) {
                        if (!in_array($assignee['staffid'], $task->assignees_ids)) {
                            if (
                                $task->rel_type == 'project'
                                && total_rows(db_prefix() . 'project_members', ['project_id' => $task->rel_id, 'staff_id' => $assignee['staffid']]) == 0
                            ) {
                                continue;
                            }
                            $options .= '<option value="' . $assignee['staffid'] . '">' . e($assignee['full_name']) . '</option>';
                        }
                    }
                    echo $options;
                    ?>
                </select>
            </div>
        <?php } ?>
        <div class="task_users_wrapper">
            <?php
            $_assignees = '';
            foreach ($task->assignees as $assignee) {
                $_remove_assigne = '';
                if (
                    staff_can('edit', 'tasks') ||
                    ($task->current_user_is_creator && staff_can('create', 'tasks'))
                ) {
                    $_remove_assigne = ' <a href="#" class="remove-task-user text-danger" onclick="remove_assignee(' . $assignee['id'] . ',' . $task->id . '); return false;"><i class="fa fa-remove"></i></a>';
                }
                $_assignees .= '
               <div class="task-user"  data-toggle="tooltip" data-title="' . e($assignee['full_name']) . '">
               <a href="' . admin_url('profile/' . $assignee['assigneeid']) . '" target="_blank">' . staff_profile_image($assignee['assigneeid'], [
                    'staff-profile-image-small',
                ]) . '</a> ' . $_remove_assigne . '</span>
               </div>';
            }
            if ($_assignees == '') {
                $_assignees = '<div class="text-danger display-block tw-text-sm">' . _l('task_no_assignees') . '</div>';
            }
            echo $_assignees;
            ?>
        </div>
        <hr class="task-info-separator" />
        <div class="clearfix"></div>
        <h4 class="task-info-heading tw-font-medium tw-text-base tw-flex tw-items-center tw-text-neutral-800 tw-mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <?php echo _l('task_single_followers'); ?>
        </h4>
        <?php if (
            staff_can('edit', 'tasks') ||
            ($task->current_user_is_creator && staff_can('create', 'tasks'))
        ) { ?>
            <div class="simple-bootstrap-select tw-mb-2">
                <select data-width="100%" data-task-id="<?php echo e($task->id); ?>"
                    class="text-muted selectpicker task-action-select" name="select-followers" data-live-search="true"
                    title='<?php echo _l('task_single_followers_select_title'); ?>'
                    data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    <?php
                    $options = '';
                    foreach ($staff as $follower) {
                        if (!in_array($follower['staffid'], $task->followers_ids)) {
                            $options .= '<option value="' . $follower['staffid'] . '">' . e($follower['full_name']) . '</option>';
                        }
                    }
                    echo $options;
                    ?>
                </select>
            </div>
        <?php } ?>
        <div class="task_users_wrapper">
            <?php
            $_followers = '';
            foreach ($task->followers as $follower) {
                $_remove_follower = '';
                if (
                    staff_can('edit', 'tasks') ||
                    ($task->current_user_is_creator && staff_can('create', 'tasks'))
                ) {
                    $_remove_follower = ' <a href="#" class="remove-task-user text-danger" onclick="remove_follower(' . $follower['id'] . ',' . $task->id . '); return false;"><i class="fa fa-remove"></i></a>';
                }
                $_followers .= '
                <span class="task-user" data-toggle="tooltip" data-title="' . e($follower['full_name']) . '">
                <a href="' . admin_url('profile/' . $follower['followerid']) . '" target="_blank">' . staff_profile_image($follower['followerid'], [
                    'staff-profile-image-small',
                ]) . '</a> ' . $_remove_follower . '</span>
                </span>';
            }
            if ($_followers == '') {
                $_followers = '<div class="display-block tw-text-neutral-600 mbot5 tw-text-sm">' . _l('task_no_followers') . '</div>';
            }
            echo $_followers;
            ?>
        </div>
        <?php echo form_open_multipart('admin/tasks/upload_file', ['id' => 'task-attachment', 'class' => 'dropzone tw-mt-5']); ?>
        <?php echo form_close(); ?>
        <div class="tw-my-2 tw-inline-flex tw-items-end tw-w-full tw-flex-col tw-space-y-2 tw-justify-end">
            <button class="gpicker">
                <i class="fa-brands fa-google" aria-hidden="true"></i>
                <?php echo _l('choose_from_google_drive'); ?>
            </button>
            <div id="dropbox-chooser-task"></div>
        </div>
    </div> -->
    <div class="col-md-4 task-single-col-right">
        <a href="#" id="taskCommentSlide" onclick="slideToggle('.tasks-comments'); return false;">
            <h4 class="mbot20 font-medium"><?php echo _l('task_comments'); ?></h4>
        </a>
        <div class="tasks-comments inline-block full-width simple-editor" <?php if (count($task->comments) == 0) {
                                                                                echo ' style="display:none"';
                                                                            } ?>>
            <?php echo form_open_multipart(admin_url('tasks/add_task_comment'), ['id' => 'task-comment-form', 'class' => 'dropzone dropzone-manual', 'style' => 'min-height:auto;background-color:#fff;']); ?>
            <textarea name="comment" placeholder="<?php echo _l('task_single_add_new_comment'); ?>" id="task_comment"
                rows="3" class="form-control ays-ignore"></textarea>
            <div id="dropzoneTaskComment" class="dropzoneDragArea dz-default dz-message hide task-comment-dropzone">
                <span><?php echo _l('drop_files_here_to_upload'); ?></span>
            </div>
            <div class="dropzone-task-comment-previews dropzone-previews"></div>
            <button type="button" class="btn btn-primary mtop10 pull-right hide" id="addTaskCommentBtn"
                autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"
                onclick="add_task_comment('<?php echo e($task->id); ?>');" data-comment-task-id="<?php echo e($task->id); ?>">
                <?php echo _l('task_single_add_new_comment'); ?>
            </button>
            <?php echo form_close(); ?>
            <div class="clearfix"></div>
            <?php if (count($task->comments) > 0) {
                echo '<hr />';
            } ?>
            <div id="task-comments" class="mtop10">
                <?php
                $comments = '';
                $len      = count($task->comments);
                $i        = 0;
                foreach ($task->comments as $comment) {
                    $comments .= '<div id="comment_' . $comment['id'] . '" data-commentid="' . $comment['id'] . '" data-task-attachment-id="' . $comment['file_id'] . '" class="tc-content task-comment' . (strtotime($comment['dateadded']) >= strtotime('-16 hours') ? ' highlight-bg' : '') . '">';
                    $comments .= '<a data-task-comment-href-id="' . $comment['id'] . '" href="' . admin_url('tasks/view/' . $task->id) . '#comment_' . $comment['id'] . '" class="task-date-as-comment-id"><span class="tw-text-sm"><span class="text-has-action inline-block" data-toggle="tooltip" data-title="' . e(_dt($comment['dateadded'])) . '">' . e(time_ago($comment['dateadded'])) . '</span></span></a>';
                    if ($comment['staffid'] != 0) {
                        $comments .= '<a href="' . admin_url('profile/' . $comment['staffid']) . '" target="_blank">' . staff_profile_image($comment['staffid'], [
                            'staff-profile-image-small',
                            'media-object img-circle pull-left mright10',
                        ]) . '</a>';
                    } elseif ($comment['contact_id'] != 0) {
                        $comments .= '<img src="' . e(contact_profile_image_url($comment['contact_id'])) . '" class="client-profile-image-small media-object img-circle pull-left mright10">';
                    }
                    if ($comment['staffid'] == get_staff_user_id() || is_admin()) {
                        $comment_added = strtotime($comment['dateadded']);
                        $minus_1_hour  = strtotime('-1 hours');
                        if (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 0 || (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 1 && $comment_added >= $minus_1_hour) || is_admin()) {
                            $comments .= '<span class="pull-right tw-mx-1.5"><a href="#" onclick="remove_task_comment(' . $comment['id'] . '); return false;" class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700"><i class="fa fa-trash-can"></i></span></a>';
                            $comments .= '<span class="pull-right mright5"><a href="#" onclick="edit_task_comment(' . $comment['id'] . '); return false;" class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700"><i class="fa-regular fa-pen-to-square"></i></span></a>';
                        }
                    }

                    $comments .= '<div class="media-body comment-wrapper">';
                    $comments .= '<div class="mleft40">';

                    if ($comment['staffid'] != 0) {
                        $comments .= '<a href="' . admin_url('profile/' . $comment['staffid']) . '" target="_blank">' . e($comment['staff_full_name']) . '</a> <br />';
                    } elseif ($comment['contact_id'] != 0) {
                        $comments .= '<span class="label label-info mtop5 mbot5 inline-block">' . _l('is_customer_indicator') . '</span><br /><a href="' . admin_url('clients/client/' . get_user_id_by_contact_id($comment['contact_id']) . '?contactid=' . $comment['contact_id']) . '" class="pull-left" target="_blank">' . e(get_contact_full_name($comment['contact_id'])) . '</a> <br />';
                    }

                    $comments .= '<div data-edit-comment="' . $comment['id'] . '" class="hide edit-task-comment"><textarea rows="5" id="task_comment_' . $comment['id'] . '" class="ays-ignore form-control">' . str_replace('[task_attachment]', '', $comment['content']) . '</textarea>
                  <div class="clearfix mtop20"></div>
                  <button type="button" class="btn btn-primary pull-right" onclick="save_edited_comment(' . $comment['id'] . ',' . $task->id . ')">' . _l('submit') . '</button>
                  <button type="button" class="btn btn-default pull-right mright5" onclick="cancel_edit_comment(' . $comment['id'] . ')">' . _l('cancel') . '</button>
                  </div>';
                    if ($comment['file_id'] != 0) {
                        $comment['content'] = str_replace('[task_attachment]', '<div class="clearfix"></div>' . $attachments_data[$comment['file_id']], $comment['content']);
                        // Replace lightbox to prevent loading the image twice
                        $comment['content'] = str_replace('data-lightbox="task-attachment"', 'data-lightbox="task-attachment-comment-' . $comment['id'] . '"', $comment['content']);
                    } elseif (count($comment['attachments']) > 0 && isset($comments_attachments[$comment['id']])) {
                        $comment_attachments_html = '';
                        foreach ($comments_attachments[$comment['id']] as $comment_attachment) {
                            $comment_attachments_html .= trim($comment_attachment);
                        }
                        $comment['content'] = str_replace('[task_attachment]', '<div class="clearfix"></div>' . $comment_attachments_html, $comment['content']);
                        // Replace lightbox to prevent loading the image twice
                        $comment['content'] = str_replace('data-lightbox="task-attachment"', 'data-lightbox="task-comment-files-' . $comment['id'] . '"', $comment['content']);
                        $comment['content'] .= '<div class="clearfix"></div>';
                        $comment['content'] .= '<div class="text-center download-all">
                   <hr class="hr-10" />
                   <a href="' . admin_url('tasks/download_files/' . $task->id . '/' . $comment['id']) . '" class="bold">' . _l('download_all') . ' (.zip)
                   </a>
                   </div>';
                    }
                    $comments .= '<div class="comment-content mtop10">' . app_happy_text(check_for_links($comment['content'])) . '</div>';
                    $comments .= '</div>';
                    if ($i >= 0 && $i != $len - 1) {
                        $comments .= '<hr class="task-info-separator" />';
                    }
                    $comments .= '</div>';
                    $comments .= '</div>';
                    $i++;
                }
                echo $comments;
                ?>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    if (typeof(commonTaskPopoverMenuOptions) == 'undefined') {
        var commonTaskPopoverMenuOptions = {
            html: true,
            placement: 'bottom',
            trigger: 'click',
            template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>',
        };
    }

    // Clear memory leak
    if (typeof(taskPopoverMenus) == 'undefined') {
        var taskPopoverMenus = [{
                selector: '.task-menu-options',
                title: "<?php echo _l('actions'); ?>",
            },
            {
                selector: '.task-menu-status',
                title: "<?php echo _l('ticket_single_change_status'); ?>",
            },
            {
                selector: '.task-menu-priority',
                title: "<?php echo _l('task_single_priority'); ?>",
            },
            {
                selector: '.task-menu-milestones',
                title: "<?php echo _l('task_milestone'); ?>",
            },
        ];
    }

    for (var i = 0; i < taskPopoverMenus.length; i++) {
        $(taskPopoverMenus[i].selector + ' .trigger').popover($.extend({}, commonTaskPopoverMenuOptions, {
            title: taskPopoverMenus[i].title,
            content: $('body').find(taskPopoverMenus[i].selector + ' .content-menu').html()
        }));
    }

    if (typeof(Dropbox) != 'undefined') {
        document.getElementById("dropbox-chooser-task").appendChild(Dropbox.createChooseButton({
            success: function(files) {
                taskExternalFileUpload(files, 'dropbox', <?php echo e($task->id); ?>);
            },
            linkType: "preview",
            extensions: app.options.allowed_files.split(','),
        }));
    }

    init_selectpicker();
    init_datepicker();
    init_lightbox();

    tinyMCE.remove('#task_view_description');

    if (typeof(taskAttachmentDropzone) != 'undefined') {
        taskAttachmentDropzone.destroy();
        taskAttachmentDropzone = null;
    }

    taskAttachmentDropzone = new Dropzone("#task-attachment", appCreateDropzoneOptions({
        uploadMultiple: true,
        parallelUploads: 20,
        maxFiles: 20,
        paramName: 'file',
        sending: function(file, xhr, formData) {
            formData.append("taskid", '<?php echo e($task->id); ?>');
        },
        success: function(files, response) {
            response = JSON.parse(response);
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                _task_append_html(response.taskHtml);
            }
        }
    }));

    $('#task-modal').find('.gpicker').googleDrivePicker({
        onPick: function(pickData) {
            taskExternalFileUpload(pickData, 'gdrive', <?php echo e($task->id); ?>);
        }
    });

    $('.edit-timesheet-cancel').click(function() {
        $('.timesheet-edit').addClass('hide');
        $('.add-timesheet').removeClass('hide');
    });

    $('.task-single-edit-timesheet').click(function() {
        var edit_timesheet_id = $(this).data('timesheet-id');
        $('.timesheet-edit, .add-timesheet').addClass('hide');
        $('.task-modal-edit-timesheet-' + edit_timesheet_id).removeClass('hide');
    });

    $('.task-modal-edit-timesheet-form').submit(event => {
        event.preventDefault();
        $('.edit-timesheet-submit').prop('disabled', true);

        var form = new FormData(event.target);
        var data = {};

        data.timer_id = form.get('timer_id');
        data.start_time = form.get('start_time');
        data.end_time = form.get('end_time');
        data.timesheet_staff_id = form.get('staff_id');
        data.timesheet_task_id = form.get('task_id');
        data.note = form.get('note');

        $.post(admin_url + 'tasks/update_timesheet', data).done(function(response) {
            response = JSON.parse(response);
            if (response.success === true || response.success == 'true') {
                init_task_modal(data.timesheet_task_id);
                alert_float('success', response.message);
            } else {
                alert_float('warning', response.message);
            }
            $('.edit-timesheet-submit').prop('disabled', false);
        });
    });
</script>