<div class="DragFileUpload">
    <div class="DragFileUpload__title"><span>파일업로드</span></div>
    <input type="hidden" name="ta_idx" value="<?php echo $ta_idx ?>" />
    <input type="hidden" name="nr_idx" value="<?php echo $nr_idx ?>" />
    <div id="uploader" class="DragFileUpload__drag">
        <span>Drop Files Here</span>
    </div>
    <!-- STATUS -->
    <div id="upstat"></div>

    <!-- FALLBACK -->
    <?php echo form_open_multipart('/nmpa/erps_doc/do_upload', array("class"=>"DragFileUpload__form"));?>
        <input type="file" name="userfile[]" id="userfile" />
        <input type="submit" value="Upload File" name="submit" />
    <?php echo form_close() ?>
</div>

<script>

var upcontrol = {
  queue : null, // upload queue
  now : 0, // current file being uploaded
  start : function (files) {
    // WILL ONLY START IF NO EXISTING UPLOAD QUEUE
    if (upcontrol.queue==null) {
      // VISUAL - DISABLE UPLOAD UNTIL DONE
      upcontrol.queue = files;
      document.getElementById('uploader').classList.add('disabled');

      // PROCESS UPLOAD - ONE BY ONE
      upcontrol.run();
    }
  },
  run : function () {
    var xhr = new XMLHttpRequest();
    var data = new FormData();
    data.append('userfile', upcontrol.queue[upcontrol.now]);
    data.append("ta_idx", $("[name='ta_idx']").val() );
    data.append("nr_idx", $("[name='nr_idx']").val() );

    // @TODO - ADD MORE POST DATA IF YOU WANT
    // data.append("foo", "bar");
 
    xhr.open('POST', '/nmpa/erps_doc/ajax_upload', true);
    xhr.onload = function (e) {
      // SHOW UPLOAD STATUS
      var fstat = document.createElement('div'),
          txt = upcontrol.queue[upcontrol.now].name + " - ";
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          // SERVER RESPONSE
          alert(xhr.responseText);
          //window.close();
        } else {
          // ERROR
          alert(xhr.responseText);
          //window.close();
        }
      }
   
      // UPLOAD NEXT FILE
      upcontrol.now++;
      if (upcontrol.now < upcontrol.queue.length) {
        upcontrol.run();
      } else {
        upcontrol.now = 0;
        upcontrol.queue = null;
        document.getElementById('uploader').classList.remove('disabled');
 
        // @TODO - ADD MESSAGE HERE IF YOU WANT
        console.log("Upload complete");
      }
    };
    xhr.send(data);
  }
};

window.addEventListener("load", function () {

  // IF DRAG-DROP UPLOAD SUPPORTED
  if (window.File && window.FileReader && window.FileList && window.Blob) {
    /* [THE ELEMENTS] */
    var uploader = document.getElementById('uploader');

    /* [VISUAL - HIGHLIGHT DROP ZONE ON HOVER] */
    uploader.addEventListener("dragenter", function (e) {
      e.preventDefault();
      e.stopPropagation();
      uploader.classList.add('highlight');
    });
    uploader.addEventListener("dragleave", function (e) {
      e.preventDefault();
      e.stopPropagation();
      uploader.classList.remove('highlight');
    });

    /* [UPLOAD MECHANICS] */
    // STOP THE DEFAULT BROWSER ACTION FROM OPENING THE FILE
    uploader.addEventListener("dragover", function (e) {
      e.preventDefault();
      e.stopPropagation();
    });

    // ADD OUR OWN UPLOAD ACTION
    uploader.addEventListener("drop", function (e) {
      e.preventDefault();
      e.stopPropagation();
      uploader.classList.remove('highlight');
      upcontrol.start(e.dataTransfer.files);
    });
  }
  // FALLBACK - HIDE DROP ZONE IF DRAG-DROP UPLOAD NOT SUPPORTED
  else {
    document.getElementById('uploader').style.display = "none";
  }
});
</script>