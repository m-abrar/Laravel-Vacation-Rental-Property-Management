<table class="table table-striped table-bordered">
  @foreach($features as $feature)
  <tr valign="top">
    <th width="50%" bgcolor="#efefef" scope="row" style="padding:4px;">
      {!!$feature->title!!}
    </th>
    <td width="50%">
      <input name="feature_value_{{$feature->id}}" 
        class="form-control" type="text" size="12" 
        value="@if(old('feature_value_'.$feature->id)){!! old('feature_value_'.$feature->id) !!}@elseif(isset($feature->value)){!!$feature->value!!}@endif" 
        />
    </td>
  </tr>
  @endforeach
</table>
