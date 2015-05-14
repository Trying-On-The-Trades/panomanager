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
  if(width == null){
    width = 560;
  }

  if(height == null){
    height = 315;
  }

  if(oppia == null){
    oppia = '';
  }else{
    var aux = '?oppia=' + oppia;
    oppia = aux;
  }

  $.featherlight({iframe: frm + oppia, iframeWidth: width, iframeHeight: height});
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
