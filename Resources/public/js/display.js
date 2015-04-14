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
	var origin = $("span[data-id=" + response.key + "]");
	var action = origin.attr("data-action");
	var attributes = origin.prop("attributes");

	var link = "";
	if(action !== undefined) {
		link = $("<a href='" + action + ':' + response.value + "'>" + response.value + "</a>");
	}else{
		link = $("<span>" + response.value + "</span>");
	}

	$.each(attributes, function() {
		if(this.name != "data-type" && this.name != "data-id" && this.name != "data-value" && this.name != 'data-action') {
			link.attr(this.name, this.value);
		}
	});
	origin.replaceWith(link);
}
