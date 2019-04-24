<!-- Tab Content !-->
<table class="optiontable form-table">
    <tbody>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Store Type', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <select name="<?php live_sales_notifications_set_field('store_type') ?>"
                    class="mbui fluid dropdown">
                <?php $store_types = live_sales_notifications_store_type();

                foreach ($store_types as $store => $label) {
                    ?>
                    <option <?php selected(live_sales_notifications_get_field('store_type'), $store) ?>
                            value="<?php echo esc_attr($store); ?>"><?php echo esc_html($label) ?></option>
                <?php }
                ?>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo live_sales_notifications_set_field('enable') ?>">
                <?php esc_html_e('Enable', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo live_sales_notifications_set_field('enable') ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('enable'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo live_sales_notifications_set_field('enable') ?>"/>
                <label></label>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo live_sales_notifications_set_field('enable_mobile') ?>">
                <?php esc_html_e('Mobile', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo live_sales_notifications_set_field('enable_mobile') ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('enable_mobile'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo live_sales_notifications_set_field('enable_mobile') ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Notification will show on mobile and responsive.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    </tbody>
</table>