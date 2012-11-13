<script src="{$config.asset}/js/jquery.masonry.min.js"></script>
<script>
var masonryOptions = {
	itemSelector : '.waterfall-item',
	columnWidth : 280,
	isAnimated: true
};
var masonryHandler = $("#waterfall");
var page_offset = 0;
var limit = 10;
var refresh_lock = false;
var first = true;

function updateWaterfall( json_url, wrapFunction ) {
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

				if( first ) {
					first = false;
					masonryHandler.imagesLoaded( function() {
						masonryHandler.append( $newItems ).masonry( masonryOptions );
					});
				} else {
					masonryHandler.imagesLoaded( function() {
						masonryHandler.append( $newItems ).masonry( 'appended', $newItems, true );
					});
				}
				
				page_offset += limit;
				refresh_lock = false;
			}
		});
	}
}
</script>