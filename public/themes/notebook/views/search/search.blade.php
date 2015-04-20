<div class="m-b-md">
	<h3 class="m-b-none">Search by Project</h3>
</div>

{{ bootstrap_alert() }}

<section class="panel panel-default">

	<div class="panel-body">
		<div class="alert alert-warning alert-block">
			{{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
			<h4><i class="fa fa-bell-alt"></i>Search by selected keywords:</h4>
			<div class="vbox" style="font-size:110%">
				@foreach($search_fields as $key => $field)
				<div class="col-md-3">
					<?php if(in_array($key, $defaults)) $tf = true; else $tf = false; ?>
					<label>
					{{ Form::checkbox('check_'.$key, 1, $tf, array('id' => 'check-'.$key)) }} 
					&nbsp;{{ $field }}
					</label>
				</div>
				@endforeach
			</div>
		</div>

		<div class="line line-dashed line-lg pull-in"></div>

	  {{ Form::open(array('route' => 'search', 'method' => 'post')) }}
	  	
	  	<div id="keyword-project_type" 
	  	@if(!in_array('project_type', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('project_type', 'Project Type') }}
	        	{{ Form::select('project_type', $project_types, '', array('class' => 'form-control m-b')) }}
	        </div>
	        <div class="line line-dashed line-lg pull-in"></div>
        </div>

        <div id="keyword-vendor_type"
        @if(!in_array('vendor_type', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('vendor_type', 'Vendor Type') }}
				{{ Form::select('vendor_type', $vendor_types, '', array('class' => 'form-control m-b')) }}
	        </div>
	        <div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-method"
		@if(!in_array('method', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('method', 'Method') }}
				{{ Form::select('method', $methods, '', array('class' => 'form-control m-b')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-company"
		@if(!in_array('company', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('company', 'Company') }}
				{{ Form::select('company', $company, '', array('class' => 'form-control m-b')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-vendor_id"
		@if(!in_array('vendor_id', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('vendor_name', 'Vendor Name') }}
				{{ Form::text('vendor_name', Input::get('vendor_name'), array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vendor-name')) }}
			    {{ Form::hidden('vendor_id', '', array('id' => 'vendor-id')) }}
			 </div>
			 <div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-vendor_status"
		@if(!in_array('vendor_status', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('vendor_status', 'Vendor Status') }}
				{{ Form::select('vendor_status', $vendor_status, '', array('class' => 'form-control m-b')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-project_number"
		@if(!in_array('project_number', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
		        {{ Form::label('project_number', 'P.O/W.O/LOA No.') }}
				{{ Form::text('project_number', '', array('class' => 'form-control')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-scope_of_work"
		@if(!in_array('scope_of_work', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('scope_of_work', 'Scope of Work') }}
				{{ Form::text('scope_of_work', '', array('class' => 'form-control')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-buyer_id"
		@if(!in_array('buyer_id', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('buyer_name', 'Buyer Name') }}
				{{ Form::text('buyer_name', '', array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'buyer-name')) }}
			    {{ Form::hidden('buyer_id', '', array('id' => 'buyer-id')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-issuance_date"
		@if(!in_array('issuance_date', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('issuance_date', 'Issuance Date') }}
				{{ Form::text('issuance_date', '', array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-actual_date"
		@if(!in_array('actual_date', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('actual_date', 'Actual Date') }}
				{{ Form::text('actual_date', '', array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-project_manager_id"
		@if(!in_array('project_manager_id', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('project_manager', 'Project Manager') }}
				{{ Form::text('project_manager', '', array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'project-manager')) }}
			    {{ Form::hidden('project_manager_id', '', array('id' => 'project-manager-id')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-end_user_id"
		@if(!in_array('end_user_id', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('end_user', 'End User') }}
				{{ Form::text('end_user', '', array('class' => 'typeahead-employee form-control', 'autocomplete' => 'off', 'id' => 'end-user')) }}
			    {{ Form::hidden('end_user_id', '', array('id' => 'end-user-id')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

		<div id="keyword-status"
		@if(!in_array('status', $defaults)){{'style="display:none"'}}@endif>
		  	<div class="form-group">
	          	{{ Form::label('status', 'Project Status') }}
				{{ Form::select('status', $statuses, '', array('class' => 'form-control m-b')) }}
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
        </div>

        <div class="pull-right">
    		<button type="submit" id="submit-btn" class="btn btn-primary"><i class="fa fa-search"></i> Search Project</button>
    	</div>
	  {{ Form::close() }}
	</div>
</section>


