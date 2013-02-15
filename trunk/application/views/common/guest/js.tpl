<script src="{$config.asset}/js/jquery.validate.min.js"></script>
<script>
areaSelector = '#select-area-1';
schoolSelector = '#select-school-1';
schoolArray = new Array('aaaaaaa');
schoolIdArray = new Array();
$( function() {
  initializeArea();
  initializeSchool(21);
});
$('.typeahead').tooltip({
  title : '先选择城市区县，在这里开始输入学校全称，从下拉框中选择你的学校~',
  placement: 'right',
  trigger: 'focus'
});
$(".carousel").carousel({
  interval: 5000,
  pause: 'hover'
});
$("#remember-me-anchor").click( function() {
  if( $("#loginRemember").attr("checked") )
    $("#loginRemember").removeAttr("checked");
  else
    $("#loginRemember").attr("checked", true);
});
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
        }
      },
      highlight: function(label) {
        $(label).closest('.control-group').addClass('error').removeClass('success');
      },
      success: function(label) {
        label
          .text('OK!').addClass('valid')
          .closest('.control-group').addClass('success').removeClass('error');
      }
});
$("#tab-stu").click(function() {
  $("#input-type").val( 'stu' );
  areaSelector = '#select-area-1';
  schoolSelector = '#select-school-1';
});
$("#tab-org").click(function() {
  $("#input-type").val( 'org' );
  areaSelector = '#select-area-2';
  schoolSelector = '#select-school-2';
});
$("#tab-chr").click(function() {
  $("#input-type").val( 'chr' );
});
$("#tab-com").click(function() {
  $("#input-type").val( 'com' );
});
$("#submit-btn").click(function() {
  school = $(schoolSelector).val();
  //for ie doesn't support indexof 
		if(!Array.indexOf){ 
            Array.prototype.indexOf = function(obj){ 
                for(var i=0; i<this.length; i++){ 
                    if(this[i]==obj){ 
                        return i; 
                    } 
                } 
                return -1; 
            } 
        } 
  id = schoolIdArray[ schoolArray.indexOf(school) ];
  $("#input-school-id").val(id);
});

$(".area-list").change(function() {
  initializeSchool( $(this).val() );
});

function initializeArea() {
      $(".area-list").empty();
      $.getJSON("{'welcome/ajaxGetAllAreaInformation'|site_url}?city_id="+window.document.getElementById("select-province-1").value,function(data){
        for (i in data) {
          op = "<option value="+data[i].area_id+">"+data[i].name+"</option>";
          $(".area-list").append(op);
        }
      });
}
function initializeArea2() {
      $(".area-list").empty();
      $.getJSON("{'welcome/ajaxGetAllAreaInformation'|site_url}?city_id="+window.document.getElementById("select-province-2").value,function(data){
        for (i in data) {
          op = "<option value="+data[i].area_id+">"+data[i].name+"</option>";
          $(".area-list").append(op);
        }
      });
}
function initializeSchool(area) {
  schoolArray = [];
  schoolIdArray = [];
  $.ajax( {
      url: "{'welcome/ajaxGetAllSchoolInformation'|site_url}?area_id="+area,
      dataType: 'json',
      async: false,
      success: function(data) {
        for (i in data) {
          schoolArray.push( data[i].name );
          schoolIdArray.push( data[i].school_id );
        }
        //console.log(schoolIdArray);
      }
  });
  $(schoolSelector).typeahead( {
    source: function() { return schoolArray; }, 
    minLength: 2,
    items: 12
  });
  //console.log('typeahead initialized');
}

</script>