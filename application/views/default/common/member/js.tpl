<script src="__($config.template_prefix)__asset/js/jquery.masonry.min.js"></script>
<script>
$( function(){
  $('#container').masonry({
    // options
    itemSelector : '.main-showcase-item',
    columnWidth : 280
  });
});
</script>