<div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::model(Auth::user(), ['url' => url('update-profile'), 'method' => 'post', 'class' => 'ajax']) !!}
        <div class="modal-body">
          <div class="form-row">
              <div class="col-sm-7">
                  {!! Form::inputGroup('text', 'Name', 'name') !!}
              </div>
              <div class="col-sm-5">
                  {!! Form::inputGroup('number', 'Mobile Number', 'contact_number', null, ['placeholder' => 'ie: 09XXXXXXXXX']) !!}
              </div>
          </div>
          <div class="form-row">
              <div class="col-sm-5">
                  {!! Form::inputGroup('email', 'Email', 'email') !!}
              </div>
              <div class="col-sm-7">
                  {!! Form::inputGroup('text', 'Address', 'address') !!}
              </div>
          </div>
          <hr>
          <fieldset>
            <legend>Change Password</legend>
            <div class="form-row">
                <div class="col-sm-6">
                    {!! Form::passwordGroup('Password', 'password') !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::passwordGroup('Password Confirmation', 'password_confirmation') !!}
                </div>
            </div>
          </fieldset>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
