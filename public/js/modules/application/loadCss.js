define(function() {
	/**
	 * This function offers the capability to dynamically load CSS stylsheets,
	 * because RequireJS can not (yet) be used to do so.
	 *
	 * @see http://requirejs.org/docs/faq-advanced.html#css
	 * @param url The URL of the stylsheet
	 */
	return function(url) {
		var link = document.createElement("link");
		link.type = "text/css";
		link.rel = "stylesheet";
		link.href = url;
		document.getElementsByTagName("head")[0].appendChild(link);
	}
});