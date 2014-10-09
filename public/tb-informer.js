'use strict';

var TBInformer = 
{
    admin_prefix: '',
    period: 120,
    notification_container: null,
    notification_total_counter: null,
    notification_buttons: null,
    total_badge: null,
    dropdown_container: null,
    lock_message: '',
    
    
    init: function()
    {
        TBInformer.dropdown_container = jQuery('.ajax-dropdown');
        TBInformer.notification_container = jQuery('.ajax-notifications', '.ajax-dropdown');
        TBInformer.notification_total_counter = jQuery('.e-notification-total', '#activity');
        TBInformer.notification_buttons = jQuery('.btn-group .btn', '.ajax-dropdown');
        TBInformer.total_badge = jQuery("#activity > .badge");
        TBInformer.lock_message = jQuery('#default-lock-message').html();
        
        TBInformer.initNotificationRefreshing();
    }, // end init
    
    initNotificationRefreshing: function()
    {
        setInterval(function() {
            TBInformer.doRefreshNotifications();
        }, TBInformer.period * 1000);
    }, // end initNotificationRefreshing
    
    doRefreshNotifications: function()
    {
        if (TBInformer.dropdown_container.is(':visible')) {
            return;
        }
        
        jQuery.ajax({
            type: "POST",
            // FIXME: move action url to options
            url: TBInformer.admin_prefix +'/tb/informer/get-notification-counts',
            data: {},
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    TBInformer.notification_total_counter.text(response.total);
                    if (response.total > 0) {
                        TBInformer.total_badge.addClass("bg-color-red bounceIn animated");
                    } else {
                        TBInformer.total_badge.removeClass("bg-color-red bounceIn animated");
                    }
                    
                    jQuery.each(TBInformer.notification_buttons, function(index, value) {
                        var $button = jQuery(value);
                        $button.removeClass('active');
                        $button.find('.e-notification-count').text(response.counts[index]);
                    });
                    
                    TBInformer.notification_container.html(TBInformer.lock_message);
                } else {
                    //TableBuilder.showErrorNotification('Что-то пошло не так');
                    console.log('fcuk');
                }
            }
        });
    }, // end doRefreshNotifications
    
    fetchNotification: function(index)
    {
        jQuery.ajax({
            type: "POST",
            // FIXME: move action url to options
            url: TBInformer.admin_prefix +'/tb/informer/get-notification',
            data: {index: index},
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    TBInformer.notification_container.html(response.html);
                } else {
                    //TableBuilder.showErrorNotification('Что-то пошло не так');
                    console.log('fcuk');
                }
            }
        });
    }, // end fetchNotification
    
};

jQuery(document).ready(function() {
    TBInformer.init();
});
