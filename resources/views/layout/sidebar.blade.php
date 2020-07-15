<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ url('assets/images/faces/face8.jpg') }}" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name">{{ Auth::user()->name }}</p>
            <div class="dropdown" data-display="static">
              <a href="#" class="nav-link d-flex user-switch-dropdown-toggler" id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">Administrator</small>
                <span class="status-indicator online"></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                <a class="dropdown-item p-0">
                  <div class="d-flex border-bottom">
                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                      <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                    </div>
                    <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                      <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                    </div>
                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                      <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item mt-2"> Manage Accounts </a>
                <a class="dropdown-item"> Change Password </a>
                <a class="dropdown-item"> Check Inbox </a>
                <a class="dropdown-item"> Sign Out </a>
              </div>
            </div>
          </div>
        </div>
        <!-- <button class="btn btn-success btn-block">New Project <i class="mdi mdi-plus"></i> -->
        </button>
      </div>
    </li>
    <li class="nav-item {{ active_class(['home']) }}">
      <a class="nav-link" href="{{ url('/home') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <!-- -->
    <li class="nav-item {{ active_class(['admin/employees']) }}">
      <a class="nav-link" href="{{ url('/admin/employees') }}">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Employees</span>
      </a>
    </li>
    <li class="nav-item {{ active_class(['admin/payrolls']) }}">
      <a class="nav-link" href="{{ url('/admin/payrolls') }}">
        <i class="menu-icon mdi mdi-calculator"></i>
        <span class="menu-title">Payrolls</span>
      </a>
    </li>
    <li class="nav-item {{ active_class(['admin/projects']) }}">
      <a class="nav-link" href="{{ url('/admin/projects') }}">
        <i class="menu-icon mdi mdi-cube"></i>
        <span class="menu-title">Projects</span>
      </a>
    </li>
    <!-- -->
    {{-- <div class="progress">
      <div class="progress-bar bg-disabled progress-bar" role="progressbar" style="width: 100%"  aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <li class="nav-item {{ active_class(['admin/variables/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['basic-ui/*']) }}" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-dna"></i>
        <span class="menu-title">Variables</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['admin/variables/*']) }}" id="basic-ui">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['admin/variables/positions']) }}">
            <a class="nav-link" href="{{ url('/admin/variables/positions') }}">Positions</a>
          </li>
          <li class="nav-item {{ active_class(['admin/variables/payroll-items']) }}">
            <a class="nav-link" href="{{ url('/admin/variables/payroll-items') }}">Payroll Items</a>
          </li>
        </ul>
      </div>
    </li> --}}
  </ul>
</nav>