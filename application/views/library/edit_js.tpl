<script src="{$config.asset}/js/jquery.validate.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/inc/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="/inc/kindeditor/lang/zh_CN.js"></script>
<script>
//disable Enter for form submission
$("form").keypress(function(e) {
  if( e.which == 13 ) {
    return false;
  }
});
$("#sidebar-new-book").addClass("active");
$('#book-form').validate({
      rules: {
      	name: {
      		required: true
      	}
      },
      highlight: function(label) {
        $(label).closest('.control-group').addClass('error').removeClass('success');
      },
      success: function(label) {
        $(label).closest('.control-group').removeClass('error');
      }
});
var editor = KindEditor.create('.richtext',{ resizeType : 1,
                          items : ['fontsize', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', '|', 'emoticons', 'image', 'link']
                          });
$('.cover-upload').click(function() {
		editor.loadPlugin('image', function() {
			editor.plugin.imageDialog({
				imageUrl : $('#image').val(),
				clickFn : function(url, title, width, height, border, align) {
					$('#cover-view').attr('src',url);
					$('#cover-url').val(url);
					editor.hideDialog();
				}
			});
		});
});
  
</script>