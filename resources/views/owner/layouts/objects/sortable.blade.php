<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Sortable</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{asset('/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https:/maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https:/code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom Styling -->
    <link href="{{ asset('/admin/_noblesoft/css/style.css') }}" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:/ -->
    <!--[if lt IE 9]>
    <script src="https:/oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https:/oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script type="text/javascript">
      function save(){
      $("#sortable tbody").sortable({opacity: 0.7, handle: 'dragger', cursor: 'move', update: function() {
      
      var order = $(this).sortable("serialize"); 
                  
          showSpinnerOnPage();//abrar
          
          $.ajax({
              url: "{{url('admin/sortable/update?')}}" + order,
              success: function(result) {
      
                if(result=='SUCCESS'){       
                hideSpinnerOnPage();
                }else{
                $(".page-center-spinner").html(result);
                }
      
              }
            });
      
      
      }                 
      });
      }
      
    </script>
    <script src="{{asset('admin/_noblesoft/js/custom-functions.js')}}"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="ajax-spinner-center page-center-spinner"></div>
    <div class="wrapper">
      <div class="content-wrapper">
        @include('admin.layouts.partials.alerts')
        <table id="sortable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Order#</th>
              <th>Drag</th>
              <th>Picture</th>
              <th>Title</th>
            </tr>
          </thead>
          <tbody>
            @foreach( $items as $item )
            <tr id="id_{{$item->id}}">
              <td>{{$item->display_order}}</td>
              <td>
                <dragger class=" cursor-move"><span class="glyphicon glyphicon-sort" onmouseover="javascript:save();" ></span></dragger>
              </td>
              <td>
                @if(is_file($item->image))
                <img class="image-100 img-responsive" 
                  src="{{asset($item->image)}}" alt="{{$item->title}}">
                @endif
              </td>
              <td>{{$item->title}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Order#</th>
              <th>Drag</th>
              <th>Picture</th>
              <th>Title</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </body>
</html>
