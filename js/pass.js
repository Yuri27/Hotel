$(document).ready(function () {
	
	$("#pass").keyup(function() {
	
		var pass = $("#pass").val();
		$("#result").text(check(pass));
	
	});
	
	function check(pass) {
		var protect = 0;
		
		if(pass.length < 8) {
			$("#bg_res").removeClass();
			$("#bg_res").addClass('red');
			return "Слабый";
		}
		
		//a,s,d,f
		var small = "([a-z]+)";
		if(pass.match(small)) {
			protect++;
		}
		
		//A,B,C,D
		var big = "([A-Z]+)";
		if(pass.match(big)) {
			protect++;
		}
		//1,2,3,4,5 ... 0
		var numb = "([0-9]+)";
		if(pass.match(numb)) {
			protect++;
		}
		//!@#$
		if(pass.match(/\W/)) {
			protect++;
		}
		
		if(protect == 2) {
			$("#bg_res").removeClass();
			$("#bg_res").addClass('yellow');
			return "Средний";
		}
		if(protect == 3) {
			$("#bg_res").removeClass();
			$("#bg_res").addClass('green');
			return "Хороший";
		}
		if(protect == 4) {
			$("#bg_res").removeClass();
			$("#bg_res").addClass('green_v');
			return "Высокий";
		}
	}

});