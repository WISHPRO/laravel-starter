<div class="m-b-md">
    <h3 class="m-b-none">Buyers</h3>
</div>

{{ bootstrap_alert() }}

<a name="entryform">&nbsp;</a>
<section class="panel panel-default">
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
          <tr>
            <th class="col-md-2">ID</th>
            <th class="col-md-4">Name</th>
            <th class="col-md-3">Email</th>
            <th class="col-md-1 text-center">Active</th>
            <th class="col-md-2 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            {{ Form::open(array('route' => array('config.buyer.put', $id), 'method' => 'put')) }}
            <td>
              {{ Form::text('id', $update->id, array('class' => 'form-control', 'disabled' => 'disabled')) }}
            </td>
            <td>
              {{ Form::text('name', $update->name, array('class' => 'form-control')) }}
            </td>
            <td>
              {{ Form::text('email', $update->email, array('class' => 'form-control')) }}
            </td>
            <td>
              {{ Form::select('status', array(0 => 'No', 1 => 'Yes'), $update->status, array('class' => 'form-control')) }}
            </td>
            <td class="text-center">
              <button type="submit" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> 
                @if($id) Edit Buyer
                @else Add Buyer
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
            <th class="col-md-2">ID</th>
            <th class="col-md-4">Name</th>
            <th class="col-md-3">Email</th>
            <th class="col-md-1 text-center">Active</th>
            <th class="col-md-2 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($buyers as $key => $buyer)
          <tr>
            <td @if($id == $buyer->id) style="background-color:#FFFFCC"@endif>{{ $buyer->id }}</td>
            <td @if($id == $buyer->id) style="background-color:#FFFFCC"@endif>{{ $buyer->name }}</td>
            <td @if($id == $buyer->id) style="background-color:#FFFFCC"@endif>{{ $buyer->email }}</td>
            <?php if($buyer->status) $active = 'Yes'; else $active = 'No'; ?>
            <td @if($id == $buyer->id) style="background-color:#FFFFCC"@endif class="text-center">{{ $active }}</td>
            <td @if($id == $buyer->id) style="background-color:#FFFFCC"@endif class="text-center">
                <a data-id="13" class="btn btn-xs btn-default btn-user-edit" href="{{ route('config.buyer.update', $buyer->id) }}#entryform"><i class="fa fa-pencil fa-fw"></i></a>
                {{ HTML::decode(HTML::link(route('config.buyer.delete', $buyer->id), '<i class="fa fa-times fa-fw"></i>', array('class' => 'btn btn-xs btn-default btn-user-edit', 'data-method' => 'delete', 'data-confirm' => 'Are you sure want to delete this buyer?'))) }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
</section>