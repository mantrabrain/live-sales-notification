   <!-- Tab Content !-->
    <table class="optiontable form-table">
        <tbody>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo live_sales_notifications_set_field('audio_enable') ?>"><?php esc_html_e('Enable', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <div class="mbui toggle checkbox">
                    <input id="<?php echo live_sales_notifications_set_field('audio_enable') ?>"
                           type="checkbox" <?php checked(live_sales_notifications_get_field('audio_enable'), 1) ?>
                           tabindex="0" class="hidden" value="1"
                           name="<?php echo live_sales_notifications_set_field('audio_enable') ?>"/>
                    <label></label>
                </div>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><?php esc_html_e('Audio', 'live-sales-notifications') ?></label>
            </th>
            <td>
                <?php
                $audios = self::get_audios();
                ?>
                <select name="<?php echo live_sales_notifications_set_field('audio') ?>" class="mbui fluid dropdown">
                    <?php foreach ($audios as $audio) { ?>
                        <option <?php selected(live_sales_notifications_get_field('audio', 'cool'), $audio) ?>
                                value="<?php echo esc_attr($audio) ?>"><?php echo esc_html($audio) ?></option>
                    <?php } ?>
                </select>

                <p class="description"><?php echo esc_html__('Please select audio. Notification rings when show.', 'live-sales-notifications') ?></p>
            </td>
        </tr>
        </tbody>
    </table>