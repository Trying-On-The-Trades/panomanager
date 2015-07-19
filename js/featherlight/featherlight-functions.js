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
function addBonusPoints(hot_id, pts){
  if(pts != 0){
    postUrl = getPostUrl();
    $.ajax({
      type: 'POST',
      url: postUrl,
      data: {
        action: 'update_progress_with_bonus',
        hotspot: hot_id,
        bonus_points: pts
      },
      success: function(){
        var verb = pointsVerb(pts);
        var totalPoints = $('#bonus_points').text();
        totalPoints = parseInt(totalPoints, 10);
        totalPoints = totalPoints + parseInt(pts, 10);
        $('#bonus_points').html(totalPoints);
        $('#done_activities').html(done_activities + hot_id.toString() + ',');
        $().toastmessage('showSuccessToast', 'You ' + verb + ' ' + pts + ' ' + getPointsName(pts) + '!');
      }
    });
  }
}

/*
  Adds points from missions to database. The number of points is already on the database.
  Parameter:
  - hot_id (Hotspot id)
*/
function addRegularPoints(hot_id){
  var postUrl = getPostUrl();
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
      $().toastmessage('showSuccessToast', 'You earned ' + hotspotPoints + ' ' + getPointsName(hotspotPoints) + '!');
    }
  });
}

/*
  Tests if user can open an activity based on a post to the database.
  If user is allowed a new attempt, the activity will open normally.
  If the user is not allowed a new attempt, a toast will be shown.
  Parameter:
  - hot_id (Hotspot id)
  Returns:
  - allow (Boolean -> [false - can't open activity] [true - can open activity])
*/
allowNewAttempt = function(hot_id){
  var allow = true;
  var postUrl = getPostUrl();
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
  if(!allow){
    $().toastmessage('showNoticeToast', 'You reached the limit number of attempts for this activity');
  }
  return allow;
}

/*
  Displays the hotspot information message in a featherlight pop-up.
*/
function displayInfoMessage(message){
  $.featherlight("<p style=\"white-space: pre;\">           " + message + "</p>", null, false);
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
  Gets the last hotstpot information message trough an ajax call.
  The global variable 'lastHotspot' keeps track of the hotspot id.
*/
// Initializing variable
lastHotspot = 0;
function getInfoMessage(){
  var postUrl = getPostUrl();
  var ret = $.ajax(
    {
      async : false,
      method: 'POST',
      url : postUrl,
      data : {
        action : 'get_hotspot_info',
        hotspot_id : lastHotspot
      }
    })
  return ret.responseText;
}

/*
  Returns the alias for points chosen by the user, in the plural form (if points > 1), or singular form (otherwise).
  Parameters:
  - pts_qty (The quantity of points awarded)
  Returns:
  - pointsName (String)
*/
function getPointsName(pts_qty){
  var postUrl = getPostUrl();
  var pointsName = 'points';
  if(pts_qty > 1 || pts_qty < -1){
    $.ajax({
      type: 'POST',
      async: false,
      url: postUrl,
      data: {
        action: 'get_points_name_plural'
      },
      success: function(plural){
        pointsName = plural;
      }
    });
  }
  else{
    $.ajax({
      type: 'POST',
      async: false,
      url: postUrl,
      data: {
        action: 'get_points_name_singular'
      },
      success: function(singular){
        pointsName = singular;
      }
    });
  }
  return pointsName;
}

/*
  Returns the url address of the post page.
*/
function getPostUrl(){
  var postUrl = document.getElementById('admin_dir').getAttribute('value')+'admin-post.php';
  return postUrl;
}

/*
  Opens a pop-up with html content using ajax.
  Parameters:
  - hot_id (Hotspot id)
  - htm (Ajax path)
  Returns: void
*/
function loadAjax(hot_id, htm){
  updateLastHotspot(hot_id);
  $.featherlight(htm, {type: 'ajax'});
}

/*
  Opens a pop-up with a frame.
  If you want to save your activity points, set the pts parameter.
  Parameters:
  - hot_id (Hotspot id)
  - frm (Frame address)
  - pts (Save points) [Default value: 'none'] [Regular mission points: 'reg'] [Bonus points: 'bns']
*/
function loadFrame(hot_id, frm, pts){
  updateLastHotspot(hot_id);
  var size = getClientBrowserSize();
  var width = parseInt(size[0] * 0.8);
  var height = parseInt(size[1] * 0.8);
  // Standard pts: 'none'
  if(pts == null){
    pts = 'none';
  }

  allowed = function(){
    var follow = allowNewAttempt(hot_id);
    return follow;
  }

  // Loading frame with no points
  if(pts == 'none'){
    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height, beforeOpen: allowed});
  }

  // Loading frame with regular points
  else if(pts == 'reg'){

    // Adding points to db and toast
    showPts = function(){
        addRegularPoints(hot_id);
    }
    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height, beforeOpen: allowed, afterClose: showPts});
  }

  // Loading frame with bonus points
  else if(pts == 'bns'){
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
      if(fpoints != 0){
        addBonusPoints(hot_id, fpoints);
      }
    }

    $.featherlight({iframe: frm, iframeWidth: width, iframeHeight: height, beforeOpen: allowed, beforeClose: getPts, afterClose: showPts});
  }
}

/*
  Opens a pop-up with an image.
  Parameters:
  - hot_id (Hotspot id)
  - img (Image path)
  Returns: void
*/
function loadImage(hot_id, img){
  updateLastHotspot(hot_id);
  $.featherlight(img, {type: 'image'});
}

/*
  Opens a pop-up with an Oppia Exploration.
  If you want to save your activity points, set the award_points parameter to true.
  For bonus points, set timer to true.
  Parameters:
  - hot_id (Hotspot id)
  - frm (Location of load-oppia.php)
  - oppia_id (Oppia unique id)
  - award_points (Award points) [Default value: 'none']
  - base_points (Base points to be awarded)
  - timer (Award bonus points) [Default value: false]
  - bonus_points (Bonus points)
  - time_limit (Time limit to be awarded with bonus points)
*/
function loadOppia(hot_id, frm, oppia_id, award_points, base_points, timer, bonus_points, time_limit){
  updateLastHotspot(hot_id);
  var frame_address = '';
  if(award_points == null){
    award_points = 'none';
  }
  if(timer == null){
    timer = false;
  }
  if(award_points == 'none'){
    frame_address = frm + '?oppia=' + oppia_id;
  }else{
    if(!timer){
      frame_address = frm + '?oppia=' + oppia_id + '&base_points=' + base_points;
    }else{
      frame_address = frm + '?oppia=' + oppia_id + '&base_points=' + base_points + '&bonus_points=' + bonus_points + '&time_limit=' + time_limit;
    }
  }
  loadFrame(hot_id, frame_address, award_points);
}

/*
  Opens a pop-up with the item to be sold. If purchase is successful, a toast message will be displayed.
  Parameters:
  - hot_id (Hotspot id)
  - item_id (The item database id)
*/
function loadShopItem(hot_id, item_id){
  updateLastHotspot(hot_id);
  var width = 400;
  var height = 400;
  var shopUrl = 'wp-content/plugins/panomanager/shop/shop.php?id=' + item_id;
  sMessage = '';
  message = function(){
    var iframe = document.getElementsByClassName('featherlight-inner')[0];
    var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
    var messageContent = innerDoc.getElementById('shop_message').getAttribute('value');
    sMessage = messageContent;
  }
  messageToast = function(){
    if(sMessage != ''){
      $().toastmessage('showSuccessToast', sMessage);
    }
  }
  $.featherlight({iframe: shopUrl, iframeWidth: width, iframeHeight: height, beforeClose: message, afterClose: messageToast});
}

/*
  Opens a pop-up with a video from a url.
  Parameters:
  - hot_id (Hotspot id)
  - url (Video url)
*/
function loadVideo(hot_id, url){
  updateLastHotspot(hot_id);
  var width = 560;
  var height = 315;
  $.featherlight({iframe: url, iframeWidth: width, iframeHeight: height});
}

/*
  Returns the verb according to the amount of points.
  Returns:
  - verb [earned - if positive] [lost - if negative]
*/
function pointsVerb(pts){
  var verb = '';
  if(pts > 0){
    verb = 'earned';
  }
  else if(pts < 0){
    verb = 'lost';
  }
  return verb;
}

/*
  Updates the value of the last hotspot open, in order to have its description shown.
  Parameters:
  - hot_id (Last hotspot id open)
*/
function updateLastHotspot(hot_id){
  if(hot_id > 0){
    lastHotspot = hot_id;
  }
}
