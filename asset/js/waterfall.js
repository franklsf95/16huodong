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

function updateWaterfall( json_url, options ) {
  var paramWidth = options.width ? options.width : 280;
  var EmptyString = '（没有项目）';
  var WrapFunc = options.wrapFunction;
  if( options.type=='activity' ) {
    EmptyString = '（没有活动）';
    if( WrapFunc==undefined ) WrapFunc = wrapActivity;
  } else if( options.type=='book' ) {
    EmptyString = '（没有微型书）';
    if( WrapFunc==undefined ) WrapFunc = wrapBook;
  }
  if( options.limit ) limit = options.limit;

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
        if( data.length==0 ) {
          masonryHandler.append(EmptyString);
          $('#waterfall-loading').slideUp();
          return;
        }
        var newItemStr = '';
        for(i in data)
          newItemStr += WrapFunc( i+1, data[i]);
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

function refillWaterfall( json_url, options ) {
  var paramWidth = options.width ? options.width : 280;
  var EmptyString = '（没有项目）';
  var WrapFunc = options.wrapFunction;
  if( options.type=='activity' ) {
    EmptyString = '（没有活动）';
    if( WrapFunc==undefined ) WrapFunc = wrapActivity;
  } else if( options.type=='book' ) {
    EmptyString = '（没有微型书）';
    if( WrapFunc==undefined ) WrapFunc = wrapBook;
  }
  if( options.limit ) limit = options.limit;

  masonryHandler.empty().masonry('destroy');
  $.ajax( {
      url: json_url,
      dataType: 'json',
      data: { 'page_offset': page_offset, 'limit': limit },
      success: function( data ) {
        var newItemStr = '';
        for(i in data)
          newItemStr += WrapFunc( i+1, data[i]);
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