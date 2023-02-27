<?php
namespace App\Http\Controllers;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendEmailsController as SendEmails;
use App\Http\Controllers\NavigationController as Nav;
use Illuminate\Http\Request;
class TransactionsController extends Controller
{
    // This function updates the status of a pending payment to paid followed by processing a successful credit card charge.
    public function update(SendEmails $sendemails, Request $request, Nav $nav, $uniqid)
    {
        $reservation = \App\Reservations::where('uniqid', $uniqid)->first();
        \Stripe\Stripe::setApiKey("sk_test_JLRmR8RbiLlzndG6af57IqGh");
        if ($reservation->customer_profile_id !== '') {
            //if the customer already has a payment profile saved in the database.
            $stripe_customer_id = $reservation->customer_profile_id;
        } //$reservation->customer_profile_id !== ''
        else {
            //the customer did not have a payment profile saved so creating it first time.
            $token = $request->get('stripeToken');
            try {
                $stripe_customer    = \Stripe\Customer::create(array(
                    "card" => $token,
                    "description" => $reservation->firstname . ' ' . $reservation->lastname,
                    "email" => $reservation->email
                ));
                //saving the customer profile id to database and assign the value to variable for charging credit card.
                $stripe_customer_id = $reservation->customer_profile_id = $stripe_customer->id;
                $reservation->save();
                @$success .= "Your customer profile has been created<br/>";
            }
            catch (\Stripe\Error\Card $e) {
                @$error .= $e->getMessage();
            }
            catch (\Stripe\Error\InvalidRequest $e) {
                @$error .= $e->getMessage();
            }
            catch (\Stripe\Error\Authentication $e) {
                @$error .= $e->getMessage();
            }
            catch (\Stripe\Error\ApiConnection $e) {
                @$error .= $e->getMessage();
            }
            catch (\Stripe\Error\Error $e) {
                @$error .= $e->getMessage();
            }
            catch (Exception $e) {
                @$error .= $e->getMessage();
            }
        }
        if ($stripe_customer_id) {
            //begin to charge the credit card based on customer payment profile id.
            $payment_id  = $request->get('payment_id');
            $transaction = \App\Transactions::where('id', $payment_id)->first();
            $amount      = $transaction->amount;
            if ($transaction->status == 'paid') {
                @$error .= 'This payment of $' . $amount . ' is already completed.<br/>';
            } //$transaction->status == 'paid'
            else {
                try {
                    $charge                           = \Stripe\Charge::create(array(
                        "amount" => ceil($amount * 100),
                        "currency" => "usd",
                        "customer" => $stripe_customer_id
                    ));
                    $transaction                      = \App\Transactions::where('id', $payment_id)->first();
                    $transaction->status              = 'paid';
                    $transaction->date_paid           = date('Y-m-d H:i:s');
                    $transaction->customer_profile_id = $stripe_customer_id;
                    $transaction->save();
                    @$success .= 'You have successfully paid the amount of $' . $amount . '<br />';
                    $reservation->status = 'booked';
                    $reservation->save();
                    //Will send emails later if charged = true.
                    $charged = true;
                }
                catch (\Stripe\Error\Card $e) {
                    @$error .= $e->getMessage();
                }
                catch (\Stripe\Error\InvalidRequest $e) {
                    @$error .= $e->getMessage();
                }
                catch (\Stripe\Error\Authentication $e) {
                    @$error .= $e->getMessage();
                }
                catch (\Stripe\Error\ApiConnection $e) {
                    @$error .= $e->getMessage();
                }
                catch (\Stripe\Error\Error $e) {
                    @$error .= $e->getMessage();
                }
                catch (Exception $e) {
                    @$error .= $e->getMessage();
                }
            }
        } //$stripe_customer_id
        else {
            @$error .= 'Failure with stripe customer profile id.<br/>';
        }
        if (@$charged === true) {
            $sent = $sendemails->reservationSuccess($reservation->id);
            $sent === true ? @$success .= 'Please check your email for details.<br/>' : @$error .= 'There was an error sending email.<br/>';
            $sent = $sendemails->notifyOwner($reservation->id);
            $sent = $sendemails->notifyHousekeeper($reservation->id);
            $sent = $sendemails->notifyVendor($reservation->id);
        } //$charged === true
        if (empty($error)) {
            //Shows success message to customer.
            return redirect('reservation/' . $uniqid . '/payment/success')->withErrors(@$error)->withMessage(@$success);
        } //empty($error)
        return redirect('reservation/' . $uniqid . '/payment')->withErrors(@$error)->withMessage(@$success);
    }
}