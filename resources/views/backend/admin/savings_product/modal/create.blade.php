<form method="post" class="ajax-submit" autocomplete="off" action="{{ route('savings_products.store') }}" enctype="multipart/form-data">
	@csrf
	<div class="row px-2">
	    <div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Name') }}</label>						
				<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Account Number Prefix') }}</label>						
				<input type="text" class="form-control" name="account_number_prefix" value="{{ old('account_number_prefix') }}">
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Starting Account Number') }}</label>						
				<input type="number" class="form-control" name="starting_account_number" value="{{ old('starting_account_number') }}" required>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Currency') }}</label>						
				<select class="form-control select2 auto-select" data-selected="{{ old('currency_id') }}" name="currency_id" required>
					<option value="">{{ _lang('Select One') }}</option>
					@foreach(\App\Models\Currency::where('status', 1)->get() as $currency)
					<option value="{{ $currency->id }}">{{ $currency->full_name }} ({{ $currency->name }})</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Yearly Interest Rate') }} (%)</label>						
				<input type="text" class="form-control float-field" name="interest_rate" value="{{ old('interest_rate') }}" >
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Interest Period') }}</label>						
				<select class="form-control auto-select" data-selected="{{ old('interest_period') }}" name="interest_period" >
					<option value="">{{ _lang('Select One') }}</option>
					<option value="1">{{ _lang('Every 1 month') }}</option>
					<option value="3">{{ _lang('Every 3 months') }}</option>
					<option value="6">{{ _lang('Every 6 months') }}</option>
					<option value="12">{{ _lang('Every 12 months') }}</option>
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Interest Method') }}</label>						
				<select class="form-control" name="interest_method" >
					<option value="daily_outstanding_balance">{{ _lang('Daily Outstanding Balance') }}</option>
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Minimum Balance for Interest') }}</label>						
				<input type="number" class="form-control" name="min_bal_interest_rate" value="{{ old('min_bal_interest_rate') }}">
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Allow Withdraw') }}</label>						
				<select class="form-control auto-select" data-selected="{{ old('allow_withdraw', 1) }}" name="allow_withdraw"  required>
					<option value="">{{ _lang('Select One') }}</option>
					<option value="1">{{ _lang('Yes') }}</option>
					<option value="0">{{ _lang('No') }}</option>
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Minimum Deposit Amount') }}</label>						
				<input type="number" class="form-control" name="minimum_deposit_amount" value="{{ old('minimum_deposit_amount', 0) }}" required>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Minimum Account Balance') }}</label>						
				<input type="number" class="form-control" name="minimum_account_balance" value="{{ old('minimum_account_balance', 0) }}" required>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Maintenance Fee') }}</label>						
				<input type="number" class="form-control" name="maintenance_fee" value="{{ old('maintenance_fee', 0) }}" required>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Maintenance Fee will be deduct') }}</label>						
				<select class="form-control auto-select" data-selected="{{ old('maintenance_fee_posting_period') }}" name="maintenance_fee_posting_period" >
					<option value="">{{ _lang('Select One') }}</option>
					@for($f=1; $f< 13; $f++)
						<option value="{{ $f }}">{{ date('F', strtotime('2022-'.$f.'-01')) }}</option>
					@endfor
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">{{ _lang('Auto Create After Signup') }}</label>						
				<select class="form-control auto-select" data-selected="{{ old('auto_create', 0) }}" name="auto_create" required>
					<option value="0">{{ _lang('No') }}</option>
					<option value="1">{{ _lang('Yes') }}</option>
				</select>
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label">{{ _lang('Status') }}</label>						
				<select class="form-control auto-select" data-selected="{{ old('status',1) }}" name="status" required>
					<option value="1">{{ _lang('Active') }}</option>
					<option value="0">{{ _lang('Deactivate') }}</option>
				</select>
			</div>
		</div>
	
		<div class="col-md-12 mt-2">
		    <div class="form-group">
			    <button type="submit" class="btn btn-primary"><i class="ti-check-box"></i>&nbsp;{{ _lang('Submit') }}</button>
		    </div>
		</div>
	</div>
</form>
