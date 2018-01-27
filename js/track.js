jQuery(function() {
  jQuery(".track-me").click(function(e) {
    e.preventDefault();
    var link = jQuery(this).attr("href");
    var zoneId = jQuery(this).attr("data-id");
    jQuery.ajax({
      type: "post",
      url: "/wp-admin/admin-ajax.php",
      data: {
        zoneId: zoneId,
        action: 'increase_click_count'
      }
    }).done(function(msg) {
      var newWin = window.open(link);
      if(!newWin || newWin.closed || typeof newWin.closed == 'undefined')  { 
        window.location = link;
      }
    });
  });
});
