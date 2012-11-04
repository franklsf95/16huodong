<script src="{$config.asset}/js/bootstrap-datepicker.js"></script>
<script src="{$config.asset}/js/jquery.validate.min.js"></script>
<script src="{$config.asset}/js/wysihtml5-0.3.0.js"></script>
<script src="{$config.asset}/js/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" charset="utf-8" src="{$config.inc}/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="{$config.inc}/kindeditor/lang/zh_CN.js"></script>
<script>
//disable Enter for form submission
$("form").keypress(function(e) {
      if( e.which == 13 ) {
        return false;
      }
});
$("#memberTag").keydown(function() {
      if( event.keyCode == 13 ) {
        $("#badge-add-tag").click();
      }
});
$("#badge-add-tag").click(function(){
      tag = $("#memberTag").val();
      if( tag != '' ) {
        newTag = '<span class="badge tag" onclick="$(this).remove()">'+tag+'<input type="hidden" name="tag[]" value="'+tag+'"></span>';
        $("#tag-list").append( newTag );
        $("#memberTag").val('');
        $("#memberTag").focus();
      }
});
$("#sidebar-edit-profile").addClass("active");
$('#profile-form').validate({
      rules: {
        new_password: {
          minlength: 6,
        },
        repeat_password: {
          equalTo: "#inputNewPassword",
        },
        name: {
        	rangelength: [2,12],
        	required: true
        },
        email: {
          email: true,
          required: true
        },
        phone: {
        	rangelength: [8,15]
        },
        qq: {
        	rangelength: [6,11]
        }
      },
      highlight: function(label) {
        $(label).closest('.control-group').addClass('error');
      },
      success: function(label) {
        $(label).closest('.control-group').removeClass('error');
      }
});
$(".datepicker").datepicker( {
    	format:'yyyy-mm-dd',
      viewMode: 2 //'years'
} );
$(".richtext").wysihtml5();

var editor = KindEditor.editor( {
      allowImageParameter : false
} );
$('.portrait-upload').click(function() {
      editor.uploadJson = '__($config.application_inc)__kindeditor/php/upload_portrait_json.php',
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : $('#portrait-url').val(),
					clickFn : function(url, title, width, height, border, align) {
						$('#portrait-view').attr('src',url);
						$('#portrait-url').val(url);
						editor.hideDialog();
					}
				});
			});
});
</script>