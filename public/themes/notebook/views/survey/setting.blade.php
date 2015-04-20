<div class="m-b-md">
  {{-- <a href="{{ route('user.list') }}" id="btn-user-add" class="btn btn-success btn-sm pull-right"><i class="fa fa-user"></i> List Users</a> --}}
  <h3 class="m-b-none">Update Profile</h3>
</div>

{{ bootstrap_alert() }}

  {{ Form::open(array('route' => array('survey.setting.put', $user->id), 'method' => 'PUT')) }}
  <section class="panel panel-default">
    <div class="panel-body">

        <div class="form-group">
          <label>Email address</label>
          {{ Form::text('email', $user->email, array('class' => 'typeahead-email form-control', 'autocomplete' => 'off', 'data-provide' => 'typeahead', 'id' => 'employees-email', 'disabled' => 'disabled')) }}
        </div>

        <div class="form-group">
          <label>Password</label>
          {{ Form::password('password', array('class' => 'form-control', 'placeholder' => '(Leave blank to remain unchanged)')) }}
        </div>

        
    </div>
  </section>

  <section class="panel panel-default">
    <div class="panel-body">

        <div class="form-group">
          <label>Full Name</label>
          {{ Form::text('full_name', $user->first_name, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
          <label>Employee ID</label>
          {{ Form::text('employee_id', $user->employee_id, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
          <label>Department</label>
          {{ Form::text('department', $user->department, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
          <label>Designation</label>
          {{ Form::text('designation', $user->designation, array('class' => 'form-control')) }}
        </div>
        
        <div class="line line-dashed line-lg pull-in"></div>
        <div class="pull-right">
          <a href="{{ route('survey') }}" id="btn-user-add" class="btn btn-default btn-sm">Cancel</a>
          <button type="submit" class="btn btn-sm btn-primary">Update User</button>
        </div>
    </div>

  </section>
  {{ Form::close() }}