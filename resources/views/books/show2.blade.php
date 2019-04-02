@extends('layouts.app')

@section('content')

<header>
    <h1 style="display: inline-block;">Books</h1>      
</header>
<hr>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
</script>


@if(isset($id))
<script>
		//getting book by ID
         $(document).ready(function(){
         	// console.log("Getting book by ID");
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                  }
              });
               $.ajax({
                  url: "{{ url('/api/books/'.$id) }}", // return JSON book
                  method: 'GET',
                  data: {
               
                  },
                  success: function(result){
                  	// console.log(result);
                  	value = result;
                  	$('#beforeAuthors').append("<h1>" + value['name'] + "</h1>" + 
				    "<hr>" + 
				    "<article>" + 
				        "<h2> Publisher: " + value['publisher'] + ", " + value['publication_year'] + "</h2>" + 


				        "<h2> Author(s): ");

	                  	$.ajax({
	                  		url: "{{ url('/api/books/findauthors/')}}" + "/" + value['id'],// get the authors (JSON) of the book
	                  		method: 'GET',
	                  		data: {

	                  		},
	                  		success: function(authors_result)
	                  		{
	                  			// console.log(result);
	                  			var namearray = [];
	                  			$.each(authors_result, function(index, value) {
	                  				namearray.push(value['name']);
	                  			})
	                  			var string = namearray.join();
	                  			$('#authors').append("<h3>" + string + "</h3>");
	                  		}
	                  	});

				        	// value['book_authors'].join() + 
				            // implode(', ', $book_authors) + 

				        $('#afterAuthors').append("</h2>" + 

				        "<h4> ISBN: " + value['ISBN'] + "</h4>" + 

				        "<br>" + 
				          "<a href='" + value['id'] + "/image'>" + 
				            "<img src='" + value['image'] + "' alt='book img'  width='20%'>" + 
				          "</a>" + 
				        "<hr>");
                  }});
  				});
</script>

@else
<script>
	//getting book by ISBN
         $(document).ready(function(){
         	console.log("Getting Book by ISBN");
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                  }
              });
               $.ajax({
                  url: "{{ url('/api/books/isbn/'.$isbn) }}", // returns a book JSON
                  method: 'GET',
                  data: {
               
                  },
                  success: function(result){
                  	// console.log(result);
                  	value = result['data'];
                  	console.log(value);
                  	$('#beforeAuthors').append("<h1>" + value['name'] + "</h1>" + 
				    "<hr>" + 
				    "<article>" + 
				        "<h2> Publisher: " + value['publisher'] + ", " + value['publication_year'] + "</h2>" + 


				        "<h2> Author(s): ");

	                  	$.ajax({
	                  		url: "{{ url('/api/books/findauthors/')}}" + "/" + value['id'], // get the authors (JSON) of the book
	                  		method: 'GET',
	                  		data: {

	                  		},
	                  		success: function(authors_result)
	                  		{
	                  			// console.log(result);
	                  			var namearray = [];
	                  			$.each(authors_result, function(index, value) {
	                  				namearray.push(value['name']);
	                  			})
	                  			var string = namearray.join();
	                  			$('#authors').append("<h3>" + string + "</h3>");
	                  		}
	                  	});

				        	// value['book_authors'].join() + 
				            // implode(', ', $book_authors) + 

				        $('#afterAuthors').append("</h2>" + 

				        "<h4> ISBN: " + value['ISBN'] + "</h4>" + 

				        "<br>" + 
				          "<a href='" + value['id'] + "/image'>" + 
				            "<img src='" + value['image'] + "' alt='book img'  width='20%'>" + 
				          "</a>" + 
				        "<hr>");
                  }});
  				});
</script>
@endif



<div id="bookInfo">
	<div id="beforeAuthors">
	</div>

	<div id="authors">
	</div>

	<div id="afterAuthors">
	</div>
</div>
@endsection