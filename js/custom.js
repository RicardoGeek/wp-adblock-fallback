jQuery(function() {

  jQuery("#save-ad-zone").click(function() {
    var country = jQuery("#ad-country-select").val();
    var size = jQuery("#ad-size").val();
    var banner = jQuery("#ad-banner-link").val();
    var link = jQuery("#ad-link").val();

    jQuery.ajax({
      type: "post",
      url: ajaxurl,
      data: {
        country: country,
        size: size,
        banner: banner,
        link: link,
        action: 'create_new_zone'
      }
    }).done(function(msg) {
      alert(msg);
      window.location.reload();
    });
  });

  jQuery(".btn-delete-zone").click(function() {
    var dataId = jQuery(this).attr("data-id");
    var c = confirm("Are you sure you wan't to do this?");
    if (c) {
      jQuery.ajax({
        type: "post",
        url: ajaxurl,
        data: {
          id: dataId,
          action: 'delete_zone'
        }
      }).done(function(msg) {
        alert(msg);
        window.location.reload();
      });
    }
  });

  jQuery(".btn-edit-zone").click(function() {
    var dataId = jQuery(this).attr("data-id");
    jQuery.ajax({
      type: "post",
      url: ajaxurl,
      data: {
        id: dataId,
        action: 'get_zone'
      }
    }).done(function(msg) {
      var zone = JSON.parse(msg);
    });
  });

});
