{{--  TODO : most of the CSS is duplicated in Terminal.css, 
    which means that it has to be changed in two places ...
    put it all into one place and then include it when needed. --}}
<style>
    #studentSearch {
        width: 70%;        
        left: 15%;
        /* TODO: topnavbar must have these top: 15%; position: relative;, but Terminal.blade must not */
        top: 15%;
        position: relative;
        border: solid gray 5px;
        border-radius: 8px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        font-size: 16px;
        /*background-color: rgba(0, 0, 0, 0.7); */
        background-color: #333;
        display: none;
    }
    #studentList {
        margin: 0 5% 5% 5%;
        color: #22264B;
        box-sizing: border-box;
    }
    .table-canvas {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 10px;
        -pie-background: linear-gradient(#ece9d8, #E5ECD8);
        box-shadow: #666 0px 2px 3px;
        behavior: url(Include/PIE.htc);
        overflow: hidden;
        width: 100%;
    }
    .table-canvas td {
        cursor: pointer;
        cursor: hand;
    }
    
    /* Pure table stuff */
    
    .pure-table {
        border-collapse: collapse;
        border-spacing: 0;
        empty-cells: show;
        border: 1px solid #cbcbcb
    }
    
    .pure-table caption {
        color: #000;
        font: italic 85%/1 arial, sans-serif;
        padding: 1em 0;
        text-align: center
    }
    
    .pure-table td,
    .pure-table th {
        border-left: 1px solid #cbcbcb;
        border-width: 0 0 0 1px;
        font-size: inherit;
        margin: 0;
        overflow: visible;
        padding: .5em 1em;
        text-align: left;
    }
    
    .pure-table td .noborder {
        border: none;
    }
    
    .pure-table td:first-child,
    .pure-table th:first-child {
        border-left-width: 0
    }
    
    .pure-table thead {
        background-color: #e0e0e0;
        color: #000;
        text-align: left;
        vertical-align: bottom;
        font-weight: bold;
    }
    
    .pure-table td {
        background-color: white;
    }
    
    .pure-table tr:hover td {
        color: #DDD;
        background-color: #666;
    }
    
    .pure-table tr:hover td a {
        color: #DDD;
    }
    
    .pure-table a {
        color: #333;
    }
    
    .pure-table a:hover {
        text-decoration: none;
        color: #DDD;
    }
    
    
    .pure-table-odd td {
        background-color: #f2f2f2;
    }
    
    .pure-table-striped tr:nth-child(2n-1) td {
        background-color: #f2f2f2
    }
    
    .pure-table-bordered td {
        border-bottom: 1px solid #cbcbcb
    }
    
    .pure-table-bordered tbody>tr:last-child>td {
        border-bottom-width: 0
    }
    
</style>
<script>
        function showOverlay() {           
            document.getElementById("studentSearch").style.display = "block";
            document.getElementById("inputName").focus();
            $("body").addClass('sidebar-collapse').trigger('collapsed.pushMenu');            
        }

        function resetTerminal() {
            document.getElementById("studentSearch").style.display = "none";            
            document.getElementById("studentList").innerHTML = "";            
            document.getElementById("inputName").value = "";
            $("body").removeClass('sidebar-collapse').trigger('expanded.pushMenu');
        }    

        /* This function gets all of the students that match the string being typed: 
        ie. their first name, last name, or student number 
        The data is returned as a table in a child view. */
        function findStudents(str) { 
            
            if (str.length == 0) { 
                resetTerminal();
                return;
            } 

            showOverlay();
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.write(xmlhttp.responseText);
                //    alert(xmlhttp.responseText);
                    document.getElementById("studentList").innerHTML = xmlhttp.responseText; 
                    document.getElementById("inputName").focus();                     
                // } else {
                //    alert('inexplicable search failure');
                }
            }
            xmlhttp.open("GET", "/terminals/studentFind2/" + str, true);
            xmlhttp.send();
            
        }
</script>

<!-- Navbar -->
 <nav class="main-header navbar navbar-expand bg-primary navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/home" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    <div class="ml-3">
        <fieldset>
            <input size=33 id="inputName" type="text" onkeyup="findStudents(this.value)" onkeydown="if (event.keyCode === 27) resetTerminal();"
            placeholder="Search: enter student first name or last name">
        </fieldset>
    </div>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            {{--  This no longer works with AdminLTE. It shows up!  --}}
            {{--  @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif  --}}
        @else
            <li class="nav-item dropdown elevation-2">
                <a id="navbarDropdown" class="nav-link bg-info rounded dropdown-toggle" href="#" role="button" data-toggle="dropdown" v-pre>
                    {{ Auth::user()->username }} : {{ Auth::user()->fullname }}<span class="caret"></span>
                </a>
            
                <div class="dropdown-menu dropdown-menu-right alert alert-info" >
                    {{--  Dont let default user change his password   --}}
                    @if (!Auth::user()->isDefaultUser)
                        <div class="dropdown-item alert alert-danger elevation-3"><a href="{{ route('changePassword') }}">Change Password</a>
                        </div>
                    @endif
                    <div class="dropdown-item alert bg-dark elevation-3">
                    <i class="fa fa-power-off"></i>&nbsp;

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </div>
                </div>
                
            </li>
        @endguest
        <!-- end Authentication Links -->
      
     
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- html to display student listing -->        
  <div id="studentSearch" class="card-body shadow-lg modal">            
          <h5 class="text-light">Press 'ESC' key to exit</h5>          
      
      <!-- the student table is created here at "studentList". There is also formatting for this in the css  -->
      <div id="studentList" class="text-center"></div>
  </div>

