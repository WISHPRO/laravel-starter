<div class="m-b-md">
  <h3 class="m-b-none">Survey List - {{ $type }}</h3>
</div>

{{ bootstrap_alert() }}

@if($profile_incomplete) 
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h5>
        <i class="fa fa-warning" style="margin-left:20px;font-size:150%;display:inline;"></i>
        <div style="margin-left:10px;display:inline">You are required to update your profile before proceed with any questionnaire.<br>
        <a href="{{ route('survey.setting') }}" class="btn btn-s-md btn-danger" style="margin-left:55px;margin-top:10px;"><i class="fa fa-gear"></i> Click here to update</a>
        </div>
      </h5>
    </div>
@endif

<section class="panel panel-default">
  <div class="table-responsive">
    <table class="table table-striped m-b-none" data-ride="datatables">
      <thead>
        <tr>
          <th style="width:0%">#</th>
          <th class="col-md-3" nowrap>P.O/ W.O/LOA No.</th>
          <th class="col-md-1">Type</th>
          <th class="col-md-1">Opco</th>
          <th class="col-md-2">Vendor Type</th>
          <th class="col-md-2">Your Role</th>
          <th class="col-md-1">Start</th>
          <th class="col-md-1">Completion</th>
          <th class="col-md-1">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $k=>$project)
        <tr> 
          <td>{{ ($k+1).'.' }}</td>
          <td nowrap>
          	<a href="{{ route('survey.display', $project->id) }}" class="btn btn-sm btn-default" data-toggle="ajaxModal" title="{{ $project->project_number }}">
          	{{ $project->project_number }}
          	</a>
          </td>
          <td>{{ strtoupper($project->project_type) }}</td>
          <td>{{ $company[$project->company] }}</td>
          <td>{{ $vendor_types[$project->vendor_type] }}</td>
          <?php
          $me = Sentry::getUser();
          $roles = array();
          if($me->id == $project->buyer_id) $roles[] = 'Buyer';
          if($me->id == $project->project_manager_id) $roles[] = 'Project Manager';
          if($me->id == $project->end_user_id) $roles[] = 'End User';
          ?>
          <td>{{ implode(', ', $roles) }}</td>
          <td nowrap>{{ stampToPicker($project->issuance_date) }}</td>
          <td nowrap>{{ stampToPicker($project->actual_date) }}</td>
          <td nowrap>
            <a data-id="13" class="btn btn-xs btn-primary btn-user-edit" href="{{ route('survey.'.strtolower($vendor_types[$project->vendor_type]), $project->id) }}"
            @if($profile_incomplete) disabled="disabled" @endif><i class="fa fa-search fa-fw"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>