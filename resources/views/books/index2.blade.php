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


    
<script>
         $(document).ready(function(){
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                  }
              });
               $.ajax({
                  url: "{{ url('/api/books') }}", // get JSON list of books
                  method: 'GET',
                  data: {
               
                  },
                  success: function(result){

					    $.each(result['data'], function (index, value) {
					    	// console.log(value);
					        $("#books").append (
					       " <div class='row'>" + 
							"<div class='col-md-1'>" + 
							 "  <img src="+ value['image']+" alt='book img' class='img-fluid'>" + 
							 "   </div>" + 
							 "   <div class='col-md-10'>" + 
							 "       <h2> "  + 
							 " <a href='/books/"+value['id']+"'>" + 
								 value['name'] + 
							  "          </a>" + 
							 "       </h2> " + 
							 value['publisher']+", "+value['publication_year'] +
							  "  </div> " + 
							"</div>"+ 


							"<hr>");
					});
                  }});
            });
</script>

<div id="books">
</div>
@endsection