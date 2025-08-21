@if(session()->has('system_message'))
    <div class="alert alert-success" role="alert">
        {{session()->pull('system_message')}}
    </div>
@endif
<form action="{{route('send_email')}}" method="post" id="email-form" class="commenting-form">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Your Name" value="{{old('name')}}">
            <div>
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-6">
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email Address (will not be published)" value="{{old('email')}}">
            <div>
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-12">
            <textarea name="message" id="" rows="20"
                      class="form-control @error('message') is-invalid @enderror"
                      placeholder="Type your message">{{old('message')}}</textarea>
            <div>
                @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('g-recaptcha-response')
                <div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group col-md-12">
            <button type="submit" value="Send Message" class="btn btn-secondary g-recaptcha"
                    data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"
                    data-callback='onSubmit'
                    data-action='submit'>Submit Your Message
            </button>
        </div>

    </div>
</form>

@push('footer_script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#email-form').validate({
                "rules": {
                    "name": {
                        "required": true,
                        "minlength": 2,
                        "maxlength": 30
                    },
                    "email": {
                        "required": true,
                        "email": true
                    },
                    "message": {
                        "required": true,
                        "minlength": 5,
                        "maxlength": 500
                    }
                },
                "messages": {
                    "name": {
                        "required": "Please enter your name",
                        "minlength": "Your name must be over 2 characters",
                        "maxlength": "Enter no more than 30 characters"
                    },
                    "email": {
                        "required": "Your email adress must be provided",
                        "email": "Enter valid email adress"
                    },
                    "message": {
                        "required": "What do you want to say to us",
                        "minlength": "Your message must be longer than 5 characters",
                        "maxlength": "Your message cannot be longer than 500 characters"
                    }
                },
                "errorClass": "is-invalid"
            });
        });
    </script>

@endpush
@push('recaptcha')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("email-form").submit();
        }
    </script>
@endpush
