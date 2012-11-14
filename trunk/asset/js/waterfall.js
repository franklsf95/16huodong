var masonryHandler = $("#waterfall");
var page_offset = 0;
var limit = 6;
var refresh_lock = false;
var first = true;

function updateWaterfall( json_url, wrapFunction, width ) {
  var myWidth = width ? width : 280;
  if (!refresh_lock) {
    refresh_lock = true;
    $.ajax( {
      url: json_url,
      dataType: 'json',
      data: { 'page_offset': page_offset, 'limit': limit },
      //async: false,
      success: function( data ) {
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
              columnWidth: myWidth,
              isAnimated: true
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