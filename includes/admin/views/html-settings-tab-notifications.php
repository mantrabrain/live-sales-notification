    <!-- Tab Content !-->
    <table class="optiontable form-table">
        <tbody>
        <tr valign="top">
            <th scope="row">
                <label><?php esc_html_e('Message purchased', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <table class="mbui sales-notification optiontable form-table">
                    <?php $messages = live_sales_notifications_get_field('message_purchased');
                    if (!$messages) {
                        $messages = array('Someone in {city}, {country} purchased a {product_with_link} {time_ago}');
                    } elseif (!is_array($messages) && $messages) {
                        $messages = array($messages);
                    }

                    if (count($messages)) {
                        foreach ($messages as $k => $message) {

                            ?>
                            <tr>
                                <td width="90%">

                                                    <textarea
                                                            name="<?php echo esc_attr(live_sales_notifications_set_field('message_purchased', 1)) ?>"><?php echo strip_tags($message) ?></textarea>

                                </td>
                                <td>
                                    <span class="mbui button remove-message red"><?php esc_html_e('Remove', 'live-sales-notifications') ?></span>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </table>
                <p>
                    <span class="mbui button add-message green"><?php esc_html_e('Add New', 'live-sales-notifications') ?></span>
                </p>
                <ul class="description" style="list-style: none">
                    <li>
                        <span>{first_name}</span>
                        - <?php esc_html_e('Customer\'s first name', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{city}</span>
                        - <?php esc_html_e('Customer\'s city', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{state}</span>
                        - <?php esc_html_e('Customer\'s state', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{country}</span>
                        - <?php esc_html_e('Customer\'s country', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{product}</span>
                        - <?php esc_html_e('Product title', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{product_with_link}</span>
                        - <?php esc_html_e('Product title with link', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{time_ago}</span>
                        - <?php esc_html_e('Time after purchase', 'live-sales-notifications') ?>
                    </li>
                    <li>
                        <span>{custom}</span>
                        - <?php esc_html_e('Use custom shortcode', 'live-sales-notifications') ?>
                    </li>
                </ul>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo esc_attr(live_sales_notifications_set_field('custom_shortcode')) ?>"><?php esc_html_e('Custom', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <?php $custom_shortcode = live_sales_notifications_get_field('custom_shortcode', esc_attr('{number} people seeing this product right now')); ?>
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('custom_shortcode')) ?>" type="text" tabindex="0"
                       value="<?php echo $custom_shortcode ?>"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('custom_shortcode')) ?>"/>

                <p class="description"><?php esc_html_e('This is {custom} shortcode content.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo esc_attr(live_sales_notifications_set_field('min_number')) ?>"><?php esc_html_e('Min Number', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('min_number')) ?>" type="number" tabindex="0"
                       value="<?php echo esc_attr(live_sales_notifications_get_field('min_number', 100)) ?>"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('min_number')) ?>"/>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo esc_attr(live_sales_notifications_set_field('max_number')) ?>"><?php esc_html_e('Max number', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('max_number')) ?>" type="number" tabindex="0"
                       value="<?php echo esc_attr(live_sales_notifications_get_field('max_number', 200)) ?>"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('max_number')) ?>"/>

                <p class="description"><?php esc_html_e('Number will random from Min number to Max number', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        </tbody>
    </table>