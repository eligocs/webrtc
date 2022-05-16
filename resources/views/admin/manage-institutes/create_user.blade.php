@extends('admin.layouts.app')
@section('page_heading', 'Manage Zoom User')
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
                                            {{-- <th>
                                                    <h4 class="header-title m-0 heading">Institutes Id</h4>
                                                    <!-- <span class="text-muted">Phone Number</span> -->
                                                </th> --}}
                                            <th>
                                                <h4 class="header-title m-0 heading">Institutes Name</h4>
                                                <!-- <span class="text-muted">Phone Number</span> -->
                                            </th>
                                            <th>
                                                <h4 class="header-title m-0 heading">Institutes Email</h4>
                                            </th>

                                            <th>
                                                <h4 class="header-title m-0 heading">Action</h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($zoomUsers->users as $key => $zoomUser)
                                        @if ($zoomUser->email != 'support@avestud.com'))
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            {{-- <td>
                                                            {{ $zoomUser->id }}
                                            </td> --}}
                                            <td>
                                                <h5>
                                                    {{ $zoomUser->first_name }}
                                                </h5>
                                            </td>
                                            <td>
                                                <h5 class="m-0">{{ $zoomUser->email }}</h5>
                                            </td>

                                            <td class="py-2">
                                                {{-- <button type="submit"
                                                        data-email="{{ $zoomUser->institute_email }}"
                                                class="btn-theme btn-style edit-zoom-user">
                                                Edit </button> --}}
                                                &nbsp;<button type="submit" data-id="{{ $zoomUser->id }}"
                                                    data-email="{{ $zoomUser->email }}"
                                                    class="btn btn-danger btn-style delete">
                                                    Delete </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
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
                <h5 class="modal-title" id="lectureModalLabel"> Create Zoom User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add_loader" class="lds-dual-ring hidden  overlay"></div>
            <div class="modal-body">
                <div class="card-box">
                    <div class="form-group">
                        <label for="cars">Choose a Institutes <span style="color:red">*</span></label>
                        <select name="institute" id="institute" class="form-control" required>
                            <option value selected></option>
                            @if (isset($institutes))
                            @foreach ($institutes as $institute)
                            <option data-id="{{ $institute->id }}" data-name="{{ $institute->name }}"
                                data-email="{{ $institute->email }} ">
                                {{ $institute->name }}
                            </option>
                            @endforeach
                            @endif

                        </select>
                    </div>
                    <form role="form">
                        @csrf
                        <div class="form-group">
                            <label for="fname"> User Name <span style="color:red">*</span></label>
                            <input type="text" name="name" class="form-control" id="fname" value="{{ old('fname') }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span style="color:red">*</span></label>
                            <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}"
                                readonly>
                        </div>
                        <input type="hidden" id="id" value='' name="user_id">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-theme" id="create_user">Create user</button>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!------edit model--------------------->

@push('js')
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
                $('#dataTables').DataTable();
                $("#institute").on('change', function() {
                    var new_id = $('#institute').find(':selected').data('id');
                    var name = $('#institute').find(':selected').data('name');
                    var email = $('#institute').find(':selected').data('email');

                    var enterFname = $('#fname').val(name);
                    var id = $('#id').val(new_id);
                    var enterEmail = $('#email').val(email);
                });
                $('#create_user').click(function(e) {
                    e.preventDefault();
                    var institute_Name = $('#fname').val();
                    var institute_id = $('#id').val();
                    var institute_email = $('#email').val();
                    if (institute_Name != '' && institute_id != '' && institute_email != '') {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')

                            },
                            url: "/admin/manage-institutes/create_user_ajax",
                            type: "POST",
                            data: {
                                institute_Name: institute_Name,
                                institute_id: institute_id,
                                institute_email: institute_email
                            },
                            caches: false,
                            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#add_loader').removeClass('hidden')
                            },
                            success: function(dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 201) {
                                    Swal.fire(
                                        'success!',
                                        'Done, User Created!',
                                        'success'
                                    )
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 5000);

                                } else if (dataResult.statusCode == 409) {

                                    Swal.fire(
                                        'success!',
                                        'Error, User with that email already exists',
                                        'success'
                                    )
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 5000);

                                } else if (dataResult.statusCode == 101) {
                                    Swal.fire(
                                        'success!',
                                        'All field are Required!',
                                        'success'
                                    )
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 5000);

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
                    var user_email = $(this).data('email');
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
                                    url: "/admin/manage-institutes/delete-user/" + user_id + '/' +
                                        user_email,
                                    method: "post",
                                    data: {
                                        user_id: user_id,
                                        user_email: user_email
                                    },
                                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                        $('#loader').removeClass('hidden')
                                    },
                                    success: function(dataResult) {
                                        console.log(dataResult);
                                        var dataResult = JSON.parse(dataResult);
                                        if (dataResult.statusCode == 204) {
                                            swal("User deleted successfully", {
                                                icon: "success",
                                            });
                                            setTimeout(() => {
                                                window.location.reload();
                                            }, 5000);
                                        } else if (dataResult.statusCode == 429) {
                                            swal("Fail to delete user!!!", {
                                                icon: "error",
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
            });
</script>
@endpush
@endsection