/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

(function ($) {
	$.fn.rowSortable = function () {
		$(this)
			.sortable({
				placeholder: "ui-state-highlight",
				forcePlaceholderSize: true,
				axis: "x",
				opacity: 0.8,
				tolerance: "pointer",

				start: function (event, ui) {
					$(".layoutbuilder-section .row").find(".ui-state-highlight").addClass($(ui.item).attr("class"));
					$(".layoutbuilder-section .row")
						.find(".ui-state-highlight")
						.css("height", $(ui.item).outerHeight());
				},
			})
			.disableSelection();
	};
})(jQuery);
