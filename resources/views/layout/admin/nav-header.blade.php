 {{-- <li class="nav-item d-none d-xl-flex">
        <a href="#" class="nav-link">Schedule <span class="badge badge-primary ml-1">New</span>
        </a>
      </li>
      <li class="nav-item active d-none d-lg-flex">
        <a href="#" class="nav-link">
          <i class="mdi mdi-elevation-rise"></i>Reports</a>
      </li>
      <li class="nav-item d-none d-md-flex">
        <a href="#" class="nav-link">
          <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
      </li> --}}
      <li class="nav-item dropdown d-none d-lg-flex">
        <a class="nav-link dropdown-toggle px-0" id="quickDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Settings </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown pt-3" aria-labelledby="quickDropdown">
          <a href="{{ url('/admin/users') }}" class="dropdown-item"><i class="mdi mdi-account"></i>User Accounts</a>
          <a href="{{ url('/admin/variables/positions') }}" class="dropdown-item"><i class="mdi mdi-clipboard-account"></i>Positions</a>
          <a href="{{ url('/admin/variables/payroll-items') }}" class="dropdown-item"><i class="mdi mdi-book-multiple"></i>Payroll Items</a>
        </div>
      </li>