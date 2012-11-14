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
        $('#waterfall-loading').slideUp();
        var newItemStr = '';
        for(i in data)
          newItemStr += wrapFunction( i+1, data[i]);
        var $newItems = $(newItemStr);
        masonryHandler.append( $newItems );
        if( first ) {
          first = false;
          masonryHandler.imagesLoaded( function() {
            masonryHandler.masonry( {
              itemSelector: '.waterfall-item',
              columnWidth: paramWidth
            } );
          });
        } else {
          masonryHandler.imagesLoaded( function() {
            masonryHandler.masonry( 'appended', $newItems, true );
          });
        }
        
        page_offset += limit;
        refresh_lock = false;
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