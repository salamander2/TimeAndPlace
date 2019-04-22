  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link bg-primary">
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
          
         
          @if (auth()->check() && auth()->user()->isAdministrator()) 
          <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link alert alert-warning">
                <i class="nav-icon fas fa-dragon"></i>
                <p>
                  Administrator Tasks
                  <i class="right fa fa-angle-left"></i>
                </p>
                
              </a>
              <ul class="nav nav-treeview">                  
                  <li class="nav-item">
                    <a href="/userMaint" class="nav-link "><i class="nav-icon fa fa-bezier-curve text-warning"></i>
                      <p>User Maintenance</p></a></li>                  
                  <li class="nav-item"><a href="/kiosks/create" class="nav-link">
                    <i class="nav-icon fas fa-school text-success"></i>
                    <p>Create a new Kisok</p></a></li>
                    <li class="nav-item"><a href="http://localhost:4080/phpmyadmin" target="_blank" class="nav-link">
                      <i class="nav-icon fas fa-indent text-primary"></i><p>Go to phpMyadmin</p></a></li>
                
		  <li class="nav-item"><a href="/unknown" class="nav-link alert border-white">Set Assembly Day Schedule</a></li>
		 <li class="nav-item"><a href="/autosignout" class="nav-link alert alert-danger">Auto Signout Everyone NOW</a></li>
		  <li class="nav-item"><a href="/students" class="nav-link alert ">Go to Student index page</a></li>
		  <li class="nav-item"><a href="/students/339654014" class="nav-link alert ">Go to Student show page</a></li>
		  <li class="nav-item"><a href="/courses" class="nav-link alert alert-black">Debug Course stuff</a></li>
              </ul>
              
            </li>
            @endif      
          <li class="nav-item"><a href="/kiosks" class="nav-link alert alert-info"><i class="nav-icon fab fa-korvue fa-2x"></i><p>List all Kisoks</p></a></li>

            <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link alert alert-info"><!-- alert-primary does not exist, so use 'active' -->
                <i class="nav-icon fa fa-tachometer-alt "></i>
                <p>Logs<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                  @foreach (\App\Kiosk::all() as $kiosk)                  
                <li class="nav-item">
                  <a href="{{'/logs/'.$kiosk->id}}" class="nav-link active">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>{{$kiosk->name}}</p>
                  </a>
                </li>
                @endforeach
              </ul>
            </li> <!-- end tree menu -->

          <li class="nav-item"><a href="/reports" class="nav-link alert border-success"><i class="nav-icon fa fa-folder-open"></i><p>Reports</p></a></li>
          <li class="nav-item "><a href="/help" class="nav-link alert border-white"><i class="nav-icon fa fa-question-circle fa-2x"></i><p>Help</p></a></li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>