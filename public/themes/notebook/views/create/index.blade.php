<div class="m-b-md">
	<h3 class="m-b-none">Create New Project: {{ strtoupper($new) }}</h3>
</div>

{{ bootstrap_alert() }}

<section class="panel panel-default">
	<header class="panel-heading font-bold">Register P.O / W.O / LOA</header>
	<div class="panel-body">
	  {{ Form::open(array('route' => 'create.index.post')) }}
	  	  <div class="form-group">
          <label>Project Type</label>
          {{ Form::text('project_type_display', strtoupper($new), array('class' => 'form-control', 'disabled' => 'disabled')) }}
          {{ Form::hidden('project_type', strtoupper($new)) }}
        </div>

        <div class="form-group">
          <label>Vendor Type</label>
          {{ Form::select('vendor_type', $vendor_types, '', array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>Method</label>
          {{ Form::select('method', $methods, '', array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>Company</label>
          {{ Form::select('company', $company, '', array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>Vendor Name</label>
          {{ Form::text('vendor_name', Input::get('vendor_name'), array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vendor-name')) }}
          {{ Form::hidden('vendor_id', '', array('id' => 'vendor-id')) }}
        </div>

        <div class="form-group">
          <label>Vendor Status</label>
          {{ Form::select('vendor_status', $vendor_status, '', array('class' => 'form-control m-b')) }}
        </div>

        <div class="form-group">
          <label>P.O/W.O/LOA No.</label>
            {{ Form::text('project_number', '', array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
          <label>Scope of Work</label>
            {{-- <textarea name="scope_of_work" class="form-control" rows="6"></textarea> --}}
            {{ Form::textarea('scope_of_work', '', array('class' => 'form-control', 'rows' => 6)) }}
        </div>

        <div class="form-group">
          <label>Buyer</label>
            {{ Form::text('buyer_name', '', array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'buyer-name')) }}
            {{ Form::hidden('buyer_id', '', array('id' => 'buyer-id')) }}
        </div>

        {{-- <div class="form-group">
          <label>Contract Period</label>
            {{ Form::text('contract_period', '', array('class' => 'form-control')) }}
        </div> --}}

        <div class="form-group">
          <label>P.O/ W.O/LOA Issuance Date</label>
            {{ Form::text('issuance_date', date('d-m-Y'), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
        </div>

        {{-- <div class="form-group">
          <label>Estimated Completion Date</label>
            {{ Form::text('estimate_date', date('d-m-Y'), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
        </div> --}}

        <div class="form-group">
          <label>Actual Completion Date</label>
            {{ Form::text('actual_date', date('d-m-Y'), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
        </div>

        <div class="line line-dashed line-lg pull-in"></div>

        <div class="form-group">
          <label><strong>Evaluators' Email Address:</strong></label>
        </div>

        <div class="form-group">
          <label>1. Project Manager - Executive Level</label>
          {{ Form::text('project_manager', '', array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'project-manager')) }}
          {{ Form::hidden('project_manager_id', '', array('id' => 'project-manager-id')) }}
        </div>

        <div class="form-group">
          <label>2. End User - Executive Level</label>
          {{ Form::text('end_user', '', array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'end-user')) }}
          {{ Form::hidden('end_user_id', '', array('id' => 'end-user-id')) }}
        </div>

        {{-- <div class="form-group">
          <label>3. GPD – Head Of Section</label>
            {{ Form::text('gpd_head', '', array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'gpd-head')) }}
        </div> --}}

        <div class="line line-dashed line-lg pull-in"></div>
        <div class="pull-right">
	    		<button type="submit" id="submit-btn" class="btn btn-sm btn-primary">Submit</button>
	    	</div>
	    </div>
	  {{ Form::close() }}
	</div>
</section>