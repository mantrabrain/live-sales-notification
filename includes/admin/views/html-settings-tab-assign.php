<!-- Tab Content !-->
<table class="optiontable form-table">
    <tbody>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('is_home')) ?>"><?php esc_html_e('Home page', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('is_home')) ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('is_home'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('is_home')) ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Hide notification on Home page', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('is_checkout')) ?>"><?php esc_html_e('Checkout page', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('is_checkout')) ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('is_checkout'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('is_checkout')) ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Hide notification on Checkout page', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('is_cart')) ?>"><?php esc_html_e('Cart page', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('is_cart')) ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('is_cart'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('is_cart')) ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Hide notification on Cart page', 'live-sales-notifications') ?></p>
        </td>
    </tr>

    </tbody>
</table>
