function tb_split(val) {
	return val.split(/,\s*/);
}

function tb_extract_last(term) {
	return tb_split(term).pop();
}

function tb_init_autocomplete(p_target, p_url, p_min_chars) {
	// Dynamic width?
	p_width = jQuery("" + p_target).width();
	if (p_width === 0) {
		p_width = 200;
	}

	// Init jQuery UI autocomplete
	jQuery(p_target).bind("keydown", function(event) {
		// don't navigate away from the field on tab when selecting an item
		if (event.keyCode === jQuery.ui.keyCode.TAB &&
			jQuery(this).data("ui-autocomplete").menu.active) {
			event.preventDefault();
		}
	}).autocomplete({
		minLength: p_min_chars,
		source: function(request, response) {
			jQuery.getJSON(p_url, {
				term: tb_extract_last(request.term)
			}, response);
		},
		focus: function() {
			// prevent value inserted on focus
			return false;
		},
		select: function(event, ui) {
			var terms = tb_split(this.value);
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push(ui.item.value);
			// add placeholder to get the comma-and-space at the end
			terms.push("");
			this.value = terms.join(", ");
			return false;
		}
	});
}