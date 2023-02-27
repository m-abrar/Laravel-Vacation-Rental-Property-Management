<div class="modal fade responsive" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="iframeModalLabel" aria-hidden="true">
  <div class="ajax-spinner-center modal-center-spinner">
    <!--Shown in the center of modal window while contents are being loaded through ajax call-->
  </div>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close ajax-form-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="iframeModalLabel">Add/Edit</h4>
      </div>
      <div class="modal-body">
        <div id="iframe-form-response">
          <!--Ajax Form Submit Results Here-->
        </div>
        <iframe name="iFrame" src="" style="zoom:1" width="100%" height="430" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-iframe-submit"><span class="glyphicon glyphicon-ok"></span> Save</button>
        <button type="reset" class="btn btn-default btn-iframe-reset"><span class="glyphicon glyphicon-repeat"></span> Reset</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
