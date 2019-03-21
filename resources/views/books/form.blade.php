
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('ISBN', 'ISBN:') !!}
    @if($editFlag=='true') 
        {!! Form::text('ISBN', null, ['class'=>'form-control', 'readonly']) !!}
    @else
        {!! Form::text('ISBN', null, ['class'=>'form-control']) !!}
    @endif
</div>

<div class="form-group">
    {!! Form::label('author', 'Author(s):') !!}
    @if($editFlag=='true') 
        {!! Form::text('author', $authString, ['class'=>'form-control', 'placeholder' => 'seperate authors by a comma and a space (Mark Fitzjerald, John Green)']) !!}
    @else
        {!! Form::text('author', null, ['class'=>'form-control', 'placeholder' => 'seperate authors by a comma and space (Mark Fitzjerald, John Green)']) !!}
    @endif  
</div>


<div class="form-group">
    {!! Form::label('publisher', 'Publisher:') !!}
    {!! Form::text('publisher', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('publication_year', 'Publication Year:') !!}
    {!! Form::text('publication_year', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary form-control']) !!}
</div> 