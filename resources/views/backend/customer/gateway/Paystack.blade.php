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
                        <button type="button" class="btn btn-primary btn-block" onclick="payWithPaystack()"> {{ _lang('Pay Now') }}</button>
                    </div>
                </div>
            </div>
	    </div>
    </div>
</div>
@endsection

@section('js-script')
<script src="https://js.paystack.co/v1/inline.js"></script>

<script type="text/javascript">

function payWithPaystack(e) {
  let handler = PaystackPop.setup({
    key: '{{ $deposit->gateway->parameters->paystack_public_key }}',
    email: '{{ $deposit->member->email }}',
    amount: {{ ($gatewayAmount * 100) }},
    currency: '{{ $deposit->gateway->currency }}',
    firstname: '{{ $deposit->member->first_name.' '.$deposit->member->last_name }}',
    ref: '{{ uniqid().time() }}',
    callback: function(response){
    	window.location = "{{ $data->callback_url }}?reference=" + response.reference + "&deposit_id={{ $deposit->id }}";
    }
  });
  handler.openIframe();
}

</script>
@endsection