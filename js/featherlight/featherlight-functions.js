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
  Adds bonus points from activities to database.
  Parameters:
  - hot_id (Hotspot id)
  - pts (Number of bonus points)
*/
function addBnsPtsFeather(hot_id, pts){
  if(pts > 0){
    var postUrl = document.getElementById('admin_dir').getAttribute('value')+'admin-post.php';
    $.ajax({
      type: 'POST',
      url: postUrl,
      data: {
        action: 'update_progress_with_bonus',
        hotspot: hot_id,
        bonus_points: pts
      },
      success: function(){
        var totalPoints = $('#bonus_points').text();
        totalPoints = parseInt(totalPoints, 10);
        totalPoints = totalPoints + parseInt(pts, 10);
        $('#bonus_points').html(totalPoints);
        $('#done_activities').html(done_activities + hot_id.toString() + ',');
        $().toastmessage('showSuccessToast', 'You earned ' + pts + ' points!');
      }
    });
  }
}

/*
  Adds points from missions to database. The number of points is already on the database.
  Parameter:
  - hot_id (Hotspot id)
*/
function addRegPtsFeather(hot_id){
  var postUrl = document.getElementById('admin_dir').getAttribute('value')+'admin-post.php';
  $.ajax({
    type: 'POST',
    url: postUrl,
    data: {
      action: 'update_progress',
      hotspot: hot_id
    },
    success: function(){
      var hotspot = document.getElementById(hot_id+'_menu_item');
      hotspot.setAttribute('class', 'hotspot_done');
      var hotspotPoints = parseInt(hotspot.getElementsByClassName('hotspot_points')[0].innerHTML);
      $().toastmessage('showSuccessToast', 'You earned ' + hotspotPoints + ' points!');
    }
  });
}

/*
  Tests if user can open an activity based on a post to the database.
  If user is allowed a new attempt, the activity will open normally. If the user is not allowed a new attempt, a toast will be shown.
  Parameter:
  - hot_id (Hotspot id)
  Returns:
  - allow (Boolean -> [false - can't open activity] [true - can open activity])
*/
allowNewAttempt = function(hot_id){
  var allow = true;
  var postUrl = document.getElementById('admin_dir').getAttribute('value')+'admin-post.php';
  $.ajax({
    type: 'POST',
    async: false,
    url: postUrl,
    data: {
      action: 'allow_new_attempt',
      hotspot: hot_id
    },
    success: function(para){
      if(para == ''){
        para = false;
      }
      allow = para;
    }
  });
  console.log(allow);
  if(!allow){
    $().toastmessage('showNoticeToast', 'You reached the limit number of attempts for this activity');
  }
  return allow;
}

/*
  Gets the browser width and height to apply custom featherlight size options.
  Returns:
  - size (Array -> [0 - width] [1 - height])
*/
function getClientBrowserSize(){
  var myWidth;
  var myHeight;
  var size = [];

  if(typeof(window.innerWidth) == 'number' ){
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  }else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)){
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  }else if(document.body && (document.body.clientWidth || document.body.clientHeight)){
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  size.push(myWidth);
  size.push(myHeight);
  return size;
}


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
  If you want to save your activity points, set the pts parameter to true.
  Parameters:
  - frm (Frame address)
  - pts (Save points) [Default value: false]
*/
function loadFrame(act_id, frm, pts){
  var size = getClientBrowserSize();
  var width = parseInt(size[0] * 0.6);
  var height = parseInt(size[1] * 0.8);
  // var width = '100%';
  // var height = '100%';
  // Standard pts: false
  if(pts == null){
    pts = false;
  }

  allowed = function(){
    var follow = allowNewAttempt(act_id);
    return follow;
  }

  // Loading frame without pts
  if(!pts){

    // Adding points to db and toast
    showPts = function(){
        addRegPtsFeather(act_id);
    }
    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height, beforeOpen: allowed, afterClose: showPts});
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
        addBnsPtsFeather(act_id, fpoints);
      }
    }

    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height, beforeOpen: allowed, beforeClose: getPts, afterClose: showPts});
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
  If you want to save your activity points, set the award_points parameter to true.
  For bonus points, set timer to true.
  Parameters:
  - act_id (Activity unique id)
  - frm (Location of load-oppia.php)
  - oppia_id (Oppia unique id)
  - award_points (Award points) [Default value: false]
  - base_points (Base points to be awarded)
  - timer (Award bonus points) [Default value: false]
  - bonus_points (Bonus points)
  - time_limit (Time limit to be awarded with bonus points)
*/
function loadOppia(act_id, frm, oppia_id, award_points, base_points, timer, bonus_points, time_limit){
  var frame_address = '';
  if(award_points == null){
    award_points = false;
  }
  if(timer == null){
    timer = false;
  }
  if(!award_points){
    frame_address = frm + '?oppia=' + oppia_id;
  }else{
    if(!timer){
      frame_address = frm + '?oppia=' + oppia_id + '&base_points=' + base_points;
    }else{
      frame_address = frm + '?oppia=' + oppia_id + '&base_points=' + base_points + '&bonus_points=' + bonus_points + '&time_limit=' + time_limit;
    }
  }
  loadFrame(act_id, frame_address, award_points);
}
