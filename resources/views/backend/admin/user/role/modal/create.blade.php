<form method="post" class="ajax-screen-submit" autocomplete="off" action="{{ route('roles.store') }}" enctype="multipart/form-data">
	@csrf

    <div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Name') }}</label>
			<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Description') }}</label>
			<textarea class="form-control" name="description">{{ old('description') }}</textarea>
		</div>
	</div>


	<div class="col-md-12">
	    <div class="form-group">
	        <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		    <button type="submit" class="btn btn-primary"><i class="ti-check-box"></i>&nbsp;{{ _lang('Save') }}</button>
	    </div>
	</div>
</form>
