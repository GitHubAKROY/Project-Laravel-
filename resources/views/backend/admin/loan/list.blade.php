@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Loan List') }}</span>
				<div class="ml-auto d-flex align-items-center">
					<select name="status" class="select-filter filter-select auto-select mr-2" data-selected="{{ $status }}">
						<option value="">{{ _lang('All') }}</option>
						<option value="0">{{ _lang('Pending') }}</option>
						<option value="1">{{ _lang('Approved') }}</option>
						<option value="2">{{ _lang('Completed') }}</option>
					</select>
					<a class="btn btn-primary btn-xs" href="{{ route('loans.create') }}"><i class="ti-plus"></i>&nbsp;{{ _lang('Add New') }}</a>
				</div>
			</div>

			<div class="card-body">
				<table id="loans_table" class="table table-bordered">
					<thead>
						<tr>
							<th>{{ _lang('Loan ID') }}</th>
							<th>{{ _lang('Loan Product') }}</th>
							<th>{{ _lang('Borrower') }}</th>
							<th>{{ _lang('Member No') }}</th>
							<th>{{ _lang('Release Date') }}</th>
							<th>{{ _lang('Applied Amount') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script src="{{ asset('public/backend/assets/js/datatables/loans.js?v=1.0') }}"></script>
@endsection