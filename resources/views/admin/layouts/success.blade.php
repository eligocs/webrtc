@if ($message = Session::get('success')) 
    <div class="alert alert-success success"> 
        <p>{{ $message }}</p> 
    </div> 
@endif 