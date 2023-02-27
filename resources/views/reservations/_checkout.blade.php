<!-- 
1. Included as partial file on the payment page after creating a reservation
2. Has a checkout form
3. Lets you enter your credit card details for the first time
OR
4. Lets you proceed with payment profile already created with the system
-->
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Help!</strong>
    <br/>Demo Card No.
    <br/>4242424242424242
  </div>

  
<?php \Stripe\Stripe::setApiKey( "sk_test_JLRmR8RbiLlzndG6af57IqGh" ); ?>
<?php
  if(null!=$reservation->customer_profile_id){

  $stripe_customer = \Stripe\Customer::retrieve($reservation->customer_profile_id);
  $brand = $stripe_customer->sources->data[0]->brand;
  $card = '************'.$stripe_customer->sources->data[0]->last4;
  $cvc = '***';
  $exp_month = sprintf("%02d", $stripe_customer->sources->data[0]->exp_month);
  $exp_year = $stripe_customer->sources->data[0]->exp_year;
  
  }
  ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
  // This identifies your website in the createToken call below
  Stripe.setPublishableKey('pk_test_j8dziKB3sijCal6hlkXq909b');
  // ...
</script>
<form action="" method="POST" id="payment-form">
  <span class="payment-errors"></span>
  <div class="form-group">
    <label class="col-md-4">
    <span>Card#</span>
    </label>
    <div class="col-md-8">
      <input type="text" class="form-control" size="20" data-stripe="number" value="{{@$card}}" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-4">
    <span>CVC</span>
    </label>
    <div class="col-md-8">
      <div class="col-md-6">
      <input type="text" class="form-control input-sm" size="4" data-stripe="cvc" value="{{@$cvc}}" />
      </div>

    </div>
  </div>
  <div class="form-group">
    <label class="col-md-4">
    <span>Expiration</span>
    </label>
    <div class="col-md-8">
      <div class="col-md-4">
      <input type="text" class="form-control input-sm" size="2" data-stripe="exp-month" value="{{@$exp_month}}" />
      </div>
      <div class="col-md-1">
      <span> / </span>
      </div>
      <div class="col-md-5">
      <input type="text" class="form-control input-sm" size="4" data-stripe="exp-year" value="{{@$exp_year}}" />
      </div>
    </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-8">
        (MM/YYYY)
        </div>
  </div>
  <div class="form-group text-center" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="payment_id" value="<?php echo $payment_id ?>">
    <button type="submit" class="btn btn-warning">{{trans('eminent.reservation.pay-now')}}</button>
  </div>
  
</form>

  
<script>
  jQuery(function($) {
    $('#payment-form').submit(function(event) {
  
      var $form = $(this);
  
      // Disable the submit button to prevent repeated clicks
      $form.find('button').prop('disabled', true);
  
      Stripe.card.createToken($form, stripeResponseHandler);
  
      // Prevent the form from submitting with the default action
      return false;
    });
  });
  
  function stripeResponseHandler(status, response) {
    var $form = $('#payment-form');
  
    if (response.error) {
      // Show the errors on the form
      $form.find('.payment-errors').text(response.error.message);
      $form.find('button').prop('disabled', false);
    } else {
      // response contains id and card, which contains additional card details
      var token = response.id;
      // Insert the token into the form so it gets submitted to the server
      $form.append($('<input type="hidden" name="stripeToken" />').val(token));
      // and submit
      $form.get(0).submit();
    }
  };
  
</script>


<h2>Or Pay with Paypal</h2>

<form class="paypal" action="http://noble-soft.com/eminent/demo/public/paypal/payments.php" method="post" id="paypal_form" target="_blank">
    <input type="hidden" name="cmd" value="_xclick" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="lc" value="UK" />
    <input type="hidden" name="currency_code" value="USD" />
    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
    
    <input type="hidden" name="item_name" value="<?= $reservation->property->title ?>"  />
    <input type="hidden" name="first_name" value="<?= $reservation->firstname ?>"  />
    <input type="hidden" name="last_name" value="<?= $reservation->lastname ?>"  />
    <input type="hidden" name="payer_email" value="<?= $reservation->email ?>"  />
    <input type="hidden" name="item_number" value="<?php echo $payment_id ?>" / >
    <input type="hidden" name="amount" value="<?php echo $amount_payable ?>" / >
    <input type="submit" name="submit" value="Pay with Paypal"/>
  </form>