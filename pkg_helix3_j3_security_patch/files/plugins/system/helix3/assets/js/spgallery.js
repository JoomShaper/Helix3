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

  $(".sp-gallery-field").each(function (index, el) {
    var $field = $(el);

    // Upload form
    $field.find(".btn-sp-gallery-item-upload").on("click", function (event) {
      event.preventDefault();
      $field.find(".sp-gallery-item-upload").click();
    });

    //Sortable
    $field.find(".sp-gallery-items").sortable({
      stop: function (event, ui) {
        // Set Value
        var images = [];
        $.each(
          $field.find(".sp-gallery-items").find(">li"),
          function (index, value) {
            images.push('"' + $(value).data("src") + '"');
          },
        );
        var output =
          '{"' +
          $field.find(".form-field-spgallery").data("name") +
          '":[' +
          images +
          "]}";
        $field.find(".form-field-spgallery").val(output);
      },
    });

    //Upload
    $field.find(".sp-gallery-item-upload").on("change", function (e) {
      e.preventDefault();
      var $this = $(this);
      var file = $(this).prop("files")[0];

      var data = new FormData();
      data.append("option", "com_ajax");
      data.append("plugin", "helix3");
      data.append("action", "upload_image");
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
            $field
              .find(".btn-sp-gallery-item-upload")
              .attr("disabled", "disabled");
            var loader = $(
              '<li class="sp-gallery-item-loader"><i class="fa fa-circle-o-notch fa-spin"></i></li>',
            );
            $this.prev(".sp-gallery-items").append(loader);
          },
          success: function (response) {
            var data = $.parseJSON(response);

            if (data.status) {
              $field.find(".sp-gallery-item-loader").before(data.output);
            } else {
              alert(data.output);
            }

            $this.val("");
            $this
              .prev(".sp-gallery-items")
              .find(".sp-gallery-item-loader")
              .remove();
            $this.prop("disabled", false);
            $field.find(".btn-sp-gallery-item-upload").removeAttr("disabled");

            var images = [];
            $.each(
              $field.find(".sp-gallery-items").find(">li"),
              function (index, value) {
                images.push('"' + $(value).data("src") + '"');
              },
            );
            var output =
              '{"' +
              $field.find(".form-field-spgallery").data("name") +
              '":[' +
              images +
              "]}";
            $(".form-field-spgallery").val(output);
          },
          error: function () {
            $this
              .prev(".sp-gallery-items")
              .find(".sp-gallery-item-loader")
              .remove();
            $this.val("");
          },
        });
      }

      $this.val("");
    });
  });

  // Delete Image
  $(document).on("click", ".btn-remove-image", function (event) {
    event.preventDefault();

    var $this = $(this);

    if (
      confirm(
        "You are about to permanently delete this item. 'Cancel' to stop, 'OK' to delete.",
      ) == true
    ) {
      var request = {
        option: "com_ajax",
        plugin: "helix3",
        action: "remove_image",
        src: $(this).parent().data("src"),
        format: "json",
      };
      helix3AppendCsrfToken(request, $this.closest(".sp-gallery-field"));

      $.ajax({
        type: "POST",
        data: request,
        success: function (response) {
          var data = $.parseJSON(response);
          if (data.status) {
            $this.parent().remove();

            var images = [];
            $.each($(".sp-gallery-items").find(">li"), function (index, value) {
              images.push('"' + $(value).data("src") + '"');
            });
            var output =
              '{"' +
              $(".form-field-spgallery").data("name") +
              '":[' +
              images +
              "]}";
            $(".form-field-spgallery").val(output);
          } else {
            alert(data.output);
          }
        },
      });
    }
  });
});
