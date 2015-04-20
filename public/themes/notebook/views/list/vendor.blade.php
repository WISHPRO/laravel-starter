<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">{{ $vendor->name or 'Vendor ID #: ' . $project->vendor_id }}</h4>
    </div>
    <div class="modal-body clear" style="max-height: 420px;overflow-y: auto;">
        
        <section class="panel panel-default">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="col-md-1">#</th>
                <th class="col-md-1 text-center">Type</th>
                <th class="col-md-2">P.O/W.O/LOA</th>
                <th class="col-md-5">Scope of Work</th>
                <th class="col-md-1 text-center">Status</th>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              @foreach($vendor->projects as $project)
              <tr>
                <td>{{ $i++ }}.</td>
                <td class="text-center">{{ $vendor_types[$project->vendor_type] }}</td>
                <td>
                  <a href="{{ route('list.'.strtolower($vendor_types[$project->vendor_type]).'.id', $project->id) }}" class="btn btn-sm btn-default">{{ $project->project_number }}</a>
                </td>
                <td>{{ str_limit($project->scope_of_work, 40) }}</td>
                <?php 
                if(Analytic::assessedSurveyByProject($project->id)) { 
                  $survey_status = '<span class="label bg-success">Completed</span>';
                } else {
                  $survey_status = '<span class="label bg-danger">Incomplete</span>';
                }
                ?>
                <td class="text-center">{{ $survey_status }}</td>
              </tr> 
              @endforeach
            </tbody>
          </table>
        </section>

    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
    </div>
  </div>