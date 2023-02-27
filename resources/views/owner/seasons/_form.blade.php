@if(isset($season->id))
<input type="hidden" name="id" value="{{ $season->id }}">
@endif
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($season->title)){!!$season->title!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Season Start<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <div class="col-xs-4">
      <select name="season_start_day" id="season_start_day" class="form-control" >
      <option value="0" 
      @if(!old('season_start_day') or old('season_start_day')=='0'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '0'){{'selected="selected"'}}@endif
      >Day</option>
      <option value="1"  
      @if(old('season_start_day') and old('season_start_day')=='1'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '1'){{'selected="selected"'}}@endif
      >01</option>
      <option value="2" 
      @if(old('season_start_day') and old('season_start_day')=='2'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '2'){{'selected="selected"'}}@endif
      >02</option>
      <option 
      @if(old('season_start_day') and old('season_start_day')=='3'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '3'){{'selected="selected"'}}@endif
      >03</option>
      <option 
      @if(old('season_start_day') and old('season_start_day')=='4'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '4'){{'selected="selected"'}}@endif
      >04</option>
      <option 
      @if(old('season_start_day') and old('season_start_day')=='5'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '5'){{'selected="selected"'}}@endif
      >05</option>
      <option 
      @if(old('season_start_day') and old('season_start_day')=='6'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '6'){{'selected="selected"'}}@endif
      >06</option>
      <option 
      @if(old('season_start_day') and old('season_start_day')=='7'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '7'){{'selected="selected"'}}@endif
      >07</option>
      <option value="8" 
      @if(old('season_start_day') and old('season_start_day')=='8'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '8'){{'selected="selected"'}}@endif
      >08</option>
      <option value="9" 
      @if(old('season_start_day') and old('season_start_day')=='9'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '9'){{'selected="selected"'}}@endif
      >09</option>
      <option value="10" 
      @if(old('season_start_day') and old('season_start_day')=='10'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '10'){{'selected="selected"'}}@endif
      >10</option>
      <option value="11" 
      @if(old('season_start_day') and old('season_start_day')=='11'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '0'){{'selected="selected"'}}@endif
      >11</option>
      <option value="12" 
      @if(old('season_start_day') and old('season_start_day')=='12'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '12'){{'selected="selected"'}}@endif
      >12</option>
      <option value="13" 
      @if(old('season_start_day') and old('season_start_day')=='13'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '13'){{'selected="selected"'}}@endif
      >13</option>
      <option value="14" 
      @if(old('season_start_day') and old('season_start_day')=='14'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '14'){{'selected="selected"'}}@endif
      >14</option>
      <option value="15" 
      @if(old('season_start_day') and old('season_start_day')=='15'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '15'){{'selected="selected"'}}@endif
      >15</option>
      <option value="16" 
      @if(old('season_start_day') and old('season_start_day')=='16'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '16'){{'selected="selected"'}}@endif
      >16</option>
      <option value="17" 
      @if(old('season_start_day') and old('season_start_day')=='17'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '17'){{'selected="selected"'}}@endif
      >17</option>
      <option value="18" 
      @if(old('season_start_day') and old('season_start_day')=='18'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '18'){{'selected="selected"'}}@endif
      >18</option>
      <option value="19" 
      @if(old('season_start_day') and old('season_start_day')=='19'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '19'){{'selected="selected"'}}@endif
      >19</option>
      <option value="20" 
      @if(old('season_start_day') and old('season_start_day')=='20'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '20'){{'selected="selected"'}}@endif
      >20</option>
      <option value="21" 
      @if(old('season_start_day') and old('season_start_day')=='21'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '21'){{'selected="selected"'}}@endif
      >21</option>
      <option value="22" 
      @if(old('season_start_day') and old('season_start_day')=='22'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '22'){{'selected="selected"'}}@endif
      >22</option>
      <option value="23" 
      @if(old('season_start_day') and old('season_start_day')=='23'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '23'){{'selected="selected"'}}@endif
      >23</option>
      <option value="24" 
      @if(old('season_start_day') and old('season_start_day')=='24'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '24'){{'selected="selected"'}}@endif
      >24</option>
      <option value="25" 
      @if(old('season_start_day') and old('season_start_day')=='25'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '25'){{'selected="selected"'}}@endif
      >25</option>
      <option value="26" 
      @if(old('season_start_day') and old('season_start_day')=='26'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '26'){{'selected="selected"'}}@endif
      >26</option>
      <option value="27" 
      @if(old('season_start_day') and old('season_start_day')=='27'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '27'){{'selected="selected"'}}@endif
      >27</option>
      <option value="28" 
      @if(old('season_start_day') and old('season_start_day')=='28'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '28'){{'selected="selected"'}}@endif
      >28</option>
      <option value="29" 
      @if(old('season_start_day') and old('season_start_day')=='29'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '29'){{'selected="selected"'}}@endif
      >29</option>
      <option value="30" 
      @if(old('season_start_day') and old('season_start_day')=='30'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '30'){{'selected="selected"'}}@endif
      >30</option>
      <option value="31" 
      @if(old('season_start_day') and old('season_start_day')=='31'){{'selected="selected"'}}
      @elseif(isset($season->season_start_day) and $season->season_start_day == '31'){{'selected="selected"'}}@endif
      >31</option>
      </select>
    </div>
    <div class="col-xs-5">
      <select name="season_start_month" id="season_start_month" class="form-control" >
      <option value="0" 
      @if(!old('season_start_month') or old('season_start_month')=='0'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '0'){{'selected="selected"'}}@endif
      >Month</option>
      <option value="1" 
      @if(old('season_start_month') and old('season_start_month')=='1'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '1'){{'selected="selected"'}}@endif
      >Jan (1)</option>
      <option value="2" 
      @if(old('season_start_month') and old('season_start_month')=='2'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '2'){{'selected="selected"'}}@endif
      >Feb (2)</option>
      <option value="3" 
      @if(old('season_start_month') and old('season_start_month')=='3'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '3'){{'selected="selected"'}}@endif
      >Mar (3)</option>
      <option value="4" 
      @if(old('season_start_month') and old('season_start_month')=='4'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '4'){{'selected="selected"'}}@endif
      >Apr (4)</option>
      <option value="5" 
      @if(old('season_start_month') and old('season_start_month')=='5'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '5'){{'selected="selected"'}}@endif
      >May (5)</option>
      <option value="6" 
      @if(old('season_start_month') and old('season_start_month')=='6'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '6'){{'selected="selected"'}}@endif
      >Jun (6)</option>
      <option value="7" 
      @if(old('season_start_month') and old('season_start_month')=='7'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '7'){{'selected="selected"'}}@endif
      >Jul (7)</option>
      <option value="8" 
      @if(old('season_start_month') and old('season_start_month')=='8'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '8'){{'selected="selected"'}}@endif
      >Aug (8)</option>
      <option value="9" 
      @if(old('season_start_month') and old('season_start_month')=='9'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '9'){{'selected="selected"'}}@endif
      >Sep (9)</option>
      <option value="10" 
      @if(old('season_start_month') and old('season_start_month')=='10'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '10'){{'selected="selected"'}}@endif
      >Oct (10)</option>
      <option value="11" 
      @if(old('season_start_month') and old('season_start_month')=='11'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '11'){{'selected="selected"'}}@endif
      >Nov (11)</option>
      <option value="12" 
      @if(old('season_start_month') and old('season_start_month')=='12'){{'selected="selected"'}}
      @elseif(isset($season->season_start_month) and $season->season_start_month == '12'){{'selected="selected"'}}@endif
      >Dec (12)</option>
      </select>
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Season End<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <div class="col-xs-4">
      <select name="season_end_day" id="season_end_day" class="form-control" >
      <option value="0" 
      @if(!old('season_end_day') or old('season_end_day')=='0'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '0'){{'selected="selected"'}}@endif
      >Day</option>
      <option value="1" 
      @if(old('season_end_day') and old('season_end_day')=='1'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '1'){{'selected="selected"'}}@endif
      >01</option>
      <option value="2" 
      @if(old('season_end_day') and old('season_end_day')=='2'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '2'){{'selected="selected"'}}@endif
      >02</option>
      <option value="3" 
      @if(old('season_end_day') and old('season_end_day')=='3'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '3'){{'selected="selected"'}}@endif
      >03</option>
      <option value="4" 
      @if(old('season_end_day') and old('season_end_day')=='4'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '4'){{'selected="selected"'}}@endif
      >04</option>
      <option value="5" 
      @if(old('season_end_day') and old('season_end_day')=='5'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '5'){{'selected="selected"'}}@endif
      >05</option>
      <option value="6" 
      @if(old('season_end_day') and old('season_end_day')=='6'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '6'){{'selected="selected"'}}@endif
      >06</option>
      <option value="7" 
      @if(old('season_end_day') and old('season_end_day')=='7'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '7'){{'selected="selected"'}}@endif
      >07</option>
      <option value="8" 
      @if(old('season_end_day') and old('season_end_day')=='8'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '8'){{'selected="selected"'}}@endif
      >08</option>
      <option value="9"  
      @if(old('season_end_day') and old('season_end_day')=='9'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '9'){{'selected="selected"'}}@endif
      >09</option>
      <option value="10" 
      @if(old('season_end_day') and old('season_end_day')=='10'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '10'){{'selected="selected"'}}@endif
      >10</option>
      <option value="11" 
      @if(old('season_end_day') and old('season_end_day')=='11'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '11'){{'selected="selected"'}}@endif
      >11</option>
      <option value="12"  
      @if(old('season_end_day') and old('season_end_day')=='12'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '12'){{'selected="selected"'}}@endif
      >12</option>
      <option value="13" 
      @if(old('season_end_day') and old('season_end_day')=='13'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '13'){{'selected="selected"'}}@endif
      >13</option>
      <option value="14" 
      @if(old('season_end_day') and old('season_end_day')=='14'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '14'){{'selected="selected"'}}@endif
      >14</option>
      <option value="15"  
      @if(old('season_end_day') and old('season_end_day')=='15'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '15'){{'selected="selected"'}}@endif
      >15</option>
      <option value="16" 
      @if(old('season_end_day') and old('season_end_day')=='16'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '16'){{'selected="selected"'}}@endif
      >16</option>
      <option value="17" 
      @if(old('season_end_day') and old('season_end_day')=='17'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '17'){{'selected="selected"'}}@endif
      >17</option>
      <option value="18" 
      @if(old('season_end_day') and old('season_end_day')=='18'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '18'){{'selected="selected"'}}@endif
      >18</option>
      <option value="19" 
      @if(old('season_end_day') and old('season_end_day')=='19'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '19'){{'selected="selected"'}}@endif
      >19</option>
      <option value="20" 
      @if(old('season_end_day') and old('season_end_day')=='20'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '20'){{'selected="selected"'}}@endif
      >20</option>
      <option value="21" 
      @if(old('season_end_day') and old('season_end_day')=='21'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '21'){{'selected="selected"'}}@endif
      >21</option>
      <option value="22" 
      @if(old('season_end_day') and old('season_end_day')=='22'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '22'){{'selected="selected"'}}@endif
      >22</option>
      <option value="23" 
      @if(old('season_end_day') and old('season_end_day')=='23'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '23'){{'selected="selected"'}}@endif
      >23</option>
      <option value="24" 
      @if(old('season_end_day') and old('season_end_day')=='24'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '24'){{'selected="selected"'}}@endif
      >24</option>
      <option value="25" 
      @if(old('season_end_day') and old('season_end_day')=='25'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '25'){{'selected="selected"'}}@endif
      >25</option>
      <option value="26" 
      @if(old('season_end_day') and old('season_end_day')=='26'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '26'){{'selected="selected"'}}@endif
      >26</option>
      <option value="27" 
      @if(old('season_end_day') and old('season_end_day')=='27'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '27'){{'selected="selected"'}}@endif
      >27</option>
      <option value="28" 
      @if(old('season_end_day') and old('season_end_day')=='28'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '28'){{'selected="selected"'}}@endif
      >28</option>
      <option value="29" 
      @if(old('season_end_day') and old('season_end_day')=='29'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '29'){{'selected="selected"'}}@endif
      >29</option>
      <option value="30" 
      @if(old('season_end_day') and old('season_end_day')=='30'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '30'){{'selected="selected"'}}@endif
      >30</option>
      <option value="31" 
      @if(old('season_end_day') and old('season_end_day')=='31'){{'selected="selected"'}}
      @elseif(isset($season->season_end_day) and $season->season_end_day == '31'){{'selected="selected"'}}@endif
      >31</option>
      </select>
    </div>
    <div class="col-xs-5">
      <select name="season_end_month" id="season_end_month" class="form-control" >
      <option value="0" 
      @if(!old('season_end_month') or old('season_end_month')=='0'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '0'){{'selected="selected"'}}@endif
      >Month</option>
      <option value="1" 
      @if(old('season_end_month') and old('season_end_month')=='1'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '1'){{'selected="selected"'}}@endif
      >Jan (1)</option>
      <option value="2" 
      @if(old('season_end_month') and old('season_end_month')=='2'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '2'){{'selected="selected"'}}@endif
      >Feb (2)</option>
      <option value="3" 
      @if(old('season_end_month') and old('season_end_month')=='3'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '3'){{'selected="selected"'}}@endif
      >Mar (3)</option>
      <option value="4" 
      @if(old('season_end_month') and old('season_end_month')=='4'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '4'){{'selected="selected"'}}@endif
      >Apr (4)</option>
      <option value="5" 
      @if(old('season_end_month') and old('season_end_month')=='5'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '5'){{'selected="selected"'}}@endif
      >May (5)</option>
      <option value="6" 
      @if(old('season_end_month') and old('season_end_month')=='6'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '6'){{'selected="selected"'}}@endif
      >Jun (6)</option>
      <option value="7" 
      @if(old('season_end_month') and old('season_end_month')=='7'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '7'){{'selected="selected"'}}@endif
      >Jul (7)</option>
      <option value="8" 
      @if(old('season_end_month') and old('season_end_month')=='8'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '8'){{'selected="selected"'}}@endif
      >Aug (8)</option>
      <option value="9" 
      @if(old('season_end_month') and old('season_end_month')=='9'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '9'){{'selected="selected"'}}@endif
      >Sep (9)</option>
      <option value="10" 
      @if(old('season_end_month') and old('season_end_month')=='10'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '10'){{'selected="selected"'}}@endif
      >Oct (10)</option>
      <option value="11"  
      @if(old('season_end_month') and old('season_end_month')=='11'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '11'){{'selected="selected"'}}@endif
      >Nov (11)</option>
      <option value="12" 
      @if(old('season_end_month') and old('season_end_month')=='12'){{'selected="selected"'}}
      @elseif(isset($season->season_end_month) and $season->season_end_month == '12'){{'selected="selected"'}}@endif
      >Dec (12)</option>
      </select>
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Description</label>
  <div class="col-sm-9 col-xs-12">
    <textarea name="description" class="form-control">@if(old('description')){!! old('description') !!}@elseif(isset($season->description)){!!$season->description!!}@endif</textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Display Order</label>
  <div class="col-sm-9 col-xs-12">
    <input name="display_order" type="text" class="form-control" 
      value="@if(old('display_order')){!! old('display_order') !!}@elseif(isset($season->display_order)){!!$season->display_order!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($season->is_active) and ($season->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>
