define(["accounting", "application/config/accounting.config"], function(accounting, config) {
	// Set the default settings for the accounting library
	accounting.settings = config;

	return accounting;
});