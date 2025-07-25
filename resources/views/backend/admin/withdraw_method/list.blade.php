@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<span class="header-title">{{ _lang('Withdraw Methods') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('withdraw_methods.create') }}"><i class="ti-plus"></i>&nbsp;{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="withdraw_methods_table" class="table table-bordered data-table">
					<thead>
					    <tr>
							<th>{{ _lang('Image') }}</th>
						    <th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Currency') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($withdrawmethods as $withdrawmethod)
					    <tr data-id="row_{{ $withdrawmethod->id }}">
							<td class='image'><img class="thumb-sm" src="{{ $withdrawmethod->image != null ? asset('public/uploads/media/'.$withdrawmethod->image) : asset('public/backend/images/no-image.png') }}"/></td>
							<td class='name'>{{ $withdrawmethod->name }}</td>
							<td class='currency'>{{ $withdrawmethod->currency->name }}</td>
							<td class='status'>{!! xss_clean(status($withdrawmethod->status)) !!}</td>

							<td class="text-center">
								<span class="dropdown">
								  <button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  
								  </button>
								  <form action="{{ route('withdraw_methods.destroy', $withdrawmethod['id']) }}" method="post">
									@csrf
									<input name="_method" type="hidden" value="DELETE">

									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ route('withdraw_methods.edit', $withdrawmethod['id']) }}" class="dropdown-item dropdown-edit dropdown-edit"><i class="ti-pencil-alt"></i>&nbsp;{{ _lang('Edit') }}</a>
										<button class="btn-remove dropdown-item" type="submit"><i class="ti-trash"></i>&nbsp;{{ _lang('Delete') }}</button>
									</div>
								  </form>
								</span>
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