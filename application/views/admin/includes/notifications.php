<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<a href="#" class="dropdown-toggle notifications-icon !tw-px-0 tw-group" data-toggle="dropdown" aria-expanded="false">
    <span 
        class="sm:tw-rounded-md sm:tw-border sm:tw-border-solid sm:tw-border-neutral-200/60 sm:tw-inline-flex sm:tw-items-center sm:tw-justify-center sm:tw-h-8 sm:tw-w-9 sm:-tw-mt-1.5 sm:group-hover:!tw-bg-neutral-100/60">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="tw-shrink-0 tw-text-neutral-900 tw-w-5 tw-h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
		<span id="notification-count" style="color:white !important; background-color:red !important;" class="tw-leading-none tw-px-1 tw-py-0.5 tw-text-xs tw-z-10 tw-absolute tw-rounded-full -tw-right-1.5 -tw-top-2 sm:tw-top-2 tw-min-w-[18px] tw-min-h-[18px] tw-inline-flex tw-items-center tw-justify-center icon-notifications<?php echo $current_user->total_unread_notifications == 0 ? ' hidden' : ''; ?>"><?php echo e($current_user->total_unread_notifications); ?></span>
    </span>
</a>
<?php $_notifications = $this->misc_model->get_user_notifications(); ?>
<ul id="notification-menu" class="dropdown-menu notifications animated fadeIn width400<?php echo count($_notifications) > 0  ? ' tw-pb-0' : ''; ?>"
    data-total-unread="<?php echo e($current_user->total_unread_notifications); ?>">
    <div class="tw-py-1 tw-px-3 tw-mb-1.5 tw-text-right">
        <a href="#" class="tw-text-right tw-inline"
            onclick="event.stopPropagation(); mark_all_notifications_as_read_inline(this); return false;">
            <?php echo _l('mark_all_as_read'); ?>
        </a>
    </div>
    <li class="divider"></li>
    <?php foreach ($_notifications as $notification) { ?>
    <li class="relative notification-wrapper" data-notification-id="<?php echo e($notification['id']); ?>">
        <a href="<?php echo empty($notification['link']) ? '#' : admin_url($notification['link']); ?>"
            onclick="<?php echo empty($notification['link']) ? 'event.preventDefault();' : ''; ?>"
            class="notification-handler !tw-p-0 <?php echo $notification['isread_inline'] == 0 ? ' unread-notification' : ''; echo empty($notification['link']) ? ' tw-cursor-text' : ' tw-cursor-pointer notification-top notification-link'; ?>">
            <div class="tw-p-3 notification-box">
                <?php
            if (($notification['fromcompany'] == null && $notification['fromuserid'] != 0) || ($notification['fromcompany'] == null && $notification['fromclientid'] != 0)) {
                if ($notification['fromuserid'] != 0) {
                    echo staff_profile_image($notification['fromuserid'], ['staff-profile-image-small', 'img-circle notification-image', 'pull-left']);
                } else {
                    echo '<img src="' . e(contact_profile_image_url($notification['fromclientid'])) . '" class="client-profile-image-small img-circle pull-left notification-image">';
                }
            }
            ?>
                <div class="media-body">
                    <?php
            $additional_data = '';
            if (!empty($notification['additional_data'])) {
                $additional_data = unserialize($notification['additional_data']);

                $i = 0;
                foreach ($additional_data as $data) {
                    if (strpos($data, '<lang>') !== false) {
                        $lang = get_string_between($data, '<lang>', '</lang>');
                        $temp = _l($lang);
                        if (strpos($temp, 'project_status_') !== false) {
                            $status = get_project_status_by_id(strafter($temp, 'project_status_'));
                            $temp   = $status['name'];
                        }
                        $additional_data[$i] = $temp;
                    }
                    $i++;
                }
            }
            $description = _l($notification['description'], $additional_data);
            if (($notification['fromcompany'] == null && $notification['fromuserid'] != 0)
            || ($notification['fromcompany'] == null && $notification['fromclientid'] != 0)) {
                if ($notification['fromuserid'] != 0) {
                    $description = e($notification['from_fullname']) . ' - ' . $description;
                } else {
                    $description = e($notification['from_fullname']) . ' - ' . $description . '<br /><span class="label inline-block mtop5 label-info">' . _l('is_customer_indicator') . '</span>';
                }
            }
            echo '<span class="notification-title">' . $description . '</span>'; ?><br />
                    <span class="tw-text-sm text-muted">
                        <span class="text-has-action" data-placement="right" data-toggle="tooltip"
                            data-title="<?php echo e(_dt($notification['date'])); ?>">
                            <?php echo e(time_ago($notification['date'])); ?>
                        </span>
                    </span>
                </div>
            </div>
        </a>

        <?php if ($notification['isread_inline'] == 0) { ?>
        <a href="#" class="text-muted pull-right not-mark-as-read-inline"
            onclick="set_notification_read_inline(<?php echo e($notification['id']); ?>);" data-placement="left"
            data-toggle="tooltip" data-title="<?php echo _l('mark_as_read'); ?>">
            <small>
                <i class="fa-regular fa-circle"></i>
            </small>
        </a>
        <?php } ?>
    </li>
    <li class="divider !tw-my-0"></li>
    <?php } ?>
    <div class="tw-text-center tw-p-4 tw-bg-neutral-50">
        <?php if (count($_notifications) > 0) { ?>
        <a class="btn btn-default" href="<?php echo admin_url('profile?notifications=true'); ?>">
            <?php echo _l('nav_view_all_notifications'); ?>
        </a>
        <?php } else { ?>
        <p class="tw-text-neutral-500 tw-font-medium tw-mb-0 tw-inline-flex tw-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="tw-w-6 tw-h-6 tw-mr-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <?php echo _l('nav_no_notifications'); ?>
        </p>
        <?php } ?>
    </div>

</ul>
<style>
.hidden {
    display: none;
}
</style>
<script>
function updateNotificationsForAllPages() {
    $.ajax({
        url: '<?php echo site_url("notifications/data"); ?>',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const notificationCountElem = $('#notification-count');
            const currentCount = parseInt(notificationCountElem.text()) || 0;
            if (data.count > currentCount) {
                notificationCountElem.removeClass('hidden').text(data.count);

                const sound = new Audio("<?php echo site_url('resources/audio/notification.wav'); ?>");
                sound.play();

                const notificationMenu = $('#notification-menu');
                notificationMenu.attr('data-total-unread', data.count);

				notificationMenu.find('li.notification-wrapper').remove();
            
				data.notifications.forEach(notification => {
					const notificationHtml = `
						<li class="relative notification-wrapper" data-notification-id="${notification.id}">
							<a href="${notification.link || '#'}" onclick="${notification.link ? '' : 'event.preventDefault();'}" class="notification-handler !tw-p-0 ${notification.isread_inline == 0 ? ' unread-notification' : ''} ${notification.link ? ' tw-cursor-pointer notification-top notification-link' : ' tw-cursor-text'}">
								<div class="tw-p-3 notification-box">
									${notification.profileImage ? notification.profileImage : ''}
									<div class="media-body">
										<span class="notification-title">${notification.description}</span><br />
										<span class="tw-text-sm text-muted">
											<span class="text-has-action" data-placement="right" data-toggle="tooltip" data-title="${notification.date}">
												${notification.timeAgo}
											</span>
										</span>
									</div>
								</div>
							</a>
							${notification.isread_inline == 0 ? 
							`<a href="#" class="text-muted pull-right not-mark-as-read-inline" onclick="set_notification_read_inline(${notification.id});" data-placement="left" data-toggle="tooltip" data-title="<?php echo _l('mark_as_read'); ?>">
								<small><i class="fa-regular fa-circle"></i></small>
							</a>` 
							: ''}
						</li>
						<li class="divider !tw-my-0"></li>`;
					
					notificationMenu.append(notificationHtml);
				});

				const viewAllLink = notificationMenu.find('.tw-text-center a');
				if (data.count > 0) {
					viewAllLink.attr('href', '<?php echo admin_url('profile?notifications=true'); ?>');
				} else {
					viewAllLink.replaceWith(`
						<p class="tw-text-neutral-500 tw-font-medium tw-mb-0 tw-inline-flex tw-items-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6 tw-mr-1">
								<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
							</svg>
							<?php echo _l('nav_no_notifications'); ?>
						</p>
					`);
				}
        	}
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching notifications:', textStatus, errorThrown);
        }
    });
}

setInterval(updateNotificationsForAllPages, 2500);
</script>