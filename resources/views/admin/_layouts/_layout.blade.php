<!DOCTYPE html>
<html lang="en">
@include('admin._layouts._head_link')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    @include('admin._layouts._navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('admin._layouts._sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        @yield('content')
        <!-- /.modal -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    @include('admin._layouts._footer')
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@include('admin._layouts._footer_script')
</body>
</html>
