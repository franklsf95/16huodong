/*
后台公共Javascript函数

*/

var alert_delete_affirm = "确认删除？";
var alert_delete_success = "删除成功";
var alert_delete_faild = "删除失败";


function checkAll( n, fldName ) {
	if (!fldName) {
		fldName = 'cb';
	}
	var f = document.adminForm;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxchecked.value = n2;
	} else {
		document.adminForm.boxchecked.value = 0;
	}
}


function isChecked(isitchecked){
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
	} else {
		document.adminForm.boxchecked.value--;
	}
}


function applyFormAction(){
	var f = document.adminForm;
	var task = f.task.value;
	
	if (task == 'remove') {
		var filds = decodeURI($("#adminForm").formSerialize());
		$.ajax({
			url:f.action+"/remove",
			data:filds,
			type:"GET",
			dataType:"json",
			success:function(data){
				if (data.result == 'Y') {
					alert(alert_delete_success);
				} else {
					alert(alert_delete_faild);
				}
				location.reload();
			}
		});
	} else if (task == "edit") {
		alert('蒜头');
	}
}

function removeRecordById(id){
	var f = document.adminForm;
	if(confirm(alert_delete_affirm)){
		$.ajax({
			url:f.action+"/remove",
			data:"cid[]="+id,
			type:"GET",
			dataType:"json",
			success:function(data){
				if (data.result == 'Y') {
					alert(alert_delete_success);
				} else {
					alert(alert_delete_faild);
				}
				location.reload();
			}
		});
	}
}