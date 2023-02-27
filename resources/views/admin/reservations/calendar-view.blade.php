@extends('admin.layouts.default.start-minified')
@section('contents')
@include('admin.layouts.objects.iframe-modal')


<?php
  function forhtml($a){return $a;}
  ?>
<a href="{{url('admin/dashboard')}}"><span aria-hidden="true">&larr;</span> Back to admin dashboard!</a>
<table border="0" align="center" width="100%">
  <tr>
    <td colspan="4" align="center" valign="top">
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th colspan="<?= $monthtotaldays + 1 ?>" bgcolor="#999999" style="color:#FFFFFF">
              <h3 class="text-center">
                <?php
                  echo date('F, Y', strtotime($year . '-' . $month . '-1'));
                  ?>
              </h3>
            </th>
          </tr>
          <tr>
            <th></th>
            <?php
              for ($d = 1; $d <= $monthtotaldays; $d++) {
              ?>
            <th> <strong>
              <?= ($d > 9) ? $d : '0' . $d ?>
              </strong> 
            </th>
            <?php
              } //$d = 1; $d <= $monthtotaldays; $d++
              ?>
          </tr>
        </thead>
        <?php
          foreach ($properties as $property) {
          
          ?>
        <tr>
          <td>
            <h4>
              <?= forhtml($property->title) ?>
            </h4>
          </td>
          <?php
            for ($d = 1; $d <= $monthtotaldays; $d++) {
            ?>
          <?php
            $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $d));
            
            if (!isset($dates_reserved[$property->id]['date_'.date('Ymd', strtotime($date))])) {
            
            
              if (date('Ymd') >= date('Ymd', strtotime($date))) {
            ?>
          <td></td>
          <?php
            } //date( 'Ymd' ) >= date( 'Ymd', strtotime( $date ) )
            else {
            
            ?>
          <td rel="{{url('admin/reservations/create/'.$property->slug.'/'.$date)}}" 
            class="date-available make-modal-large iframe-form-open" 
            data-toggle="modal" data-target="#iframeModal" title="Add Reservation - <?= date('m/d/Y',strtotime($date)) ?> - <?=forhtml($property->title)?>" ><small><span class="glyphicon glyphicon-plus-sign"></span></small></td>
          <?php
            }
            } //mysql_num_rows( $resultR ) == '0'
            else {
            
                $reservation_id = $dates_reserved[$property->id]['date_'.date('Ymd', strtotime($date))]['reservation_id'];
                $status = $dates_reserved[$property->id]['date_'.date('Ymd', strtotime($date))]['status'];
                $firstname = $dates_reserved[$property->id]['date_'.date('Ymd', strtotime($date))]['firstname'];
                $lastname = $dates_reserved[$property->id]['date_'.date('Ymd', strtotime($date))]['lastname'];
                $reservation_total_days = $dates_reserved[$property->id]['date_'.date('Ymd', strtotime($date))]['reservation_total_days'];
            
                ?>
          <td rel="{{url('admin/reservations/edit/'.$reservation_id)}}" class="date-<?= $status ?> <?= @$class ?> make-modal-large iframe-form-open cursor-pointer" data-toggle="modal" data-target="#iframeModal" title="Edit Reservation - <?= $firstname . ' ' . $lastname?> - "  colspan="<?= $reservation_total_days ?>">
            <?= $firstname . ' ' . $lastname?>
          </td>
          <?php
            $d += $reservation_total_days - 1;
            unset($class);
            
            
            }
            ?>
          <?php
            } //$d = 1; $d <= $monthtotaldays; $d++
            ?>
        </tr>
        <?php
          } //$rowP = mysql_fetch_array( $resultP )
          ?>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="4">
      <hr />
    </td>
  </tr>
  <tr>
    <td align="center" valign="bottom">
      <a href="{{url('/admin/calendar-view/'.$calendarPreviousYear.'/'.$calendarPreviousMonth)}}" >
        <div id="calendar-arrow-left"></div>
      </a>
    </td>
    <td width="75" align="center" valign="bottom">
      <table border="0">
        <tr>
          <td width="50" align="right">Booked</td>
          <td width="20" bgcolor="#ff0000" style="border:#000000 solid 1px;">&nbsp;</td>
        </tr>
      </table>
      <br>
      <table border="0">
        <tr>
          <td width="50" align="right">Owner</td>
          <td width="20" bgcolor="#777777" style="border:#000000 solid 1px;">&nbsp;</td>
        </tr>
      </table>
    </td>
    <td width="75" align="center" valign="bottom">
      <table border="0">
        <tr>
          <td width="20" bgcolor="#ffff00" style="border:#000000 solid 1px;">&nbsp;</td>
          <td width="50" align="left">Pending</td>
        </tr>
      </table>
      <br>
      <table border="0">
        <tr>
          <td width="20" bgcolor="#ffffff" style="border:#000000 solid 1px;">&nbsp;</td>
          <td width="50" align="left">Available</td>
        </tr>
      </table>
    </td>
    <td align="center" valign="bottom">
      <a href="{{url('/admin/calendar-view/'.$calendarNextYear.'/'.$calendarNextMonth)}}">
        <div id="calendar-arrow-right"></div>
      </a>
    </td>
  </tr>
</table>

<nav>
  <ul class="pager">
    <li><a href="{{url('/admin/dashboard')}}"><span aria-hidden="true">&larr;</span> Back to admin</a></li>
  </ul>
</nav>
@endsection
