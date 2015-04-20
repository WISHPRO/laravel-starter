<div class="m-b-md">
	<h3 class="m-b-none">{{ ucwords($type) }} Performance Evaluation Survey</h3>
</div>

{{ bootstrap_alert() }}

<section class="panel panel-default">

	<div class="panel-body">
		
    @if($responded)
      <div class="alert alert-danger alert-block">
  			<button type="button" class="close" data-dismiss="alert">×</button>
  			<p><h5 style="padding-left:20px;"><i class="fa fa-exclamation-triangle"></i> &nbsp; You've already responded to this questionnaire.</h5></p>
  		</div>
    @else
      <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>
        Dear Sir/ Madam,</h4>
        <p><h5>We need your coorperation evaluate our vendor performance.<br>Detail as follows:</h5></p>
      </div>
    @endif

		<div class="line line-dashed line-lg pull-in"></div>

	  {{ Form::open(array('route' => 'survey.'.$type.'.post')) }}
	  	<div class="form-group">
          <label>Vendor Name</label>
          <?php 
          if(!isset($vendor->name)) 
            $vendor_name = 'Vendor ID #: ' . $project->vendor_id;
          else $vendor_name = $vendor->name; 
          ?>
          {{ Form::text('vendor_name', $vendor_name, array('class' => 'form-control', 'disabled' => 'disabled')) }}
        </div>

        <div class="form-group">
          <label>P.O/W.O/LOA No.</label>
          {{ Form::text('po_number', $project->project_number, array('class' => 'form-control', 'disabled' => 'disabled')) }}
        </div>

        <div class="form-group">
          <label>Scope of Work</label>
          {{ Form::textarea('scope', $project->scope_of_work, array('class' => 'form-control', 'disabled' => 'disabled', 'rows' => 6)) }}
        </div>

        <div class="form-group">
        	<label>Questionnaire</label>
        	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>{{ ucwords($type) }} Assessment Criteria</th>
						<th class="text-center">Good</th>
						<th class="text-center">Average</th>
						<th class="text-center">Poor</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					@foreach($questionnaires as $questionnaire)
					<tr>
						<td>{{ $i++ }}.</td>
						<td>{{ $questionnaire->criteria }}</td>
						<td class="col-md-1 text-center">
              @if(isset($marks[$questionnaire->id])) 
                {{Form::radio('questions['.$questionnaire->id.']', 3, $marks[$questionnaire->id][3])}}
              @else
                {{Form::radio('questions['.$questionnaire->id.']', 3, false)}}
              @endif
            </td>
						<td class="col-md-1 text-center">
              @if(isset($marks[$questionnaire->id])) 
                {{Form::radio('questions['.$questionnaire->id.']', 2, $marks[$questionnaire->id][2])}}
              @else
                {{Form::radio('questions['.$questionnaire->id.']', 2, false)}}
              @endif
            </td>
						<td class="col-md-1 text-center">
              @if(isset($marks[$questionnaire->id])) 
                {{Form::radio('questions['.$questionnaire->id.']', 1, $marks[$questionnaire->id][1])}}
              @else
                {{Form::radio('questions['.$questionnaire->id.']', 1, false)}}
              @endif
            </td>
					</tr>
					@endforeach
          {{Form::hidden('total_questions', ($i-1))}}
				</tbody>
			</table>

        </div>

        <div class="form-group">
          <label>Remarks (if any)</label>
          {{ Form::textarea('remark', $survey->remark, array('class' => 'form-control', 'rows' => 6, 'id' => 'remark')) }}
        </div>

        <?php
          $me = Sentry::getUser();
          $roles = array();
          if($me->id == $project->buyer_id) $roles[] = 'BY';
          if($me->id == $project->project_manager_id) $roles[] = 'PM';
          if($me->id == $project->end_user_id) $roles[] = 'EU';
        ?>
        @if((in_array('PM', $roles) || in_array('EU', $roles)) && (($responded && $project->delay == 1) || !$responded))
        <div class="line line-dashed line-lg pull-in"></div>
        <div class="form-group">
          <label>
            <?php
            if($project->delay == 1) {
              $tf = true;
            } else {
              $tf = false;
            }
            ?>
            {{ Form::checkbox('delay', 1, $tf, array('id' => 'delay')) }}
            Project Delay
          </label>
        </div>

        <div id="delay-box" class="alert alert-danger alert-block" 
              @if($project->delay == 0)
                style="display:none"
              @endif>
          <p>
            <div class="form-group">
              <label>New Estimate Date of Completion</label>
              {{ Form::text('delay_date', stampToPicker($project->delay_date), array('class' => 'datepicker-input form-control', 'data-date-format' => 'dd-mm-yyyy', 'id' => 'delay-date')) }}
            </div>

            <div class="form-group">
              <label>Reason</label>
              {{ Form::textarea('delay_reason', $project->delay_reason, array('class' => 'form-control', 'rows' => 6, 'id' => 'delay-reason')) }}
            </div>
          </p>
        </div>
        @endif

        <div class="line line-dashed line-lg pull-in"></div>
        
        <div class="pull-right">
          <a href="{{ route('survey') }}" class="btn btn-default">Cancel</a>
        	{{ Form::hidden('project_id', $project->id) }}
      		<button type="submit" id="submit-btn" class="btn btn-primary" @if($responded) disabled="disabled" @endif>Submit Questionnaire</button>
      	</div>
	  {{ Form::close() }}
	</div>
</section>