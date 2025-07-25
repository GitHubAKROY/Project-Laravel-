@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><span class="panel-title">{{ _lang('Collateral List') }}</span>
					<a class="btn btn-primary btn-xs float-right" href="{{ route('loan_collaterals.create',['loan_id' => $loan_id]) }}">{{ _lang('Add New') }}</a>
				</h4>
				<table id="loan_collaterals_table" class="table table-bordered data-table">
					<thead>
						<tr>
							<th>{{ _lang('Loan ID') }}</th>
							<th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Collateral Type') }}</th>
							<th>{{ _lang('Serial Number') }}</th>
							<th>{{ _lang('Estimated Price') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($loancollaterals as $loancollateral)
						<tr data-id="row_{{ $loancollateral->id }}">
							<td class='loan_id'>{{ $loancollateral->loan_id }}</td>
							<td class='name'>{{ $loancollateral->name }}</td>
							<td class='collateral_type'>{{ $loancollateral->collateral_type }}</td>
							<td class='serial_number'>{{ $loancollateral->serial_number }}</td>
							<td class='estimated_price'>{{ $loancollateral->estimated_price }}</td>
							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{{ _lang('Action') }}
									</button>
									<form action="{{ route('loan_collaterals.destroy', $loancollateral['id']) }}" method="post">
									@csrf
									<input name="_method" type="hidden" value="DELETE">

									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ route('loan_collaterals.edit', $loancollateral['id']) }}" class="dropdown-item dropdown-edit dropdown-edit"><i class="ti-pencil-alt"></i>&nbsp;{{ _lang('Edit') }}</a>
										<a href="{{ route('loan_collaterals.show', $loancollateral['id']) }}" class="dropdown-item dropdown-view dropdown-view"><i class="ti-eye"></i>&nbsp;{{ _lang('View') }}</a>
										<button class="btn-remove dropdown-item" type="submit"><i class="ti-trash"></i>&nbsp;{{ _lang('Delete') }}</button>
									</div>
									</form>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection