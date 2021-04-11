<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QR BUILDER | Users</title>

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
          <li class="nav-item">
            <a href="{{url('/users')}}" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
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
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addusers">Add Users</button>
            <p class="text-danger mt-3">Allocated Hits = 0 ; User has allocated unlimited Hits</p>

            <!--Add Modal -->
            <div class="modal fade" id="addusers" tabindex="-1" role="dialog" aria-labelledby="addusersLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addusersLabel">Add Users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/add_user" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Enter Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Enter Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                            <small id="email_msg"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Enter Mobile No.:</label>
                                            <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No." required>
                                            <small id="mobile_msg"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Enter Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_qr">Enter Total QR Codes:</label>
                                            <input type="number" class="form-control" id="total_qr" name="total_qr" placeholder="Enter Total QR Codes">
                                            <small class="text-warning">*Enter 0 for Unlimited QR Codes</small>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_hit">Enter Total Hits:</label>
                                            <input type="number" class="form-control" id="total_hit" name="total_hit" placeholder="Enter Total Hits">
                                            <small class="text-warning">*Enter 0 for Unlimited Hits</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Edit Modal -->
            <div class="modal fade" id="editusers" tabindex="-1" role="dialog" aria-labelledby="editusersLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editusersLabel">Edit Users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/editUsers" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="edit_id">
                                            <label for="edit_name">Enter Name:</label>
                                            <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_email">Enter Email:</label>
                                            <input type="email" class="form-control" id="edit_email" name="edit_email" placeholder="Enter Email" required>
                                            <small id="email_msg"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_mobile">Enter Mobile No.:</label>
                                            <input type="text" class="form-control" id="edit_mobile" name="edit_mobile" placeholder="Enter Mobile No." required>
                                            <small id="mobile_msg"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_password">Enter Password:</label>
                                            <input type="password" class="form-control" id="edit_password" name="edit_password" placeholder="Enter Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_total_qr">Enter Total QR Codes:</label>
                                            <input type="text" class="form-control" id="edit_total_qr" name="edit_total_qr" placeholder="Enter Total QR Codes">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_total_hit">Enter Total Hits:</label>
                                            <input type="text" class="form-control" id="edit_total_hit" name="edit_total_hit" placeholder="Enter Total Hits">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Edit User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive mt-3">
                <table class="table table-hover table-striped text-center" id="users_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Total Used/Total QR</th>
                            <th>Allocated Hits</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;?>
                        @foreach($getusers as $row)
                        <p style="display:none;">{{$used_qr= App\Models\QRModel::where('added_by', '=', $row->id)->count() }}</p>
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->mobile}}</td>
                            <td>{{$used_qr}}/{{$row->total_qr}}</td>
                            <td>{{$row->total_hit}}</td>
                            <td>
                                @if($row->status == 1)
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="{{$row->id}}" onchange="changeStatus({{$row->id}})" checked>
                                        <label class="custom-control-label" for="{{$row->id}}"></label>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="{{$row->id}}" onchange="changeStatus({{$row->id}})">
                                        <label class="custom-control-label" for="{{$row->id}}"></label>
                                    </div>
                                </div>
                                @endif
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->updated_at}}</td>
                            <td><a href="/edit_user" data-toggle="modal" data-target="#editusers" data-id="{{$row->id}}" data-edit_name="{{$row->name}}" data-edit_email="{{$row->email}}" data-edit_mobile="{{$row->mobile}}" data-edit_total_qr="{{$row->total_qr}}" data-edit_total_hit="{{$row->total_hit}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a></td>
                            <td><a href="/delete_user/{{$row->id}}" class="btn btn-sm btn-danger" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i></a>
                            <script type="text/javascript">
                                function confirmDelete() {
                                return confirm('Are you sure you want to delete this user?')
                                }
                            </script>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
    var users_table = $('#users_table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','excel','print'],
        "aaSorting": [[0,'asc']]
    });

    $('#editusers').on('show.bs.modal', function (event) {
    //   console.log("modal open");
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var edit_name = button.data('edit_name')
      var edit_email = button.data('edit_email')
      var edit_mobile = button.data('edit_mobile')
      var edit_total_qr = button.data('edit_total_qr')
      var edit_total_hit = button.data('edit_total_hit')
      
      var modal = $(this)
      modal.find('.modal-body #edit_id').val(id)
      modal.find('.modal-body #edit_name').val(edit_name)
      modal.find('.modal-body #edit_email').val(edit_email)
      modal.find('.modal-body #edit_mobile').val(edit_mobile)
      modal.find('.modal-body #edit_total_qr').val(edit_total_qr)
      modal.find('.modal-body #edit_total_hit').val(edit_total_hit)
      });

    window.changeStatus = (id) =>{
        $.ajax({
            url: "changeStatus",
            type: 'get',
            data: {id},
            success: function (result) {
                // console.log(result);
                if(result.output == 'success')
                {
                    $('#status_msg').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Status Changed Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
                else
                {
                    $('#status_msg').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Change Status</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
                
            }
        });
    }


})();
</script>

</body>
</html>
