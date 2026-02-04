$(document).ready(function() {
  var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  $('.box').slideToggle();
  $('.online_creators_title').click(function() {
    if ($('#minimize_button').html() == '<i class="fas fa-plus-circle"></i>') {
      $('#minimize_button').html("<i class='fas fa-minus-circle'></i>");
    } else {
      $('#minimize_button').html("<i class='fas fa-plus-circle'></i>");
    }
    $('.box').slideToggle();
  });

  var all_creators = $('.all_creators').length;
  //console.log(all_creators);

  for (var i = 0; i < all_creators; i++) {
    //console.log($('#timestart_'+i).text());
    if (
      $('#timestart_' + i).text() != '' &&
      $('#timestart_' + i).text() != 'No shift'
    ) {
      var creatorUTCstarttime = moment.tz($('#timestart_' + i).text(), 'UTC');
      var dateset = creatorUTCstarttime
        .clone()
        .tz(user_timezone)
        .format('YYYY-MM-DD, HH:mm');
      $('#timestart_' + i).text(dateset);
      //console.log(dateset);
    }

    if ($('#timeleft_' + i).text() != '') {
      var creatorUTCendtime = moment.tz($('#timeleft_' + i).text(), 'UTC');
      var dateset = creatorUTCendtime
        .clone()
        .tz(user_timezone)
        .format('YYYY-MM-DD, HH:mm');
      $('#timeleft_' + i).countdown(dateset, function(event) {
        $(this).html(event.strftime('%H:%M'));
        $('#creator_bubble_' + i)
          .removeClass('offline')
          .addClass('online');
        var creator_id = $('#creator_bubble_' + i + ' > .creator_id').attr(
          'id'
        );
        //console.log(creator_id);
        $('#creator_bubble_' + i + ' > #' + creator_id).val('online');
      });
      if ($('#timeleft_' + i).text() == '00:00') {
        $('#creator_bubble_' + i)
          .removeClass('online')
          .addClass('offline');
        var creator_id = $('#creator_bubble_' + i + ' > .creator_id').attr(
          'id'
        );
        //console.log(creator_id);
        $('#' + creator_id).val('offline');
      }
      //console.log(creatorUTCendtime);
    }
  }

var creator=$('.creator').length;

//console.log("creator = "+creator);

  for (var i = 0; i < creator; i++) {
    for (var j = 0; j < all_creators; j++) {
      var creator_id = $('#creator_bubble_' + j + ' > .creator_id').attr('id');
 
      var online_class = $('#creator_bubble_' + j + ' > #' + creator_id).val();
      var creator_timeleft = $('.timeleft_' + creator_id).text();
      var creator_starttime = $('.timestart_' + creator_id).text();

      if ($('.timeleft_' + creator_id).text() != '00:00') {
        $('#creators_' + i + ' > #creator_' + creator_id)
          .removeClass('offline')
          .addClass(online_class);
      }
      $('#creators_' + i + ' > #creator_' + creator_id).append(
        ' - left: ' + creator_timeleft + ' - next: ' + creator_starttime
      );
    }
  }
});


$(function(){
    $('body').find('.online_creators_title').on('click', function(){
        console.log('Title clicked');
    });
});