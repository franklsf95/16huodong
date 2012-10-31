<script src="{$config.asset}/js/jquery.validate.min.js"></script>
<script>
var areaSelector = '#select-area-1';
var schoolSelector = '#select-school-1';
$("#remember-me-anchor").click( function() {
  if( $("#loginRemember").attr("checked") )
    $("#loginRemember").removeAttr("checked");
  else
    $("#loginRemember").attr("checked", true);
});
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
          rangelength: [2,12],
          required: true
        }
      },
      highlight: function(label) {
        $(label).closest('.control-group').addClass('error').removeClass('success');
      },
      success: function(label) {
        label
          .text('OK!').addClass('valid')
          .closest('.control-group').addClass('success').removeClass('error');
      } });
    });
$("#tab-stu").click(function() {
  $("#input-type").val( 'student' );
  areaSelector = '#select-area-1';
  schoolSelector = '#select-school-1';
});
$("#tab-org").click(function() {
  $("#input-type").val( 'student_organization' );
  areaSelector = '#select-area-2';
  schoolSelector = '#select-school-2';
});
$("#tab-chr").click(function() {
  $("#input-type").val( 'commonweal_organization' );
});
$("#tab-com").click(function() {
  $("#input-type").val( 'company' );
});
$(".area-list").change(function() {
  initializeSchool( $(this).val() );
});
schoolArray = new Array();
schoolIdArray = new Array();
$("#submit-btn").click(function() {
  school = $(schoolSelector).val();
  id = schoolIdArray[ schoolArray.indexOf(school) ];
  $("#input-school-id").val(id);
});

function initializeArea() {
        $.getJSON("{'welcome/ajaxGetAllAreaInformation'|site_url}?city_id=1",function(data){
        for (i in data) {
          op = "<option value="+data[i].area_id+">"+data[i].name+"</option>";
          $(".area-list").append(op);
        }
      });
}
function initializeSchool(area) {
        $.getJSON("{'welcome/getAllSchoolInformation'|site_url}?area_id="+area,function(data) {
          schoolArray = [];
          schoolIdArray = [];
          for (i in data) {
            schoolArray.push( data[i].name );
            schoolIdArray.push( data[i].school_id );
          }
          console.log(schoolArray);
          console.log(schoolIdArray);
          $(schoolSelector).typeahead( { source: schoolArray, minLength: 2, items: 12 } );
      });
}

</script>