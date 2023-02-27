<!-- Rates table of proerty -->
<h3>{{trans('eminent.headings.rates')}}</h3>
<div class="col-md-12">
   <table class="table table-striped table-bordered" >
      <tr>
         <th scope="row"></th>
         <td class="text-right">/{{trans('eminent.reservation.day')}}</td>
         <td class="text-right">/{{trans('eminent.reservation.week')}}</td>
         <td class="text-right">/{{trans('eminent.reservation.bi-week')}}</td>
         <td class="text-right">/{{trans('eminent.reservation.month')}}</td>
      </tr>
      <!-- In the first row of table we load regular prices of the property. -->
      <tr>
         <th scope="row">{{trans('eminent.reservation.regular-prices')}}</th>
         <td class="text-right">
            {{(!empty($property->price_daily)) ? '$' . $property->price_daily : 'N/A'}}
         </td>
         <td class="text-right">{{ (!empty($property->price_weekly)) ? '$' . $property->price_weekly : 'N/A' }}</td>
         <td class="text-right">{{ (!empty($property->price_two_weekly)) ? '$' . $property->price_two_weekly : 'N/A' }}</td>
         <td class="text-right">{{ (!empty($property->price_monthly)) ? '$' . $property->price_monthly : 'N/A' }}</td>
      </tr>
      <!-- Now we load seasons rates of the property from child table. -->
      @foreach ($rates as $rate)
      <tr>
         <th scope="row"> {{$rate->title}}
            <small class="pull-right">
            {{ $rate->season_start_month }}/{{ $rate->season_start_day }}
            to
            {{ $rate->season_end_month }}/{{ $rate->season_end_day }}
            </small> 
         </th>
         <td class="text-right">{{ (!empty($rate->added->first()->price_daily)) ? '$' . $rate->added->first()->price_daily : 'N/A' }}</td>
         <td class="text-right">{{ (!empty($rate->added->first()->price_weekly)) ? '$' . $rate->added->first()->price_weekly : 'N/A' }}</td>
         <td class="text-right">{{ (!empty($rate->added->first()->price_two_weekly)) ? '$' . $rate->added->first()->price_two_weekly : 'N/A' }}</td>
         <td class="text-right">{{ (!empty($rate->added->first()->price_monthly)) ? '$' . $rate->added->first()->price_monthly : 'N/A' }}</td>
      </tr>
      @endforeach
   </table>
</div>