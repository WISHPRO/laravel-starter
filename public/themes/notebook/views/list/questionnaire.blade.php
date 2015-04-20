<div class="m-b-md">
  <a href="{{ route('list.'.strtolower($type)) }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>
	<h3 class="m-b-none">
   P.O/W.O/LOA : <strong>{{ $project->project_number or '-' }}</strong>
  </h3>

  {{-- <div class="alert alert-warning alert-block" style="margin-top:20px;padding-bottom:5px;">
    <h4>
      <i class="fa fa-chevron-right"></i> {{ ucwords($type) }} : <u><strong>{{ $vendor->name or 'Vendor ID #: ' . $project->vendor_id }}</strong></u>
    </h4>
  </div> --}}
</div>

<section class="panel panel-default">
  <div class="panel-header b-b b-r b-light" style="padding:5px 15px;">
    <h4>
      <i class="fa fa-user"></i> {{ ucwords($type) }}: <strong>{{ $vendor->name or 'Vendor ID #: ' . $project->vendor_id }}</strong>
    </h4>
  </div>
  <div class="row m-l-none m-r-none bg-light lter">
    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
      <span class="fa-stack fa-2x pull-left m-r-sm">
        <i class="fa fa-circle fa-stack-2x text-dark"></i>
        <i class="fa fa-tags fa-stack-1x text-white"></i>
      </span>
      <a class="clear" href="{{ route('list.vendor', $project->vendor_id) }}" data-toggle="ajaxModal">
        <span class="h3 block m-t-xs">
          <strong>{{ Analytic::totalProject($project->vendor_id) }} : {{ Analytic::assessedProject($project->vendor_id) }}</strong>
        </span>
        <small class="text-muted text-uc">Total Survey : Completed</small>
      </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
      <span class="fa-stack fa-2x pull-left m-r-sm">
        <i class="fa fa-circle fa-stack-2x text-warning"></i>
        <i class="fa fa-star fa-stack-1x text-white"></i>
      </span>
      <a class="clear" href="{{ route('list.score', $project->vendor_id) }}" data-toggle="ajaxModal">
        <span class="h3 block m-t-xs">
          <?php $projectScore = Analytic::projectScore($project->id); ?>
          @if($projectScore['mark'] > 0)
            <strong>{{ $projectScore['mark'] }} ({{ $projectScore['grade'] }})</strong>
          @else
            <strong>--</strong>
          @endif
        </span>
        <small class="text-muted text-uc">This Survey Score</small>
      </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
      <span class="fa-stack fa-2x pull-left m-r-sm">
        <i class="fa fa-circle fa-stack-2x text-info"></i>
        <i class="fa fa-trophy fa-stack-1x text-white"></i>
      </span>
      <a class="clear" href="{{ route('list.score', $project->vendor_id) }}" data-toggle="ajaxModal">
        <span class="h3 block m-t-xs">
          <?php $totalScore = Analytic::totalScore($project->vendor_id); ?>
          @if($totalScore['mark'] > 0)
            <strong>{{ $totalScore['mark'] }} ({{ $totalScore['grade'] }})</strong>
          @else
            <strong>--</strong>
          @endif
        </span>
        <small class="text-muted text-uc">Average Score</small>
      </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
      <span class="fa-stack fa-2x pull-left m-r-sm">
        <?php 
        if(Analytic::assessedSurveyByProject($project->id)) { 
          $survey_status = 'Completed';
        ?>
        <i class="fa fa-circle fa-stack-2x text-success"></i>
        <i class="fa fa-check fa-stack-1x text-white"></i>
        <?php } else { 
          $survey_status = 'Incomplete';
        ?>
        <i class="fa fa-circle fa-stack-2x text-danger"></i>
        <i class="fa fa-exclamation fa-stack-1x text-white"></i>
        <?php } ?>
      </span>
      <a class="clear" href="{{ route('list.vendor', $project->vendor_id) }}" data-toggle="ajaxModal">
        <span class="h3 block m-t-xs"><strong>{{ $survey_status }}</strong></span>
        <small class="text-muted text-uc">This Survey Status</small>
      </a>
    </div>
  </div>
</section>

{{ bootstrap_alert() }}


<section class="panel panel-default">
  <header class="panel-heading bg-light">
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tab-questionnaire" data-toggle="tab"><i class="fa fa-question-circle text-default"></i> Result</a>
      </li>
      <li>
        <a href="#tab-assessor" data-toggle="tab"><i class="fa fa-user text-default"></i> Assessors</a>
      </li>
      <li>
        <a href="#tab-project" data-toggle="tab"><i class="fa fa-dashboard text-default"></i> Project Details</a>
      </li>
      <li class="hidden-sm pull-right">
      <a href="#tab-options" data-toggle="tab"><i class="fa fa-gear text-default"></i> Options</a>
    </li>
    </ul>
  </header>
  <div class="panel-body">
    <div class="tab-content">

      
      {{-- Questionnaire --}}
      <div class="tab-pane fade active in" id="tab-questionnaire">
        <div class="form-group">
          <h4>Performance Evaluation Survey</h4>
        </div>
        <div class="line line-dashed line-lg pull-in"></div>

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
              @if(count($questionnaires) > 0)
                <?php $i = 1; ?>
                @foreach($questionnaires as $questionnaire)
                <tr>
                  <td>{{ $i++ }}.</td>
                  <td>{{ $questionnaire->criteria }}</td>
                  <td class="col-md-1 text-center">
                    @if(isset($marks[$questionnaire->id])) 
                      {{ $marks[$questionnaire->id][3] }} 
                    @else
                      {{ '0' }}
                    @endif
                  </td>
                  <td class="col-md-1 text-center">
                    @if(isset($marks[$questionnaire->id])) 
                      {{ $marks[$questionnaire->id][2] }}
                    @else
                      {{ '0' }}
                    @endif
                  </td>
                  <td class="col-md-1 text-center">
                    @if(isset($marks[$questionnaire->id])) 
                      {{ $marks[$questionnaire->id][1] }} 
                    @else
                      {{ '0' }}
                    @endif
                  </td>
                </tr>
                @endforeach
              @endif
            </tbody>
          </table>
      </div>


      {{-- Assessors --}}
      <div class="tab-pane fade" id="tab-assessor">
          <div class="form-group">
            <h4>Assessor Details</h4>
          </div>
          <div class="line line-dashed line-lg pull-in"></div>
          <div class="form-group">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th class="col-md-1">#</th>
                  <th>Assessor Name</th>
                  <th class="col-md-4">Email</th>
                  <th class="col-md-2 text-center">Role</th>
                  <th class="col-md-1 text-center">Status</th>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                @foreach($assessors as $assessor)
                <tr>
                  <td>{{ $i++ }}.</td>
                  <td>{{ $assessor['user'] }}</td>
                  <td>{{ $assessor['email'] }}</td>
                  <td class="text-center">{{ $assessor['type'] }}</td>
                  <td class="text-center">{{ $assessor_status[$assessor['status']] }}</td>
                </tr> 
                @endforeach
              </tbody>
            </table>
          </div>
      </div>

      {{-- Project Details --}}
      <div class="tab-pane fade" id="tab-project">
        <div class="form-group">
          <h4>Project Details</h4>
        </div>
        <div class="line line-dashed line-lg pull-in"></div>
        
        <div class="form-group">
          <label class="col-sm-3 text-left">Project Type:</label>
          <label>{{ $project->project_type or '-' }}</label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left bold">Vendor Type:</label>
          <label>
            <?php if(isset($project)) $vendor_type = VendorType::find($project->vendor_type); ?>
            {{ $vendor_type->type or '-' }}
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Method:</label>
          <label>
            <?php if(isset($project)) $method = Method::find($project->method); ?>
            {{ $method->method or '-' }}
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Company:</label>
          <label>
            <?php if(isset($project)) $company = Company::find($project->company); ?>
            {{ $company->company or '-' }}
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Vendor Name:</label>
          <label>{{ $vendor->name or '-' }}</label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Vendor Status:</label>
          <label>
            <?php if(isset($project)) $vendorStatus = VendorStatus::find($project->vendor_status); ?>
            {{ $vendorStatus->status or '-' }}
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">P.O/W.O/LOA No.:</label>
          <label>{{ $project->project_number or '-' }}</label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Scope of Work:</label>
          <label>{{ $project->scope_of_work or '-' }}</label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Buyer:</label>
          <label>
            <?php if(isset($project)) $buyerName = User::find($project->buyer_id); ?>
            {{ $buyerName->first_name or '-' }}
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Contract Period:</label>
          <label>{{ $project->contract_period or '-' }}</label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">Issuance Date:</label>
          <label>{{ dateToString($project->issuance_date) }}</label>
        </div>

        {{-- <div class="form-group">
          <label class="col-sm-3 text-left">Estimated Completion Date:</label>
          <label>{{ stampToPicker($project->estimate_date) }}</label>
        </div> --}}

        <div class="form-group">
          <label class="col-sm-3 text-left">Actual Completion Date:</label>
          <?php
          if($project->delay == 1) {
            $actual_date = '<span style="text-decoration:line-through">' . dateToString($project->delay_date).'</span> ' . dateToString($project->actual_date) . '&nbsp;&nbsp;<a href="#" class="label bg-danger">Project Delayed</a>';

          } else $actual_date = dateToString($project->actual_date);
          ?>
          <label>{{ $actual_date }} </label>
        </div>

        @if($project->delay == 1)
        <div class="vbox">
          <label class="col-sm-3 text-left">Delay Reason:</label>
          <label>{{{ $project->delay_reason }}} </label>
        </div>
        @endif

        <div class="line line-dashed line-lg pull-in"></div>

        <div class="form-group">
          <label><h4>Evaluators' Email Address</h4></label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">1. Project Manager - Executive:</label>
          <label>
            <?php if(isset($project)) $pmName = User::find($project->project_manager_id); ?>
            {{ $pmName->first_name or '-' }}
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-3 text-left">2. End User - Executive:</label>
          <label>
            <?php if(isset($project)) $endName = User::find($project->end_user_id); ?>
            {{ $endName->first_name or '-' }}
          </label>
        </div>
      </div>

      {{-- Options --}}
      <div class="tab-pane fade" id="tab-options">
        <div class="form-group">
            <h4>Options</h4>
        </div>
        <div class="line line-dashed line-lg pull-in"></div>
        <div class="form-group">
          {{ HTML::decode(HTML::link(route('list.'.$type.'.delete', $project->id), '<i class="fa fa-trash"></i> Delete This Project', array('class' => 'btn btn-md btn-danger btn-user-edit', 'data-method' => 'delete', 'data-confirm' => 'Are you sure want to delete this project?'))) }}
          {{ HTML::decode(HTML::link(route('edit.index', array(strtolower($project->project_type), $project->id)), '<i class="fa fa-trash"></i> Edit This Project', array('class' => 'btn btn-md btn-success btn-user-edit', 'data-confirm' => 'Are you sure want to delete this project?'))) }}
        </div>
      </div>


    </div>
  </div>
</section>