/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

jQuery(function ($) {
	"use strict";

	$("#style-form").addClass("helix-options");

	$(document).ready(function () {
		// remove basic fields
		$(".info-labels").prev("h2").remove();
		$(".info-labels").next("div").remove();
		$(".info-labels").next("hr").addBack().remove();
		$("#jform_params___field1-lbl").closest(".control-group").remove();

		// child parent relation
		var childParentEngine = function () {
			var classes = new Array();
			$(".parent:not(.child)").each(function () {
				var elClass = $(this).attr("class").split(/\s/g);
				var $key = $.inArray("parent", elClass);
				if ($key != -1) {
					classes.push(elClass[$key + 1]);
				}
			});

			$(".parent:not(.child)").each(function () {
				var parent = $(this);
				var elClass = $(this).attr("class").split(/\s/g);
				var childClassName = ".child";
				var conditionClassName = "";
				var i;

				for (i = 0; i < elClass.length; i++) {
					if ($.inArray(elClass[i], classes) < 0) {
						continue;
					} else {
						var elCls = "." + elClass[i];

						$(childClassName + elCls)
							.closest(".control-group")
							.hide();

						if ($(parent).prop("type") != "select-one") {
							var selected = $(parent).find("input[type=radio]:checked");
							var radios = $(parent).find("input[type=radio]");
							var activeItems = conditionClassName + elCls + "_" + $(selected).val();
							var childItem = $.trim(childClassName + elCls + activeItems);

							setTimeout(function () {
								$(childItem).closest(".control-group").show();
							}, 100);

							$(radios).on("click", function (event) {
								$(childClassName + elCls)
									.closest(".control-group")
									.hide();
								$(childClassName + elCls + conditionClassName + elCls + "_" + $.trim($(this).val()))
									.closest(".control-group")
									.fadeIn();
							});
						} else if ($(parent).prop("type") == "select-one") {
							var element = $(parent);
							var selected = $(parent).find("option:selected");
							var activeItems = conditionClassName + elCls + "_" + $(selected).val();
							var childItem = $.trim(childClassName + elCls + activeItems);

							setTimeout(function () {
								$(childItem).closest(".control-group").show();
							}, 100);

							$(element).on("change", function (event) {
								$(childClassName + elCls)
									.closest(".control-group")
									.hide();
								$(childClassName + elCls + conditionClassName + elCls + "_" + $.trim($(this).val()))
									.closest(".control-group")
									.fadeIn();
							});
						}
					}
				}
			});
		}; //end childParentEngine

		$(".group_separator").each(function () {
			$(this).parent().prev().remove();
			$(this).parent().parent().addClass("group-separator");
			$(this).unwrap();
		});

		//Presets
		$(".preset").addClass("new-hello").parent().unwrap().prev().remove();
		$(".preset").parent().removeClass("controls").addClass("presets clearfix");

		//Load Preset
		$("#attrib-preset")
			.find(".preset-control")
			.each(function () {
				if ($(this).hasClass(current_preset)) {
					$(this).closest(".control-group").show();
				} else {
					$(this).closest(".control-group").hide();
				}
			});

		//Change Preset
		$(".preset").on("click", function (event) {
			event.preventDefault();
			var $that = $(this);

			$(".preset").removeClass("active");
			$(this).addClass("active");

			$("#attrib-preset")
				.find(".preset-control")
				.each(function () {
					if ($(this).hasClass($that.data("preset"))) {
						$(this).closest(".control-group").fadeIn();
					} else {
						$(this).closest(".control-group").hide();
					}
				});

			$("#template-preset").val($that.data("preset"));
		});

		//Change Preset
		$(document).on("blur", ".preset-control", function (event) {
			event.preventDefault();

			var active_preset = $(".preset.active").data("preset");

			if ($(this).attr("id") == "jform_params_" + active_preset + "_major") {
				$(".preset.active").css("background-color", $(this).val());
			}
		});

		//Template Information
		$("#jform_template")
			.closest(".control-group")
			.appendTo($(".title-alias"))
			.wrap('<div class="col-12 col-md-auto"></div>');

		$("#jform_home1")
			.closest(".control-group")
			.appendTo($(".title-alias"))
			.wrap('<div class="col-12 col-md-auto"></div>');
		$(".title-alias").find(">div:nth-child(2)").remove();

		childParentEngine();

		// Helix3 Admin Footer
		var footerHtml = '<div class="helix-footer-area">';
		footerHtml += '<div class="clearfix">';
		footerHtml +=
			'<a class="helix-logo-area" href="https://www.joomshaper.com/helix" target="_blank">Helix3 Logo</a>';
		footerHtml += '<span class="template-version">' + pluginVersion + "</span>";
		footerHtml += "</div>";
		footerHtml += '<div class="help-links">';
		footerHtml +=
			'<a href="https://www.joomshaper.com/documentation/helix-framework/helix3" target="_blank">Documentation</a><span>|</span>';
		footerHtml +=
			'<a href="https://www.facebook.com/groups/helix.framework" target="_blank">Helix Community</a><span>|</span>';
		footerHtml +=
			'<a href="https://www.joomshaper.com/page-builder" target="_blank">Page Builder Pro</a><span>|</span>';
		footerHtml +=
			'<a href="https://www.joomshaper.com/joomla-templates" target="_blank">Premium Templates</a><span>|</span>';
		footerHtml += '<a href="https://www.joomshaper.com/joomla-extensions" target="_blank">Joomla Extensions</a>';
		footerHtml += "</div>";
		footerHtml += "</div>";

		$(footerHtml).insertAfter("#style-form");
	});

	//Import Template Settings
	$(document).on("click", "#import-settings", function (event) {
		event.preventDefault();

		var $that = $(this),
			template_id = $that.data("template_id"),
			temp_settings = $.trim($("#import-data").val());

		if (temp_settings == "") {
			return false;
		}

		if (confirm("Warning: It will change all current settings of this Template.") != true) {
			return false;
		}

		var data = {
			action: "import",
			template_id: template_id,
			settings: temp_settings,
		};

		var request = {
			option: "com_ajax",
			plugin: "helix3",
			data: data,
			format: "json",
		};

		$.ajax({
			type: "POST",
			data: request,
			success: function (response) {
				window.location.reload();
			},
			error: function () {
				alert("Somethings wrong, Try again");
			},
		});
		return false;
	});
});
