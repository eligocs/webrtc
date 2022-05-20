<div class="tab-pane fade " id="resolved" role="tabpanel" aria-labelledby="resolved-tab">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form id="add_new_institute_form" class="form-horizontal" action="{{route('admin.manage-institutes.store')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="example-text-input">Institute Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="example-email">Email</label>
                            <div class="col-sm-10">
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="example-email">Mobile Number</label>
                            <div class="col-sm-10">
                                <input type="text"  id="mobile_no" name="mobile_no" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="example-email">Address</label>
                            <div class="col-sm-10">
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>
                        </div>                               
                        <div class="form-group text-center">
                           <button type="submit" class="btn btn-theme waves-effect waves-light m-l-10 submit_btn">Create Institute</button>
                        </div>
                        <div class="response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>