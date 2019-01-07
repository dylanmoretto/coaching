$( "#test" ).click(function() {
	var newDiet = $("#newDiet").is(':checked');
	$.ajax({
		type: "GET",
		url: "getListDiet/" + $("#client").val() + "/" + newDiet,
		//url: "getDiet",
		//data: data,
		success : function(data){
	  		$("#result").html(data);
		}
	});
});


$( "#contenu" ).on("click", ".addDiet", function() {
	var id = $(this).attr("i");
	var qte = $(".qte" + id).val();
	var select = $('#selectRepas option:selected').val();
	$.ajax({
		type: "GET",
		url: "addDiet/" + id + "/" + qte + "/" + select ,
		//url: "getDiet",
		//data: data,
		success : function(data){
	  		$("#contenu").html(data);
		}
	});  
	// IMPORTANT !!! empeche le double envoi jquery
	e.preventDefault();	
});


$( "#contenu" ).on("click", ".delDietItem", function() {
	var id = $(this).attr("id");
	$.ajax({
		type: "GET",
		url: "delDietItem/" + id  ,
		//url: "getDiet",
		//data: data,
		success : function(data){
	  		$("#contenu").html(data);
		}
	});  
	// IMPORTANT !!! empeche le double envoi jquery
	e.preventDefault();	
});


$( ".selector" ).on("click", ".selectDiet", function() {
	var id = $(this).attr("i");
	$.ajax({
		type: "GET",
		url: "getDiet/" + id  ,
		//url: "getDiet",
		//data: data,
		success : function(data){
	  		$("#contenu").html(data);
		}
	});
});


$( "#contenu" ).on("click", ".delDiet", function(e) {
	var idDiet = $(this).attr("id");
	var idClient = $(this).attr('idClient');
	
	$.ajax({
		type: "GET",
		url: "delDiet/" + idDiet + "/" + idClient,
		//url: "getDiet",
		//data: data,
		success : function(data){
	  		$("#contenu").html(data);
		}
	});  
	// IMPORTANT !!! empeche le double envoi jquery
	e.preventDefault();	
});