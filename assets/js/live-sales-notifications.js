'use strict';
jQuery(document).ready(function () {
    if (jQuery('#sales-notification').length > 0) {
        var notify = live_sales_notifications;

        if (_live_sales_notifications_params.billing == 0 && _live_sales_notifications_params.detect == 0) {
            notify.detect_address();
        }
    }

});
jQuery(window).load(function () {
    var notify = live_sales_notifications;
    notify.loop = _live_sales_notifications_params.loop;
    notify.init_delay = _live_sales_notifications_params.initial_delay;
    notify.total = _live_sales_notifications_params.notification_per_page;
    notify.display_time = _live_sales_notifications_params.display_time;
    notify.next_time = _live_sales_notifications_params.next_time;
    notify.ajax_url = _live_sales_notifications_params.ajax_url;
    notify.products = _live_sales_notifications_params.products;
    notify.messages = _live_sales_notifications_params.messages;
    notify.image = _live_sales_notifications_params.image;
    notify.redirect_target = _live_sales_notifications_params.redirect_target;
    notify.time = _live_sales_notifications_params.time;
    notify.display_effect = _live_sales_notifications_params.display_effect;
    notify.hidden_effect = _live_sales_notifications_params.hidden_effect;
    notify.messages = _live_sales_notifications_params.messages;
    notify.names = _live_sales_notifications_params.names;
    notify.detect = _live_sales_notifications_params.detect;
    notify.billing = _live_sales_notifications_params.billing;
    notify.in_the_same_cate = _live_sales_notifications_params.in_the_same_cate;
    notify.message_custom = _live_sales_notifications_params.message_custom;
    notify.message_number_min = _live_sales_notifications_params.message_number_min;
    notify.message_number_max = _live_sales_notifications_params.message_number_max;
    notify.time_close = _live_sales_notifications_params.time_close;
    notify.show_close = _live_sales_notifications_params.show_close;
    if (_live_sales_notifications_params.billing == 0 && _live_sales_notifications_params.detect == 0) {
        notify.cities = [notify.getCookie('live_sales_notifications_city')];
        notify.country = [notify.getCookie('live_sales_notifications_country')];
        var check_ip = notify.getCookie('live_sales_notifications_client_ip');

        if (check_ip && check_ip != 'undefined') {
            notify.init();
        }
    } else {
        notify.cities = _live_sales_notifications_params.cities;
        notify.country = _live_sales_notifications_params.country;
        notify.init();
    }

});


var live_sales_notifications = {
    billing: 0,
    in_the_same_cate: 0,
    loop: 0,
    init_delay: 5,
    total: 30,
    display_time: 5,
    next_time: 60,
    count: 0,
    intel: 0,
    live_sales_notifications_popup: 0,
    id: 0,
    messages: '',
    products: '',
    ajax_url: '',
    display_effect: '',
    hidden_effect: '',
    time: '',
    names: '',
    cities: '',
    country: '',
    message_custom: '',
    message_number_min: '',
    message_number_max: '',
    detect: 0,
    time_close: 0,
    show_close: 0,

    shortcodes: ['{first_name}', '{city}', '{state}', '{country}', '{product}', '{product_with_link}', '{time_ago}', '{custom}'],
    init: function () {
        if (this.ajax_url) {
            this.ajax_get_data();

        } else {
            setTimeout(function () {
                live_sales_notifications.get_product();
            }, this.init_delay * 1000);
        }
        jQuery('#sales-notification').on('mouseenter', function () {
            window.clearInterval(live_sales_notifications.live_sales_notifications_popup);
        }).on('mouseleave', function () {
            live_sales_notifications.message_show()
        });
    },
    detect_address: function () {
        var ip_address = this.getCookie('live_sales_notifications_client_ip');
        if (!ip_address) {

            jQuery.getJSON('https://extreme-ip-lookup.com/json/', function (data) {
                if (data.query) {
                    live_sales_notifications.setCookie('live_sales_notifications_client_ip', data.query, 86400);
                }
                if (data.city) {
                    live_sales_notifications.setCookie('live_sales_notifications_city', data.city, 86400);
                }
                if (data.country) {
                    live_sales_notifications.setCookie('live_sales_notifications_country', data.country, 86400);
                }
            });
        }

    },
    ajax_get_data: function () {

        if (this.ajax_url) {
            var str_data;
            if (this.id) {
                str_data = '&id=' + this.id;
            } else {
                str_data = '';
            }
            jQuery.ajax({
                type: 'POST',
                data: 'action=live_sales_notifications_get_product' + str_data,
                url: this.ajax_url,
                success: function (data) {
                    var products = jQuery.parseJSON(data);
                    
                    if (products && products != 'undefined' && products.length > 0) {
                        live_sales_notifications.products = products;
                        live_sales_notifications.message_show();
                        setTimeout(function () {
                            live_sales_notifications.get_product();
                        }, live_sales_notifications.init_delay * 1000);
                    }
                },
                error: function (html) {
                }
            })
        }
    },
    message_show: function () {
        var count = this.count++;
        if (this.total <= count) {
            return;
        }
        window.clearInterval(this.intel);
        var message_id = jQuery('#sales-notification');
        if (message_id.hasClass(this.hidden_effect)) {
            jQuery(message_id).removeClass(this.hidden_effect);
        }
        jQuery(message_id).addClass(this.display_effect).css('display', 'flex');
        this.audio();

        this.live_sales_notifications_popup = setTimeout(function () {
            live_sales_notifications.message_hide();
        }, this.display_time * 1000);
    },

    message_hide: function () {

        var message_id = jQuery('#sales-notification');

        if (message_id.hasClass(this.display_effect)) {
            jQuery(message_id).removeClass(this.display_effect);
        }
        jQuery('#sales-notification').addClass(this.hidden_effect);
        jQuery('#sales-notification').fadeOut(1000);
        window.clearInterval(this.live_sales_notifications_popup);
        if (this.getCookie('live_sales_notifications_close')) {
            return;
        }
        if (this.loop == true) {
            this.intel = setInterval(function () {
                live_sales_notifications.get_product();
            }, this.next_time * 1000);
        }
    },
    get_time_string: function () {
        var time_cal = this.random(0, this.time * 3600);
        /*Check day*/
        var check_time = parseFloat(time_cal / 86400);
        if (check_time > 1) {
            check_time = parseInt(check_time);
            if (check_time == 1) {
                return check_time + ' ' + _live_sales_notifications_params.str_day
            } else {
                return check_time + ' ' + _live_sales_notifications_params.str_days
            }
        }
        check_time = parseFloat(time_cal / 3600);
        if (check_time > 1) {
            check_time = parseInt(check_time);
            if (check_time == 1) {
                return check_time + ' ' + _live_sales_notifications_params.str_hour
            } else {
                return check_time + ' ' + _live_sales_notifications_params.str_hours
            }
        }
        check_time = parseFloat(time_cal / 60);
        if (check_time > 1) {
            check_time = parseInt(check_time);
            if (check_time == 1) {
                return check_time + ' ' + _live_sales_notifications_params.str_min
            } else {
                return check_time + ' ' + _live_sales_notifications_params.str_mins
            }
        } else if (check_time < 10) {
            return _live_sales_notifications_params.str_few_sec
        } else {
            check_time = parseInt(check_time);
            return check_time + ' ' + _live_sales_notifications_params.str_secs
        }
    },
    get_product: function () {

        var products = this.products;
        var messages = this.messages;
        var image_redirect = this.image;
        var redirect_target = this.redirect_target;
        var data_first_name, data_state, data_country, data_city, time_str, index;
        if (products == 'undefined' || !products || !messages) {
            return;
        }
        if (products.length > 0 && messages.length > 0) {
            /*Get message*/
            index = live_sales_notifications.random(0, messages.length - 1);
            var string = messages[index];

            /*Get product*/
            index = live_sales_notifications.random(0, products.length - 1);
            var product = products[index];

            /*Get name*/
            if (parseInt(this.billing) > 0 && parseInt(this.in_the_same_cate) < 1) {

                data_first_name = product.first_name;
                data_city = product.city;
                data_state = product.state;
                data_country = product.country;
                time_str = product.time;

            } else {

                if (this.names && this.names != 'undefined') {
                    index = live_sales_notifications.random(0, this.names.length - 1);
                    data_first_name = this.names[index];
                } else {
                    data_first_name = '';
                }
                if (this.cities && this.cities != 'undefined') {
                    index = live_sales_notifications.random(0, this.cities.length - 1);
                    data_city = this.cities[index];
                } else {
                    data_city = '';
                }


                data_state = '';
                data_country = this.country;

                time_str = this.get_time_string();
            }

            var data_product = '<span class="live-sales-notifications-popup-product-title">' + product.title + '</span>';
            var data_product_link = '<a ';
            if (redirect_target) {
                data_product_link += 'target="_blank"';
            }
            data_product_link += ' href="' + product.url + '">' + product.title + '</a>';
            var data_time = '<small>' + _live_sales_notifications_params.str_about + ' ' + time_str + ' ' + _live_sales_notifications_params.str_ago + ' </small>';
            var data_custom = this.message_custom;
            var image_html = '';
            if (product.thumb) {
                if (image_redirect) {
                    image_html = '<a ';
                    if (redirect_target) {
                        image_html += 'target="_blank"';
                    }
                    image_html += ' href="' + product.url + '"><img src="' + product.thumb + '"></a>'
                } else {
                    image_html = '<img src="' + product.thumb + '">';
                }
            }
            /*Replace custom message*/
            data_custom = data_custom.replace('{number}', this.random(this.message_number_min, this.message_number_max));
            /*Replace message*/
            var replaceArray = this.shortcodes;
            var replaceArrayValue = [data_first_name, data_city, data_state, data_country, data_product, data_product_link, data_time, data_custom];
            var finalAns = string;
            for (var i = replaceArray.length - 1; i >= 0; i--) {
                finalAns = finalAns.replace(replaceArray[i], replaceArrayValue[i]);
            }
            var close_html = '';
            if (parseInt(this.show_close) > 0) {
                close_html = '<div id="notify-close"></div>'
            }
            var html = image_html + '<p>' + finalAns + '</p>' + close_html;

            jQuery('#sales-notification').html(html);
            this.close_notify();
            live_sales_notifications.message_show();
        }

    },
    close_notify: function () {
        jQuery('#notify-close').unbind();
        jQuery('#notify-close').bind('click', function () {
            live_sales_notifications.message_hide();
            if (parseInt(live_sales_notifications.time_close) > 0) {
                jQuery('#sales-notification').unbind();
                live_sales_notifications.setCookie('live_sales_notifications_close', 1, 3600 * parseInt(live_sales_notifications.time_close));
            }
        });
    },
    audio: function () {
        if (jQuery('#live-sales-notifications-audio').length > 0) {
            var audio = document.getElementById("live-sales-notifications-audio");
            var initAudio = function () {
                audio.play();
                setTimeout(function () {
                    audio.stop();
                }, 0);
                document.removeEventListener('touchstart', initAudio, false);
            };
            document.addEventListener('touchstart', initAudio, false);
            audio.play();
        }
    },
    random: function (min, max) {
        min = parseInt(min);
        max = parseInt(max);
        var rand_number = Math.random() * (max - min);
        return Math.round(rand_number) + min;
    },
    setCookie: function (cname, cvalue, expire) {
        var d = new Date();
        d.setTime(d.getTime() + (expire * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },

    getCookie: function (cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
}
