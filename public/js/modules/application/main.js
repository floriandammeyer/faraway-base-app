define(["jquery", "accounting", "jquery-ui"], function($, accounting) {
	/**
	* Fügt automatisch zu allen entsprechenden Formularelementen die entsprechenden CSS-Klassen hinzu,
	* damit diese automatisch auf der ganzen Seite dieselbe hübsche Darstellung haben.
	*/
	// TODO: ajax-after-success-event hinzufügen, sodass per ajax abgerufene formulare ebenfalls gestyled werden
	function initForms()
	{
		// Textfelder
		$("fieldset.form input[type='text']").addClass("text ui-widget-content ui-corner-all");
		// Textareas
		$("fieldset.form textarea").addClass("text ui-widget-content ui-corner-all");
		// Selects
		$("fieldset.form select").addClass("text ui-widget-content ui-corner-all");
		// Radiogroups
		$("fieldset.form .radiogroup").buttonset();
		// Buttons
		$(".buttons *").button();
	}

	//
	// Nach dem vollständigen Laden der Seite ausführen:
	$(function()
	{
		$("nav ul").menu();
		initForms();

		$("input.preis, input.price")
			// Beim betreten eines Preis-Formularfelds muss die
			// Formatierung entfernt werden...
			.focus(function(event)
			{
				var unformatted = accounting.unformat( $(event.target).val() , ",");
				$(event.target).val( unformatted.toFixed(2).replace(".", ",") );
			})
			// ...und beim Verlassen dann wieder hinzugefügt werden
			.blur(function(event)
			{
				var value = $(event.target).val().replace(",", ".");
				$(event.target).val( accounting.formatMoney(value) );
			});
		$(document).trigger("formatprice");

		// HOTFIX Nach Änderung des Status eines Auftrags oder Angebots in der jeweiligen Übersichtstabelle werden nach dem Seitenreload
		// die Selects wieder zurückgesetzt auf ihre vordefinierten Werte, damit sie nicht den zuletzt vom Nutzer ausgewählten Wert beibehalten
		$('select option').prop('selected', function() {
			return this.defaultSelected;
		});
	});
});