
window.Ruby = function(ctx){

	var width = ctx.canvas.width;
	var height = ctx.canvas.height;


	//High pixel density displays - multiply the size of the canvas height/width by the device pixel ratio, then scale.
	/*if (window.devicePixelRatio) {
		ctx.canvas.style.width = width + "px";
		ctx.canvas.style.height = height + "px";
		ctx.canvas.height = height * window.devicePixelRatio;
		ctx.canvas.width = width * window.devicePixelRatio;
		ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
	}
*/
	this.drawText = function(data, direction = 'vertical', font_family = 'Arial',font_size = 16, u_color = '#0000ff', sentence_gap = 20, ){
		var gap = 20;
		var ruby = font_size - 4;
		var p_gap = 5;
		var main_x_pos = gap, main_y_pos = gap;
		var ruby_x_pos = 0, ruby_y_pos = 0;
		var line_x_pos = 0, line_y_pos = 0;
		var f_line = false, f_ruby = false;
		var str_len = 1;
		var max_len = 1;
		var flag = false;
		for(var i = 0; i < data.length; i++){
			str_len = 1;
			for(var p = 0; p < data[i].length; p++){
				if(flag || data[i][p] == "#" || data[i][p] == "%")
					str_len++;
				if(data[i][p] == "*")
					if(flag)
						flag = false;
					else
						flag = true;
			}
			str_len = data[i].length - str_len;
			max_len = max_len < str_len?str_len:max_len;
		}
		ctx.canvas.height = font_size * max_len>height?font_size * max_len:height;
		ctx.canvas.width = (font_size + ruby + p_gap * 2 + sentence_gap) * data.length + gap>width?(font_size + ruby + p_gap * 2 + sentence_gap) * data.length + gap:width;
		if(direction == "vertical"){
			//ctx.translate(ctx.canvas.width, 0);
			for(var p = 0; p < data.length; p++){
				main_y_pos = gap;
				ruby_x_pos = 0; ruby_y_pos = 0;
				line_x_pos = 0; line_y_pos = 0;
				f_line = false, f_ruby = false;
				for(var i = 0; i < data[p].length; i++){
					if(data[p][i] == "#"){
						if(f_line){
							f_line = false;
						}else{
							var temp_flag = false;
							for(var j = i + 1; j < data[p].length; j++){
								if(data[p][j] == '#'){
									temp_flag = false;
									break;
								}
								if(data[p][j] == '*')
								{
									temp_flag = true;
									break;
								}
							}
							if(!temp_flag){
								line_x_pos = main_x_pos;
								line_y_pos = main_y_pos;
							}else{
								line_x_pos = main_x_pos + p_gap + p_gap + ruby;
								line_y_pos = main_y_pos;
							}
							
							f_line = true;
						}
					}else if(data[p][i] == "%"){
							ruby_x_pos = main_x_pos + font_size + p_gap;
							ruby_y_pos = main_y_pos + font_size;
					}else if(data[p][i] == "*"){
						if(f_ruby)
							f_ruby = false;
						else
							f_ruby = true;
					}else{
						if(f_line){
							ctx.save();
							ctx.strokeStyle = "#0000ff";
							ctx.translate(line_x_pos, line_y_pos);
							ctx.moveTo(0, 0);
							ctx.lineTo(0, font_size);
							ctx.stroke();
							line_y_pos+=font_size;
							ctx.restore();
						}
						if(f_ruby){
							ctx.save();
							ctx.font = ruby + "px Arial";
							ctx.translate(ruby_x_pos, ruby_y_pos);
							ctx.fillText(data[p][i], 0, 0);
							ruby_y_pos += ruby;
							ctx.restore();
							if(f_line){
								ctx.save();
								line_y_pos = ruby_y_pos;
								ctx.strokeStyle = "#0000ff";
								ctx.translate(line_x_pos, line_y_pos);
								ctx.moveTo(0, 0);
								ctx.lineTo(0, ruby);
								ctx.stroke();
								ctx.restore();
							}
						}else{
							ctx.save();
							ctx.font = font_size + "px Arial";
							main_y_pos +=font_size;
							if(main_y_pos < ruby_y_pos)
								main_y_pos = ruby_y_pos;
							ctx.translate(main_x_pos, main_y_pos);
							ctx.fillText(data[p][i], 0, 0);
							ctx.restore();
						}
					}
				}
				main_x_pos += (font_size + ruby + 2 * p_gap + sentence_gap);
			}
		}else{
			main_y_pos = gap;
			for(var p = 0; p < data.length; p++){
				main_x_pos = gap;
				ruby_x_pos = 0; ruby_y_pos = 0;
				line_x_pos = 0; line_y_pos = 0;
				f_line = false, f_ruby = false;
				for(var i = 0; i < data[p].length; i++){
					if(data[p][i] == "#"){
						if(f_line){
							f_line = false;
						}else{
							line_y_pos = main_y_pos + font_size + ruby + p_gap;
							line_x_pos = main_x_pos + font_size;
							f_line = true;
						}
					}else if(data[p][i] == "%"){
							ruby_y_pos = main_y_pos + font_size + p_gap;
							ruby_x_pos = main_x_pos + font_size;
					}else if(data[p][i] == "*"){
						if(f_ruby)
							f_ruby = false;
						else
							f_ruby = true;
					}else{
						if(f_line){
							ctx.save();
							ctx.strokeStyle = "%0000ff";
							ctx.translate(line_x_pos, line_y_pos);
							ctx.moveTo(0, 0);
							ctx.lineTo(font_size, 0);
							ctx.stroke();
							line_x_pos+=font_size;
							ctx.restore();
						}
						if(f_ruby){
							ctx.save();
							ctx.font = ruby + "px Arial";
							ctx.translate(ruby_x_pos, ruby_y_pos);
							ctx.fillText(data[p][i], 0, 0);
							ruby_x_pos += ruby;
							ctx.restore();
							if(f_line){
								ctx.save();
								line_x_pos = ruby_x_pos;
								ctx.strokeStyle = "%0000ff";
								ctx.translate(line_x_pos, line_y_pos);
								ctx.moveTo(0, 0);
								ctx.lineTo(ruby, 0);
								ctx.stroke();
								ctx.restore();
							}
						}else{
							ctx.save();
							ctx.font = font_size + "px Arial";
							main_x_pos +=font_size;
							if(main_x_pos < ruby_x_pos)
								main_x_pos = ruby_x_pos;
							ctx.translate(main_x_pos, main_y_pos);
							ctx.fillText(data[p][i], 0, 0);
							ctx.restore();
						}
					}
				}
				main_y_pos += (font_size + ruby + 2 * p_gap + sentence_gap);
			}
		}
	}
	
}


