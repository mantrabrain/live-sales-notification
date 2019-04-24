<!-- Tab Content !-->
<table class="optiontable form-table">
    <tbody>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Product font color', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <input data-ele="highlight" type="text" class="color-picker"
                   name="<?php echo esc_attr(live_sales_notifications_set_field('product_color')) ?>"
                   value="<?php echo esc_attr(live_sales_notifications_get_field('product_color', '#000000')) ?>"
                   style="background-color: <?php echo esc_attr(live_sales_notifications_get_field('product_color', '#000000')) ?>"/>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Text color', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <input data-ele="textcolor"
                   style="background-color: <?php echo esc_attr(live_sales_notifications_get_field('text_color', '#000000')) ?>"
                   type="text" class="color-picker"
                   name="<?php echo esc_attr(live_sales_notifications_set_field('text_color')) ?>"
                   value="<?php echo esc_attr(live_sales_notifications_get_field('text_color', '#000000')) ?>"/>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Background color', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <input style="background-color: <?php echo esc_attr(live_sales_notifications_get_field('background_color', '#ffffff')) ?>"
                   data-ele="backgroundcolor" type="text" class="color-picker"
                   name="<?php echo esc_attr(live_sales_notifications_set_field('background_color')) ?>"
                   value="<?php echo esc_attr(live_sales_notifications_get_field('background_color', '#ffffff')) ?>"/>
        </td>
    </tr>
    <tr valign="top" class="background-image">
        <th scope="row">
            <label><?php esc_html_e('Background Image', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui grid">
                <?php $attachment_id = (int)live_sales_notifications_get_field('background_image', 0);

                $attachment_url = wp_get_attachment_url($attachment_id);
                ?>
                <div class="four wide column image-picker-wrap">
                    <img id='image-preview' class="image-preview"
                         src='<?php echo esc_url($attachment_url); ?>'
                         style='height: 96px; width: 320px; <?php echo (empty($attachment_url) || $attachment_id < 1) ? 'display:none;' : ''; ?>'>
                    <input id="upload_image_button" type="button" class="upload_image_button button"
                           value="<?php _e('Upload image'); ?>"/>
                    <input id="remove_image_button" type="button" class="remove_image_button button"
                           value="<?php _e('Remove image'); ?>"
                           style="<?php echo (empty($attachment_url) || $attachment_id < 1) ? 'display:none;' : ''; ?>"/>

                    <input id="<?php echo esc_attr(live_sales_notifications_set_field('background_image')) ?>"
                           type="hidden" <?php checked(live_sales_notifications_get_field('background_image', 0), 0) ?>
                           tabindex="0" class="text image_attachment_id"
                           value="<?php echo $attachment_id; ?>"
                           name="<?php echo esc_attr(live_sales_notifications_set_field('background_image')) ?>"/>


                </div>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Image Position', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <select name="<?php echo esc_attr(live_sales_notifications_set_field('image_position')) ?>"
                    class="mbui fluid dropdown">
                <option <?php selected(live_sales_notifications_get_field('image_position'), 0) ?>
                        value="0"><?php esc_attr_e('Left', 'live-sales-notifications') ?></option>
                <option <?php selected(live_sales_notifications_get_field('image_position'), 1) ?>
                        value="1"><?php esc_attr_e('Right', 'live-sales-notifications') ?></option>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Position', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui form">
                <div class="fields">
                    <div class="four wide field">
                        <div class="mbui toggle checkbox center aligned segment">
                            <input id="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"
                                   type="radio" <?php checked(live_sales_notifications_get_field('position', 0), 0) ?>
                                   tabindex="0" class="hidden" value="0"
                                   name="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"/>
                            <label><?php esc_attr_e('Bottom left', 'live-sales-notifications') ?></label>
                        </div>

                    </div>
                    <div class="four wide field">


                        <div class="mbui toggle checkbox center aligned segment">
                            <input id="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"
                                   type="radio" <?php checked(live_sales_notifications_get_field('position'), 1) ?>
                                   tabindex="0" class="hidden" value="1"
                                   name="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"/>
                            <label><?php esc_attr_e('Bottom right', 'live-sales-notifications') ?></label>
                        </div>
                    </div>
                    <div class="four wide field">


                        <div class="mbui toggle checkbox center aligned segment">
                            <input id="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"
                                   type="radio" <?php checked(live_sales_notifications_get_field('position'), 2) ?>
                                   tabindex="0" class="hidden" value="2"
                                   name="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"/>
                            <label><?php esc_attr_e('Top left', 'live-sales-notifications') ?></label>
                        </div>
                    </div>
                    <div class="four wide field">


                        <div class="mbui toggle checkbox center aligned segment">
                            <input id="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"
                                   type="radio" <?php checked(live_sales_notifications_get_field('position'), 3) ?>
                                   tabindex="0" class="hidden" value="3"
                                   name="<?php echo esc_attr(live_sales_notifications_set_field('position')) ?>"/>
                            <label><?php esc_attr_e('Top right', 'live-sales-notifications') ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label><?php esc_html_e('Border radius', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui form">
                <div class="inline fields">
                    <input type="number" name="<?php echo esc_attr(live_sales_notifications_set_field('border_radius')) ?>"
                           value="<?php echo esc_attr(live_sales_notifications_get_field('border_radius', '0')) ?>"/>
                    <label><?php esc_html_e('px', 'live-sales-notifications') ?></label>
                </div>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('show_close_icon')) ?>">
                <?php esc_html_e('Show Close Icon', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('show_close_icon')) ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('show_close_icon'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('show_close_icon'))?>"/>
                <label></label>
            </div>
        </td>
    </tr>
    <tr valign="top" class="show-close-icon hidden">
        <th scope="row">
            <label><?php esc_html_e('Time close', 'live-sales-notifications') ?></label>
        </th>
        <td>
            <div class="mbui form">
                <div class="inline fields">
                    <input type="number" name="<?php echo esc_attr(live_sales_notifications_set_field('time_close')) ?>"
                           value="<?php echo esc_attr(live_sales_notifications_get_field('time_close', '24')) ?>"/>
                    <label><?php esc_html_e('hours', 'live-sales-notifications') ?></label>
                </div>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('image_redirect')) ?>">
                <?php esc_html_e('Image redirect', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('image_redirect')) ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('image_redirect'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('image_redirect')) ?>"/>
                <label></label>
            </div>
            <p class="description"><?php echo esc_html__('When click image, you will redirect to product single page.', 'live-sales-notifications') ?></p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('image_redirect_target')) ?>">
                <?php esc_html_e('Link target', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <div class="mbui toggle checkbox">
                <input id="<?php echo esc_attr(live_sales_notifications_set_field('image_redirect_target')) ?>"
                       type="checkbox" <?php checked(live_sales_notifications_get_field('image_redirect_target'), 1) ?>
                       tabindex="0" class="hidden" value="1"
                       name="<?php echo esc_attr(live_sales_notifications_set_field('image_redirect_target')) ?>"/>
                <label></label>
            </div>
            <p class="description"><?php echo esc_html__('Open link on new tab.', 'live-sales-notifications') ?></p>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('message_display_effect')) ?>">
                <?php esc_html_e('Message display effect', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <select name="<?php echo esc_attr(live_sales_notifications_set_field('message_display_effect')) ?>"
                    class="mbui fluid dropdown"
                    id="<?php echo esc_attr(live_sales_notifications_set_field('message_display_effect')) ?>">
                <optgroup label="Bouncing Entrances">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'bounceIn') ?>
                            value="bounceIn"><?php esc_attr_e('bounceIn', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'bounceInDown') ?>
                            value="bounceInDown"><?php esc_attr_e('bounceInDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'bounceInLeft') ?>
                            value="bounceInLeft"><?php esc_attr_e('bounceInLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'bounceInRight') ?>
                            value="bounceInRight"><?php esc_attr_e('bounceInRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'bounceInUp') ?>
                            value="bounceInUp"><?php esc_attr_e('bounceInUp', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Fading Entrances">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fade-in') ?>
                            value="fade-in"><?php esc_attr_e('fadeIn', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInDown') ?>
                            value="fadeInDown"><?php esc_attr_e('fadeInDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInDownBig') ?>
                            value="fadeInDownBig"><?php esc_attr_e('fadeInDownBig', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInLeft') ?>
                            value="fadeInLeft"><?php esc_attr_e('fadeInLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInLeftBig') ?>
                            value="fadeInLeftBig"><?php esc_attr_e('fadeInLeftBig', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInRight') ?>
                            value="fadeInRight"><?php esc_attr_e('fadeInRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInRightBig') ?>
                            value="fadeInRightBig"><?php esc_attr_e('fadeInRightBig', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInUp') ?>
                            value="fadeInUp"><?php esc_attr_e('fadeInUp', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'fadeInUpBig') ?>
                            value="fadeInUpBig"><?php esc_attr_e('fadeInUpBig', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Flippers">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'flipInX') ?>
                            value="flipInX"><?php esc_attr_e('flipInX', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'flipInY') ?>
                            value="flipInY"><?php esc_attr_e('flipInY', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Lightspeed">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'lightSpeedIn') ?>
                            value="lightSpeedIn"><?php esc_attr_e('lightSpeedIn', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Rotating Entrances">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'rotateIn') ?>
                            value="rotateIn"><?php esc_attr_e('rotateIn', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'rotateInDownLeft') ?>
                            value="rotateInDownLeft"><?php esc_attr_e('rotateInDownLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'rotateInDownRight') ?>
                            value="rotateInDownRight"><?php esc_attr_e('rotateInDownRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'rotateInUpLeft') ?>
                            value="rotateInUpLeft"><?php esc_attr_e('rotateInUpLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'rotateInUpRight') ?>
                            value="rotateInUpRight"><?php esc_attr_e('rotateInUpRight', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Sliding Entrances">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'slideInUp') ?>
                            value="slideInUp"><?php esc_attr_e('slideInUp', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'slideInDown') ?>
                            value="slideInDown"><?php esc_attr_e('slideInDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'slideInLeft') ?>
                            value="slideInLeft"><?php esc_attr_e('slideInLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'slideInRight') ?>
                            value="slideInRight"><?php esc_attr_e('slideInRight', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Zoom Entrances">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'zoomIn') ?>
                            value="zoomIn"><?php esc_attr_e('zoomIn', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'zoomInDown') ?>
                            value="zoomInDown"><?php esc_attr_e('zoomInDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'zoomInLeft') ?>
                            value="zoomInLeft"><?php esc_attr_e('zoomInLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'zoomInRight') ?>
                            value="zoomInRight"><?php esc_attr_e('zoomInRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'zoomInUp') ?>
                            value="zoomInUp"><?php esc_attr_e('zoomInUp', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Special">
                    <option <?php selected(live_sales_notifications_get_field('message_display_effect'), 'rollIn') ?>
                            value="rollIn"><?php esc_attr_e('rollIn', 'live-sales-notifications') ?></option>
                </optgroup>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('message_hidden_effect')) ?>">
                <?php esc_html_e('Message hidden effect', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
            <select name="<?php echo esc_attr(live_sales_notifications_set_field('message_hidden_effect')) ?>"
                    class="mbui fluid dropdown"
                    id="<?php echo esc_attr(live_sales_notifications_set_field('message_hidden_effect')) ?>">
                <optgroup label="Bouncing Exits">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'bounceOut') ?>
                            value="bounceOut"><?php esc_attr_e('bounceOut', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'bounceOutDown') ?>
                            value="bounceOutDown"><?php esc_attr_e('bounceOutDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'bounceOutLeft') ?>
                            value="bounceOutLeft"><?php esc_attr_e('bounceOutLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'bounceOutRight') ?>
                            value="bounceOutRight"><?php esc_attr_e('bounceOutRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'bounceOutUp') ?>
                            value="bounceOutUp"><?php esc_attr_e('bounceOutUp', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Fading Exits">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fade-out') ?>
                            value="fade-out"><?php esc_attr_e('fadeOut', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutDown') ?>
                            value="fadeOutDown"><?php esc_attr_e('fadeOutDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutDownBig') ?>
                            value="fadeOutDownBig"><?php esc_attr_e('fadeOutDownBig', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutLeft') ?>
                            value="fadeOutLeft"><?php esc_attr_e('fadeOutLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutLeftBig') ?>
                            value="fadeOutLeftBig"><?php esc_attr_e('fadeOutLeftBig', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutRight') ?>
                            value="fadeOutRight"><?php esc_attr_e('fadeOutRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutRightBig') ?>
                            value="fadeOutRightBig"><?php esc_attr_e('fadeOutRightBig', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutUp') ?>
                            value="fadeOutUp"><?php esc_attr_e('fadeOutUp', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'fadeOutUpBig') ?>
                            value="fadeOutUpBig"><?php esc_attr_e('fadeOutUpBig', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Flippers">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'flipOutX') ?>
                            value="flipOutX"><?php esc_attr_e('flipOutX', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'flipOutY') ?>
                            value="flipOutY"><?php esc_attr_e('flipOutY', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Lightspeed">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'lightSpeedOut') ?>
                            value="lightSpeedOut"><?php esc_attr_e('lightSpeedOut', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Rotating Exits">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'rotateOut') ?>
                            value="rotateOut"><?php esc_attr_e('rotateOut', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'rotateOutDownLeft') ?>
                            value="rotateOutDownLeft"><?php esc_attr_e('rotateOutDownLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'rotateOutDownRight') ?>
                            value="rotateOutDownRight"><?php esc_attr_e('rotateOutDownRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'rotateOutUpLeft') ?>
                            value="rotateOutUpLeft"><?php esc_attr_e('rotateOutUpLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'rotateOutUpRight') ?>
                            value="rotateOutUpRight"><?php esc_attr_e('rotateOutUpRight', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Sliding Exits">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'slideOutUp') ?>
                            value="slideOutUp"><?php esc_attr_e('slideOutUp', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'slideOutDown') ?>
                            value="slideOutDown"><?php esc_attr_e('slideOutDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'slideOutLeft') ?>
                            value="slideOutLeft"><?php esc_attr_e('slideOutLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'slideOutRight') ?>
                            value="slideOutRight"><?php esc_attr_e('slideOutRight', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Zoom Exits">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'zoomOut') ?>
                            value="zoomOut"><?php esc_attr_e('zoomOut', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'zoomOutDown') ?>
                            value="zoomOutDown"><?php esc_attr_e('zoomOutDown', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'zoomOutLeft') ?>
                            value="zoomOutLeft"><?php esc_attr_e('zoomOutLeft', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'zoomOutRight') ?>
                            value="zoomOutRight"><?php esc_attr_e('zoomOutRight', 'live-sales-notifications') ?></option>
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'zoomOutUp') ?>
                            value="zoomOutUp"><?php esc_attr_e('zoomOutUp', 'live-sales-notifications') ?></option>
                </optgroup>
                <optgroup label="Special">
                    <option <?php selected(live_sales_notifications_get_field('message_hidden_effect'), 'rollOut') ?>
                            value="rollOut"><?php esc_attr_e('rollOut', 'live-sales-notifications') ?></option>
                </optgroup>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="<?php echo esc_attr(live_sales_notifications_set_field('custom_css')) ?>">
                <?php esc_html_e('Custom CSS', 'live-sales-notifications') ?>
            </label>
        </th>
        <td>
                                <textarea class=""
                                          name="<?php echo esc_attr(live_sales_notifications_set_field('custom_css')) ?>"><?php echo esc_html(live_sales_notifications_get_field('custom_css')) ?></textarea>
        </td>
    </tr>
    </tbody>
</table>
<?php
$class = array();
switch (live_sales_notifications_get_field('position')) {
    case 1:
        $class[] = 'bottom_right';
        break;
    case 2:
        $class[] = 'top_left';
        break;
    case 3:
        $class[] = 'top_right';
        break;
    default:
        $class[] = '';
}
$class[] = live_sales_notifications_get_field('image_position') ? 'img-right' : '';


$attachment_id = live_sales_notifications_get_field('background_image', 0);

$attachment_url = wp_get_attachment_url($attachment_id);
$custom_css = 'display:block;';
$custom_css .= !empty($attachment_url) && $attachment_id > 0 ? "background-image:url(" . $attachment_url . "); background-size:cover;" : '';
?>
<div style="<?php echo $custom_css; ?>"
     class="  <?php echo esc_attr(implode(' ', $class)) ?>"
     id="sales-notification"
     data-effect_display="<?php echo esc_attr(live_sales_notifications_get_field('message_display_effect')); ?>"
     data-effect_hidden="<?php echo esc_attr(live_sales_notifications_get_field('message_hidden_effect')); ?>">
    <img src="<?php echo esc_url(live_sales_notifications_instance()->plugin_url() . '/assets/images/sample-product.jpg') ?>">

    <p>Joe Doe in New York , United States purchased a
        <a href="#">Mantranews Pro</a>
        <small>About 9 hours ago</small>
    </p>
    <span id="notify-close"></span>

</div>
