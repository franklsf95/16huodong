<script src="{$config.asset}/js/bootstrap-datepicker.js"></script>
<script src="{$config.asset}/js/jquery.validate.min.js"></script>
<script type="text/javascript" charset="utf-8" src="{$config.inc}/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="{$config.inc}/kindeditor/lang/zh_CN.js"></script>
<script>
//disable Enter for form submission
$("form").keypress(function(e) {
  		if( e.which == 13 ) {
  			return false;
  		}
});
$("#sidebar-new-activity").addClass("active");
$(".datepicker").datepicker( {
    	format: "yyyy-mm-dd"
});
$("#actTag").keydown(function() {
  if( event.keyCode == 13 ) {
    $("#badge-add-tag").click();
  }
});
$('#activity_never_end').click(function(){
  var elem = $('#actEndTime');
  elem.val('2345-6-7').attr('disabled', !elem.attr('disabled') );
})
$("#badge-add-tag").click(function(){
    	tag = $("#actTag").val();
    	if( tag != '' ) {
        $('.tag-prompt').hide();
    		newTag = '<span class="badge tag tag-edit" onclick="$(this).remove()">'+tag+'<input type="hidden" name="tag[]" value="'+tag+'"></span>';
    		$(".tag-list").append( newTag );
    		$("#actTag").val('');
    		$("#actTag").focus();
    	}
});
jQuery.validator.addMethod("endDate",
function(value, element) {
var startDate = $('#actStartTime').val();
return new Date(Date.parse(startDate.replace("-", "/"))) <= new Date(Date.parse(value.replace("-", "/")));
}, 
"结束时间不应早于开始时间");
jQuery.validator.addMethod("endDateApply",
function(value, element) {
var startDate = $('#applyStartTime').val();
return new Date(Date.parse(startDate.replace("-", "/"))) <= new Date(Date.parse(value.replace("-", "/")));
}, 
"结束时间不应早于开始时间");
$('#activity-form').validate({
  rules: {
    name: {
      required: true
    },
		end_time: {
			required: true,
			endDate: true
		},
		apply_end_time: {
			required: true,
			endDateApply: true
		},
      	price: {
      		min: 0
      	},
      	address: {
      		required: true
      	},
      	image: {
      		required: true
      	},
      	description: {
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
  items : ['fontsize', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', '|', 'emoticons', 'image', 'link'] });
$('.cover-upload').click(function() {
		editor.loadPlugin('image_resize', function() {
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
