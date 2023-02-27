<!--this file is part of properties.php-->
<table class="table table-striped table-bordered">
  @foreach($amenities as $amenity)
  <tr valign="top">
    <th width="50%" bgcolor="#efefef" scope="row" style="padding:4px;">
      {!!$amenity->title!!}
    </th>
    <td width="50%">
      <input name="amenity_value_{{$amenity->id}}" type="checkbox" value="Yes"
      @if(old('amenity_value_'.$amenity->id)){{'checked="checked"'}}
      @elseif(isset($amenity->value) and ($amenity->value=='Yes')){{'checked="checked"'}}@endif
      />
    </td>
  </tr>
  @endforeach
</table>
