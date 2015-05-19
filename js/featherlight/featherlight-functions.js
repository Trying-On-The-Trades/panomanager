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
  Opens a pop-up with an image.
  Parameters:
  - img (Image path)
  Returns: void
*/
function loadImage(img){
  $.featherlight(img, {type: 'image'});
}

/*
 Opens a pop-up with a frame.
 Width and height can be specified, or they will use Youtube standard embedded video size (560 x 315)
 The last argument is optional, and used when loading an Google Oppia game.
 Parameters:
 - frm (Frame address)
 - width (Pop-up width) [Default value: 560]
 - height (Pop-up height) [Default value: 315]
 - oppia (Unique oppia game identifier, or oppia-id)
 Returns: void
*/
function loadFrame(frm, width, height, oppia){
  // Standard width
  if(width == null){
    width = 560;
  }
  // Standard height
  if(height == null){
    height = 315;
  }
  // Loading non-oppia iframe
  if(oppia == null){
    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height});
  }
  // Loading oppia iframe
  if(oppia != null){
    var aux = '?oppia=' + oppia;
    oppia = aux;
    var points = 0;

    function getPts(){
      var iframe = document.getElementsByTagName('iframe')[1];
      var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
      window.points = innerDoc.getElementById('points').getAttribute('value');
      console.log(window.points);
    }

    showPts = function(){
      if(window.points > 0){
        addPts(4, points);
      }
    }
    $.featherlight({iframe: frm + oppia, iframeWidth: width, iframeHeight: height, beforeClose: getPts, afterClose: showPts});
  }  
}

/*
  Opens a pop-up with html content using ajax
  Parameters:
  - htm (Ajax path)
  Returns: void
*/
function loadAjax(htm){
  $.featherlight(htm, {type: 'ajax'});
}
