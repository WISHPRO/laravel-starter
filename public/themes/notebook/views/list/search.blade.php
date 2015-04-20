<div class="m-b-md">
	<h3 class="m-b-none">{{ ucwords($type) }} Performance Evaluation Survey</h3>
</div>

{{ bootstrap_alert() }}

<section class="panel panel-default">

	<div class="panel-body">
		<div class="alert alert-warning alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4><i class="fa fa-bell-alt"></i>Search by Project</h4>
			<p><h5>Please select Project based on P.O/W.O/LOA number to proceed.</h5></p>
		</div>

		<div class="line line-dashed line-lg pull-in"></div>

	  {{ Form::open(array('route' => 'questionnaire.'.$type, 'method' => 'get')) }}
	  	<div class="form-group">
          <label>Type</label>
          {{ Form::select('type', $vendor_types, $selected, array('class' => 'form-control', 'disabled' => 'disabled')) }}
        </div>

        <div class="form-group">
          <label>P.O/W.O/LOA No.</label>
          {{ Form::text('po_number', Input::get('pid'), array('class' => 'form-control')) }}
        </div>

        <div class="line line-dashed line-lg pull-in"></div>
        <div class="pull-right">
        	{{-- {{ Form::hidden('project_id', $project_id) }} --}}
    		<button type="submit" id="submit-btn" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search Questionnaire</button>
    	</div>
	  {{ Form::close() }}
	</div>
</section>