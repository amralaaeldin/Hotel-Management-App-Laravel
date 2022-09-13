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
                <form role="form" method="POST" action="{{ route('reservations.store', $room->id) }}">
                    @csrf
                    <div class="card-body">
                        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                        <h3>Info</h3>
                        <div class="form-group">
                            <label for="accompany_number">Number Of People</label>
                            <input required value="1" type="number" class="form-control" name="accompany_number"
                                id="accompany_number" placeholder="Enter total number of people">
                        </div>
                        <div class="form-group">
                            <label for="st_date">Start Date</label>
                            <input required value="{{ date('Y-m-d') }}" type="date" class="form-control" name="st_date"
                                id="st_date" placeholder="Enter preferred start date">
                        </div>
                        <div class="form-group">
                            <label for="price_paid_per_day">Price Per Day</label>
                            <input required readonly value="{{ $room->price }}" type="number" class="form-control"
                                name="price_paid_per_day" id="price_paid_per_day" placeholder="Price paid per day">
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input required value="1" type="number" class="form-control" name="duration"
                                id="duration" placeholder="Enter duration of accommodation">
                        </div>
                        <div class="form-group">
                            <label for="total_price">Total Price</label>
                            <input required readonly value="" type="number" class="form-control" name="total_price"
                                id="total_price" placeholder="Total price">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <h3>Payment</h3>
                        <button type="submit" class="btn btn-info">Confirm Payment</button>
                    </div>
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
@endsection
