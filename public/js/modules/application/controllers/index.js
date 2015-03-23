define(["jquery"], function($) {
	$(function() {
		$("#trigger_manual_synchronization").click(function() {
			var WaitDialog = function()
			{
				this.element = $("<div></div>");
				this.element.dialog({
					dialogClass: "no-close",
					resizable: false,
					draggable: false,
					title: "Synchronisieren",
					modal: true
				});
				$(".no-close .ui-dialog-titlebar-close").css("display", "none");
			};
			WaitDialog.prototype = {
				showSavingMessage: function()
				{
					this.element.empty();
					this.element.append("<p style='text-align: center;'>Verwaltung wird synchronisiert<br /><img src='public/design/default/images/ajax-loader.gif' /></p>");
					this.element.dialog({buttons: {}});
				},
				destroy: function()
				{
					this.element.remove();
				}
			};

			var dialog = new WaitDialog();
			dialog.showSavingMessage();

			$.ajax({
				type: "GET",
				url: "?module=exchange&controller=randshop&action=all",
				success: function(d, textStatus, jqXHR) {
					dialog.destroy();
					alert("Erfolgreich synchronisiert");
					location.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					dialog.destroy();
					alert("Leider ist ein unbekannter Fehler aufgetreten, versuchen Sie es später erneut");
				},
				dataType: "text",
				async: false,
				cache: false
			});
		});
	});
});