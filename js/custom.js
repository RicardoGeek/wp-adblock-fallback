jQuery(function() {

  jQuery("#zones-table").bind('dynatable:afterUpdate', function(e, dynatable) {
    bindTableActions();
  });

  jQuery("#zones-table").dynatable({
    params: {
      page: 'dtPage'
    }
  });

  jQuery("#save-ad-zone").click(function() {
    var country = jQuery("#ad-country-select").val();
    var size = jQuery("#ad-size").val();
    var banner = jQuery("#ad-banner-link").val();
    var link = jQuery("#ad-link").val();
    
    jQuery("#errors").html("");
    
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
      var obj = JSON.parse(msg);
      if(obj.status == "ok") {
        window.location.reload(true);  
      } else {
        jQuery("#errors").html(obj.msg);
      }
    });
  });

  jQuery("#save-zone-edits").click(function() {
    var dataId = jQuery("#edit-zone-id").val();
    var countryId = jQuery("#edit-ad-country-select").val();
    var size = jQuery("#edit-ad-size").val();
    var banner = jQuery("#edit-ad-banner-link").val();
    var link = jQuery("#edit-ad-link").val();
    jQuery("#errors").html("");
    
    jQuery.ajax({
      type: "post",
      url: ajaxurl,
      data: {
        action: "edit_zone",
        dataId: dataId,
        countryId: countryId,
        size: size,
        banner: banner,
        link: link
      }
    }).done(function(msg) {
      var obj = JSON.parse(msg);
      if(obj.status == "ok") {
        window.location.reload(true);  
      } else {
        jQuery("#errors").html(obj.msg);
      }
    });
  });
  
  bindTableActions();
  
  //funcitons
  function bindTableActions() {
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
        zone = zone[0];
        jQuery("#edit-zone-id").val(zone.id);
        jQuery("#edit-ad-country-select").val(zone.countryId);
        jQuery("#edit-ad-size").val(zone.size);
        jQuery("#edit-ad-banner-link").val(zone.banner);
        jQuery("#edit-ad-link").val(zone.link);
      });
    });
  }

});