@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Get Your Quote!</div>

                    <div class="card-body">
                        <pre id="quote-results"></pre>
                        <form id="quoteForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="start" class="col-md-4 col-form-label text-md-right">start date</label>

                                <div class="col-md-6">
                                    <input id="start" type="date" class="form-control" name="start" value="" required
                                           autocomplete="start">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end" class="col-md-4 col-form-label text-md-right">end date</label>

                                <div class="col-md-6">
                                    <input id="end" type="date" class="form-control" name="end" value="" required
                                           autocomplete="end">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ages" class="col-md-4 col-form-label text-md-right">ages</label>

                                <div class="col-md-6">
                                    <input id="ages" type="text" class="form-control" name="ages" value="" required
                                           autocomplete="ages">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="country" class="col-md-4 col-form-label text-md-right"> select
                                    location </label>
                                <div class="col-md-6">
                                    <select class="form-control custom-select" name="country">
                                        <option value disabled>select location</option>
                                        @foreach( $countries as $country)
                                            <option value={{$country}}>{{$country}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="currency" class="col-md-4 col-form-label text-md-right"> select
                                    currency </label>
                                <div class="col-md-6">
                                    <select class="form-control custom-select" name="currency">
                                        <option value disabled>select currency</option>
                                        @foreach( $currencies as $key=>$val)
                                            <option value={{$key}}>{{$key}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="quote-button" class="btn btn-primary">
                                        Quote
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    var currentJWTToken = null
    window.onload = function () {
        getJWTToken()
    }

    document.addEventListener("DOMContentLoaded", function (e) {
        document.getElementById("quote-button").addEventListener('click', function (event) {
            postQuotation()
            event.preventDefault()
        })
    })

    function jwtReqListener() {
        const resp = JSON.parse(this.response)
        currentJWTToken = resp.token
    }

    // get a JWT token to auth with the backend api.
    // this user already exists and would have been registered previously.
    function getJWTToken() {
        const payload = new FormData()
        payload.append("email", "jsnow@world.com")
        var jwtAuthRequest = new XMLHttpRequest()
        jwtAuthRequest.addEventListener("load", jwtReqListener)
        jwtAuthRequest.open("POST", "http://localhost/api/auth")
        jwtAuthRequest.send(payload)
    }


    //updates the pre tag to show the result of the quote.
    function quoteListener() {
        document.getElementById("quote-results").innerHTML = this.responseText
    }

    function serializeFormDataHelper(formData) {
        var object = {}
        formData.forEach((value, key) => object[key] = value);
        return JSON.stringify(object)
    }

    function postQuotation() {
        if (currentJWTToken) {
            var quotationRequest = new XMLHttpRequest()
            quotationRequest.addEventListener("load", quoteListener)
            quotationRequest.open("POST", "http://localhost/api/quotation")
            quotationRequest.setRequestHeader("Content-Type", "application/json")
            quotationRequest.setRequestHeader("Authorization", "Bearer " + currentJWTToken)
            const quoteForm = document.forms.quoteForm
            const payload = serializeFormDataHelper(new FormData(quoteForm))
            quotationRequest.send(payload)
        }
    }

</script>
