  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link bg-primary">
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
                    <a href="/userMaint" class="nav-link ">
                      <i class="nav-icon fa fa-bezier-curve text-warning"></i><p>User Maintenance</p></a></li>                  
                  <li class="nav-item"><a href="/kiosks/create" class="nav-link">
                    <i class="nav-icon far fa-circle text-warning"></i> Create a new Kisok</a></li>
                    <li class="nav-item"><a href="http://localhost:4080/phpmyadmin" target="_blank" class="nav-link">
                      <i class="nav-icon fas fa-indent text-warning"></i> Go to phpMyadmin</a></li>
                      <li class="nav-item"><a href=""  class="nav-link alert-danger">
                        <i class="nav-icon fas fa-indent "></i> A red button</a></li>
                        <li class="nav-item"><a href=""  class="nav-link alert-success">
                            <i class="nav-icon fas fa-indent "></i> A green button</a></li>
                
              </ul>
              
            </li>
            @endif      
          <li class="nav-item"><a href="/kiosks" class="nav-link alert alert-info"> <i class="nav-icon far fa-folder-open "></i>List all Kisoks</a></li>
          <li class="nav-item"><a href="/students" class="nav-link alert ">Go to Student index page</a></li>
          <li class="nav-item"><a href="/students/339654014" class="nav-link alert ">Go to Student show page</a></li>
          <li class="nav-item"><a href="/courses" class="nav-link alert alert-black">Debug Course stuff</a></li>
                    
          
         

            <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-tachometer-alt "></i>
                <p>Logs<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                  @foreach (\App\Kiosk::all() as $kiosk)                  
                <li class="nav-item">
                  <a href="{{'/logs/'.$kiosk->id}}" class="nav-link active">
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
