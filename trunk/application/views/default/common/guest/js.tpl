<script src="__($config.template_prefix)__asset/js/jquery.validate.min.js"></script>
<script>
$( function() {
  initializeArea();
      $('.typeahead').typeahead();
      $('#reg-form').validate({
      rules: {
        username: {
          minlength: 6,
          required: true
        },
        password: {
          minlength: 6,
          required: true
        },
        password2: {
          equalTo: "#password",
          required: true
        },
        email: {
          email: true,
          required: true
        },
        name: {
          minlength: 2,
          maxlength: 6,
          required: true
        }
      },
      highlight: function(label) {
        $(label).closest('.control-group').addClass('error');
      },
      success: function(label) {
        label
          .text('OK!').addClass('valid')
          .closest('.control-group').addClass('success');
      } });
    });
$("#tab-stu").click(function() {
  $("#input-type").val( 'student' );
});
$("#tab-org").click(function() {
  $("#input-type").val( 'student_organization' );
});
$("#tab-chr").click(function() {
  $("#input-type").val( 'commonweal_organization' );
});
$("#tab-com").click(function() {
  $("#input-type").val( 'company' );
});
function initializeArea() {
        $.getJSON("__('base_ajax_controller/getAllAreaInformation'|site_url)__?city_id=1",function(data){
        for (i in data) {
          $("<option>1</option>").appendTo("#area-list");

          //alert();
        }
      });
}

</script>