@extends('install.layout')

@section('content')

<div class="card">
	<div class="card-header bg-dark text-white text-center">Database Settings</div>
	<div class="card-body">
	   <div class="col-md-12">
			@if (\Session::has('error'))
			  <div class="alert alert-danger">
				<span>{{ \Session::get('error') }}</span>
			  </div>
			@endif
		    <form action="{{ url('install/process_install') }}" method="post" autocomplete="off">
			   @csrf
			  <div class="form-group">
				<label>Hostname:</label>
				<input type="text" class="form-control" value="{{ old('hostname', 'localhost') }}" name="hostname" id="hostname">
			  </div>

			  <div class="form-group">
				<label>Database:</label>
				<input type="text" class="form-control" name="database" id="database" value="{{ old('database') }}">
			  </div>

			  <div class="form-group">
				<label>Username:</label>
				<input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}">
			  </div>

			  <div class="form-group">
				<label>Password:</label>
				<input type="password" class="form-control" name="password" value="{{ old('password') }}">
			  </div>

			  <button type="submit" id="next-button" class="btn btn-install">Next</button>
		    </form>
	    </div>
	</div>
</div>
@endsection

@section('js-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#next-button').attr('disabled', true);

            $('#hostname, #username, #database').keyup(function() {
                inputCheck();
            });
        });

        function inputCheck() {
            hostname = $('#hostname').val();
            username = $('#username').val();
            database = $('#database').val();

            if (hostname != '' && username != '' && database != '') {
                $('#next-button').attr('disabled', false);
            } else {
                $('#next-button').attr('disabled', true);
            }
        }
    </script>
@stop
