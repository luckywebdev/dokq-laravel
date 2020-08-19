$(document).ready(function(){
	
	setInterval(function(){

		if($("select[name=type]").val()==2){
			
			$("input[name=total_chars]").attr("readonly", null);
//			if ($("input[name=total_chars]").val() == ""){
//				$(".point").html("0");
//				$("#point").val("0");
//			}
//			else {
			$(".param").attr("readonly", true);
			if ($("input[name=total_chars]").val() != ""){
				var total_chars = Number($("input[name=total_chars]").val());
				var point1 = total_chars * recommend * (0.0001 + 0.0001 * 0.05);
				
				$(".point").html(Math.round(point1*100)/100);
				$("#point").val(Math.round(point1*100)/100);

			}
//			
//			$(".calc").each(function(index, item){
//				if($(item).val() == ""){
//					$(item).val("0");
//				}
//			})
			
			
		}else{
			$(".param").attr("readonly", null);
			$("input[name=total_chars]").attr("readonly", "true");
			if(checkFieldFilled()){
				
				var A = Number($("input[name=entire_blanks]").val()) + Number($("input[name=quarter_filled]").val())*0.75 + Number($("input[name=half_blanks]").val())*0.5
				 + Number($("input[name=quarter_blanks]").val())*0.25;
				var B = (Number($("input[name=p30]").val())+Number($("input[name=p50]").val())+Number($("input[name=p70]").val())+Number($("input[name=p90]").val())+Number($("input[name=p110]").val()))/Number($("input[name=max_rows]").val());
					B = B/5;
				var C = 1-B
				var D = Number($("input[name=max_rows]").val())*Number($("input[name=max_chars]").val())*C*(Number($("input[name=pages]").val())-A)
				
				if (D > 0) D = D; 
				else D = 0; // D: NaN
				var point = recommend*D*0.0001;
				point = Math.round(point*100)/100;
				$(".point").html(point)
				$("#point").val(point);
				$("input[name=total_chars]").val(Math.round(D));
				$("input[name=total_chars]").html(Math.round(D));
			}
			else {
				
			}
		}
	},500)
	
	var checkFieldFilled = function(){
		var calcInputs = $(".param");
		for(i = 0; i < calcInputs.length; i++){
			var calcInput = $(calcInputs[i]);
			if(calcInput.val() == ""){
				return false;
			}
		}
		return true;
	}
})