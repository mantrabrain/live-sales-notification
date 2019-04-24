   <!-- Tab Content !-->
    <table class="optiontable form-table">
        <tbody>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo esc_attr(live_sales_notifications_set_field('enable_single_product')) ?>"><?php esc_html_e('Run single product', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui toggle checkbox">
                    <input id="<?php echo esc_attr(live_sales_notifications_set_field('enable_single_product')) ?>"
                           type="checkbox" <?php checked(live_sales_notifications_get_field('enable_single_product'), 1) ?>
                           tabindex="0" class="hidden" value="1"
                           name="<?php echo esc_attr(live_sales_notifications_set_field('enable_single_product')) ?>"/>
                    <label></label>
                </div>
                <p class="description"><?php esc_html_e('Notification will only display current product in product detail page that they are viewing.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo esc_attr(live_sales_notifications_set_field('notification_product_show_type')) ?>"><?php esc_html_e('Notification show', 'live-sales-notifications') ?></label>
            </th>
            <td>

                <select name="<?php echo esc_attr(live_sales_notifications_set_field('notification_product_show_type')); ?>"
                        class="mbui fluid dropdown">
                    <option <?php selected(live_sales_notifications_get_field('notification_product_show_type', 0), '0') ?>
                            value="0"><?php echo esc_html__('Current product', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('notification_product_show_type')) ?>
                            value="1"><?php echo esc_html__('Products in the same category', 'live-sales-notifications') ?></option>
                </select>

                <p class="description"><?php esc_html_e('In product single page, Notification can only display current product or other products in the same category.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top" class="only_current_product hidden">
            <th scope="row">
                <label for="<?php echo esc_attr(live_sales_notifications_set_field('show_variation')); ?>"><?php esc_html_e('Show variation', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui toggle checkbox">
                    <input id="<?php echo esc_attr(live_sales_notifications_set_field('show_variation')) ?>"
                           type="checkbox" <?php checked(live_sales_notifications_get_field('show_variation'), 1) ?>
                           tabindex="0" class="hidden" value="1"
                           name="<?php echo esc_attr(live_sales_notifications_set_field('show_variation')) ?>"/>
                    <label></label>
                </div>
                <p class="description"><?php esc_html_e('Show variation instead of product variable.', 'live-sales-notifications') ?></p>
            </td>
        </tr>

        </tbody>
    </table>