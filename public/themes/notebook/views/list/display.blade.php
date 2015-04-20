<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Project Details</h4>
    </div>
    <div class="modal-body clear">
        
        <div class="vbox">
          <label class="col-sm-4 text-left">Project Type:</label>
          <label class="col-sm-8">{{ $project->project_type or '-' }}</label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left bold">Vendor Type:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $vendor_type = VendorType::find($project->vendor_type); ?>
            {{ $vendor_type->type or '-' }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Method:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $method = Method::find($project->method); ?>
            {{ $method->method or '-' }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Company:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $company = Company::find($project->company); ?>
            {{ $company->company or '-' }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Vendor Name:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $vendorName = Vendor::find($project->vendor_id); ?>
            {{ $vendorName->name or 'Vendor ID #: ' . $project->vendor_id }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Vendor Status:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $vendor_status = VendorStatus::find($project->vendor_status); ?>
            {{ $vendor_status->status or '-' }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">P.O/W.O/LOA No.:</label>
          <label class="col-sm-8">{{ $project->project_number or '-' }}
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Scope of Work:</label>
          <label class="col-sm-8">{{ $project->scope_of_work or '-' }} </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Buyer:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $buyerName = User::find($project->buyer_id); ?>
            {{ $buyerName->first_name or '-' }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Contract Period:</label>
          <label class="col-sm-8">{{ $project->contract_period or '-' }} </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">Issuance Date:</label>
          <label class="col-sm-8">{{ dateToString($project->issuance_date) }} </label>
        </div>

        {{-- <div class="vbox">
          <label class="col-sm-4 text-left">Est. Completion Date:</label>
          <label class="col-sm-8">{{ stampToPicker($project->estimate_date) }} </label>
        </div> --}}

        <div class="vbox">
          <label class="col-sm-4 text-left">Actual Completion Date:</label>
          <?php
          if($project->delay == 1) {
            $actual_date = '<span style="text-decoration:line-through">' . dateToString($project->delay_date).'</span> ' . dateToString($project->actual_date) . '&nbsp;&nbsp;<a href="#" class="label bg-danger">Project Delayed</a>';

          } else $actual_date = dateToString($project->actual_date);
          ?>
          <label class="col-sm-8">{{ $actual_date }} </label>
        </div>

        @if($project->delay == 1)
        <div class="vbox">
          <label class="col-sm-4 text-left">Delay Reason:</label>
          <label class="col-sm-8">{{{ $project->delay_reason }}} </label>
        </div>
        @endif

          <label><h4>Evaluators' Email Address</h4></label>

        <div class="vbox">
          <label class="col-sm-4 text-left">1. Project Manager:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $pmName = User::find($project->project_manager_id); ?>
            {{ $pmName->first_name or '-' }}
          </label>
        </div>

        <div class="vbox">
          <label class="col-sm-4 text-left">2. End User:</label>
          <label class="col-sm-8">
            <?php if(isset($project)) $endName = User::find($project->end_user_id); ?>
            {{ $endName->first_name or '-' }}
          </label>
        </div>

    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
      <a href="{{ route('list.'.strtolower($vendor_type->type).'.id', $project->id) }}" class="btn btn-primary">{{ $vendor_type->type }} Performance Evaluation Survey</a>
    </div>
  </div>