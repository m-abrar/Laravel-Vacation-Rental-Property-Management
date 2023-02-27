<!-- Show calendar for displaying availability of a property -->
<!-- Enables the user to click and select date of arrival and departure -->
<table class="table table-striped table-bordered" >
  <thead>
    <th colspan="7">
      <strong class="pull-left"><?php echo date("F, Y", $timestamp);?></strong>
      <div class="pull-right">
        <a data-year="{{$calendarPreviousYear}}" data-month="{{$calendarPreviousMonth}}" 
          class="calendar-navigate cursor-pointer glyphicon glyphicon-circle-arrow-left" ></a>
        <a data-year="{{$calendarNextYear}}" data-month="{{$calendarNextMonth}}" 
          class="calendar-navigate cursor-pointer glyphicon glyphicon-circle-arrow-right" ></a>
      </div>
    </th>
    </th>
  </thead>
  <thead>
    <th>S</th>
    <th>M</th>
    <th>T</th>
    <th>W</th>
    <th>T</th>
    <th>F</th>
    <th>S</th>
  </thead>
  <?php
    for ($i = 0; $i < ($monthtotaldays + $startday); $i++) {
        if (($i % 7) == 0) {
            echo "<tr>\n";
        } //( $i % 7 ) == 0
        if ($i < $startday) {
            echo "<td></td>\n";
        } 
        else {
            $dateclass  = '';
            $loopDayNum = ($i - $startday + 1);
            $loopDate   = $loopYear . "-" . $loopMonth . "-" . $loopDayNum;
            $loopDate   = date('Y-m-d', strtotime($loopDate));
            //if (date('Ymd',strtotime('-1 month')) >= date('Ymd', strtotime($loopDate)))
            if (date('Ymd') >= date('Ymd', strtotime($loopDate)))
            {
                $dateclass .= 'date-past ';
                echo '<td class="' . $dateclass . '" >';
            } //date( 'Ymd' ) >= date( 'Ymd', strtotime( $loopDate ) )
            else {
                
                //$cycle = intval((strtotime($loopDate) - strtotime(date('Ymd',strtotime('-1 month')))) / 86400);
                $cycle = intval((strtotime($loopDate) - strtotime(date('Ymd'))) / 86400);
    
                $cycle += 1001; //This helps to fix a javascript operator bug we found in most browsers. 
    
                if (isset($dates_reserved['date_'.date('Ymd', strtotime($loopDate))])) {
    
                    $key = 'date_'.date('Ymd', strtotime($loopDate));
                    $cDayStatus = $dates_reserved[$key];
                    
                    if ($cDayStatus == "booked") {
                        $dateclass .= ' date-booked cursor-not-allowed';
                    } //$cDayStatus == "booked"
                    elseif ($cDayStatus == "pending") {
                        $dateclass .= ' date-pending cursor-not-allowed';
                    } //$cDayStatus == "pending"
                    elseif ($cDayStatus == "blocked") {
                        $dateclass .= ' date-blocked cursor-not-allowed';
                    } //$cDayStatus == "blocked"
                    echo '<td class="' . $dateclass . '">';
                } //$numRows > 0
                else {
                    
                    $dateclass .= ' date-available ';

                    if (isset($dates_editing) AND in_array($loopDate, $dates_editing)) {
                        
                        $dateclass .= ' date-editing ';
                        if (min($dates_editing) == $loopDate ) {
                          $dateclass .= ' date-selected-start '.min($dates_editing);
                        }elseif(max($dates_editing) == $loopDate ) {
                          $dateclass .= ' date-selected-end '.max($dates_editing);
                        }else{
                          
                        }

                    }
                    if (isset($dates_searched) AND in_array($loopDate, $dates_searched)) {
                        
                        $dateclass .= ' date-selected ';
                        if (min($dates_searched) == $loopDate ) {
                          $dateclass .= ' date-selected-start ';
                        }elseif(max($dates_searched) == $loopDate ) {
                          $dateclass .= ' date-selected-end ';
                        }else{
                          
                        }

                    }
                    

                    echo '<td id="date-' . $cycle . '" data-cycle="' . $cycle . '" 
                    data-date="' . $loopDate . '" class="' . $dateclass . '" >';
                }
            }
            echo $loopDayNum;
            echo "</td>\n";
        }
        if (($i % 7) == 6) {
            echo "</tr>\n";
        } //( $i % 7 ) == 6
    } //$i = 0; $i < ( $monthtotaldays + $startday ); $i++
    ?>
</table>
<div class="col-md-12 text-center">
  <table class="legends-table ">
    <tr>
      <td class="legend-booked"></td>
      <td>Booked</td>
      <td class="legend-pending"></td>
      <td>Pending</td>
      <td class="legend-blocked"></td>
      <td>Blocked</td>
      <td class="legend-selected"></td>
      <td>Selected</td>
    </tr>
  </table>
</div>
<!-- <br/><br/>
@if(isset($pre_select_date_start) and $pre_select_date_start!='NA')
<small><strong>Help:</strong> Click the last date of your stay.</small>
@else
<small><strong>Help:</strong> Click the first and last dates of your stay.</small>
@endif
 -->