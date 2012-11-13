<script src="{$config.asset}/js/jquery.wookmark.js"></script>
<script>
var wmOptions = {
      autoResize: true,
      container: $('#waterfall'),
      itemWidth: 280
    };
var handler = null;
var page_offset = 0;
var limit = 10;
var refresh_lock = false;

function updateWaterfall( url, wrapFunction ) {
	if (!refresh_lock) {
		refresh_lock = true;
		$.getJSON(url, {
			"page_offset": page_offset,
			"limit": limit,
			async: false
		}, function(data) {
			for(i in data) {
				$("#waterfall").append( wrapFunction( i+1, data[i]) );
			}
			if(handler) handler.wookmarkClear();
			handler = $("#waterfall li");
			handler.fadeIn('slow');
			handler.wookmark(wmOptions);

			page_offset += limit;
			refresh_lock = false;
		});
	}
}
</script>