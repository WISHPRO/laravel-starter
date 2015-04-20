<div class="m-b-md">
  <h3 class="m-b-none">Projects List - {{ ucwords($type) }}</h3>
</div>

<section class="panel panel-default">
  <div class="table-responsive">
    <table id="datatable" class="table table-striped m-b-none">
      <thead>
        <tr>
          <th style="width:1%">#</th>
          <th class="col-md-2" nowrap>P.O/ W.O/LOA No.</th>
          <th class="col-md-2 text-left">Buyer</th>
          {{-- <th class="col-md-1 text-center">Type</th> --}}
          <th class="col-md-1 text-center">Opco</th>
          <th class="col-md-1 text-center" nowrap>Type</th>
          <th class="col-md-1 text-center">Start</th>
          <th class="col-md-1 text-center">Completion</th>
          <th class="col-md-1 text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $k=>$project)
        <tr>
          <td>{{ ($k+1).'.' }}</td>
          <td nowrap>
          	<a href="{{ route('list.display', $project->id) }}" class="btn btn-sm btn-default" data-toggle="ajaxModal">
          	{{ $project->project_number }}
          	</a>&nbsp;&nbsp;
            @if(Analytic::assessedSurveyByProject($project->id))
            <span class="label bg-success">Completed</span>
            @elseif($project->delay == 1)
            <span class="label bg-danger">Delayed</span>
            @endif
          </td>
          <?php
          if ($project->buyer_id > 0) {
            $buyer_name = User::find($project->buyer_id)->first_name;
          } else {
            $buyer_name = '';
          }
          ?>
          <td class="text-left" nowrap>{{ str_limit($buyer_name, 20) }}</td>
          {{-- <td class="text-center">{{ strtoupper($project->project_type) }}</td> --}}
          <td class="text-center" nowrap>{{ $company[$project->company] }}</td>
          <td class="text-center">{{ $vendor_types[$project->vendor_type] }}</td>
          <td class="text-center" nowrap>{{ dateToString($project->issuance_date) }}</td>
          <td class="text-center" nowrap>{{ dateToString($project->actual_date) }}</td>
          <td class="text-center" nowrap>
            <a data-id="13" class="btn btn-xs btn-primary btn-user-edit" href="{{ route('list.'.strtolower($vendor_types[$project->vendor_type]).'.id', $project->id) }}"><i class="fa fa-search fa-fw"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</section>