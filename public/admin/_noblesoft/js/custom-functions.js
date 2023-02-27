
    function PreviewImage(no) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage" + no).files[0]);
        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview" + no).src = oFREvent.target.result;
        };
    }


    function confirmDelete(delUrl) {
        if (confirm("Are you sure you want to delete?\r\nThis action is not reversible.")) {
            document.location = delUrl;
        }
    }


    $(document).ready(function() {

        $(".iframe-form-open").click(function() {

            $("#iframe-form-response").html('');
            var rel = $(this).attr('rel');
            $('iframe').attr("src", rel);
            var title = $(this).attr('title');
            if(title==''){title = 'Add/Edit';}
            $("#iframeModalLabel").html(title);

        });

        $(".make-modal-large").click(function() {
            $(".modal-dialog").addClass('modal-lg');
        });
        
        $(".btn-iframe-submit").click(function() {
            $('iframe').contents().find('form')[0].submit();
        });
        $(".btn-iframe-reset").click(function() {
            $('iframe').contents().find('form')[0].reset();
        });

    });






var spinnerVisible = false;
  
  function showSpinnerOnPage() { 
      if (!spinnerVisible) {
            $(".page-center-spinner").html();
            $(".page-center-spinner").fadeIn("slow");
            spinnerVisible = true;
      }
    }
  function hideSpinnerOnPage() { 
    if (spinnerVisible) {
          var spinner = $(".page-center-spinner");
          spinner.stop();
          spinner.fadeOut("slow");
          spinnerVisible = false;
      }
  }
