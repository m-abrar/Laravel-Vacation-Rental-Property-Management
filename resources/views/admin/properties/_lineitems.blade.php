<!--this file is part of properties.php-->
<table class="table table-striped table-bordered">
   @foreach($lineitems as $lineitem)
   <tr valign="top">
      <th width="50%" bgcolor="#efefef" scope="row" style="padding:4px;">
         {!!$lineitem->title!!}<br/>
         <small>Global/Default Value: 
         @if($lineitem->value_type=='fixed')$@endif
         {!!$lineitem->value_default!!}
         @if($lineitem->value_type=='percentage')% @endif
         </small>
      </th>
      <td width="50%">
         <div class="input-group">
            @if($lineitem->value_type=='fixed')
            <span class="input-group-addon">$</span>
            @endif
            <input name="lineitem_value_{{$lineitem->id}}" 
               class="form-control" type="text" size="12" 
               value="@if(old('lineitem_value_'.$lineitem->id)){!! old('lineitem_value_'.$lineitem->id) !!}@elseif(isset($lineitem->value)){!!$lineitem->value!!}@endif" 
               />
            @if($lineitem->value_type=='percentage')
            <span class="input-group-addon">%</span> 
            @endif
         </div>
      </td>
   </tr>
   @endforeach
</table>