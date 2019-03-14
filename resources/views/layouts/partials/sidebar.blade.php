  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-primary">
      <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  Administrator Tasks
                  <i class="right fa fa-angle-left"></i>
                </p>
                
              </a>
              <ul class="nav nav-treeview">
                  @if (auth()->check() && auth()->user()->isAdministrator()) 
                  
                  <li class="nav-item"><a href="/userMaint" class="nav-link alert alert-warning"><i class="icon fa fa-warning"></i> User Maintenance</a></li>                  
                  <li class="nav-item"><a href="/kiosks/create" class="nav-link alert alert-warning"><i class="icon fa fa-warning"></i> Create a new Kisok</a></li>
                  @endif      
                
                
              </ul>
            </li>
          
          <li class="nav-item"><a href="/kiosks" class="nav-link alert alert-info">List all Kisoks</a></li>
          <li class="nav-item"><a href="/students" class="nav-link alert alert-success">Go to Student index page</a></li>
          <li class="nav-item"><a href="/students/339654014" class="nav-link alert alert-success">Go to Student show page</a></li>
          <li class="nav-item"><a href="/courses" class="nav-link alert alert-black">Debug Course stuff</a></li>
          <li class="nav-item"><a href="/home1" class="nav-link alert alert-gray">Go to AdminLTE home page</a></li>
          <li class="nav-item"><a href="/bpterminal/1" class="nav-link alert alert-success"> Launch BluePanel terminal</a></li>
          
          <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  Kiosks (all)
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  @foreach (\App\Kiosk::all() as $kiosk)                  
                <li class="nav-item">
                  <a href="{{'/kiosks/'.$kiosk->id.'/edit'}}" class="nav-link active">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p></p>{{$kiosk->name}}</p>
                  </a>
                </li>
                @endforeach
              </ul>
            </li> <!-- end tree menu -->

            <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  Logs
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  @foreach (\App\Kiosk::all() as $kiosk)                  
                <li class="nav-item">
                  <a href="{{'/kiosks/'.$kiosk->id.'/edit'}}" class="nav-link active">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p></p>{{$kiosk->name}}</p>
                  </a>
                </li>
                @endforeach
              </ul>
            </li> <!-- end tree menu -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
