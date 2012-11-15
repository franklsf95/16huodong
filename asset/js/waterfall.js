var masonryHandler = $("#waterfall");
var page_offset = 0;
var limit = 6;
var refresh_lock = false;
var first = true;

function resetWaterfall() {
  masonryHandler.empty().masonry('destroy');
  page_offset = 0;
  refresh_lock = false;
  first = true;
}

function updateWaterfall( json_url, wrapFunction, width ) {
  var paramWidth = width ? width : 280;
  if (!refresh_lock) {
    refresh_lock = true;
    $.ajax( {
      url: json_url,
      dataType: 'json',
      data: { 'page_offset': page_offset, 'limit': limit },
      beforeSend : function() {
        $('#waterfall-loading').show();
      },
      success: function( data ) {
        console.log(data);
        if( data.length==0 ) {
          masonryHandler.append('（空）');
          $('#waterfall-loading').slideUp();
          return;
        }
        var newItemStr = '';
        for(i in data)
          newItemStr += wrapFunction( i+1, data[i]);
        var $newItems = $(newItemStr);
        masonryHandler.append( $newItems );
        if( first ) {
          first = false;
          masonryHandler.imagesLoaded( function() {
            $('#waterfall-loading').slideUp();
            masonryHandler.masonry( {
              itemSelector: '.waterfall-item',
              columnWidth: paramWidth,
              isAnimated: true
            } );
          });
        } else {
          masonryHandler.imagesLoaded( function() {
            $('#waterfall-loading').slideUp();
            masonryHandler.masonry( 'appended', $newItems, true );
          });
        }
        
        page_offset += limit;
        refresh_lock = false;
      },
      error: function() {
        $('#waterfall-loading').slideUp();
      }
    });
  }
}

function refillWaterfall( json_url, wrapFunction, width ) {
  masonryHandler.empty().masonry('destroy');
  var paramWidth = width ? width : 280;
  $.ajax( {
      url: json_url,
      dataType: 'json',
      data: { 'page_offset': page_offset, 'limit': limit },
      success: function( data ) {
        var newItemStr = '';
        for(i in data)
          newItemStr += wrapFunction( i+1, data[i]);
        var $newItems = $(newItemStr);
        masonryHandler.append( $newItems ).hide();
        masonryHandler.imagesLoaded( function() {
            masonryHandler.masonry( {
              itemSelector: '.waterfall-item',
              columnWidth: paramWidth,
              isAnimated: false
            } );
        });
        masonryHandler.fadeIn();
      }
    });
}

function wrapActivity( id, act ) {
  var str = 
'<div class="waterfall-item" id="item-'+id+'">'+'<a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+'<img src="'+act.activity_image+'" class="img-rounded"></a>'
+'<h4><a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+act.activity_name+'</a></h4>'
+'<div class="waterfall-item-bottom"><ul>'
+'<li>开始时间: '+act.start_time+'</li>'
+'<li>结束时间: '+act.end_time+'</li>'
+'<li>发起人: <a href="{"profile"|site_url}?id='+act.publisher_id+'">'+act.publisher_name+'</a></li>'
+'<li><code>'+act.attend_count+'</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+act.follow_count+'</code>人关注</li>'
+'</ul></div></div>';
  return str;
}