@extends('admin.layouts.start-navigation')
@section('contents')
<a href="{{url('admin/dashboard')}}" class="btn btn-success" title="Dashboard">
<span class="glyphicon glyphicon-chevron-left"></span> Back to Dashboard
</a>
<a href="{{url('admin/navigation/create/'.$group_name)}}" class="btn btn-info" title="Add Navigation">
<span class="glyphicon glyphicon-plus"></span> Add
</a>
<a href="{{url('/admin/navigation/'.$group_name)}}" class="btn btn-success">
<span class="glyphicon glyphicon-refresh"></span>
</a>
<a href="{{url('admin/dashboard')}}" class="btn btn-success" title="Frontend" target="_blank">
<span class="glyphicon glyphicon-chevron-right"></span> Frontend
</a>
<form id="navigation-nesting" method="POST" >
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group_name" value="{{$group_name}}">
  <input type="hidden" name="navigation" id="nestable-output" >
</form>
<div class="col-md-12" >
  <form id="page-status-control" method="POST" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="group_name" value="{{$group_name}}">
    <div class="dd" id="nestable">
      {!!$menu!!}
    </div>
  </form>
  <script>
    $(document).ready(function()
    {
        var updateOutput = function(e)
        {
            
            var list   = e.length ? e : $(e.target);
            var output = list.data('output');
    
            if (window.JSON) {
                var result = window.JSON.stringify(list.nestable('serialize'));
                output.val(result);//, null, 2));
    
            } else {
                output.val('JSON browser support required for this demo.');
            }
            
                $('#navigation-nesting').submit();
        };
    
        $( '#navigation-nesting' ).on( 'submit', function() {
    
                showSpinnerOnPage();
                var url = "{{url('admin/navigation/updatenavigationnesting')}}";
                var data = {
                    "_token": $( this ).find( 'input[name=_token]' ).val(),
                    "group_name": $( this ).find( 'input[name=group_name]' ).val(),
                    "formdata": $('#nestable-output').val(),
                };
    
    
                $.post(url, data, function(response){                
                    if(response=='SUCCESS'){             
                    hideSpinnerOnPage();
                    
                    }else{
                    $("#ajaxresponse").html(response);
                    }
                }/* ,'json'*/
                );
    
            //prevent the form from actually submitting in browser
            return false;
        } );
    
        // activate Nestable for list 1
        $('#nestable').nestable().on('change', updateOutput);
    
        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    });
  </script>
  <!-- Update Page Active Status -->
  <script>
    $(document).ready(function(){
        $(".page-status").click(function(){
            
            $('#page-status-control').submit();
            
        });
    
        $( '#page-status-control' ).on( 'submit', function() {
     
            showSpinnerOnPage();
            var url = "{{url('admin/navigation/updatenavigationstatus')}}";
            var data = {
                "_token": $( this ).find( 'input[name=_token]' ).val(),
                "group_name": $( this ).find( 'input[name=group_name]' ).val(),
                "formdata": $('form#page-status-control').serialize(),
            };
    
            $.post(url, data, function(response){
              
              if(response=='SUCCESS'){       
              hideSpinnerOnPage();
              }else{
              $("#ajaxresponse").html(response);
              }
            });
     
            //prevent the form from actually submitting in browser
            return false;
        } );
    });
  </script>
</div>
@endsection
