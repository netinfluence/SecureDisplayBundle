$(document).ready(function(){
	var links = $("span[data-type=secure-display]");
	var data = {keys: {}};

	links.each(function(){
		var id = $(this).attr("data-id");
		var code = $(this).attr("data-value");
		data.keys[id] = code;
	});
	$.ajax({
		method: 'post',
		url: Routing.generate('netinfluence_secure_display'),
		data: data,
		success: replaceAll,
		dataType: 'json'
	});
});

function replaceAll(response) {
	for(var key in response) {
		replaceDisplay(key, response[key]);
	}
}

function replaceDisplay(key, value) {
	var origin = $("span[data-id=" + key + "]");
	var action = origin.attr("data-action");
	var attributes = origin.prop("attributes");

	var link = "";
	if(action !== undefined) {
		link = $("<a href='" + action + ':' + value + "'>" + value + "</a>");
	}else{
		link = $("<span>" + value + "</span>");
	}

	$.each(attributes, function() {
		if(this.name != "data-type" && this.name != "data-id" && this.name != "data-value" && this.name != 'data-action') {
			link.attr(this.name, this.value);
		}
	});
	origin.replaceWith(link);
}
