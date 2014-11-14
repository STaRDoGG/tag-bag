jQuery(document).ready(function() {
	// Display initial link
	jQuery("#tb-clicks-tags .inside").html('<a href="#tb_click_tags" id="open_clicktags">'+tbHelperClickTagsL10n.show_txt+'</a><a href="#tb_click_tags" id="close_clicktags">'+tbHelperClickTagsL10n.hide_txt+'</a><div class="container_clicktags"></div>');

	// Take current post ID
	var current_post_id = jQuery('#post_ID').val();

	// Show tags
	jQuery("#open_clicktags").click(function(event) {
		event.preventDefault();

		jQuery("#tb-clicks-tags .container_clicktags")
			.fadeIn('fast')
			.load(ajaxurl + '?action=tagbag&tb_action=click_tags&post_id='+current_post_id, function() {
				jQuery("#tb-clicks-tags .container_clicktags span").click(function(event) {
					event.preventDefault();
					addTag(this.innerHTML);
					jQuery(this).addClass('used_term');
				});
				jQuery("#open_clicktags").hide();
				jQuery("#close_clicktags").show();
			});
		return false;
	});

	// Hide tags
	jQuery("#close_clicktags").click(function(event) {
		event.preventDefault();

		jQuery("#tb-clicks-tags .container_clicktags").fadeOut('fast', function() {
			jQuery("#open_clicktags").show();
			jQuery("#close_clicktags").hide();
		});
		return false;
	});
});