<div class="m-b-md">
  <a href="{{ route('list.'.strtolower($vendor_types[$project->vendor_type])) }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>
	<h3 class="m-b-none">Edit Project: {{ strtoupper($new) }}</h3>
</div>

{{ bootstrap_alert() }}

<section class="panel panel-default">
	<header class="panel-heading font-bold">Register P.O / W.O / LOA</header>
	<div class="panel-body">
	  {{ Form::open(array('route' => 'edit.index.put', 'method' => 'put')) }}
	  	  <div class="form-group">
          <label>Project Type</label>
          {{ Form::text('project_type_display', strtoupper($new), array('class' => 'form-control', 'disabled' => 'disabled')) }}
          {{ Form::hidden('project_type', strtoupper($new)) }}
          {{ Form::hidden('project_id', $project->id) }}
        </div>

        <div class="form-group">
          <label>Vendor Type</label>
          {{ Form::select('vendor_type', $vendor_types, $project->vendor_type, array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>Method</label>
          {{ Form::select('method', $methods, $project->method, array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>Company</label>
          {{ Form::select('company', $company, $project->company, array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>Vendor Name</label>
          <?php $vendor = Vendor::find($project->vendor_id); ?>
          {{ Form::text('vendor_name', $vendor->name, array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vendor-name')) }}
          {{ Form::hidden('vendor_id', $project->vendor_id, array('id' => 'vendor-id')) }}
        </div>

        <div class="form-group">
          <label>Vendor Status</label>
          {{ Form::select('vendor_status', $vendor_status, $project->vendor_status, array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>P.O/W.O/LOA No.</label>
            {{ Form::text('project_number', $project->project_number, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
          <label>Scope of Work</label>
            {{-- <textarea name="scope_of_work" class="form-control" rows="6"></textarea> --}}
            {{ Form::textarea('scope_of_work', $project->scope_of_work, array('class' => 'form-control', 'rows' => 6)) }}
        </div>

        <div class="form-group">
          <label>Buyer</label>
            <?php
            if ($project->buyer_id > 0) {
              $user = User::find($project->buyer_id);
              $employee = Employee::where('email', $user->email)->first();
              $buyer_name = $user->first_name;
              $buyer_id = $employee->id;
            } else {
              $buyer_name = '';
              $buyer_id = '';
            }
            ?>
            {{ Form::text('buyer_name', $buyer_name, array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'buyer-name')) }}
            {{ Form::hidden('buyer_id', $buyer_id, array('id' => 'buyer-id')) }}
        </div>

        {{-- <div class="form-group">
          <label>Contract Period</label>
            {{ Form::text('contract_period', $project->contract_period, array('class' => 'form-control')) }}
        </div> --}}

        <div class="form-group">
          <label>P.O/ W.O/LOA Issuance Date</label>
            {{ Form::text('issuance_date', dateToString($project->issuance_date), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
        </div>

        {{-- <div class="form-group">
          <label>Estimated Completion Date</label>
            {{ Form::text('estimate_date', dateToString($project->estimate_date), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
        </div> --}}

        <div class="form-group">
          <label>Actual Completion Date</label>
            {{ Form::text('actual_date', dateToString($project->actual_date), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
        </div>

        <div class="line line-dashed line-lg pull-in"></div>

        <div class="form-group">
          <label><strong>Evaluators' Email Address:</strong></label>
        </div>

        <div class="form-group">
          <label>1. Project Manager - Executive Level</label>
          <?php
            if ($project->project_manager_id > 0) {
              $user = User::find($project->project_manager_id);
              $employee = Employee::where('email', $user->email)->first();
              $pm_name = $user->first_name;
              $pm_id = $employee->id;
            } else {
              $pm_name = '';
              $pm_id = '';
            }
          ?>
          {{ Form::text('project_manager', $pm_name, array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'project-manager')) }}
          {{ Form::hidden('project_manager_id', $pm_id, array('id' => 'project-manager-id')) }}
        </div>

        <div class="form-group">
          <label>2. End User - Executive Level</label>
          <?php
            if ($project->end_user_id > 0) {
              $user = User::find($project->end_user_id);
              $employee = Employee::where('email', $user->email)->first();
              $enduser_name = $user->first_name;
              $enduser_id = $employee->id;
            } else {
              $enduser_name = '';
              $enduser_id = '';
            }
          ?>
          {{ Form::text('end_user', $enduser_name, array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'end-user')) }}
          {{ Form::hidden('end_user_id', $enduser_id, array('id' => 'end-user-id')) }}
        </div>

        {{-- <div class="form-group">
          <label>3. GPD – Head Of Section</label>
            {{ Form::text('gpd_head', '', array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'gpd-head')) }}
        </div> --}}

        <div class="line line-dashed line-lg pull-in"></div>
        <div class="pull-right">
	    		<button type="submit" id="submit-btn" class="btn btn-sm btn-primary">Update</button>
	    	</div>
	    </div>
	  {{ Form::close() }}
	</div>
</section>