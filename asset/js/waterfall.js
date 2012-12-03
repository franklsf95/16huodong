var masonryHandler = $("#waterfall");
var page_offset = 0;
var limit = 8;
var refresh_lock = false;

function resetWaterfall() {
  masonryHandler.empty().masonry('destroy');
  page_offset = 0;
  refresh_lock = false;
}

function Waterfall( json_url, functype, options ) {
  var paramWidth = options.width ? options.width : 210;
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

  if( functype=='start' ) resetWaterfall();

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

        masonryHandler.imagesLoaded( function() {
          $('#waterfall-loading').slideUp();
          if( options.callBack!=undefined ) options.callBack();
          
          if(functype=='start') {
            masonryHandler.masonry({
              itemSelector: '.waterfall-item',
              columnWidth: paramWidth,
              isAnimated: true
            });
          } else {
            masonryHandler.masonry( 'appended', $newItems, true );
          }
        });
        
        page_offset += limit;
        refresh_lock = false;
      },
      error: function() {
        $('#waterfall-loading').slideUp();
      }
    });
  }
}
