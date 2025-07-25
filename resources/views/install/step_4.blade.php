@extends('install.layout')

@section('content')
<div class="card">
	<div class="card-header bg-dark text-white text-center">System Settings</div>
	<div class="card-body">

		<form action="{{ url('install/finish') }}" method="post" autocomplete="off">
			@csrf
					
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">Company Name</label>						
				<input type="text" class="form-control" name="company_name" required>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">Site Title</label>						
				<input type="text" class="form-control" name="site_title" required>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">Phone</label>						
				<input type="text" class="form-control" name="phone" required>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">Email</label>						
				<input type="text" class="form-control" name="email" required>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">Timezone</label>						
				<select class="form-control select2" name="timezone" required>
				<option value="">Select One</option>
				{{ create_timezone_option() }}
				</select>
			  </div>
			</div>
			
			<div class="col-md-12">
				<button type="submit" id="next-button" class="btn btn-install">Finish</button>
		    </div>
		</form>
	</div>
</div>
@endsection

