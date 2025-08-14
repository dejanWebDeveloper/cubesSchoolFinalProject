<!DOCTYPE html>
<html>
@include('front._layouts._head_link')
<body>
@include('front._layouts._header')

@yield('content')

@include('front._layouts._footer')
@include('front._layouts._footer_script')
</body>
</html>
