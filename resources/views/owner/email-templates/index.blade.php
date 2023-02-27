@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Email Templates
  <small>Optional description</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Email Templates</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-body">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Subject</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $emailtemplates as $emailtemplate )
        <tr>
          <td>{{$emailtemplate->email_subject}}</td>
          <td>
            <a href="#" rel="{{url('admin/email-templates/edit/'.$emailtemplate->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Email Template: {{$emailtemplate->email_subject}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Subject</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
