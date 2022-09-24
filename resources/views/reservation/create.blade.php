@extends('layouts.client-form')



@if (Auth::guard('client')->user()->approved)
    @section('content')
        <div class="content-wrapper d-flex align-items-center justify-content-center">
            <div class="w-50 card card-info">
                <div class="card-header">
                    <h3 class="card-title">Reservation - Create</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="payment-form" role="form" method="POST" action="{{ route('reservations.store', $room->id) }}">
                    @csrf
                    <div class="card-body">
                        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                        <h3>Info</h3>
                        <div class='form-row'>
                            <div class="col-6 form-group">
                                <label for="accompany_number">Number Of People</label>
                                <input required value="1" type="number" class="form-control" name="accompany_number"
                                    id="accompany_number" placeholder="Enter total number of people">
                            </div>
                            <div class="col-6 form-group">
                                <label for="st_date">Start Date</label>
                                <input required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" type="date"
                                    class="form-control" name="st_date" id="st_date"
                                    placeholder="Enter preferred start date">
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class="col-6 form-group">
                                <label for="price_paid_per_day">Price Per Day</label>
                                <input required readonly value="{{ $room->price }}" type="number" class="form-control"
                                    name="price_paid_per_day" id="price_paid_per_day" placeholder="Price paid per day">
                            </div>
                            <div class="col-6 form-group">
                                <label for="duration">Duration</label>
                                <input required value="1" type="number" class="form-control" name="duration"
                                    id="duration" placeholder="Enter duration of accommodation">
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class="col-4 form-group">
                                <label for="total_price">Total Price</label>
                                <input required readonly value="" type="number" class="form-control"
                                    name="total_price" id="total_price" placeholder="Total price">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <h3>Payment</h3>
                        <div class="form-group">
                            <label for="name_on_card">Name on Card</label>
                            <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="">
                        </div>
                        {{-- <div class='form-group'>
                            <label class='control-label'>Card Number</label>
                            <div class='col-xs-12 form-group card required'>
                                <input autocomplete='off' placeholder="1234 1234 1234 1234" class='form-control card-number'
                                    size='20' type='number' name="card_no">
                            </div>
                            <div class='form-row'>
                                <div class='col-6 form-group expiration required'>
                                    <label class='control-label'>Expiration</label>
                                    <div>
                                        <input class='col-5 d-inline form-control card-expiry-month' placeholder='MM'
                                            size='4' type='number' name="ccExpiryMonth">
                                        <input class='col-5 d-inline form-control card-expiry-year' placeholder='YYYY'
                                            size='4' type='number' name="ccExpiryYear">
                                    </div>
                                </div>
                                <div class='col-6 form-group cvc required'>
                                    <label class='control-label'>CVV</label>
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                        size='4' type='text' name="cvvNumber">
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                                <!-- a Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors -->
                            <div id="card-errors" role="alert"></div>
                        </div>

                        {{-- <button type="submit"  class="button-primary full-width">Complete Order</button> --}}




                        <button type="submit" id="complete-order" class="btn btn-info">Proceed to Payment</button>
                        <div class='form-row mt-3'>
                            {{-- <div class='col-md-12 error form-group hide'>
                                <div class='text-danger'>
                                    Please correct the errors and try again.
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- <div class="card-footer">
                        <h3>Payment</h3>
                        <div id="payment-element">
                            <!--Stripe.js injects the Payment Element-->
                        </div>
                        <button class="btn btn-info" id="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay now</span>
                        </button>
                        <div id="payment-message" class="hidden"></div>
                    </div> --}}
                </form>
            </div>
        </div>
    @endsection
@else
    @section('content')
        <div class="content-wrapper d-flex justify-content-center">
            <div style="height:fit-content;" class="card mt-5">
                <div class="card-header">
                    Pending Approval
                </div>
                <div style="line-height:2.5rem;" class="card-body">
                    <h3 style="font-size:1.3rem; font-weight:bold;" class="card-title">Sorry, You are pending Approval!</h3>
                    <p class="card-text">If your profile is completed, you will be approved very soon.</p>
                </div>
            </div>
        </div>
    @endsection

@endif


@section('extra-js')
    <script>
        const durationField = document.getElementById('duration');
        const totalPriceField = document.getElementById('total_price');
        const pricePerDay = document.getElementById('price_paid_per_day').value;

        function getTotalPrice() {
            totalPriceField.value = durationField.value * pricePerDay
        }

        getTotalPrice()
        durationField.addEventListener('input', () => {
            getTotalPrice()
        })
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function() {
            // Create a Stripe client
            var stripe = Stripe("{{ env('STRIPE_PUBLISHABLE_KEY') }}");

            // Create an instance of Elements
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
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

            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Disable the submit button to prevent repeated clicks
                document.getElementById('complete-order').disabled = true;

                var options = {
                    name: document.getElementById('name_on_card').value,
                    // address_line1: document.getElementById('address').value,
                    // address_city: document.getElementById('city').value,
                    // address_state: document.getElementById('province').value,
                    // address_zip: document.getElementById('postalcode').value
                }

                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;

                        // Enable the submit button
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });

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

        })();
    </script>
@endsection
