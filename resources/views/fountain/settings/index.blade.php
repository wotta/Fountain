@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="settings">
        @include('fountain.partials.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Profile Photo</h3>
              </div>
              <div class="panel-body">
                <div class="text-center">
                    @if(Auth::user()->avatar == null)
                        <div>
                            <img src="{{ Auth::user()->gravatar }}" class="img-rounded" id="avatar" width="130">
                        </div>
                    @else
                        <div>
                            <img src="/storage/{{ Auth::user()->avatar }}" class="img-rounded" id="avatar" width="130">
                        </div>
                    @endif
                    <div class="change-image">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#avatarChangeModal">Change Image</button>
                    </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Contact Information</h3>
              </div>
              <div class="panel-body">
              <div id="formReply"></div>
                <form class="form-horizontal" action="{{ route('fountain.settings.update') }}" method="POST" id="settingsUpdate">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Update</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
<!--Avatar Change Modal-->
<div class="modal fade" id="avatarChangeModal" tabindex="-1" role="dialog" aria-labelledby="avatarChangeModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Avatar</h4>
            </div>
            <form id="avatarUploadForm" enctype="multipart/form-data" action="{{ route('fountain.settings.changeavatar') }}" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                        <input type="file" name="avatar">
                        <p class="help-block">Maximum image dimensions: 512x512</p>
                </div>
                <div id="avatarUploadReply"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // Update Settings Ajax
    $("#settingsUpdate").submit(function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    var url2 = $(this).attr('action');
    $.ajax({
        url: url2,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            //Process user view
            var reply = "" + data.reply + "";
            $('#formReply').removeClass('alert alert-danger');
            $('#formReply').show().addClass('alert alert-success');
            $('#formReply').text(reply);
        },
        error: function (data) {
            //Handle Errors
            if( data.status === 422 ) {
            var errors = '';
            for(datos in data.responseJSON){
                errors += data.responseJSON[datos] + '<br>';
            }
            $('#formReply').removeClass('alert alert-success');
            $('#formReply').addClass('alert alert-danger');
            $('#formReply').show().html(errors);
        } else{
            alert('There was an error processing your request. Please try again later.')
        }
        }
    });
});
// Update Avatar Ajax
    $('#avatarUploadForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $('#avatarChangeModal').modal('toggle');
                $('#avatar').attr('src', '/storage/' + data.location);
                $('#navatar').attr('src', '/storage/' + data.location);
            },
            error: function(data){
                //Handle Errors
                if( data.status === 422 ) {
                    var errors = '';
                    for(datos in data.responseJSON){
                        errors += data.responseJSON[datos] + '<br>';
                    }
                    $('#avatarUploadReply').removeClass('alert alert-success');
                    $('#avatarUploadReply').addClass('alert alert-danger');
                    $('#avatarUploadReply').show().html(errors);
                } else{
                    alert('There was an error processing your request. Please try again later.')
                }
            }
        });
    }));
</script>
@endsection