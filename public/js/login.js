$(document).ready(function(){
	var rows = 0
	var infors = []
	var total_counts = 0
	$("#add_class").click(function(){
	/*	if ( $("#type").val() == '') {
			$("#type").focus();
			return;
		}	
		if ( $("#member_counts").val() == 0 ){
			$("#member_counts").focus();
			return;
		}
		rows +=1;
		var info = {
			type: $("#type").val(),
			classname : $("#classname").val(),
			member_counts : $("#member_counts").val(),
			key: rows
		}
		total_counts += Number($("#member_counts").val());
		total_fee = total_counts * 1200;
		infors.push(info)
		var class_info = JSON.stringify(infors);
		$("#inform").val(class_info)
		
		var appendstring = "<tr>";
		appendstring += "<td>" + $("#type option:selected").html() + "</td>";
		appendstring += "<td>" + $("#classname").val() + "</td>";
		appendstring += "<td>" + $("#member_counts").val() + "</td>";
		// appendstring += "<td>" + '<button type="button"　data-id=' + rows + '   class="btn del_btn btn-xs btn-danger">削除</button>' + "</td>";
		appendstring += "</tr>"
		$("#class_table").removeClass('display-hide')
		$("#total_counts").html(total_counts)
		$("#total_fees").html(total_fee)
		$("#class_table tbody").append($(appendstring))*/

		$('#div-add').before(
			'<div class="form-group row">'
				+'<label class="control-label col-md-1 text-md-right">会員種別:</label>'
				+'<div class="col-md-2">'
				+	'<select class="bs-select form-control" name="type" id="type">'
				+		$('#type').html()
				+	'</select>'
				+'</div>'

				+'<label class="control-label col-md-1 text-md-right">クラス:</label>'
				+'<div class="col-md-2">'
				+	'<div class="col-md-8">'
				+		'<input type="text" name="classname" id="classname" class="form-control">'
				+	'</div>'
				+	'<label class="control-label text-md-left label-after-input">学級(半角)</label>'
				+	'<span class="help-block">'
				+		'<span>クラスが無い場合は空欄</span>'
				+	'</span>'
				+'</div>'

				+'<label class="control-label col-md-1 text-md-right">人数:</label>'
				+'<div class="col-md-1">'
				+	'<div id="counts">'
				+		'<div class="input-group">'
				+			'<input type="text" id="member_counts" name="member_counts" class="spinner-input form-control" maxlength="3" value="0">'
				+			'<div class="spinner-buttons input-group-btn btn-group-vertical">'
				+				'<button type="button" class="btn spinner-up btn-xs blue">'
				+				'<i class="fa fa-angle-up"></i>'
				+				'</button>'
				+				'<button type="button" class="btn spinner-down btn-xs blue">'
				+				'<i class="fa fa-angle-down"></i>'
				+				'</button>'
				+			'</div>'
				+		'</div>'
				+	'</div>'
				+'</div>'
				+'<label class="control-label text-md-left label-after-input">名(半角)</label>');
		$('.bs-select').selectpicker({
	            iconBase: 'fa',
	            tickIcon: 'fa-check'
        });
        handleSpinners();
	})
	$(document).on('click','.del_btn', function(){
		//console.log($(this).data('id'))
	} )
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	
})