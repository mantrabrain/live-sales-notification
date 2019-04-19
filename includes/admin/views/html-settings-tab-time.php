
    <!-- Tab Content !-->
    <table class="optiontable form-table">
        <tbody>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo live_sales_notifications_set_field('loop') ?>"><?php esc_html_e('Loop', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui toggle checkbox">
                    <input id="<?php echo live_sales_notifications_set_field('loop') ?>"
                           type="checkbox" <?php checked(live_sales_notifications_get_field('loop'), 1) ?> tabindex="0"
                           class="hidden" value="1" name="<?php echo live_sales_notifications_set_field('loop') ?>"/>
                    <label></label>
                </div>
            </td>
        </tr>
        <tr valign="top" class="hidden time_loop">
            <th scope="row">
                <label><?php esc_html_e('Next time display', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui form">
                    <div class="inline fields">
                        <input type="number" name="<?php echo live_sales_notifications_set_field('next_time') ?>"
                               value="<?php echo live_sales_notifications_get_field('next_time', 60) ?>"/>
                        <label><?php esc_html_e('seconds', 'live-sales-notifications') ?></label>
                    </div>
                </div>
                <p class="description"><?php esc_html_e('Time to show next notification ', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top" class="hidden time_loop">
            <th scope="row">
                <label><?php esc_html_e('Notification per page', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <input type="number" name="<?php echo live_sales_notifications_set_field('notification_per_page') ?>"
                       value="<?php echo live_sales_notifications_get_field('notification_per_page', 30) ?>"/>

                <p class="description"><?php esc_html_e('Number of notifications on a page.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo live_sales_notifications_set_field('initial_delay_random') ?>"><?php esc_html_e('Initial time random', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui toggle checkbox">
                    <input id="<?php echo live_sales_notifications_set_field('initial_delay_random') ?>"
                           type="checkbox" <?php checked(live_sales_notifications_get_field('initial_delay_random'), 1) ?>
                           tabindex="0" class="hidden" value="1"
                           name="<?php echo live_sales_notifications_set_field('initial_delay_random') ?>"/>
                    <label></label>
                </div>
                <p class="description"><?php esc_html_e('Initial time will be random from 0 to current value.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top" class="hidden initial_delay_random">
            <th scope="row">
                <label><?php esc_html_e('Minimum initial delay time', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui form">
                    <div class="inline fields">
                        <input type="number" name="<?php echo live_sales_notifications_set_field('initial_delay_min') ?>"
                               value="<?php echo live_sales_notifications_get_field('initial_delay_min', 0) ?>"/>
                        <label><?php esc_html_e('seconds', 'live-sales-notifications') ?></label>
                    </div>
                </div>
                <p class="description"><?php esc_html_e('Time will be random from Initial delay time min to Initial time.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><?php esc_html_e('Initial delay', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui form">
                    <div class="inline fields">
                        <input type="number" name="<?php echo live_sales_notifications_set_field('initial_delay') ?>"
                               value="<?php echo live_sales_notifications_get_field('initial_delay', 0) ?>"/>
                        <label><?php esc_html_e('seconds', 'live-sales-notifications') ?></label>
                    </div>
                </div>
                <p class="description"><?php esc_html_e('When your site loads, notifications will show after this amount of time', 'live-sales-notifications') ?></p>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label><?php esc_html_e('Display time', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui form">
                    <div class="inline fields">
                        <input type="number" name="<?php echo live_sales_notifications_set_field('display_time') ?>"
                               value="<?php echo live_sales_notifications_get_field('display_time', 5) ?>"/>
                        <label><?php esc_html_e('seconds', 'live-sales-notifications') ?></label>
                    </div>
                </div>
                <p class="description"><?php esc_html_e('Time your notification display.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        </tbody>
    </table>