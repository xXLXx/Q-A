$(function(){
	var converter1 = Markdown.getSanitizingConverter();
    var editor1 = new Markdown.Editor(converter1);
    editor1.run();

    var newTags = {};
    var tagsCtr = 0;
    $("#select2").select2({
    	placeholder : "Input tags associated with your question here.",
    	tags: [],
  		tokenSeparators: [",", " "],
    	minimumInputLength: 1,
    	ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
	        url: BASE_PATH + "/questions/get-tags",
	        dataType: 'json',
	        data: function (term, page) {
	            return {
	                q: term, // search term
	            };
	        },
	        results: function (data, page) { // parse the results into the format expected by Select2.
	            // since we are using custom formatting functions we do not need to alter remote JSON data
	            var names = {results: []};
	            for(var key in data){
	            	var text = data[key].name.toLowerCase();
	            	var id = data[key].id;
	            	// if(data[key].id == 0){
	            	// 	if((id = newTags[text]) == null){
	            	// 		id = --tagsCtr;
	            	// 		newTags[text] = id;
	            	// 	}
	            	// 	else if($("#select2").val().split(',').indexOf(id.toString()) != -1){
	            	// 		continue;
	            	// 	}
	            	// }
	            	names.results.push({'id' : (id + ':' + text), 'text' : text});
	            }

	            return names;
	        }
	    },
	    // initSelection: function(element, callback) {
	    // 	console.log(element);
	    //     // the input tag has a value attribute preloaded that points to a preselected movie's id
	    //     // this function resolves that id attribute to an object that select2 can render
	    //     // using its formatResult renderer - that way the movie name is shown preselected
     //        $.ajax(BASE_PATH + "/questions/get-tags", {
     //            data: {
     //                q: $(element).val()
     //            },
     //            dataType: "json"
     //        }).done(function(data) {
     //        	console.log(data);
     //        	callback(data);
     //        });
	    // },
    });
    $(".select2-choices").addClass("form-control");
    $(".select2-container").css("width", "100%");
});