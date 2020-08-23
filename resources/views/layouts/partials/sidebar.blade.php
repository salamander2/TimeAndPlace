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
		 <li class="nav-item "><a href="/adminPage" class="nav-link alert alert-warning"><i class="nav-icon fas fa-dragon"></i><p>Admin Page</p></a></li>
		 </li>
	 @endif

          <li class="nav-item"><a href="/kiosks" class="nav-link alert alert-info"><i class="nav-icon fab fa-korvue fa-2x"></i>
            <p>List all Kisoks</p></a></li>

            {{-- Logs Tree Menu --}}
            <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link alert alert-info"> {{-- alert-primary does not exist, so use active --}}
                <i class="nav-icon fa fa-tachometer-alt "></i>
                <p>Logs<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                  @foreach (\App\Kiosk::all()->sortBy('name') as $kiosk)
                  {{--  TODO allow the kiosk users to view the logs for their own private kiosks  --}}
                  @if (!$kiosk->publicViewable) 
                    @continue
                  @endif

                <li class="nav-item">
                  <a href="{{'/logs/byKiosk/'.$kiosk->id}}" class="nav-link active">
                    <i class="text-dark far fa-sm fa-circle nav-icon"></i>
                    <p>{{$kiosk->name}}</p>
                  </a>
                </li>
                @endforeach
              </ul>
            </li> <!-- end tree menu -->

            {{-- Reports Tree Menu --}}
            <li class="nav-item has-treeview menu-closed">
              <a href="#" class="nav-link alert border-success"> {{-- alert-primary does not exist, so use active --}}
                <i class="nav-icon fa fa-folder-open"></i>
                <p>Reports<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                  @foreach (\App\Kiosk::all()->sortBy('name') as $kiosk)
                  {{--  TODO allow the kiosk users to view the logs for their own private kiosks  --}}
                  @if (!$kiosk->publicViewable) 
                    @continue
                  @endif

                <li class="nav-item">
                  <a href="{{'/reports/summary/'.$kiosk->id}}" class="nav-link active text-primary bg-dark">
                    <i class="text-warning far fa-sm fa-circle nav-icon"></i>
                    <p>{{$kiosk->name}}</p>
                  </a>
                </li>
                @endforeach
              </ul>
            </li> <!-- end tree menu -->
  
          
          <li class="nav-item "><a href="/lockers" class="nav-link alert alert-light border-primary text-info"><i class="nav-icon fas fa-microchip"></i><p>Lockers</p></a></li>
          <li class="nav-item "><a href="/classlists" class="nav-link alert alert-info"><i class="nav-icon fas fa-list-ol fa-2x"></i><p>Class Lists</p></a></li>
          <li class="nav-item "><a href="/help" class="nav-link alert border-white"><i class="nav-icon fa fa-question-circle fa-2x"></i><p>Help</p></a></li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
