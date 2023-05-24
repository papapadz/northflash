<li class="nav-item {{ active_class(['home']) }}">
    <a class="nav-link" href="{{ url('/home') }}">
      <i class="menu-icon mdi mdi-television"></i>
      <span class="menu-title">Dashboard</span>
    </a>
  </li>
  <li class="nav-item {{ active_class(['admin/employees']) }} {{ active_class(['admin/employee/*']) }}">
    <a class="nav-link" href="{{ url('/admin/employees') }}">
      <i class="menu-icon mdi mdi-account"></i>
      <span class="menu-title">Employees</span>
    </a>
  </li>
  <li class="nav-item {{ active_class(['admin/registrations']) }} {{ active_class(['admin/registrations/*']) }}">
    <a class="nav-link" href="{{ url('/admin/registrations') }}">
      <i class="menu-icon mdi mdi-account-edit"></i>
      <span class="menu-title">Registrations</span>
    </a>
  </li>
  <li class="nav-item {{ active_class(['admin/payrolls']) }} {{ active_class(['admin/payrolls/*']) }}">
    <a class="nav-link" href="{{ url('/admin/payrolls') }}">
      <i class="menu-icon mdi mdi-calculator"></i>
      <span class="menu-title">Payrolls</span>
    </a>
  </li>
  <li class="nav-item {{ active_class(['admin/projects']) }} {{ active_class(['admin/project/*']) }}">
    <a class="nav-link" href="{{ url('/admin/projects') }}">
      <i class="menu-icon mdi mdi-cube"></i>
      <span class="menu-title">Projects</span>
    </a>
  </li>