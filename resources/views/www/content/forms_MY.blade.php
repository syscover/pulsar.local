@extends('layouts.default')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="{{ asset('packages/syscover/forms/vendor/jquery.forms/jquery.forms.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#customerForm').forms({
                id: 1, // Aquí el ID del registro del formulario que has creada en la sección Forms -> Forms
                debug:  true,
                ajax:   true,
                fields: {
                    name: 'name',
                    surname: 'surname',
                    email: 'email',
                    subject: 'subject'
                }
            }, function(response){

                if(response.success)
                {
                    // form submit successful
                }

            }).on('forms:submit', function(event){
                // here check your form, if are any error to stop execution use event.preventDefault();

            }).on('forms:error', function(event, error) {
                console.log(event);
                console.log(error);
            });
        });
    </script>
@stop

@section('content')
<div class="container">
    <form id="customerForm">
        <div class="form-group">
            <label for="nameCustomer">Name</label>
            <input type="text" class="form-control" id="nameCustomer" placeholder="Name" name="name">
        </div>
        <div class="form-group">
            <label for="surnameCustomer">Surname</label>
            <input type="text" class="form-control" id="surnameCustomer" placeholder="Surname" name="surname">
        </div>
        <div class="form-group">
            <label for="emailCustomer">Email address</label>
            <input type="email" class="form-control" id="emailCustomer" placeholder="Email" name="email">
        </div>
        <div class="form-group">
            <label for="subjectCustomer">Subject</label>
            <input type="text" class="form-control" id="subjectCustomer" placeholder="Subject" name="subject">
        </div>
        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
@stop