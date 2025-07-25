@extends('layouts.guest')

@section('content')
<script src="https://js.stripe.com/v3/"></script>

<div class="row">
	<div class="col-lg-6 offset-lg-3">
		<div class="card">
			<div class="card-header">
				<h4 class="header-title text-center">{{ _lang('Pay Via Stripe') }}</h4>
			</div>
			<div class="card-body">
				<div class="row">  
					<div class="col-md-12">
						<table class="table table-bordered">
							<tr>
								<td>{{ _lang('Package Name') }}</td>
								<td>{{ $package->name }}</td>
							</tr>
							<tr>
								<td>{{ _lang('Cost') }}</td>
								<td>{{ decimalPlace($package->cost, currency_symbol()) }}</td>
							</tr>
							@if($package->discount > 0)
							<tr>
								<td>{{ _lang('Discount') }}</td>
								<td>{{ $package->discount }}%</td>
							</tr>
							@endif
							<tr>
								<td>{{ _lang('Grand Total') }}</td>
								<td>{{ decimalPlace($package->cost - ($package->discount / 100) * $package->cost, currency_symbol()) }}</td>
							</tr>
							<tr>
								<td colspan="2">
								<form action="{{ $data->callback_url }}?user_id={{ $data->user_id }}&slug={{ $slug }}" method="post" id="payment-form">
									@csrf
									<div class="form-row">
										<div id="card-element">
										<!-- A Stripe Element will be inserted here. -->
										</div>

										<!-- Used to display form errors. -->
										<div id="card-errors" role="alert"></div>
									</div>

									<div class="form-row">
										<button class="btn btn-primary btn-block" id="pay_now">{{ _lang('Pay Now') }}</button>
									</div>
								</form>
								</td>
							</tr>					
						</table>
					</div>
				</div>
			</div>
		</div>
  	</div>
</div>
@endsection

@section('js-script')
<script>
// Create a Stripe client.
var stripe = Stripe("{{ $gateway->parameters->publishable_key }}");

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  document.getElementById('pay_now').disabled = true;

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
      document.getElementById('pay_now').disabled = false;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>
@endsection