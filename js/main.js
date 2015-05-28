
// console.log('This would be the main JS file.');

function onLoad(){
  updateMissionPoints();
  // var mission_tab = $('#krpanoSWFObject > div:nth-child(1) > div:nth-child(2) > div:nth-child(22)');
  // mission_tab.onClick(function(){
  //   updateMissionPoints();
  // });
}

function updateMissionPoints(){
  // Building mission points
  var mission_elements = document.getElementsByClassName('hotspot_points');
  var total_mission_points = 0;
  var done_mission_points = 0;
  for(var i = 0; i < mission_elements.length; i++){
    var points = parseInt(mission_elements[i].innerHTML);
    total_mission_points += points;
    if(mission_elements[i].parentNode.parentNode.getAttribute('class') == 'hotspot_done'){
      done_mission_points += points;
    }
  }
  document.getElementById('current_points').innerHTML = done_mission_points;
  document.getElementById('total_mission_points').innerHTML = total_mission_points;
}


document.addEventListener('DOMContentLoaded', onLoad, false);
