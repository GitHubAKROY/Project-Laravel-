@extends('layouts.app')

@section('content')
@php $permissions = permission_list(); @endphp
<div class="row">
	@if (in_array('dashboard.total_customer_widget', $permissions))
	<div class="col-xl-3 col-md-6">
		<a href="{{ route('members.index') }}">
			<div class="card mb-4 dashboard-card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Total Members') }}</h5>
							<h4 class="pt-1 mb-0"><b>{{ $total_customer }}</b></h4>
						</div>
						<div class="ml-2 text-center">
							<i class="fas fa-users bg-success text-white"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	@endif

	@if (in_array('dashboard.deposit_requests_widget',$permissions))
	<div class="col-xl-3 col-md-6">
		<a href="{{ route('deposit_requests.index') }}">
			<div class="card mb-4 dashboard-card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Deposit Requests') }}</h5>
							<h4 class="pt-1 mb-0"><b>{{ request_count('deposit_requests') }}</b></h4>
						</div>
						<div class="ml-2 text-center">
							<i class="fas fa-calendar-alt bg-info text-white"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	@endif

	@if (in_array('dashboard.withdraw_requests_widget',$permissions))
	<div class="col-xl-3 col-md-6">
		<a href="{{ route('withdraw_requests.index') }}">
			<div class="card mb-4 dashboard-card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Withdraw Requests') }}</h5>
							<h4 class="pt-1 mb-0"><b>{{ request_count('withdraw_requests') }}</b></h4>
						</div>
						<div class="ml-2 text-center">
							<i class="fas fa-coins bg-primary text-white"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	@endif

	@if (in_array('dashboard.loan_requests_widget',$permissions))
	<div class="col-xl-3 col-md-6">
		<a href="{{ route('loans.index') }}">
			<div class="card mb-4 dashboard-card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Pending Loans') }}</h5>
							<h4 class="pt-1 mb-0"><b>{{ request_count('pending_loans') }}</b></h4>
						</div>
						<div class="ml-2 text-center">
							<i class="fas fa-dollar-sign bg-danger text-white"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	@endif
</div>

<div class="row">
	@if (in_array('dashboard.expense_overview_widget',$permissions))
	<div class="col-lg-4 col-md-5 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center">
				<span>{{ _lang('Expense Overview').' - '.date('M Y') }}</span>
			</div>
			<div class="card-body">
				<canvas id="expenseOverview"></canvas>
			</div>
		</div>
	</div>
	@endif

	@if (in_array('dashboard.deposit_withdraw_analytics',$permissions))
	<div class="col-lg-8 col-md-7 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center">
				<span>{{ _lang('Deposit & Withdraw Analytics').' - '.date('Y')  }}</span>
				<select class="filter-select ml-auto py-0 auto-select" data-selected="{{ base_currency_id() }}">
					@foreach(\App\Models\Currency::where('status',1)->get() as $currency)
					<option value="{{ $currency->id }}" data-symbol="{{ currency_symbol($currency->name) }}">{{ $currency->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="card-body">
				<canvas id="transactionAnalysis"></canvas>
			</div>
		</div>
	</div>
	@endif
</div>

@if (in_array('dashboard.active_loan_balances',$permissions))
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card mb-4">
			<div class="card-header">
				{{ _lang('Active Loan Balances') }}
			</div>
			<div class="card-body px-0 pt-0">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="text-nowrap pl-4">{{ _lang('Currency') }}</th>
								<th class="text-nowrap">{{ _lang('Applied Amount') }}</th>
								<th class="text-nowrap">{{ _lang('Paid Amount') }}</th>
								<th class="text-nowrap">{{ _lang('Due Amount') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(count($loan_balances) == 0)
								<tr>
									<td colspan="4"><p class="text-center">{{ _lang('No Data Available') }}</p></td>
								</tr>
							@endif
							@foreach($loan_balances as $loan_balance)
							<tr>
								<td class="pl-4">{{ $loan_balance->currency->name }}</td>
								<td>{{ decimalPlace($loan_balance->total_amount, currency($loan_balance->currency->name)) }}</td>
								<td>{{ decimalPlace($loan_balance->total_paid, currency($loan_balance->currency->name)) }}</td>
								<td>{{ decimalPlace($loan_balance->total_amount - $loan_balance->total_paid, currency($loan_balance->currency->name)) }}</td>
							</tr>
							@endforeach	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@if (in_array('dashboard.due_loan_list',$permissions))
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card mb-4">
			<div class="card-header">
				{{ _lang('Due Loan Payments') }}
			</div>
			<div class="card-body px-0 pt-0">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="text-nowrap pl-4">{{ _lang('Loan ID') }}</th>
								<th class="text-nowrap">{{ _lang('Member No') }}</th>
								<th class="text-nowrap">{{ _lang('Member') }}</th>
								<th class="text-nowrap">{{ _lang('Last Payment Date') }}</th>
								<th class="text-nowrap">{{ _lang('Due Repayments') }}</th>
								<th class="text-nowrap text-right pr-4">{{ _lang('Total Due') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(count($due_repayments) == 0)
								<tr>
									<td colspan="6"><p class="text-center">{{ _lang('No Data Available') }}</p></td>
								</tr>
							@endif

							@foreach($due_repayments as $repayment)
							<tr>
								<td class="pl-4">{{ $repayment->loan->loan_id }}</td>
								<td>{{ $repayment->loan->borrower->member_no }}</td>
								<td>{{ $repayment->loan->borrower->name }}</td>
								<td class="text-nowrap">{{ $repayment->repayment_date }}</td>
								<td class="text-nowrap">{{ $repayment->total_due_repayment }}</td>
								<td class="text-nowrap text-right pr-4">{{ decimalPlace($repayment->total_due, currency($repayment->loan->currency->name)) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@if (in_array('dashboard.recent_transaction_widget',$permissions))
<div class="row">
	<div class="col-lg-12">
		<div class="card mb-4">
			<div class="card-header">
				{{ _lang('Recent Transactions') }}
			</div>
			<div class="card-body px-0 pt-0">
				<div class="table-responsive">
					<table class="table table-bordered">
					<thead>
					    <tr>
						    <th class="pl-4">{{ _lang('Date') }}</th>
							<th>{{ _lang('Member') }}</th>
							<th class="text-nowrap">{{ _lang('Account Number') }}</th>
							<th>{{ _lang('Amount') }}</th>
							<th class="text-nowrap">{{ _lang('Debit/Credit') }}</th>
							<th>{{ _lang('Type') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					@if(count($recent_transactions) == 0)
						<tr>
							<td colspan="8"><p class="text-center">{{ _lang('No Data Available') }}</p></td>
						</tr>
					@endif
					@foreach($recent_transactions as $transaction)
						@php
						$symbol = $transaction->dr_cr == 'dr' ? '-' : '+';
						$class  = $transaction->dr_cr == 'dr' ? 'text-danger' : 'text-success';
						@endphp
						<tr>
							<td class="text-nowrap pl-4">{{ $transaction->trans_date }}</td>
							<td>{{ $transaction->member->name }}</td>
							<td>{{ $transaction->account->account_number }}</td>
							<td><span class="text-nowrap {{ $class }}">{{ $symbol.' '.decimalPlace($transaction->amount, currency($transaction->account->savings_type->currency->name)) }}</span></td>
							<td>{{ strtoupper($transaction->dr_cr) }}</td>
							<td>{{ ucwords(str_replace('_',' ',$transaction->type)) }}</td>
							<td>{!! xss_clean(transaction_status($transaction->status)) !!}</td>
							<td class="text-center"><a href="{{ route('transactions.show', $transaction->id) }}" target="_blank" class="btn btn-outline-primary btn-xs"><i class="ti-arrow-right"></i>&nbsp;{{ _lang('View') }}</a></td>
						</tr>
					@endforeach
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@endsection

@section('js-script')
<script src="{{ asset('public/backend/plugins/chartJs/chart.min.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/dashboard.js') }}"></script>
@endsection
