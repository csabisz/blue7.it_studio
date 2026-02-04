function logViewportCoordinates() {
  // Viewport dimensions

  var viewportWidth = window.innerWidth;

  var viewportHeight = window.innerHeight;

  // Scroll positions

  var scrollX = window.scrollX || window.pageXOffset;

  var scrollY = window.scrollY || window.pageYOffset;

  // Calculate viewport coordinates

  var topLeft = { x: scrollX, y: scrollY };

  var topRight = { x: scrollX + viewportWidth, y: scrollY };

  var bottomLeft = { x: scrollX, y: scrollY + viewportHeight };

  var bottomRight = { x: scrollX + viewportWidth, y: scrollY + viewportHeight };

  // Log the coordinates

  console.log("Top Left:", topLeft);

  console.log("Top Right:", topRight);

  console.log("Bottom Left:", bottomLeft);

  console.log("Bottom Right:", bottomRight);
}

// this.imagePreview = function() {

//     if ($(window).width() > 1200) {

//         var previewWidth = 600; // Width of the preview element

//         var previewHeight = 400; // Height of the preview element

//         var xOffset = (window.innerWidth - previewWidth) / 2;

//         var yOffset = (window.innerHeight - previewHeight) / 2;

//         $('img.img-responsive').hover(

//             function(e) {

//                 this.t = this.alt;

//                 this.alt = '';

//                 var c = this.t != '' ? '<br/>' + this.t : '';

//                 $('body').append(

//                     "<p class='text-center' id='preview' style='height: 55vh; z-index: 9999; min-height: unset !important;'><img src='" +

//                     this.src +

//                     "'   alt='Image prview' style='max-height: 50vh !important; z-index: 9999; height: inherit !important; max-width: unset !important; width: auto;' />" +

//                     c +

//                     '</p>'

//                 );

//                 var maxTop = window.innerHeight - $('#preview').height() - yOffset;

//                 var previewTop = Math.min(e.pageY - xOffset, maxTop);

//                 if (e.pageX + yOffset > window.innerWidth / 2 + previewWidth) {

//                     $('#preview')

//                         .css('top', e.pageY - xOffset + 'px')

//                         .css('left',  yOffset + 'px')

//                         .fadeIn('slow');

//                 } else {

//                     $('#preview')

//                         .css('position', 'fixed')

//                         .css('top', e.pageY - xOffset + 'px')

//                         .css('left', e.pageX + yOffset + 'px')

//                         .fadeIn('slow');

//                 }

//             },

//             function() {

//                 this.alt = this.t;

//                 $('#preview').remove();

//             }

//         );

//         $('img.img-responsive').mousemove(function(e) {

//             // Get viewport dimensions

//             var viewportWidth = window.innerWidth;

//             var viewportHeight = window.innerHeight;

//             // Calculate preview dimensions

//             var previewWidth = 600;

//             var previewHeight = $('#preview').height(); // Assuming the preview is already visible

//             // Calculate the maximum top position to keep the preview within the viewport

//             var maxTop = viewportHeight - previewHeight + 600;

//             // Calculate the maximum left position to keep the preview within the viewport

//             var maxLeft = viewportWidth - previewWidth;

//             // Calculate the desired top position for the preview

//             var desiredTop = e.pageY - xOffset;

//             // Calculate the desired left position for the preview

//             var desiredLeft = e.pageX + yOffset;

//             // Ensure the preview stays within the viewport boundaries

//             var previewTop = Math.min(Math.max(desiredTop, 0), maxTop);

//             var previewLeft = Math.min(Math.max(desiredLeft, 0), maxLeft);

//             // Set the position of the preview

//             $('#preview')

//                 .css('top', e.pageY - 600 + 'px')

//                 .css('left', previewLeft + 'px')

//                 .fadeIn('slow');

//         });

//         var previewCoordinates = $('#preview').position();

//         console.log("Preview Element Coordinates:", previewCoordinates);

//     }

// };

// $(document).ready(function() {

//   imagePreview();

// });

$(function () {
  $("body")
    .find($("button").attr("aria-expanded", "true"))
    .each(function () {
      $(this).on("click", function () {
        if ($(this).find("strong").find("span").html() === "Hide") {
          $(this).find("strong").find("span").html("View");
        } else {
          $(this).find("strong").find("span").html("Hide");
        }
      });
    });
});

$(function () {
  $("body")
    .find("div.boxes")
    .each(function () {
      var input = $(this).find('input[type="checkbox"]');

      if (input.val() === "1") {
        input.attr("checked", "checked");
      } else {
        input.attr("checked", null);
      }
    });
});

function check(x) {
  var valoare = $("#" + x).val();

  console.log(valoare);

  if (valoare == "1") {
    $("#" + x).val("0");

    $("#" + x)
      .parent()
      .find('input[type="hidden"]')
      .val("0");
  }

  if (valoare == "0") {
    $("#" + x).val("1");

    $("#" + x)
      .parent()
      .find('input[type="hidden"]')
      .val("1");
  }

  $("#" + x)
    .parent()
    .parent()
    .parent()
    .submit();
}

$(function () {
  $("#inbtnb3").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#inbtnb5").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if ($("#inbtnb7").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (
        !$("#inbtnb5").hasClass("clicked") &&
        !$("#inbtnb7").hasClass("clicked")
      ) {
        $("#remarks_in_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_in_row").removeClass("d-none");

      $("#inbtnb3").addClass("clicked");
    }
  });

  $("#inbtnb5").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#inbtnb3").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if ($("#inbtnb7").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (
        !$("#inbtnb3").hasClass("clicked") &&
        !$("#inbtnb7").hasClass("clicked")
      ) {
        $("#remarks_in_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_in_row").removeClass("d-none");

      $("#inbtnb5").addClass("clicked");
    }
  });

  $("#inbtnb6").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#inbtnb3").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if ($("#inbtnb7").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (
        !$("#inbtnb3").hasClass("clicked") &&
        !$("#inbtnb7").hasClass("clicked")
      ) {
        $("#remarks_in_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_in_row").removeClass("d-none");

      $("#inbtnb6").addClass("clicked");
    }
  });

  $("#inbtnb7").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#inbtnb3").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if ($("#inbtnb5").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (
        !$("#inbtnb3").hasClass("clicked") &&
        !$("#inbtnb5").hasClass("clicked")
      ) {
        $("#remarks_in_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_in_row").removeClass("d-none");

      $("#inbtnb7").addClass("clicked");
    }
  });

  $("#exbtnb5").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#exbtnb7").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (!$("#exbtnb7").hasClass("clicked")) {
        $("#remarks_ex_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_ex_row").removeClass("d-none");

      $("#exbtnb5").addClass("clicked");
    }
  });

  $("#exbtnb6").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#exbtnb7").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (!$("#exbtnb7").hasClass("clicked")) {
        $("#remarks_ex_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_ex_row").removeClass("d-none");

      $("#exbtnb6").addClass("clicked");
    }
  });

  $("#exbtnb7").on("click", function () {
    if ($(this).hasClass("clicked")) {
      if ($("#exbtnb5").hasClass("clicked")) {
        $(this).removeClass("clicked");
      }

      if (!$("#exbtnb5").hasClass("clicked")) {
        $("#remarks_ex_row").addClass("d-none");

        $(this).removeClass("clicked");
      }
    } else {
      $("#remarks_ex_row").removeClass("d-none");

      $("#exbtnb7").addClass("clicked");
    }
  });
});

$(function () {
  $("table#uploadFiles")
    .find("tbody")
    .find("tr")
    .find("td")
    .find(".row")
    .find(".col-md-6")
    .find("a.addFiles")
    .on("click", function () {
      var nameInput = $(this)
        .parent()
        .parent()
        .find(".col-md-6")
        .find("label")
        .parent()
        .attr("id");

      $(this)
        .parent()
        .parent()
        .find(".col-md-6")
        .find("label")
        .parent()
        .append(
          "<label class='file-upload'> <input type='file' name='" +
            nameInput +
            "[]' /> </label>"
        );
    });
});
