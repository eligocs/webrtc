@extends('admin.layouts.app')
@section('page_heading', 'Add new class')
@section('content')
  <!-- Start Content-->
  <div class="container-fluid">
    <div>{{ Breadcrumbs::render('add-new-class', request()->id) }}</div>
    <div class="row">
      <div class="col-md-6">
        <div class="card-box">
          <form role="form" action="{{ route('admin.manage-institutes.get-new-class-data') }}" method="post">
            <input type="hidden" name="id" value="{{ $id ?? '' }}" />
            <input type="hidden" name="lastId" value="{{ $edit->id ?? '' }}" />
            @csrf 
            <div class="form-group">
              <label>Select Category</label>
     
              <select class="form-control" id="category" name="category" required>
                @if (count($categories) > 0)
                  <option value="">select</option>
                  @foreach ($categories as $category)
                    <option  @php if(!empty($edit->category_id) && ($edit->category_id == $category->id)){ echo "selected"; } @endphp value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label>Name of the class</label>
              <div class="input-group">
                <input type="text" name="name" class="form-control" value="{{ !empty($edit->name) ? $edit->name : '' }}" placeholder="Enter class name" id=""
                  autocomplete="off" required>
              </div>
              <!-- input-group -->
            </div>
            <div class="form-group">
              <label>Mention Start Date</label>
              <div class="input-group">
                <input type="text" name="start_date" value="{{ !empty($edit->start_date) ? date('m/d/Y',strtotime($edit->start_date))  :'' }}" class="form-control" placeholder="mm/dd/yyyy"
                  id="datepicker-autoclose" autocomplete="off" required>
              </div>
              <!-- input-group -->
            </div>
            <div class="form-group">
              <label>Mention End Date</label>
              <div class="input-group">
                <input type="text" name="end_date" value="{{!empty($edit->end_date) ? date('m/d/Y',strtotime($edit->end_date)) : '' }}" class="form-control" autocomplete="off" id="datepicker"
                  placeholder="mm/dd/yyyy" required>
              </div>
              <!-- input-group -->
            </div>
            <div class="form-group">
              <label for="price">Mention Price</label>
              <input type="text" class="form-control" value="{{ $edit->price ?? '' }}" data-parsley-type="digits" id="price" name="price" required>
            </div>
            <div class="form-group">
              <label for="price">State</label>
              <input type="text" class="form-control" value="{{ $edit->state ?? '' }}" id="state" name="state" required>
            </div>
            <div class="form-group">
              <label for="price">City</label>
              <input type="text" class="form-control" value="{{ $edit->city ?? '' }}" id="city" name="city" required>
            </div>
            <div class="form-group">
              <label for="price">Board</label>
              <input type="text" class="form-control"  value="{{ $edit->board ?? '' }}" id="board" name="board" required>
            </div>
            <div class="form-group">
              <label>Add subjects <i class="fa fa-plus-circle" data-toggle="modal"
                  data-target="#exampleModal"></i></label>
              <select class="select2" id="subjects" name="subjects[]"  multiple="multiple" required>
                {{--
                <optgroup>
                  --}}
                  {{-- @foreach (\App\Models\Subject::all() as $element)
                    <option value="{{ $element->name }}">{{ $element->name }}</option>
                  @endforeach --}}
                  {{--
                </optgroup>
                --}}
              </select>
            </div>
            <div class="form-group">
              <label>Mention Language <i class="fa fa-plus-circle" data-toggle="modal"
                  data-target="#languageModal"></i></label>
              <select class="form-control select2" id="languages" name="language" required>
                {{-- <option value="hindi">English</option>
                <option value="english">Hindi</option> --}}
              </select>
            </div>
            <div class=" text-center">
              {{-- <button type="submit" class="btn btn-theme"><a
                  href="select-days.html">Save</a></button> --}}
              <button type="submit" class="btn btn-theme waves-effect waves-light m-l-10">
                Next
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Subject Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          {{--
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addSubject" action="{{ route('admin.subjects.addSubject') }}" method="post">
          <div class="modal-body">
            @csrf
            <input type="text" name="name" class="form-control" value="" placeholder="Add subject" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submiti" class="btn btn-primary">Save Subject</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- language modal --}}
  <div class="modal fade" id="languageModal" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          {{--
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addLanguage" action="{{ route('admin.languages.addLanguage') }}" method="post">
          <div class="modal-body">
            @csrf
            <input type="text" name="name" class="form-control" value="" placeholder="Add Language" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submiti" class="btn btn-primary">Save Language</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- container -->
  <input type="hidden" id="getSubjectsByCatUrl" value="{{ route('getSubjectsByCat') }}" />

@endsection
@section('js')
  <script>
    $(document).ready(function() {
     

      $('#addSubject').submit(function(e) {
        e.preventDefault();

        $.ajax({
          url: "{{ route('admin.subjects.addSubject') }}",
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(res) {
            if (res.status == 'Success') alert('subject added');
            else alert(res.error[0]);
            $('#addSubject').trigger('reset');
            $('#exampleModal').modal('hide');
          }
        })
      })
      $('#addLanguage').submit(function(e) {
        e.preventDefault();

        $.ajax({
          url: "{{ route('admin.languages.addLanguage') }}",
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(res) {
            if (res.status == 'Success') alert('language added');
            else alert(res.error[0]);
            $('#addLanguage').trigger('reset');
            $('#languageModal').modal('hide');
          }
        })
      })
      //  $('#category').change(function(){ 
      //      let getSubjectsByCatUrl = $('#getSubjectsByCatUrl').val();
      //      let id = $(this).val();  
      //      $.ajax({            
      //          type:'POST',
      //          url:getSubjectsByCatUrl,
      //          data:{
      //              "_token": "{{ csrf_token() }}",
      //              id:id
      //          },
      //          success:function(return_data) { 
      //              if(return_data.status == 'Success'){
      //                  $("#subjects").html(return_data.html); 
      //              }
      //              else
      //              {
      //                  $('#subjects').html(''); 
      //              }
      //              $("#subjects").trigger("chosen:updated");
      //              $("#subjects").trigger("liszt:updated");
      //          }
      //      });
      //  });

      $('#subjects').select2({
        ajax: {
          url: "{{ route('admin.subjects.getSubjects') }}",
          type: 'get',
          dataType: 'json',
          data: function(params) {
            return {
              q: $.trim(params.term)
            };
          },
          processResults: function(data) {
            return {
              results: data
            }; 
          },
          cache: true, 
        }
      });  

  
     
     

      $('#languages').select2({
        ajax: {
          url: "{{ route('admin.languages.getLanguages') }}",
          type: 'get',
          dataType: 'json',
          data: function(params) {
            return {
              q: $.trim(params.term)
            };
          },
          processResults: function(data) {
            return {
              results: data
            };
          },
          cache: true,
          // cache: true
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
      })


      var data_id = "{{!empty($edit->id) ? ($edit->id) : ''}}";
        if(data_id){
          $.ajax({
              url: "{{ route('admin.manage-institutes.getClass') }}",
              method: "post",
              dataType: "json",
              data: {
                _token: "{{ csrf_token() }}",
                data_id: data_id,
              },
            success: function(response){
              var $options = '';
              var $options2 = '';
              if(response.options){
                var opt = response.options;
                var Alloptions1 = response.Alloptions1;
                for(var i=0;i<opt.length;i++){  
                   $options = $("<option selected></option>").val(opt[i].id).text(opt[i].text);
                   $('#subjects').append($options).trigger('change'); 
                }
                 if(Alloptions1){
                   $options2 = $("<option selected></option>").val(Alloptions1[0].id).text(Alloptions1[0].text);
                   $('#languages').append($options2).trigger('change');  
                 }
              } 
            }
          });
        } 
         


      // var select2 = $('#subjects').select2({
      //   tags: true,
      //   // insertTag: function(data, tag){
      //   //   console.log(tag);


      //   // tag.text = tag.text + "(new)";
      //   // data.push(tag);
      //   // },
      // }).on('select2:select', function(){
      //   alert('ss');
      //   if($(this).find("option:selected").data("select2-tag")==true) {
      //     // $.ajax({
      //     //   url: "{{ route('admin.subjects.store', request()->id) }}",
      //     //   method: "post",
      //     //   dataType: "json",
      //     //   data: {
      //     //     _token: "{{ csrf_token() }}",
      //     //     name: $(this).find("option:selected").val(),
      //     //   },
      //     //   success: function(response){
      //     //     // alert(response.status);
      //     //     if(response.status){
      //     //     $(this).find("option:selected").val(response.data.id);
      //     //     $(this).find("option:selected").text(response.data.name);
      //     //     }
      //     //   }
      //     // })
      //   }
      // });
    });

  </script>
@endsection
