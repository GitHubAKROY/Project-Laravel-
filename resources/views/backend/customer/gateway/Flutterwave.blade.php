@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-6 offset-lg-3">
		<div class="card">
			<div class="card-header">
				<h4 class="header-title text-center">{{ _lang('Payment Confirm') }}</h4>
			</div>
			<div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">{{ _lang('Amount') }}</label>
                    <input type="text" class="form-control" name="code" value="{{ decimalPlace($gatewayAmount - $charge, currency($deposit->gateway->currency)) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">{{ _lang('Charge') }}</label>
                    <input type="text" class="form-control" name="code" value="{{ decimalPlace($charge, currency($deposit->gateway->currency)) }}" readonly>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">{{ _lang('Total') }}</label>
                    <input type="text" class="form-control" name="code" value="{{ decimalPlace($gatewayAmount, currency($deposit->gateway->currency)) }}" readonly>
                </div>
            </div>

            <div class="col-md-12">
                <form>
                    <script src="https://checkout.flutterwave.com/v3.js"></script>
                    <button type="button" class="btn btn-primary btn-block" onClick="makePayment()">{{ _lang('Pay Now') }}</button>
                </form>
            </div>
        </div>
			</div>
		</div>
  </div>
</div>
@endsection

@section('js-script')
<script>
  function makePayment() {
    FlutterwaveCheckout({
      public_key: "{{ $deposit->gateway->parameters->public_key }}",
      tx_ref: "{{ uniqid().time() }}",
      amount: {{ $gatewayAmount }},
      currency: "{{ $deposit->gateway->currency }}",
      customer: {
        email: "{{ $deposit->member->email }}",
        phone_number: "{{ $deposit->member->country_code.$deposit->member->mobile }}",
        name: "{{ $deposit->member->first_name.' '.$deposit->member->last_name }}",
      },
      callback: function (data) {
        if(data.status == 'successful'){
            window.location.href = "{{ $data->callback_url }}?transaction_id=" + data.transaction_id + "&deposit_id={{ $deposit->id }}";
        }else{
            window.location.href = "{{ $data->callback_url }}?deposit_id={{ $deposit->id }}";
        }
      },
      onclose: function() {},
      customizations: {
        title: "{{ get_option('site_title') }}",
        description: "{{ _lang('Deposit via Flutterwave') }}",
        //logo: "{{ get_logo() }}",
      },
    });
  }
</script>
@endsection