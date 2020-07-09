<!DOCTYPE html>
<html>
<head>
  <title>North Flash Power and Builds, Inc.</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('assets/images/nfpb.jpg') }}">

  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  {!! Html::style('assets/datatable/datatables.css') !!}
  {!! Html::style('assets/select2/css/select2.css') !!}
  <!-- end plugin css -->

  @stack('plugin-styles')

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

  <div class="container-scroller" id="app">
    @include('layout.header')
    <div class="container-fluid page-body-wrapper">
      @include('layout.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @if(session('success'))
              <div class="alert alert-success dismissable">
                {{ session('success') }}
              </div>
          @elseif(session('danger'))
            <div class="alert alert-danger dismissable">
              {{ session('danger') }}
            </div>
          @elseif(session('warning'))
            <div class="alert alert-warning dismissable">
              {{ session('warning') }}
            </div>
          @endif
          @yield('content')
        </div>
        @include('layout.footer')
      </div>
    </div>
  </div>

  <!-- base js -->
  {!! Html::script('js/app.js') !!}
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}
  <!-- end base js -->

  <!-- plugin js -->
  @stack('plugin-scripts')
  {!! Html::script('assets/datatable/datatables.js') !!}
  <!-- end plugin js -->

  <!-- common js -->
  {!! Html::script('assets/js/off-canvas.js') !!}
  {!! Html::script('assets/js/hoverable-collapse.js') !!}
  {!! Html::script('assets/js/misc.js') !!}
  {!! Html::script('assets/js/settings.js') !!}
  {!! Html::script('assets/js/todolist.js') !!}
  {!! Html::script('assets/select2/js/select2.js') !!}
  {!! Html::script('assets/plugins/moment/moment.js') !!}
  <!-- end common js -->


  <script>
    function buttonCRUD(tbl,id,crud) {
      
      if(confirm('Are you sure you want to make this changes?')) {
        $.ajax({
          url: "{{ url('admin/crud') }}",
          method: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            tbl:tbl,
            id:id,
            crud:crud
          }
        }).done(function() {
          window.location.reload();
        });
      }
    }
  </script>
  @stack('custom-scripts')
</body>
</html>