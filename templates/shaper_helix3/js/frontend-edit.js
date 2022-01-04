/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

(function ($) {
	$.fn.extend({
		/**
		 * This jQuery custom method makes the elements absolute, and with true argument moves them to end of body to avoid CSS inheritence
		 *
		 * @param   rebase boolean
		 * @returns {jQuery}
		 */
		jEditMakeAbsolute: function (rebase) {
			return this.each(function () {
				var el = $(this);
				var pos;

				if (rebase) {
					pos = el.offset();
				} else {
					pos = el.position();
				}

				el.css({
					position: "absolute",
					marginLeft: 0,
					marginTop: 0,
					top: pos.top,
					left: pos.left,
					bottom: "auto",
					right: "auto",
				});

				if (rebase) {
					el.detach().appendTo("body");
				}
			});
		},
	});

	$(document).ready(function () {
		$(".jmoddiv").on({
			mouseenter: function () {
				// Get module editing URL and tooltip for module edit:
				var moduleEditUrl = $(this).data("jmodediturl");
				var moduleTip = $(this).data("jmodtip");
				var moduleTarget = $(this).data("target");

				// Stop timeout on previous tooltip and remove it:
				$("body>.btn.jmodedit").clearQueue().tooltip("dispose").remove();

				// Add editing button with tooltip:
				$(this)
					.addClass("jmodinside")
					.prepend(
						'<a class="btn btn-secondary btn-sm jmodedit" href="#" target="' +
							moduleTarget +
							'"><span class="fas fa-edit" aria-hidden="true"></span></a>'
					)
					.children(":first")
					.attr("href", moduleEditUrl)
					.attr("title", moduleTip)
					.tooltip({ html: true, placement: "top" })
					.jEditMakeAbsolute(true);

				$(".btn.jmodedit").on({
					mouseenter: function () {
						// Stop delayed removal programmed by mouseleave of .jmoddiv or of this one:
						$(this).clearQueue();
					},
					mouseleave: function () {
						// Delay remove editing button if not hovering it:
						$(this)
							.delay(500)
							.queue(function (next) {
								$(this).tooltip("dispose").remove();
								next();
							});
					},
				});
			},
			mouseleave: function () {
				// Delay remove editing button if not hovering it:
				$("body>.btn.jmodedit")
					.delay(500)
					.queue(function (next) {
						$(this).tooltip("dispose").remove();
						next();
					});
			},
		});

		// Menu items edit icons:

		var activePopover = null;

		$(
			".jmoddiv[data-jmenuedittip] .nav li,.jmoddiv[data-jmenuedittip].nav li,.jmoddiv[data-jmenuedittip] .nav .nav-child li,.jmoddiv[data-jmenuedittip].nav .nav-child li"
		).on({
			mouseenter: function () {
				// Get menu ItemId from the item-nnn class of the li element of the menu:
				var itemids = /\bitem-(\d+)\b/.exec($(this).attr("class"));
				if (typeof itemids[1] == "string") {
					// Find module editing URL from enclosing module:
					var enclosingModuleDiv = $(this).closest(".jmoddiv");
					var moduleEditUrl = enclosingModuleDiv.data("jmodediturl");
					// Transform module editing URL into Menu Item editing url:
					var menuitemEditUrl = moduleEditUrl.replace(
						/\/index.php\?option=com_config&controller=config.display.modules([^\d]+).+$/,
						"/administrator/index.php?option=com_menus&view=item&layout=edit$1" + itemids[1]
					);
				}

				// Get tooltip for menu items from enclosing module
				var menuEditTip = enclosingModuleDiv.data("jmenuedittip").replace("%s", itemids[1]);

				var content = $(
					'<div><a class="btn jfedit-menu" href="#" target="_blank" rel="noopener noreferrer"><span class="icon-edit"></span></a></div>'
				);
				content.children("a.jfedit-menu").prop("href", menuitemEditUrl).prop("title", menuEditTip);

				if (activePopover) {
					$(activePopover).popover("hide");
				}
				$(this)
					.popover({
						html: true,
						content: content.html(),
						container: "body",
						trigger: "manual",
						animation: false,
						placement: "bottom",
					})
					.popover("show");
				activePopover = this;

				$("body>div.popover")
					.on({
						mouseenter: function () {
							if (activePopover) {
								$(activePopover).clearQueue();
							}
						},
						mouseleave: function () {
							if (activePopover) {
								$(activePopover).popover("hide");
							}
						},
					})
					.find("a.jfedit-menu")
					.tooltip({ html: true, placement: "bottom" });
			},
			mouseleave: function () {
				$(this)
					.delay(1500)
					.queue(function (next) {
						$(this).popover("hide");
						next();
					});
			},
		});
	});

	$(document).ready(function () {
		// Turn radios into btn-group
		$(".radio.btn-group label").addClass("btn btn-outline-secondary");
		$(".btn-group label:not(.active)").click(function () {
			var label = $(this);
			var input = $("#" + label.attr("for"));

			if (!input.prop("checked")) {
				label
					.closest(".btn-group")
					.find("label")
					.removeClass("active btn-outline-success btn-outline-danger btn-outline-primary");
				if (input.val() == "") {
					label.addClass("active btn-outline-primary");
				} else if (input.val() == 0) {
					label.addClass("active btn-outline-danger");
				} else {
					label.addClass("active btn-outline-success");
				}
				input.prop("checked", true);
			}
		});

		$(".btn-group input[checked=checked]").each(function () {
			if ($(this).val() == "") {
				$("label[for=" + $(this).attr("id") + "]").addClass("active btn-outline-primary");
			} else if ($(this).val() == 0) {
				$("label[for=" + $(this).attr("id") + "]").addClass("active btn-outline-danger");
			} else {
				$("label[for=" + $(this).attr("id") + "]").addClass("active btn-outline-success");
			}
		});
	});

	if (typeof MooTools != "undefined") {
		var mHide = Element.prototype.hide;
		Element.implement({
			hide: function () {
				if ($(".hasPopover") && $(".hasPopover").attr("data-original-title")) {
					return this;
				}
				mHide.apply(this, arguments);
			},
		});
	}

	// MooTools issue with Joomla 3
	if (typeof jQuery != "undefined" && typeof MooTools != "undefined") {
		$(document).ready(function () {
			$(".carousel").each(function (index, element) {
				$(this)[index].slide = null;
			});
		});

		window.addEvent("domready", function () {
			Element.prototype.hide = function () {};
		});
	}

	// collapse
	// $.fn.collapse = function (option) {
	// 	return this.each(function () {
	// 		var $this = $(this),
	// 			data = $this.data("collapse"),
	// 			options = $.extend({}, $.fn.collapse.defaults, $this.data(), typeof option == "object" && option);
	// 		console.log("data", data);
	// 		console.log(options);
	// 		if (!data) {
	// 			$this.data("collapse", (data = new bootstrap.Collapse(this, options)));
	// 		}
	// 		if (typeof option == "string") data[option]();
	// 	});
	// };

	// $.fn.collapse.defaults = {
	// 	toggle: true,
	// };
})(jQuery);
