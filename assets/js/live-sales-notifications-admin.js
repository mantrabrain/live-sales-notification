'use strict';
jQuery(document).ready(function () {
    jQuery('.mbui.tabular.menu .item').vi_tab({
        history: true,
        historyType: 'hash'
    });

    /*Setup tab*/
    var tabs,
        tabEvent = false,
        initialTab = 'general',
        navSelector = '.mbui.menu',
        panelSelector = '.mbui.tab',
        panelFilter = function () {
            jQuery(panelSelector + ' a').filter(function () {
                return jQuery(navSelector + ' a[title=' + jQuery(this).attr('title') + ']').size() != 0;
            }).each(function (event) {
                jQuery(this).attr('href', '#' + $(this).attr('title').replace(/ /g, '_'));
            });
        };
    // Initializes plugin features
    jQuery.address.strict(false).wrap(true);

    if (jQuery.address.value() == '') {
        jQuery.address.history(false).value(initialTab).history(true);
    }

    // Address handler
    jQuery.address.init(function (event) {

        // Adds the ID in a lazy manner to prevent scrolling
        jQuery(panelSelector).attr('id', initialTab);

        panelFilter();

        // Tabs setup
        tabs = jQuery('.mbui.menu')
            .vi_tab({
                history: true,
                historyType: 'hash'
            })

    });

    jQuery('select.mbui.dropdown').dropdown();
    /*Search*/
    jQuery(".product-search").select2({
        placeholder: "Please fill in your  product title",
        ajax: {
            url: "admin-ajax.php?action=live_sales_notifications_search_product",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    /*Search*/
    jQuery(".category-search").select2({
        placeholder: "Please fill in your category title",
        ajax: {
            url: "admin-ajax.php?action=live_sales_notifications_search_cate",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    /*Save Submit button*/
    jQuery('.live-sales-notifications-submit').one('click', function () {
        jQuery(this).addClass('loading');
    });
    /*Add field depend*/
    /*Products*/
    if (jQuery('.get_from_billing').length > 0) {

        jQuery('.get_from_billing').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['0']
            }
        });
    }
    if (jQuery('.show-close-icon').length > 0) {

        jQuery('.show-close-icon').dependsOn({
            'input[name="live_sales_notifications_params[show_close_icon]"]': {
                checked: true
            }
        });
    }
    if (jQuery('.latest-product-select-categories').length > 0) {

        jQuery('.latest-product-select-categories').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['2', '3', '4']
            }
        });
    }
    if (jQuery('.select-categories').length > 0) {

        jQuery('.select-categories').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['3']
            }
        });
    }
    if (jQuery('.select_product').length > 0) {

        jQuery('.select_product').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['1', '2', '3', '4']
            }
        });
    }
    if (jQuery('.select_only_product').length > 0) {

        jQuery('.select_only_product').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['1']
            }
        });
    }
    if (jQuery('.exclude_products').length > 0) {

        jQuery('.exclude_products').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['0']
            }
        });
    }
    if (jQuery('.only_current_product').length > 0) {

        jQuery('.only_current_product').dependsOn({
            'select[name="live_sales_notifications_params[notification_product_show_type]"]': {
                values: ['0']
            }
        });
    }
    if (jQuery('.virtual_address').length > 0) {
        jQuery('.virtual_address').dependsOn({
            'select[name="live_sales_notifications_params[show_product_option]"]': {
                values: ['1', '2', '3', '4']
            },
            'select[name="live_sales_notifications_params[country]"]': {
                values: ['1']
            }
        });
    }
    if (jQuery('select[name="live_sales_notifications_params[show_product_option]').length > 0) {
        jQuery('select[name="live_sales_notifications_params[show_product_option]"]').on('change', function () {
            var data = jQuery(this).val();
            if (data == 0) {
                jQuery('.virtual_address').hide();
            } else {
                var data1 = jQuery('select[name="live_sales_notifications_params[country]"]').val();
                if (data1 > 0) {
                    jQuery('.virtual_address').show();
                }
            }
        });
    }
    if (jQuery('.time_loop').length > 0) {

        /*Time*/
        jQuery('.time_loop').dependsOn({
            'input[name="live_sales_notifications_params[loop]"]': {
                checked: true
            }
        });
    }
    if (jQuery('.initial_delay_random').length > 0) {

        /*Initial time random*/
        jQuery('.initial_delay_random').dependsOn({
            'input[name="live_sales_notifications_params[initial_delay_random]"]': {
                checked: true
            }
        });
    }

// Color picker
    jQuery('.color-picker').iris({
        change: function (event, ui) {
            jQuery(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
            var ele = jQuery(this).data('ele');
            if (ele == 'highlight') {
                jQuery('#sales-notification').find('a').css({'color': ui.color.toString()});
            } else if (ele == 'textcolor') {
                jQuery('#sales-notification').css({'color': ui.color.toString()});
            } else {
                jQuery('#sales-notification').css({backgroundColor: ui.color.toString()});
            }
        },
        hide: true,
        border: true
    }).click(function () {
        jQuery('.iris-picker').hide();
        jQuery(this).closest('td').find('.iris-picker').show();
    });

    jQuery('body').click(function () {
        jQuery('.iris-picker').hide();
    });
    jQuery('.color-picker').click(function (event) {
        event.stopPropagation();
    });

    var image_picker = {

        init: function ($wrapper) {
            this.event($wrapper);
        },
        event: function ($wrapper) {

            var uploadBtn = $wrapper.find('.upload_image_button');
            var removeBtn = $wrapper.find('.remove_image_button');
            var file_frame;
            var wp_media_post_id = $wrapper.attr('data-old-id');
            var set_to_post_id = $wrapper.attr('data-new-id');
            uploadBtn.on('click', function (event) {

                var file_frame;


                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame) {
                    // Set the post ID to what we want
                    file_frame.uploader.uploader.param('post_id', set_to_post_id);
                    // Open frame
                    file_frame.open();
                    return;
                } else {
                    // Set the wp.media post id so the uploader grabs the ID we want when initialised
                    wp.media.model.settings.post.id = set_to_post_id;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select a image to upload',
                    button: {
                        text: 'Use this image',
                    },
                    multiple: false	// Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on('select', function () {
                    // We set multiple to false so only get one image from the uploader
                    var attachment = file_frame.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    $wrapper.find('.image-preview').attr('src', attachment.url).show();
                    removeBtn.show();
                    $wrapper.find('.image_attachment_id').val(attachment.id);
                    jQuery('#sales-notification').css('background-image', 'url("' + attachment.url + '")');
                    // Restore the main post ID
                    wp.media.model.settings.post.id = wp_media_post_id;
                });

                // Finally, open the modal
                file_frame.open();
            });
            removeBtn.on('click', function (event) {

                // Do something with attachment.id and/or attachment.url here
                $wrapper.find('.image-preview').hide();
                $wrapper.find('.image_attachment_id').val(0);
                jQuery('#sales-notification').css({backgroundImage: 'none'});
                removeBtn.hide();


            });
        }

    };
    image_picker.init(jQuery('.image-picker-wrap'));


    jQuery('input[name="live_sales_notifications_params[position]"]').on('change', function () {
        var data = jQuery(this).val();
        if (data == 1) {
            jQuery('#sales-notification').removeClass('top_left top_right').addClass('bottom_right');
        } else if (data == 2) {
            jQuery('#sales-notification').removeClass('bottom_right top_right').addClass('top_left');
        } else if (data == 3) {
            jQuery('#sales-notification').removeClass('bottom_right top_left').addClass('top_right');
        } else {
            jQuery('#sales-notification').removeClass('bottom_right top_left top_right');
        }
    });
    jQuery('select[name="live_sales_notifications_params[image_position]"]').on('change', function () {
        var data = jQuery(this).val();
        if (data == 1) {
            jQuery('#sales-notification').addClass('img-right');
        } else {
            jQuery('#sales-notification').removeClass('img-right');
        }
    });

    /*add optgroup to select box semantic*/
    jQuery('.mbui.dropdown.selection').has('optgroup').each(function () {
        var $menu = jQuery('<div/>').addClass('menu');
        jQuery(this).find('optgroup').each(function () {
            $menu.append("<div class=\"header\">" + this.label + "</div><div class=\"divider\"></div>");
            return jQuery(this).children().each(function () {
                return $menu.append("<div class=\"item\" data-value=\"" + this.value + "\">" + this.innerHTML + "</div>");
            });
        });
        return jQuery(this).find('.menu').html($menu.html());
    });

    jQuery('#sales-notification').attr('data-effect_display', '');
    jQuery('#sales-notification').attr('data-effect_hidden', '');

    jQuery('select[name="live_sales_notifications_params[message_display_effect]"]').on('change', function () {
        var data = jQuery(this).val(),
            message_purchased = jQuery('#sales-notification');

        switch (data) {
            case 'bounceIn':
                message_purchased.attr('data-effect_display', 'bounceIn');
                break;
            case 'bounceInDown':
                message_purchased.attr('data-effect_display', 'bounceInDown');
                break;
            case 'bounceInLeft':
                message_purchased.attr('data-effect_display', 'bounceInLeft');
                break;
            case 'bounceInRight':
                message_purchased.attr('data-effect_display', 'bounceInRight');
                break;
            case 'bounceInUp':
                message_purchased.attr('data-effect_display', 'bounceInUp');
                break;
            case 'fade-in':
                message_purchased.attr('data-effect_display', 'fade-in');
                break;
            case 'fadeInDown':
                message_purchased.attr('data-effect_display', 'fadeInDown');
                break;
            case 'fadeInDownBig':
                message_purchased.attr('data-effect_display', 'fadeInDownBig');
                break;
            case 'fadeInLeft':
                message_purchased.attr('data-effect_display', 'fadeInLeft');
                break;
            case 'fadeInLeftBig':
                message_purchased.attr('data-effect_display', 'fadeInLeftBig');
                break;
            case 'fadeInRight':
                message_purchased.attr('data-effect_display', 'fadeInRight');
                break;
            case 'fadeInRightBig':
                message_purchased.attr('data-effect_display', 'fadeInRightBig');
                break;
            case 'fadeInUp':
                message_purchased.attr('data-effect_display', 'fadeInUp');
                break;
            case 'fadeInUpBig':
                message_purchased.attr('data-effect_display', 'fadeInUpBig');
                break;
            case 'flipInX':
                message_purchased.attr('data-effect_display', 'flipInX');
                break;
            case 'flipInY':
                message_purchased.attr('data-effect_display', 'flipInY');
                break;
            case 'lightSpeedIn':
                message_purchased.attr('data-effect_display', 'lightSpeedIn');
                break;
            case 'rotateIn':
                message_purchased.attr('data-effect_display', 'rotateIn');
                break;
            case 'rotateInDownLeft':
                message_purchased.attr('data-effect_display', 'rotateInDownLeft');
                break;
            case 'rotateInDownRight':
                message_purchased.attr('data-effect_display', 'rotateInDownRight');
                break;
            case 'rotateInUpLeft':
                message_purchased.attr('data-effect_display', 'rotateInUpLeft');
                break;
            case 'rotateInUpRight':
                message_purchased.attr('data-effect_display', 'rotateInUpRight');
                break;
            case 'slideInUp':
                message_purchased.attr('data-effect_display', 'slideInUp');
                break;
            case 'slideInDown':
                message_purchased.attr('data-effect_display', 'slideInDown');
                break;
            case 'slideInLeft':
                message_purchased.attr('data-effect_display', 'slideInLeft');
                break;
            case 'slideInRight':
                message_purchased.attr('data-effect_display', 'slideInRight');
                break;
            case 'zoomIn':
                message_purchased.attr('data-effect_display', 'zoomIn');
                break;
            case 'zoomInDown':
                message_purchased.attr('data-effect_display', 'zoomInDown');
                break;
            case 'zoomInLeft':
                message_purchased.attr('data-effect_display', 'zoomInLeft');
                break;
            case 'zoomInRight':
                message_purchased.attr('data-effect_display', 'zoomInRight');
                break;
            case 'zoomInUp':
                message_purchased.attr('data-effect_display', 'zoomInUp');
                break;
            case 'rollIn':
                message_purchased.attr('data-effect_display', 'rollIn');
                break;
        }

    });

    jQuery('select[name="live_sales_notifications_params[message_hidden_effect]"]').on('change', function () {
        var data = jQuery(this).val(),
            message_purchased = jQuery('#sales-notification');

        switch (data) {
            case 'bounceOut':
                message_purchased.attr('data-effect_hidden', 'bounceOut');
                break;
            case 'bounceOutDown':
                message_purchased.attr('data-effect_hidden', 'bounceOutDown');
                break;
            case 'bounceOutLeft':
                message_purchased.attr('data-effect_hidden', 'bounceOutLeft');
                break;
            case 'bounceOutRight':
                message_purchased.attr('data-effect_hidden', 'bounceOutRight');
                break;
            case 'bounceOutUp':
                message_purchased.attr('data-effect_hidden', 'bounceOutUp');
                break;
            case 'fade-out':
                message_purchased.attr('data-effect_hidden', 'fade-out');
                break;
            case 'fadeOutDown':
                message_purchased.attr('data-effect_hidden', 'fadeOutDown');
                break;
            case 'fadeOutDownBig':
                message_purchased.attr('data-effect_hidden', 'fadeOutDownBig');
                break;
            case 'fadeOutLeft':
                message_purchased.attr('data-effect_hidden', 'fadeOutLeft');
                break;
            case 'fadeOutLeftBig':
                message_purchased.attr('data-effect_hidden', 'fadeOutLeftBig');
                break;
            case 'fadeOutRight':
                message_purchased.attr('data-effect_hidden', 'fadeOutRight');
                break;
            case 'fadeOutRightBig':
                message_purchased.attr('data-effect_hidden', 'fadeOutRightBig');
                break;
            case 'fadeOutUp':
                message_purchased.attr('data-effect_hidden', 'fadeOutUp');
                break;
            case 'fadeOutUpBig':
                message_purchased.attr('data-effect_hidden', 'fadeOutUpBig');
                break;
            case 'flipOutX':
                message_purchased.attr('data-effect_hidden', 'flipOutX');
                break;
            case 'flipOutY':
                message_purchased.attr('data-effect_hidden', 'flipOutY');
                break;
            case 'lightSpeedOut':
                message_purchased.attr('data-effect_hidden', 'lightSpeedOut');
                break;
            case 'rotateOut':
                message_purchased.attr('data-effect_hidden', 'rotateOut');
                break;
            case 'rotateOutDownLeft':
                message_purchased.attr('data-effect_hidden', 'rotateOutDownLeft');
                break;
            case 'rotateOutDownRight':
                message_purchased.attr('data-effect_hidden', 'rotateOutDownRight');
                break;
            case 'rotateOutUpLeft':
                message_purchased.attr('data-effect_hidden', 'rotateOutUpLeft');
                break;
            case 'rotateOutUpRight':
                message_purchased.attr('data-effect_hidden', 'rotateOutUpRight');
                break;
            case 'slideOutUp':
                message_purchased.attr('data-effect_hidden', 'slideOutUp');
                break;
            case 'slideOutDown':
                message_purchased.attr('data-effect_hidden', 'slideOutDown');
                break;
            case 'slideOutLeft':
                message_purchased.attr('data-effect_hidden', 'slideOutLeft');
                break;
            case 'slideOutRight':
                message_purchased.attr('data-effect_hidden', 'slideOutRight');
                break;
            case 'zoomOut':
                message_purchased.attr('data-effect_hidden', 'zoomOut');
                break;
            case 'zoomOutDown':
                message_purchased.attr('data-effect_hidden', 'zoomOutDown');
                break;
            case 'zoomOutLeft':
                message_purchased.attr('data-effect_hidden', 'zoomOutLeft');
                break;
            case 'zoomOutRight':
                message_purchased.attr('data-effect_hidden', 'zoomOutRight');
                break;
            case 'zoomOutUp':
                message_purchased.attr('data-effect_hidden', 'zoomOutUp');
                break;
            case 'rollOut':
                message_purchased.attr('data-effect_hidden', 'rollOut');
                break;
        }

    });

    /*Add new message*/
    jQuery('.add-message').on('click', function () {
        var tr = jQuery('.sales-notification').find('tr').last().clone();
        jQuery(tr).appendTo('.sales-notification');
        remove_message()
    });
    remove_message();

    function remove_message() {
        jQuery('.remove-message').unbind();
        jQuery('.remove-message').on('click', function () {
            if (confirm("Would you want to remove this message?")) {
                if (jQuery('.sales-notification tr').length > 1) {
                    var tr = jQuery(this).closest('tr').remove();
                }
            } else {

            }
        });
    }

    jQuery('input[name="live_sales_notifications_params[background_image]"]').on('change', function () {

        var data = jQuery(this).val();
        var init_data = {
            'spring': {
                'hightlight': '#415602',
                'text': '#415602',
            },
            'summer': {
                'hightlight': '#164b6d',
                'text': '#164b6d',
            },
            'autumn': {
                'hightlight': '#903b28',
                'text': '#903b28',

            },
            'winter': {
                'hightlight': '#443e39',
                'text': '#443e39',

            },
            'christmas': {
                'hightlight': '#ffffff',
                'text': '#ffffff',

            },
            'christmas_1': {
                'hightlight': '#ffffff',
                'text': '#ffffff',

            },
            'black_friday': {
                'hightlight': '#ffffff',
                'text': '#ffffff',

            },
            'happy_new_year': {
                'hightlight': '#ffffff',
                'text': '#ffffff',

            },
            'valentine': {
                'hightlight': '#4e0e2c',
                'text': '#4e0e2c',

            },
            'father': {
                'hightlight': '#89152c',
                'text': '#89152c',

            },
            'halloween': {
                'hightlight': '#e3a51e',
                'text': '#e3a51e',

            },
            'halloween_1': {
                'hightlight': '#ffffff',
                'text': '#ffffff',
            },
            'kids': {
                'hightlight': '#401b02',
                'text': '#401b02',

            },
            'kids_1': {
                'hightlight': '#2b373e',
                'text': '#2b373e',

            },
            'mother': {
                'hightlight': '#ffffff',
                'text': '#ffffff',

            },
            'mother_1': {
                'hightlight': '#ffffff',
                'text': '#ffffff',

            }
        };
        if (parseInt(data) == 0) {
            jQuery('#sales-notification').fadeIn('200');
            jQuery('input[name="live_sales_notifications_params[product_color]"]').val('#212121').change();
            jQuery('input[name="live_sales_notifications_params[text_color]"]').val('#212121').change();
            jQuery('input[name="live_sales_notifications_params[backgroundcolor]"]').val('#ffffff').change();
        } else {
            jQuery('#sales-notification').fadeOut('200');
            jQuery('input[name="live_sales_notifications_params[product_color]"]').val(init_data[data]['hightlight']).change();
            jQuery('input[name="live_sales_notifications_params[text_color]"]').val(init_data[data]['text']).change();
        }

    });
    /**
     * Start Get download key
     */
    jQuery('.villatheme-get-key-button').one('click', function (e) {
        var v_button = jQuery(this);
        v_button.addClass('loading');
        var data = v_button.data();
        var item_id = data.id;
        var app_url = data.href;
        var main_domain = window.location.hostname;
        main_domain = main_domain.toLowerCase();
        var popup_frame;
        e.preventDefault();
        var download_url = v_button.attr('data-download');
        popup_frame = window.open(app_url, "myWindow", "width=380,height=600");
        window.addEventListener('message', function (event) {
            /*Callback when data send from child popup*/
            var obj = jQuery.parseJSON(event.data);
            var update_key = '';
            var message = obj.message;
            var support_until = '';
            var check_key = '';
            if (obj['data'].length > 0) {
                for (var i = 0; i < obj['data'].length; i++) {
                    if (obj['data'][i].id == item_id && (obj['data'][i].domain == main_domain || obj['data'][i].domain == '' || obj['data'][i].domain == null)) {
                        if (update_key == '') {
                            update_key = obj['data'][i].download_key;
                            support_until = obj['data'][i].support_until;
                        } else if (support_until < obj['data'][i].support_until) {
                            update_key = obj['data'][i].download_key;
                            support_until = obj['data'][i].support_until;
                        }
                        if (obj['data'][i].domain == main_domain) {
                            update_key = obj['data'][i].download_key;
                            break;
                        }
                    }
                }
                if (update_key) {
                    check_key = 1;
                    jQuery('.villatheme-autoupdate-key-field').val(update_key);
                }
            }
            v_button.removeClass('loading');
            if (check_key) {
                jQuery('<p><strong>' + message + '</strong></p>').insertAfter(".villatheme-autoupdate-key-field");
                jQuery(v_button).closest('form').submit();
            } else {
                jQuery('<p><strong> Your key is not found. Please contact support@villatheme.com </strong></p>').insertAfter(".villatheme-autoupdate-key-field");
            }
        });
    });


    /**
     * End get download key
     */

});