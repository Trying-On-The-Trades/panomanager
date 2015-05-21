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
function loadFrame(act_id, frm, width, height, pts){
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
    fpoints = 0;

    // Getting points value
    getPts = function(){

      var iframe = document.getElementsByClassName('featherlight-inner')[0];
      var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
      fpoints = innerDoc.getElementById('points').getAttribute('value');
    }
    // Adding points to db and toast
    showPts = function(){
      if(fpoints > 0){
        addPointsFeather(act_id, fpoints);
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
  - oppia_id (Oppia unique identifier)
  - width (Pop-up width)
  - height (Pop-up height)
  - pts (Save points) [Default value: false]
*/
function loadOppia(act_id, frm, oppia_id, width, height, pts){
  // Saving oppia id
  aux = '?oppia=' + oppia_id;
  oppia_id = aux;

  // Standard pts: false
  if(pts == null){
    pts = false;
  }

  // Loading frame without pts
  if(!pts){
    $.featherlight({iframe: frm + oppia_id, iframeWidth: width, iframeHeight: height});
  }

  // Loading frame with pts
  if(pts){
    // Variable to store points achieved
    fpoints = 0;

    // Getting points value
    getPts = function(){
      var iframe = document.getElementsByClassName('featherlight-inner')[0];
      var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
      fpoints = innerDoc.getElementById('points').getAttribute('value');
    }
    // Adding points to db and toast
    showPts = function(){
      if(fpoints > 0){
        addPointsFeather(act_id, fpoints);
      }
    }

    $.featherlight({iframe: frm + oppia_id, iframeWidth: width, iframeHeight: height, beforeClose: getPts, afterClose: showPts});
  }
}

/*
  Adds points to extra activities.
  Parameters:
  - id (activity id)
  - pts (number of points to be added)
*/
function addPointsFeather(act_id, pts){
  // Checking if activity was previously done
  var done = false;
  console.log(document.cookie);
  if(cookie = ''){
    done = false;
    document.cookie="act_id=" + act_id + "";
    // setCookie('act_id', act_id.toString());
  }else{
    cookie_content = getCookie('act_id');
    if(act_id == cookie_content){
      done = true;
    }
  }
  // if(!window.completed){
  //   window.completed = [];
  //   done = false;
  // }
  // else{
  //   for(var i = 0; i < window.completed.length; i++){
  //     if(act_id == window.completed[i]){
  //       done = true;
  //     }else{
  //       window.completed.push(act_id);
  //     }
  //   }
  // }
  // console.log(window.completed);
  if(!done){
    // Checking for positive number of points
    if(pts > 0){
      var totalPoints = $('#bonus_points').text();
      totalPoints = parseInt(totalPoints, 10);
      totalPoints = totalPoints + parseInt(pts, 10);
      $('#bonus_points').html(totalPoints);
      $().toastmessage('showSuccessToast', 'You earned ' + pts + ' points!');
    }
  }
}

// Cookie functions
function setCookie(cname, cvalue, exdays) {
    if(exdays != null){
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+d.toUTCString();
    }else{
      expires = "";
    }
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}
