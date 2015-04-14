$(document).ready(function(){
	var links = $("span[data-type=secure-display]");

	links.each(function(){
		var id = $(this).attr("data-id");
		var code = $(this).attr("data-value");
		$.ajax({
			method: 'post',
			url: Routing.generate('netinfluence_secure_display'),
			data: {'id': id, 'hash' : code},
			success: replaceDisplay,
			dataType: 'json'
		})
	});
});

function replaceDisplay(response) {
	var action = "tel:";
	if(response.value.indexOf('@') > 0) {
		action = "mailto:";
	}
	var link = $("<a href='" + action + response.value + "'>" + response.value + "</a>");
	var origin = $("span[data-id=" + response.key + "]");
	var attributes = origin.prop("attributes");
	$.each(attributes, function() {
		if(this.name != "data-type" && this.name != "data-id" && this.name != "data-value") {
			link.attr(this.name, this.value);
		}
	});
	origin.replaceWith(link);
}
