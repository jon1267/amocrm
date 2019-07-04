{{--<div class="tab-pane fade" id="user-settings">--}}
    <div class="tile user-settings">
        <h4 class="line-head">Create Amo Data</h4>
        <form action="{{ route('post.amo.create') }}" method="post">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Contact Name</label>
                    <input class="form-control" type="text" name="name">
                </div>
                <div class="col-md-4">
                    <label>Responsible User ID</label>
                    <input class="form-control" type="text" name="responsible_user_id">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-4">
                    <label>Created By</label>
                    <input class="form-control" type="text" name="created_by">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-8 mb-4">
                    <label>Lead Name</label>
                    <input class="form-control" type="text" name="lead">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-8 mb-4">
                    <label>Phone </label>
                    <input class="form-control" type="text" name="phone">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-8 mb-4">
                    <label>Email </label>
                    <input class="form-control" type="text" name="email">
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-md-12">
                     {{--<a href="{{ route('get.amo.create') }}" class="btn btn-primary" ><i class="fa fa-fw fa-lg fa-check-circle"></i> Create</a>--}}
                    <button class="btn btn-primary" ><i class="fa fa-fw fa-lg fa-check-circle"></i> Create</button>
                </div>
            </div>
        </form>
    </div>
{{--</div>--}}