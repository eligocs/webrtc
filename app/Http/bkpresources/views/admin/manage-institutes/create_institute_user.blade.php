@extends('admin.layouts.app')
@section('page_heading', 'Manage Institute User')
@push('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<style>
    [type=search] {
        height: 38px;
        width: 220px;
        padding-left: 20px;
        padding-right: 0;
        color: #323a46;
        background-color: #ffffff;
        box-shadow: none;
        border: 1px solid #644699;
        border-radius: 9px !important;
        outline: none;
    }



    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }

    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay {
        position: absolute;
        /* child */
        top: 50%;
        left: 50%;
        margin-left: -39px;
        /* half of width*/
        margin-top: -39px;
        /* half of height */
        width: 100%;
        height: 100vh;
        background: #ececec;
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }

    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #63c22d #286e2e00 #b2d7e1 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@section('content')
<!-- Start content -->
<style>
    .manage_search i {
        position: absolute;
        right: 7px;
        top: 12px;
        color: #000000;
    }

    .manage_search input {
        padding-right: 20px;
    }
</style>
<div class="content">
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box position-relative">
                        <h3 class="heading-title m-0 text-center heading">Add User</h3>
                        <button class="btn-theme btn-style add_lecture-btn" data-toggle="modal"
                            data-target="#userCreate">Add User</button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('message'))
                            <div class="alert alert-success">{{ session()->get('message') }}</div>
                            @endif
                            <div id="loader" class="lds-dual-ring hidden  overlay"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 package-table" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h4 class="header-title m-0 heading">Sr. No.</h4>
                                            </th>
                                            <th>
                                                <h4 class="header-title m-0 heading">User Name</h4>
                                            </th>
                                            <th>
                                                <h4 class="header-title m-0 heading">User Phone Number</h4>
                                            </th>
                                            <th>
                                                <h4 class="header-title m-0 heading">User Id</h4>
                                            </th>
                                            <th>
                                                <h4 class="header-title m-0 heading">Subject</h4>
                                            </th>
                                            <th>
                                                <h4 class="header-title m-0 heading">Action</h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($users_institute)> 0)
                                        @foreach($users_institute as $key=> $user)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->subjects}}</td>
                                            <td class="py-2">
                                                <button type="submit" data-id="{{ $user->id }}" data-toggle="modal"
                                                    class="btn-theme btn-style edit-zoom-user editUser">
                                                    Edit </button>
                                                &nbsp;<button type="submit" data-id="{{ $user->id }}"
                                                    class="btn btn-danger btn-style delete">
                                                    Delete </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!---row end-->
        </div> <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div><!-- content -->

<!-----add user model------------------------------------>
<div class="modal fade" id="userCreate" tabindex="-1" role="dialog" aria-labelledby="lectureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModalLabel"> Create Institute User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add_loader" class="lds-dual-ring hidden  overlay"></div>
            <div class="modal-body">
                <div class="card-box">
                    <form role="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name <span style="color:red">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="userId">Teacher Id <span style="color:red">*</span></label>
                            <input type="text" name="userId" class="form-control" id="userId"
                                value="{{ old('userId') }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label><span style="color:red">*</span></label>
                            <input type="number" name="phone" class="form-control" id="phone"
                                value="{{ old('phone') }}">
                            <span id="numErr" style =color:red;>**Enter a 10 digit number</span>
                        </div>
                        <div class="form-group">
                            <label for="subjects">Subject</label> <span style="color:red">*</span></label>
                            <input type="text" name="subjects" class="form-control" id="subjects"
                                value="{{ old('subjects') }}">
                        </div>
                        <input type="hidden" id="id" value='{{ $institute->id }}' name="user_id">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-theme" id="create_user">Create user</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!------edit model--------------------->
<div class="modal fade editUserForm" id="editUserForm" tabindex="-1" role="dialog" aria-labelledby="lectureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModalLabel"> Edit Institute User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add_loader" class="lds-dual-ring hidden  overlay"></div>
            <div class="modal-body">
                <div class="card-box">
                    <form>
                        @csrf
                        <div class="form-group">
                            <label for="name">Name <span style="color:red">*</span></label>
                            <input type="text" value="" name="name" class="form-control" id="nameUser">
                        </div>
                        <div class="form-group">
                            <label for="userId">User Id <span style="color:red">*</span></label>
                            <input type="text" name="userId" class="form-control" value="" id="userid">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label><span style="color:red">*</span></label>
                            <input type="number" name="phone" class="form-control" value="" id="phoneUser">
                            <span id="numErrr" style =color:red;>**Enter a 10 digit number</span>
                        </div>
                        <div class="form-group">
                            <label for="subjects">Subject</label> <span style="color:red">*</span></label>
                            <input type="text" name="subjects" class="form-control" value="" id="usersubjects">
                        </div>
                        <input type="hidden" id="indtitute_id" value='{{ $institute->id }}'>
                        <input type="hidden" id="userinsertId" value="" name="userInid">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-theme edit_user_data" id="edit_user_data">Edit
                                user</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
                $('#dataTables').DataTable();

                    //phoneNo validation
                $("#phone").keyup(function(){
                    var phoneValue = $(this).val();
                    if (phoneValue.length != 10) {
                            $("#numErr").show();                   
                        } else {
                            $("#numErr").hide();                   
                        }
                });

                $("#phoneUser").keyup(function(){
                    var phoneValueuser = $(this).val();
                    console.log(phoneValueuser.length);
                    if (phoneValueuser.length != 10) {
                            $("#numErrr").show();                   
                        } else {
                            $("#numErrr").hide();                   
                        }
                });
                $('#create_user').click(function(e) {
                    e.preventDefault();
                    var user_name = $('#name').val();
                    var phone = $('#phone').val();
                    var institute_id = $('#id').val();
                    var user_id = $('#userId').val();
                    var subject = $('#subjects').val();
                    // console.log(user_name,phone, institute_id, user_id, subject,)
                    if (user_name != '' && phone != '' && user_id != '' && subject != '') {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')

                            },
                            url: "/admin/manage-institutes/store-user-institute",
                            type: "POST",
                            data: {
                                name: user_name,
                                phone: phone,
                                institute_id: institute_id,
                                email:user_id,
                                subjects:subject
                            },
                            caches: false,
                            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#add_loader').removeClass('hidden')
                            },
                            success: function(res) {
                                if (res.status == 'Success') {
                                    swal('User added successfully');
                                    setTimeout(() => {
                                    window.location.reload();
                                }, 5000);
                            }
                                else {
                                    swal(res.error[0]);
                                }
                            },
                            complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#add_loader').addClass('hidden')
                            },
                        })

                    } else {
                        Swal.fire(
                            'Error!',
                            'All field are Required!',
                            'error'
                        )

                    }
                });

                $('.delete').click(function() {
                    // e.preventDefault();
                    var user_id = $(this).data('id');
                    // console.log(user_email);
                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    url: "/admin/manage-institutes/delete-user-institute",
                                    method: "post",
                                    data: {
                                        user_id: user_id,
                                    },
                                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                        $('#loader').removeClass('hidden')
                                    },
                                    success: function(dataResult) {
                                        var dataResult = JSON.parse(dataResult);
                                        if (dataResult.statusCode == 200) {
                                            swal("User deleted successfully", {
                                                icon: "success",
                                            });
                                            setTimeout(() => {
                                                window.location.reload();
                                            }, 5000);
                                        }
                                        
                                    },
                                    complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                        $('#loader').addClass('hidden')
                                    },
                                });
                            }
                        });
                });


                $('.editUser').click(function(e) {
                    e.preventDefault();
                    var user_nameGet = $('#nameUser').val('');
                    var idGet = $(this).data('id');
                    var phoneGet = $('#phoneUser').val('');
                    var user_idGet = $('#userid').val('');
                    var subjectGet = $('#usersubjects').val('');
                    var seridGet = $('#userinsertId').val('');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            url: "/admin/manage-institutes/get-user-institute/" + idGet,
                            type: "POST",
                            data: {
                                id: idGet,
                            },
                            caches: false,
                            success: function(dataResult) {
                                if (dataResult.status) {
                                    $("#editUserForm").modal('show');
                                    var userNameSet = $('#nameUser').val(dataResult.data.name);
                                    var phoneNumberset = $('#phoneUser').val(dataResult.data.phone);
                                    var userIdSet = $('#userid').val(dataResult.data.email);
                                    var subjectSet = $('#usersubjects').val(dataResult.data.subjects);
                                    var iduserSet = $('#userinsertId').val(dataResult.data.id);
                                }
                            }
                        })
                });                

               $("#edit_user_data").on('click', function(e){
                e.preventDefault();
                    var id = $('#userinsertId').val();
                    var user_name = $('#nameUser').val();
                    var phone = $('#phoneUser').val();
                    var institute_id = $('#indtitute_id').val();
                    var user_id = $('#userid').val();
                    var subject = $('#usersubjects').val();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },
                        url: "/admin/manage-institutes/update-user-institute/" + institute_id,
                        type: "POST",
                        data: {
                            id: id,
                            name:user_name,
                            phone:phone,
                            institute_id :institute_id,
                            email :user_id,
                            subjects :subject,
                        },
                        beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to
                            $('#loader').removeClass('hidden')
                        },
                            success: function(res) {
                                if (res.status == 'Success') {
                                    swal('User Edit successfully');
                                    setTimeout(() => {
                                    window.location.reload();
                                    }, 5000);
                                }
                                else{

                                swal(res.error[0]); 
                                } 
                            },

                        complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#add_loader').addClass('hidden')
                        },
                    })

            });
        });
</script>
@endpush
@endsection