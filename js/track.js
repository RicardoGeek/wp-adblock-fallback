jQuery(function() {
  jQuery(".track-me").click(function() {
    var link = jQuery(this).attr("href");
    var zoneId = jQuery(this).attr("data-id");
    jQuery.ajax({
      type: "post",
      url: ajaxurl,
      data: {
        id: zoneId,
        action: 'increase_click_count'
      }
    }).done(function(msg) {
       window.open(link, '_blank');
    });
  });
});
