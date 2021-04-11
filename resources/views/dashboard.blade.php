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
            <a href="{{url('/dashboard')}}" class="nav-link active">
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
            <h1 class="m-0">QR Code</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">QR Code</li>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addusers">Add QR Code</button>

            <!--Add QR Modal -->
            <div class="modal fade" id="addusers" tabindex="-1" role="dialog" aria-labelledby="addusersLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addusersLabel">Add QR Code</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/add_qr_code" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Enter Name of QR Code:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name of QR Code" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="link">Enter Link:</label>
                                            <input type="text" class="form-control" id="link" name="link" placeholder="Enter Link" autocomplete="off" required>
                                            <small id="email_msg"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="color">Enter Color:</label>
                                            <input type="color" class="form-control" id="color" name="color" placeholder="Enter Color" autocomplete="off" required>
                                            <small id="mobile_msg"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="size">Enter Size:</label>
                                            <input type="text" class="form-control" id="size" name="size" placeholder="Enter Size eg.100,200" autocomplete="off" required>
                                            <small>Recommended values: 50 to 300</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                @if(session()->get('ROLE') == '0')
                                <button type="submit" class="btn btn-success">Add QR Code</button>
                                @endif
                                @if(session()->get('ROLE') == '1')
                                  @if($allocated_qr == 0)
                                    <button type="submit" class="btn btn-success">Add QR Code</button>
                                  @else
                                    @if($allocated_qr > $used_qr)
                                      <button type="submit" class="btn btn-success">Add QR Code</button>
                                    @else
                                      <p class="text-danger">You Have exceeded the limit of creation of new QR Codes</p>
                                    @endif
                                  @endif
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Edit QR Modal -->
            <div class="modal fade" id="editqr" tabindex="-1" role="dialog" aria-labelledby="editqrLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editqrLabel">Edit QR Code</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/edit_qr_code" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="edit_id">
                                            <label for="edit_name">Enter Name of QR Code:</label>
                                            <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Enter Name of QR Code" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_link">Enter Link:</label>
                                            <input type="text" class="form-control" id="edit_link" name="edit_link" placeholder="Enter Link" autocomplete="off" required>
                                            <small id="email_msg"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_color">Enter Color:</label>
                                            <input type="color" class="form-control" id="edit_color" name="edit_color" placeholder="Enter Color" autocomplete="off" required>
                                            <small id="mobile_msg"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_size">Enter Size:</label>
                                            <input type="text" class="form-control" id="edit_size" name="edit_size" placeholder="Enter Size eg.100,200" autocomplete="off" required>
                                            <small>Recommended values: 50 to 300</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Edit QR Code</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            

            @if(session()->get('ROLE') == '0')
            <div class="table-responsive mt-3">
                  <table class="table table-hover table-striped text-center" id="qr_table">
                      <thead class="thead-dark">
                          <tr>
                              <th>#</th>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Added&nbsp;by</th>
                              <th>Email</th>
                              <th>QR Code</th>
                              <th>Link</th>
                              <th>Color</th>
                              <th>Size</th>
                              <th>Status</th>
                              <th>Created&nbsp;At</th>
                              <th>Updated&nbsp;At</th>
                              <th>Report</th>
                              <th>Edit</th>
                              <th>Delete</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $i=1;?>
                          @foreach($getqr as $row)
                          <tr>
                              <td>{{$i++}}</td>
                              <td>{{$row->id}}</td>
                              <p style="display:none;">{{$d= App\Models\UserModel::where('id', '=', $row->added_by)->get(['name','email']) }}</p>
                              <td>{{$row->name}}</td>
                              <td>{{$d[0]->name}}</td>
                              <td>{{$d[0]->email}}</td>
                              <td><a href="https://chart.googleapis.com/chart?cht=qr&chs={{$row->size}}x{{$row->size}}&chl=http://192.168.1.100:8000/statistics/{{$row->id}}&chco={{ltrim($row->color, '#')}}" target="_blank"><img src="https://chart.googleapis.com/chart?cht=qr&chs={{$row->size}}x{{$row->size}}&chl=http://192.168.1.100:8000/statistics/{{$row->id}}&chco={{ltrim($row->color, '#')}}" alt="qrcode of {{$row->id}}" width="100"></a></td>
                              <td>{{$row->link}}</td>
                              <td>{{$row->color}} <span style="background-color:{{$row->color}}">&emsp;</span></td>
                              <td>{{$row->size}}</td>
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
                              <td><a href="/qrReport/{{$row->id}}" class="btn btn-sm btn-info"><i class="fa fa-book"></i></a></td>
                              <td><a href="javascript:void(0)" data-toggle="modal" data-target="#editqr" data-id="{{$row->id}}" data-edit_name="{{$row->name}}" data-edit_link="{{$row->link}}" data-edit_color="{{$row->color}}" data-edit_size="{{$row->size}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a></td>
                              <td><a href="/delete_qr/{{$row->id}}" class="btn btn-sm btn-danger" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i></a>
                              <script type="text/javascript">
                                  function confirmDelete() {
                                  return confirm('Are you sure you want to delete this QR Code?')
                                  }
                              </script>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              @endif

              @if(session()->get('ROLE') == '1')
            <div class="table-responsive mt-3">
                  <table class="table table-hover table-striped text-center" id="qr_table">
                      <thead class="thead-dark">
                          <tr>
                              <th>#</th>
                              <th>ID</th>
                              <th>Name</th>
                              <th>QR Code</th>
                              <th>Link</th>
                              <th>Color</th>
                              <th>Size</th>
                              <th>Status</th>
                              <th>Created&nbsp;At</th>
                              <th>Updated&nbsp;At</th>
                              <th>Report</th>
                              <th>Edit</th>
                              <th>Delete</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $i=1;?>
                          @foreach($getqrbyuser as $row)
                          <tr>
                              <td>{{$i++}}</td>
                              <td>{{$row->id}}</td>
                              <td>{{$row->name}}</td>
                              <td><a href="https://chart.googleapis.com/chart?cht=qr&chs={{$row->size}}x{{$row->size}}&chl=http://192.168.1.100:8000/statistics/{{$row->id}}&chco={{ltrim($row->color, '#')}}" target="_blank"><img src="https://chart.googleapis.com/chart?cht=qr&chs={{$row->size}}x{{$row->size}}&chl={{$row->link}}&chco={{ltrim($row->color, '#')}}" alt="qrcode of {{$row->id}}" width="100"></a></td>
                              <td>{{$row->link}}</td>
                              <td>{{$row->color}} <span style="background-color:{{$row->color}}">&emsp;</span></td>
                              <td>{{$row->size}}</td>
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
                              <td><a href="/qrReport/{{$row->id}}" class="btn btn-sm btn-info"><i class="fa fa-book"></i></a></td>
                              <td><a href="javascript:void(0)" data-toggle="modal" data-target="#editqr" data-id="{{$row->id}}" data-edit_name="{{$row->name}}" data-edit_link="{{$row->link}}" data-edit_color="{{$row->color}}" data-edit_size="{{$row->size}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a></td>
                              <td><a href="/delete_qr/{{$row->id}}" class="btn btn-sm btn-danger" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i></a>
                              <script type="text/javascript">
                                  function confirmDelete() {
                                  return confirm('Are you sure you want to delete this QR Code?')
                                  }
                              </script>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              @endif

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
  var qr_table = $('#qr_table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','excel','print'],
        "aaSorting": [[0,'asc']]
    });

  $('#editqr').on('show.bs.modal', function (event) {
    //   console.log("modal open");
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var edit_name = button.data('edit_name')
      var edit_link = button.data('edit_link')
      var edit_color = button.data('edit_color')
      var edit_size = button.data('edit_size')
      
      var modal = $(this)
      modal.find('.modal-body #edit_id').val(id)
      modal.find('.modal-body #edit_name').val(edit_name)
      modal.find('.modal-body #edit_link').val(edit_link)
      modal.find('.modal-body #edit_color').val(edit_color)
      modal.find('.modal-body #edit_size').val(edit_size)
  });

  window.changeStatus = (id) =>{
        $.ajax({
            url: "qrchangeStatus",
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
