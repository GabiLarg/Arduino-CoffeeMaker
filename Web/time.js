function time(){
	
	time = "<p>in</p>"+
		"<form method='post' action='coffee.php' autocomplete = 'on'>"+
		"<label for='txtList'>Hours:</label>"+
            	  "<select name='hour' id='Hour'>";
		for(var i = 0; i<25;i++){
			var num = i;
			time +="<option value = "+num+">";
			if(i<10){
				time+="0";
			}
			time+=i+"</option>";
		}
               		
				time+="</select>"+
		"<label for='txtList'>:Minutes</label>"+
            	  "<select name='minu' id='Minutes'>";
			for(var i = 0; i<60;i++){
			var num = i;
			time +="<option value = "+num+">";
			if(i<10){
				time+="0";
			}
			time+=i+"</option>";
		}
			
				time+="</select>"+
		"<label for='txtList'>:Seconds</label>"+
            	  "<select name='sec' id='Seconds'>";
			for(var i = 0; i<60;i++){
			var num = i;
			time +="<option value = "+num+">";
			if(i<10){
				time+="0";
			}
			time+=i+"</option>";
		}
				time+="</select>"+
		"<input class= 'button' type='submit' name='rcmd' value='Submit'>"+
            	"<input class='button' type='reset' value='Clear'>"+
		"</form>";
	document.getElementById("time").innerHTML = time;

	//  End -->
}
