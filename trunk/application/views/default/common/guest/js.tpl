<script src="__($config.template_prefix)__asset/js/jquery.validate.min.js"></script>
<script>
$( function() {
      initializeArea();
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
          maxlength: 12,
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
$("#area-list").change(function() {
  initializeSchool( $("#area-list").val() );
});
schoolArray = new Array();
schoolIdArray = new Array();
$("#submit-btn").click(function() {
  school = $("#select-school").val();
  id = schoolIdArray[ schoolArray.indexOf(school) ];
  $("#input-school-id").val(id);
});

function initializeArea() {
        $.getJSON("__('base_ajax_controller/getAllAreaInformation'|site_url)__?city_id=1",function(data){
        for (i in data) {
          $("#area-list").append("<option value="+data[i].area_id+">"+data[i].name+"</option>");
        }
      });
}
function initializeSchool(area) {
        $.getJSON("__('base_ajax_controller/getAllSchoolInformation'|site_url)__?area_id="+area,function(data) {
          for (i in data) {
            schoolArray.push( data[i].name );
            schoolIdArray.push( data[i].school_id );
          }
          $('#select-school').typeahead( { source: schoolArray, minLength: 2, items: 12 } );
      });
}

</script>