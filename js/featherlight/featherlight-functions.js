/*
*  Featherlight Functions
*
*  Featherlight is a jQuery plugin that manages pop-up events.
*  These functions are used to load content using featherlight.
*
*  Dependencies:
*  - featherlight[.min].js
*  - featherlight[.min].css
*  - load-oppia.php (PHP file to load Google Oppia games)
*
*  Author: Douglas Modena
*/

/*
  Opens a pop-up with html content using ajax.
  Parameters:
  - htm (Ajax path)
  Returns: void
*/
function loadAjax(htm){
  $.featherlight(htm, {type: 'ajax'});
}

/*
  Opens a pop-up with a frame.
  Widht and height can be specified, or they will use YouTube standard embedded video size (560 x 315).
  If you want to save your activity points, set the pts parameter to true.
  Parameters:
  - frm (Frame address)
  - width (Pop-up width) [Default value: 560]
  - height (Pop-up height) [Default value: 315]
  - pts (Save points) [Default value: false]
*/
function loadFrame(frm, width, height, pts){
  // Standard width: 560
  if(width == null){
    width = 560;
  }
  // Standard height: 315
  if(height == null){
    height = 315;
  }
  // Standard pts: false
  if(pts == null){
    pts = false;
  }

  // Loading frame without pts
  if(!pts){
    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height});
  }

  // Loading frame with pts
  if(pts){
    // Variable to store points achieved
    var points = 0;

    // Getting points value
    getPts = function(){
      var iframe = document.getElementsByTagName('iframe')[1];
      var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
      window.points = innerDoc.getElementById('points').getAttribute('value');
    }
    // Adding points to db and toast
    showPts = function(){
      if(window.points > 0){
        addPts(4, points);
      }
    }

    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height, beforeClose: getPts, afterClose: showPts});
  }
}

/*
  Opens a pop-up with an image.
  Parameters:
  - img (Image path)
  Returns: void
*/
function loadImage(img){
  $.featherlight(img, {type: 'image'});
}

/*
  Opens a pop-up with an Oppia Exploration.
  If you want to save your activity points, set the pts parameter to true.
  Parameters:
  - frm (Frame address)
  - id (Oppia unique identifier)
  - width (Pop-up width)
  - height (Pop-up height)
  - pts (Save points) [Default value: false]
*/
function loadOppia(frm, id, width, height, pts){
  // Saving oppia id
  aux = '?oppia=' + id;
  id = aux;

  // Standard pts: false
  if(pts == null){
    pts = false;
  }

  // Loading frame without pts
  if(!pts){
    $.featherlight({iframe: frm + id, iframeWidth: width, iframeHeight: height});
  }

  // Loading frame with pts
  if(pts){
    // Variable to store points achieved
    var points = 0;

    // Getting points value
    getPts = function(){
      var iframe = document.getElementsByTagName('iframe')[1];
      var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
      window.points = innerDoc.getElementById('points').getAttribute('value');
    }
    // Adding points to db and toast
    showPts = function(){
      if(window.points > 0){
        addPts(4, points);
      }
    }

    $.featherlight({iframe: frm + id, iframeWidth: width, iframeHeight: height, beforeClose: getPts, afterClose: showPts});
  }
}
