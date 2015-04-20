<div class="m-b-md">
    <h3 class="m-b-none">Consultant Questionnaires</h3>
</div>

{{ bootstrap_alert() }}

<a name="entryform">&nbsp;</a>
<section class="panel panel-default">
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
          <tr>
            <th class="col-md-2">Index</th>
            <th>Criteria</th>
            <th class="col-md-2 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            {{ Form::open(array('route' => array('config.consultant.put', $id), 'method' => 'put')) }}
            <td>
              {{ Form::text('index', $update->index, array('class' => 'form-control')) }}
            </td>
            <td>
              {{ Form::text('criteria', $update->criteria, array('class' => 'form-control')) }}
            </td>
            <td class="text-center">
              <button type="submit" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> 
                @if($id) Edit Questionnaire
                @else Add Questionnaire
                @endif
              </button>
            </td>
            {{ Form::close() }}
          </tr>
        </tbody>
      </table>
  </div>
</section>


<section class="panel panel-default">
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
          <tr>
            <th class="col-md-2">Index</th>
            <th>Criteria</th>
            <th class="col-md-2 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($questionnaires as $key => $question)
          <tr>
            <td @if($id == $question->id)style="background-color:#FFFFCC"@endif>{{ $question->index }}</td>
            <td @if($id == $question->id) style="background-color:#FFFFCC"@endif>{{ $question->criteria }}</td>
            <td @if($id == $question->id) style="background-color:#FFFFCC"@endif class="text-center">
                <a data-id="13" class="btn btn-xs btn-default btn-user-edit" href="{{ route('config.consultant.update', $question->id) }}"><i class="fa fa-pencil fa-fw"></i></a>
                {{ HTML::decode(HTML::link(route('config.consultant.delete', $question->id), '<i class="fa fa-times fa-fw"></i>', array('class' => 'btn btn-xs btn-default btn-user-edit', 'data-method' => 'delete', 'data-confirm' => 'Are you sure want to delete this question?'))) }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
</section>