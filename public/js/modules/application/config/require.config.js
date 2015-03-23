// Configure the RequireJS library
var require = {
	baseUrl: basePath + "/js/modules",
	paths: {
		"jquery": "../lib/jquery/dist/jquery",
		"jquery-ui": "../lib/jquery-ui/jquery-ui",
		"datatables": "../lib/DataTables/media/js/jquery.dataTables",
		"underscore": "../lib/underscore/underscore",
		"accounting": "../lib/accounting.js/accounting",
		"x-editable": "../lib/x-editable/dist/jqueryui-editable/js/jqueryui-editable",
		"moment": "../lib/moment/min/moment-with-locales"
	},
	map: {
		'*': {
			// Map accounting and datatables libraries to their wrapper modules,
			// so that the configuration of each library is automatically loaded
			// when the library has been loaded
			'accounting': 'application/accounting.wrapper',
			'datatables': 'application/datatables.wrapper'
		},
		'application/datatables.wrapper': {
			'datatables': 'datatables'
		},
		'application/accounting.wrapper': {
			'accounting': 'accounting'
		}
	},
	shim: {
		'x-editable': {
			deps: ["jquery-ui"]
		}
	},
	waitSeconds: 30
};