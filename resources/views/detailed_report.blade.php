<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QR BUILDER | QR Codes</title>

@include('partials/links')
@include('partials/datatableslinks')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <a href="/logout" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i></a>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span style="margin-left:50px;font-family: 'Train One', cursive;">QR BUILDER</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/avatar-1.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{session()->get('USER_NAME')}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="{{url('/dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-qrcode"></i>
              <p>QR Code</p>
            </a>
          </li>
          @if(session()->get('ROLE') == '0')
          <li class="nav-item">
            <a href="{{url('/users')}}" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-book"></i>
              <p>Detailed Report</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detailed Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Detailed Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="container">
          {!! session('db_change_status') !!}
            <span id="status_msg"></span>

            <div class="row">
              <div class="col-md-12 col-12">
                <p><a href="/qrReport/{{$id}}">&#8592; Back to Reports</a></p>
              </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover text-center" id="detailed_report_table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Device</th>
                                    <th>OS</th>
                                    <th>Browser</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;?>
                            @foreach($d_report as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->device}}</td>
                                    <td>{{$row->os}}</td>
                                    <td>{{$row->browser}}</td>
                                    <td>{{$row->city}}</td>
                                    <td>{{$row->state}}</td>
                                    <td>{{$row->country}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  @include('partials/footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('partials/scripts')
@include('partials/datatables')
<script>
(function(){
  var detailed_report_table = $('#detailed_report_table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','excel','print'],
        "aaSorting": [[0,'asc']]
    });
})();
</script>

</body>
</html>
