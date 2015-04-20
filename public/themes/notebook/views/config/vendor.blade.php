<div class="m-b-md">
    <h3 class="m-b-none">Vendors</h3>
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
            <th class="col-md-3">Contact</th>
            <th class="col-md-1 text-center">Active</th>
            <th class="col-md-2 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            {{ Form::open(array('route' => array('config.vendor.post', $id))) }}
            <td>
              {{ Form::text('id', $update->id, array('class' => 'form-control')) }}
            </td>
            <td>
              {{ Form::text('name', $update->name, array('class' => 'form-control')) }}
            </td>
            <td>
              {{ Form::text('contact', $update->contact, array('class' => 'form-control')) }}
            </td>
            <td>
              {{ Form::select('status', array(0 => 'No', 1 => 'Yes'), $update->status, array('class' => 'form-control')) }}
            </td>
            <td class="text-center">
              <button type="submit" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> 
                Add Vendor
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
    <table id="datatable" class="table table-striped">
        <thead>
          <tr>
            <th class="col-md-2">ID</th>
            <th class="col-md-4">Name</th>
            <th class="col-md-3">Contact</th>
            <th class="col-md-1 text-center">Active</th>
            <th class="col-md-2 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($vendors as $key => $vendor)
          <tr>
            <td>{{ $vendor->id }}</td>
            <td>{{ $vendor->name }}</td>
            <td>{{ $vendor->contact }}</td>
            <?php if($vendor->status) $active = 'Yes'; else $active = 'No'; ?>
            <td @if($id == $vendor->id) style="background-color:#FFFFCC"@endif class="text-center">{{ $active }}</td>
            <td class="text-center">
                <a data-id="13" class="btn btn-xs btn-default btn-user-edit" href="{{ route('config.vendor.update', $vendor->id) }}#entryform"><i class="fa fa-pencil fa-fw"></i></a>
                {{ HTML::decode(HTML::link(route('config.vendor.delete', $vendor->id), '<i class="fa fa-times fa-fw"></i>', array('class' => 'btn btn-xs btn-default btn-user-edit', 'data-method' => 'delete', 'data-confirm' => 'Are you sure want to delete this vendor?'))) }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
</section>