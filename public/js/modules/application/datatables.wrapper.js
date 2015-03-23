define(["jquery", "datatables", "application/config/datatables.config"], function($, dataTable, config) {
	// Set datatables default values
	$.extend(
		//$.fn.dataTable.defaults,
		dataTable.defaults,
		config
	);

	return dataTable;
});