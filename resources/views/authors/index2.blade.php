@extends('layouts.app')

@section('content')
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
</script>

<h1>Authors</h1>
<hr>

<!-- show messages like: Author sucessfully deleted -->
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif


<script>
         $(document).ready(function(){
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                  }
              });
               $.ajax({
                  url: "{{ url('/api/authors') }}",
                  method: 'GET',
                  data: {
               
                  },
                  success: function(result){

					    $.each(result['data'], function (index, value) {
					    	console.log(value);
					        $("#AuthorList").append (
					        	"<h4>" + value['name'] + "</h4>" +
					        	"<h5>ID: " + value['id'] + "</h5>" + 
					        	"<h5>Created: " + value['created_at'] + "</h5>" + 
					        	"<hr>"
					       );
					});
                  }});
            });
</script>


<div id="AuthorList">
</div>


@endsection