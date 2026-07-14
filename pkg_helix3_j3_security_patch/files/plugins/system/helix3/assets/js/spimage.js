/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2026 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
jQuery(function ($) {
  function helix3GetCsrfTokenName($context) {
    var tokenName = $context.data("csrf-name");

    if (tokenName) {
      return tokenName;
    }

    var $tokenInput = $context
      .closest("form")
      .find('input[type="hidden"]')
      .filter(function () {
        return /^[a-f0-9]{32}$/.test(this.name);
      })
      .first();

    return $tokenInput.length ? $tokenInput.attr("name") : null;
  }

  function helix3AppendCsrfToken(data, $context) {
    var tokenName = helix3GetCsrfTokenName($context);

    if (tokenName) {
      if (data instanceof FormData) {
        data.append(tokenName, "1");
      } else {
        data[tokenName] = "1";
      }
    }

    return tokenName;
  }

  $(".sp-image-field").each(function (index, el) {
    var $field = $(el);

    // Upload form
    $field.find(".btn-sp-image-upload").on("click", function (event) {
      event.preventDefault();
      $field.find(".sp-image-upload").click();
    });

    //Upload
    $field.find(".sp-image-upload").on("change", function (e) {
      e.preventDefault();
      var $this = $(this);
      var file = $(this).prop("files")[0];

      var data = new FormData();
      data.append("option", "com_ajax");
      data.append("plugin", "helix3");
      data.append("action", "upload_image");
      data.append("imageonly", false);
      data.append("format", "json");

      if (file.type.match(/image.*/)) {
        data.append("image", file);
        helix3AppendCsrfToken(data, $field);

        $.ajax({
          type: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            $this.prop("disabled", true);
            $field.find(".btn-sp-image-upload").attr("disabled", "disabled");
            var loader = $(
              '<div class="sp-image-item-loader"><i class="fa fa-circle-o-notch fa-spin"></i></div>',
            );
            $field.find(".sp-image-upload-wrapper").html(loader);
          },
          success: function (response) {
            var data = $.parseJSON(response);

            if (data.status) {
              $field.find(".sp-image-upload-wrapper").empty().html(data.output);
            } else {
              $field.find(".sp-image-upload-wrapper").empty();
              alert(data.output);
            }

            var $image = $field.find(".sp-image-upload-wrapper").find(">img");

            if ($image.length) {
              $field.find(".btn-sp-image-upload").addClass("hide");
              $field.find(".btn-sp-image-remove").removeClass("hide");
              $field.find(".form-field-spimage").val($image.data("src"));
            } else {
              $field.find(".btn-sp-image-upload").removeClass("hide");
              $field.find(".btn-sp-image-remove").addClass("hide");
              $field.find(".form-field-spimage").val("");
            }

            $this.val("");
            $this.prop("disabled", false);
            $field.find(".btn-sp-image-upload").removeAttr("disabled");
          },
          error: function () {
            $field.find(".sp-image-upload-wrapper").empty();
            $this.val("");
          },
        });
      }

      $this.val("");
    });
  });

  // Delete Image
  $(document).on("click", ".btn-sp-image-remove", function (event) {
    event.preventDefault();

    var $this = $(this);
    var $parent = $this.closest(".sp-image-field");

    if (
      confirm(
        "You are about to permanently delete this item. 'Cancel' to stop, 'OK' to delete.",
      ) == true
    ) {
      var request = {
        option: "com_ajax",
        plugin: "helix3",
        action: "remove_image",
        src: $parent.find(".sp-image-upload-wrapper").find(">img").data("src"),
        format: "json",
      };
      helix3AppendCsrfToken(request, $parent);

      $.ajax({
        type: "POST",
        data: request,
        success: function (response) {
          var data = $.parseJSON(response);
          if (data.status) {
            $parent.find(".sp-image-upload-wrapper").empty();
            $parent.find(".btn-sp-image-upload").removeClass("hide");
            $parent.find(".btn-sp-image-remove").addClass("hide");
            $parent.find(".form-field-spimage").val("");
          } else {
            alert(data.output);
          }
        },
      });
    }
  });
});
