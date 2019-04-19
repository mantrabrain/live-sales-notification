<!-- Tab Content !-->
<?php
/**
 *
 * @var $main_instance Live_Sales_Notifications
 */

?>

<table class="optiontable form-table">
    <tbody>

    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Show Products', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <select name="<?php echo live_sales_notifications_set_field('show_product_option') ?>"
                    class="mbui fluid dropdown">
                <option <?php selected(live_sales_notifications_get_field('show_product_option'), 0) ?>
                        value="0"><?php esc_attr_e('Get from Billing', 'live-sales-notifications') ?></option>
                <option <?php selected(live_sales_notifications_get_field('show_product_option'), 1) ?>
                        value="1"><?php esc_attr_e('Select Products', 'live-sales-notifications') ?></option>
                <option <?php selected(live_sales_notifications_get_field('show_product_option'), 2) ?>
                        value="2"><?php esc_attr_e('Latest Products', 'live-sales-notifications') ?></option>
                <option <?php selected(live_sales_notifications_get_field('show_product_option'), 3) ?>
                        value="3"><?php esc_attr_e('Select Categories', 'live-sales-notifications') ?></option>
                <option <?php selected(live_sales_notifications_get_field('show_product_option'), 4) ?>
                        value="4"><?php esc_attr_e('Recently Viewed Products', 'live-sales-notifications') ?></option>
            </select>

            <p class="description"><?php esc_html_e('You can arrange product order or special product which you want to up-sell.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo live_sales_notifications_set_field('enable_out_of_stock_product') ?>"><?php esc_html_e('Out-of-stock products', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo live_sales_notifications_set_field('enable_out_of_stock_product') ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('enable_out_of_stock_product'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo live_sales_notifications_set_field('enable_out_of_stock_product') ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Turn on to show out-of-stock products on notifications.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <!--	Select Categories-->
    <tr valign="top" class="select-categories hidden">
        <th scope="row">
            <label><?php esc_html_e('Select Categories', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <?php
            $cates = live_sales_notifications_get_field('select_categories', array()); ?>
            <select multiple="multiple"
                    name="<?php echo live_sales_notifications_set_field('select_categories', true) ?>"
                    class="category-search"
                    placeholder="<?php esc_attr_e('Please select category', 'live-sales-notifications') ?>">
                <?php
                if (count($cates)) {
                    $categories = get_terms(
                        array(
                            'taxonomy' => 'product_cat',
                            'include' => $cates,
                        )
                    );
                    if (count($categories)) {
                        foreach ($categories as $category) { ?>
                            <option selected="selected"
                                    value="<?php echo esc_attr($category->term_id) ?>"><?php echo esc_html($category->name) ?></option>
                            <?php
                        }
                    }
                } ?>
            </select>
        </td>
    </tr>
    <tr valign="top" class="hidden select-categories">
        <th scope="row">
            <label><?php esc_html_e('Exclude Products', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <?php $products = live_sales_notifications_get_field('cate_exclude_products', array()); ?>
            <select multiple="multiple"
                    name="<?php echo live_sales_notifications_set_field('cate_exclude_products', true) ?>"
                    class="product-search"
                    placeholder="<?php esc_attr_e('Please select products', 'live-sales-notifications') ?>">
                <?php if (count($products)) {

                    $post_type = array('product');
                    if ($main_instance->store_type == 'edd') {
                        $post_type = array('downlaod');
                    }
                    $product_data = $main_instance->compatibility()->product_query($products, $post_type);

                    foreach ($product_data as $product_single_item) {

                        ?>
                        <option selected="selected"
                                value="<?php echo esc_attr($product_single_item['product_id']) ?>"><?php echo esc_html($product_single_item['product_name']) ?></option>
                        <?php
                    }

                    // Reset Post Data
                    wp_reset_postdata();
                } ?>
            </select>

            <p class="description"><?php esc_html_e('These products will not display on notification.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="hidden latest-product-select-categories">
        <th scope="row">
            <label><?php esc_html_e('Product limit', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <input id="<?php echo live_sales_notifications_set_field('limit_product') ?>" type="number" tabindex="0"
                   value="<?php echo live_sales_notifications_get_field('limit_product', 50) ?>"
                   name="<?php echo live_sales_notifications_set_field('limit_product') ?>"/>

            <p class="description"><?php esc_html_e('Product quantity will be got in list latest products.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="hidden exclude_products">
        <th scope="row">
            <label><?php esc_html_e('Exclude Products', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <?php $products = live_sales_notifications_get_field('exclude_products', array()); ?>
            <select multiple="multiple"
                    name="<?php echo live_sales_notifications_set_field('exclude_products', true) ?>"
                    class="product-search"
                    placeholder="<?php esc_attr_e('Please select products', 'live-sales-notifications') ?>">
                <?php if (count($products)) {
                    $post_type = array('product', 'product_variation');
                    if ($main_instance->store_type == 'edd') {
                        $post_type = array('download');
                    }
                    $product_data = $main_instance->compatibility()->product_query($products_ach, $post_type);


                    foreach ($product_data as $product_item) {
                        ?>
                        <option selected="selected"
                                value="<?php echo esc_attr($product_item['product_id']); ?>"><?php echo esc_html($product_item['product_name']); ?></option>
                        <?php

                    }
                    // Reset Post Data
                    wp_reset_postdata();
                } ?>
            </select>

            <p class="description"><?php esc_html_e('These products will not show on notification.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo live_sales_notifications_set_field('product_link') ?>"><?php esc_html_e('External link', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo live_sales_notifications_set_field('product_link') ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('product_link'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo live_sales_notifications_set_field('product_link') ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Working with  External/Affiliate product. Product link is product URL.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="get_from_billing hidden">
        <th scope="row">
            <label><?php esc_html_e('Order Time', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="fields">
                <div class="twelve wide field">
                    <input type="number"
                           value="<?php echo live_sales_notifications_get_field('order_threshold_num', 30) ?>"
                           name="<?php echo live_sales_notifications_set_field('order_threshold_num') ?>"/>
                </div>
                <div class="two wide field">
                    <select name="<?php echo live_sales_notifications_set_field('order_threshold_time') ?>"
                            class="mbui fluid dropdown">
                        <option <?php selected(live_sales_notifications_get_field('order_threshold_time'), 0) ?>
                                value="0"><?php esc_attr_e('Hours', 'live-sales-notifications') ?></option>
                        <option <?php selected(live_sales_notifications_get_field('order_threshold_time'), 1) ?>
                                value="1"><?php esc_attr_e('Days', 'live-sales-notifications') ?></option>
                        <option <?php selected(live_sales_notifications_get_field('order_threshold_time'), 2) ?>
                                value="2"><?php esc_attr_e('Minutes', 'live-sales-notifications') ?></option>
                    </select>
                </div>
            </div>
            <p class="description"><?php esc_html_e('Products in this recently time will get from order.  ', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="get_from_billing hidden">
        <th scope="row">
            <label><?php esc_html_e('Order Status', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <?php
            $order_statuses = live_sales_notifications_get_field('order_statuses');
            if (!is_array($order_statuses)) {
                $order_statuses = array();
            }

            $store_instance = live_sales_notifications_instance()->compatibility();

            $statuses = $store_instance->get_all_order_status();

            ?>
            <select multiple="multiple"
                    name="<?php echo live_sales_notifications_set_field('order_statuses', true) ?>"
                    class="mbui fluid dropdown">
                <?php foreach ($statuses as $k => $status) {
                    $selected = '';
                    if (in_array($k, $order_statuses)) {
                        $selected = 'selected="selected"';
                    }
                    ?>
                    <option <?php echo $selected; ?>
                            value="<?php echo esc_attr($k) ?>"><?php echo esc_html($status) ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr valign="top" class="select_only_product hidden">
        <th scope="row">
            <label><?php esc_html_e('Select Products', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <?php
            $products_ach = live_sales_notifications_get_field('archive_products', array()); ?>
            <select multiple="multiple"
                    name="<?php echo live_sales_notifications_set_field('archive_products', true) ?>"
                    class="product-search"
                    placeholder="<?php esc_attr_e('Please select products', 'live-sales-notifications') ?>">
                <?php if (count($products_ach)) {
                    $post_type = array('product', 'product_variation');
                    if ($main_instance->store_type == 'edd') {
                        $post_type = array('download');
                    }
                    $product_data = $main_instance->compatibility()->product_query($products_ach, $post_type);


                    foreach ($product_data as $product_item) {
                        ?>
                        <option selected="selected"
                                value="<?php echo esc_attr($product_item['product_id']); ?>"><?php echo esc_html($product_item['product_name']); ?></option>
                        <?php

                    }
                    // Reset Post Data
                    wp_reset_postdata();
                } ?>
            </select>
        </td>
    </tr>
    <tr valign="top" class="select_product hidden">
        <th scope="row">
            <label><?php esc_html_e('Virtual First Name', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <?php
            $first_names = live_sales_notifications_get_field('virtual_name')
            ?>
            <textarea
                    name="<?php echo live_sales_notifications_set_field('virtual_name') ?>"><?php echo $first_names ?></textarea>

            <p class="description"><?php esc_html_e('Virtual first name what will show on notification. Each first name on a line.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="select_product hidden">
        <th scope="row">
            <label><?php esc_html_e('Virtual Time', 'live-sales-notifications') ?></label></th>
        <td>
            <div class="mbui form">
                <div class="inline fields">
                    <input type="number" name="<?php echo live_sales_notifications_set_field('virtual_time') ?>"
                           value="<?php echo live_sales_notifications_get_field('virtual_time', '10') ?>"/>
                    <label><?php esc_html_e('hours', 'live-sales-notifications') ?></label>
                </div>
            </div>
            <p class="description"><?php esc_html_e('Time will auto get random in this time threshold ago.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="select_product hidden">
        <th scope="row">
            <label><?php esc_html_e('Address', 'live-sales-notifications') ?></label></th>
        <td>
            <select name="<?php echo live_sales_notifications_set_field('country') ?>" class="mbui fluid dropdown">
                <option <?php selected(live_sales_notifications_get_field('country'), 0) ?>
                        value="0"><?php esc_attr_e('Auto Detect', 'live-sales-notifications') ?></option>
                <option <?php selected(live_sales_notifications_get_field('country'), 1) ?>
                        value="1"><?php esc_attr_e('Virtual', 'live-sales-notifications') ?></option>
            </select>

            <p class="description"><?php esc_html_e('You can use auto detect address or make virtual address of customer.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="virtual_address hidden">
        <th scope="row">
            <label><?php esc_html_e('Virtual City', 'live-sales-notifications') ?></label></th>
        <td>
            <?php
            $virtual_city = live_sales_notifications_get_field('virtual_city');
            ?>
            <textarea
                    name="<?php echo live_sales_notifications_set_field('virtual_city') ?>"><?php echo esc_attr($virtual_city) ?></textarea>

            <p class="description"><?php esc_html_e('Virtual city name what will show on notification. Each city name on a line.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="virtual_address hidden">
        <th scope="row">
            <label><?php esc_html_e('Virtual Country', 'live-sales-notifications') ?></label></th>
        <td>
            <?php $virtual_country = live_sales_notifications_get_field('virtual_country') ?>
            <input type="text" name="<?php echo live_sales_notifications_set_field('virtual_country') ?>"
                   value="<?php echo esc_attr($virtual_country) ?>"/>

            <p class="description"><?php esc_html_e('Virtual country name what will show on notification.', 'live-sales-notifications') ?></p>

        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Product image size', 'live-sales-notifications') ?></label>
        </th>

        <td>
            <?php global $_wp_additional_image_sizes;

            ?>
            <select name="<?php echo live_sales_notifications_set_field('product_sizes') ?>"
                    class="mbui fluid dropdown">
                <?php foreach ($_wp_additional_image_sizes as $thumb => $thumb_option) { ?>
                    <option <?php selected(live_sales_notifications_get_field('product_sizes'), $thumb) ?>
                            value="<?php echo esc_attr($thumb); ?>"><?php echo esc_html($thumb) ?>
                        - <?php echo isset($_wp_additional_image_sizes[$thumb]) ? $_wp_additional_image_sizes[$thumb]['width'] . 'x' . $_wp_additional_image_sizes[$thumb]['height'] : ''; ?></option>
                <?php } ?>
            </select>

            <p class="description"><?php esc_html_e('Image size will get form your WordPress site.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top" class="get_from_billing hidden">
        <th scope="row">
            <label for="<?php echo live_sales_notifications_set_field('non_ajax') ?>"><?php esc_html_e('Non Ajax', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo live_sales_notifications_set_field('non_ajax') ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('non_ajax'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo live_sales_notifications_set_field('non_ajax') ?>"/>
                <label></label>
            </div>
            <p class="description"><?php esc_html_e('Load popup will not use ajax. Your site will be load faster. It creates cache. It is not working with Get product from Billing feature and options of Product detail tab.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    </tbody>
</table>