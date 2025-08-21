<div class="add-comment">
    <header>
        <h3 class="h6">Leave a reply</h3>
    </header>
    <form action="{{route('blog_store_comment')}}" method="post" id="comment-form" class="commenting-form">
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <input type="text" name="name" value="{{old('name')}}" id="username" placeholder="Name" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="form-group col-md-6">
                <input type="email" name="email" value="{{old('email')}}" id="useremail" placeholder="Email Address (will not be published)"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="form-group col-md-12">
                <textarea name="comment" id="usercomment" placeholder="Type your comment"
                          class="form-control @error('comment') is-invalid @enderror">{{old('comment')}}</textarea>
                @error('comment')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('g-recaptcha-response')
                <div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>
                @enderror

            </div>

            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-secondary">Submit Comment</button>
            </div>
        </div>
    </form>
</div>
@push('footer_script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>

    <script>
        $(document).ready(function () {
            // jQuery Validation
            $('#comment-form').validate({
                rules: {
                    name: { required: true, minlength: 2, maxlength: 30 },
                    email: { required: true, email: true },
                    comment: { required: true, minlength: 5, maxlength: 500 }
                },
                messages: {
                    name: "Please enter your valid name",
                    email: "Please enter a valid email",
                    comment: "Comment must be between 5 and 500 characters long"
                },
                errorClass: "is-invalid",
                validClass: "is-valid",
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("alert alert-danger mt-1");
                    error.insertAfter(element);
                }
            });
            // ajax form submit
            $('#comment-form').on('submit', function (e) {
                e.preventDefault();

                if (!$('#comment-form').valid()) {
                    return false;
                }

                let submitBtn = $('#comment-form button[type="submit"]');
                submitBtn.prop('disabled', true).text('Submitting...');

                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ env("GOOGLE_RECAPTCHA_KEY") }}', {action: 'submit'}).then(function (token) {
                        $.ajax({
                            url: "{{ route('blog_store_comment') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name: $('#username').val(),
                                email: $('#useremail').val(),
                                comment: $('#usercomment').val(),
                                post_id: {{ $singlePost->id }},
                                'g-recaptcha-response': token
                            },
                            success: function (response) {
                                $('#comment-form')[0].reset();
                                $('#post-comments').load(window.location.href + ' #post-comments > *');
                                $('<div class="alert alert-success mt-2">Your comment has been submitted!</div>')
                                    .insertBefore('#comment-form')
                                    .delay(3000).fadeOut();
                                submitBtn.prop('disabled', false).text('Submit Comment');
                            },
                            error: function (xhr) {
                                $('.is-invalid').removeClass('is-invalid');
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    $.each(xhr.responseJSON.errors, function (key, value) {
                                        let input = "#comment-form [name='" + key + "']";
                                        $(input).addClass('is-invalid');
                                    });
                                }
                                $('<div class="alert alert-danger mt-2">Something went wrong. Please try again.</div>')
                                    .insertBefore('#comment-form')
                                    .delay(3000).fadeOut();
                                submitBtn.prop('disabled', false).text('Submit Comment');
                            }
                        });
                    });
                });
            });
        });
    </script>
@endpush
