<script src="{$config.asset}/js/bootstrap-datepicker.js"></script>
<script src="{$config.asset}/js/jquery.validate.min.js"></script>
<script type="text/javascript" charset="utf-8" src="{$config.inc}/kindeditor/kindeditor.js"></script>
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
        newTag = '<span class="badge tag tag-edit" onclick="$(this).remove()">'+tag+'<input type="hidden" name="tag[]" value="'+tag+'"></span>';
        $(".tag-list").append( newTag );
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
{if $current_member_information.member_type == 'stu'}
var editor = KindEditor.editor();
{else}
var editor = KindEditor.create('.richtext', { 
  themeType: 'simple',
  items : [
        'undo', 'redo', '|', 'preview', 'cut', 'copy', 'paste', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', '|', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript', 'superscript', '|', 'quickformat', '/',
        'formatblock', 'fontname', 'fontsize', 'lineheight', '|', 'forecolor', 'bold', 'italic', 'underline', 'link', 'unlink', '|', 'image', 'table', '|', 'removeformat',  'source', 'fullscreen'
  ] }
);
{/if}
$('.portrait-upload').click(function() {
		editor.loadPlugin('image_resize', function() {
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
