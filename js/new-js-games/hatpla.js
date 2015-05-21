//HatPla js game
//Version 1.3 20/05/15
//Andre F. C. Silva and Julia Passamani
//BITSpace Development

var guesses = []; //array with correct guesses
var guess; //variable with actual guess
var lives; //number of lives available
var showLives; //element to show the number of lives
var counter; //number of characters correct
var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
      'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
      't', 'u', 'v', 'w', 'x', 'y', 'z'];
var space;//number of spaces found in the word
var used_hint;//bool variable to check if hitn was used

//this section creates the image elements to represent the user's progress
var error1 = document.createElement("img");
error1.setAttribute("src", "images/1error.png");
error1.setAttribute("alt", "No Image");   

var error2 = document.createElement("img");
error2.setAttribute("src", "images/2error.png");
error2.setAttribute("alt", "No Image");

var error3 = document.createElement("img");
error3.setAttribute("src", "images/3error.png");
error3.setAttribute("alt", "No Image");

var error4 = document.createElement("img");
error4.setAttribute("src", "images/4error.png");
error4.setAttribute("alt", "No Image");

var error5 = document.createElement("img");
error5.setAttribute("src", "images/5error.png");
error5.setAttribute("alt", "No Image");

var error6 = document.createElement("img");
error6.setAttribute("src", "images/6error.png");
error6.setAttribute("alt", "No Image");

var error7 = document.createElement("img");
error7.setAttribute("src", "images/7error.png");
error7.setAttribute("alt", "No Image");

var winner = document.createElement("img");
winner.setAttribute("src", winner_image);
winner.setAttribute("alt", "WINNER!");

var rightAnswer = document.createElement("img");
rightAnswer.setAttribute("src", "images/right.png");
rightAnswer.setAttribute("alt", "Right!");

var gameOver = document.createElement("img");
gameOver.setAttribute("src", "images/gameOver.png");
gameOver.setAttribute("alt", "Game Over!");


//function that occurrs when the page loads
function load()
{
  //set the variables to their initial values
  //alert(log);
  space = 0;
  word = word.replace(/\s/g, '-');
	showLives = document.getElementById("mylives");
	lives = 7;
	counter = 0;
  used_hint = false;

  //shows the number of lives
  comments();

  //gets elements for further use
	var myButtons = document.getElementById('buttons');
  var letters = document.createElement('ul');
  letters.id = 'alphabet'; 

  //adds event listeners to buttons
  document.getElementById("reset").addEventListener("click", reset, false);
  document.getElementById("hint").addEventListener("click", show_hint, false)

  //creates the alphabet elements
  for (var i = 0; i < alphabet.length; i++) {
    var list = document.createElement('li');
    list.innerHTML = alphabet[i];
    check(list);
    myButtons.appendChild(letters);
    letters.appendChild(list);
  }

  //shows the word to be guessed
  result();  
}

//adds event listenres to each letter's button
function check(list) 
{
  list.onclick = function () //deactivates letter and finds its occurrences
  {
    var guess = (this.innerHTML);
    this.setAttribute("class", "active");
    this.onclick = null;
    for (var i = 0; i < word.length; i++) 
    {
      if (word[i] === guess) 
      {
        guesses[i].innerHTML = guess;
        counter += 1;
      } 
    }
    var j = (word.indexOf(guess));
    if (j === -1) 
    {
      lives -= 1;
      comments();
      animate(false);
    } 
    else 
    {
      var winner = comments();
      if(!winner){
        animate(true);
      }
    }
  }
}

//function that updates the image based on the user's progress
function animate(result)
{
  var live = lives;
  smileImage = document.getElementById("smileImage");
  if (result == false) //user guessed a wrong letter
  {
      switch (live) //displays different images based on the number of lives
      {
        case 1: smileImage.innerHTML = "";
                smileImage.appendChild(error7);
                break;
        case 2: smileImage.innerHTML = "";
                smileImage.appendChild(error6);
                break;
        case 3: smileImage.innerHTML = "";
                smileImage.appendChild(error5);
                break;
        case 4: smileImage.innerHTML = "";
                smileImage.appendChild(error4);
                break;
        case 5: smileImage.innerHTML = "";
                smileImage.appendChild(error3);
                break;
        case 6: smileImage.innerHTML = "";
                smileImage.appendChild(error2);
                break;
        case 7: smileImage.innerHTML = "";
                smileImage.appendChild(error1);
                break;
      }
  } 
  else//the user guessed a correct letter
  {
      smileImage.innerHTML = "";
      smileImage.appendChild(rightAnswer);
  }
}

//shows the comments (number of lives, win and lose message)
//in case the game ends, locks the game and returns if the user won or not.
function comments() {
    showLives.innerHTML = "You have " + lives + " lives";
    if (lives < 1) {
      smileImage.innerHTML = "";
      showLives.innerHTML = "Game Over!";
      smileImage.appendChild(gameOver);
      lock(false);
      return false;

    }
    for (var i = 0; i < guesses.length; i++) {
      if (counter + space === guesses.length) {
        smileImage.innerHTML = "";
        showLives.innerHTML = "Winner!!!!";
        smileImage.appendChild(winner);
        lock(true);
        return true;
      }
    }
  }

//creates the holder for the word
function result() 
{
  var wordHolder = document.getElementById('hold');
  var correct = document.createElement('ul');
  correct.setAttribute('id', 'my-word');

  for (var i = 0; i < word.length; i++) {
    var guess = document.createElement('li');
    guess.setAttribute('class', 'guess');
    if (word[i] === "-") {
      guess.innerHTML = "-";
      space += 1;
    } else {
      guess.innerHTML = "_";
    }

    guesses.push(guess);
    correct.appendChild(guess);
  }
  wordHolder.appendChild(correct);
}

//locks the game and if the user won, shows the answer. At the end, calculates the final points
function lock(winner)
{
	var list_letters = document.getElementById("alphabet").childNodes;

	for(var i = 0; i < list_letters.length; i++)
	{
		list_letters[i].setAttribute("class", "active");
        list_letters[i].onclick = null;
	}

	document.getElementById("hint").style.display = "none";
    
    if(!winner)
	   show_answer();

   calculate_points();
    
}

//shows game's answer
function show_answer()
{
	var hold_list = document.getElementById("my-word").childNodes;
	for(var i = 0; i < word.length; i++)
	{
		hold_list[i].innerHTML = word.charAt(i);
	}
}

//resets the game
function reset()
{
	window.location.reload();
}

//shows hint and flag that points should be deducted
function show_hint()
{
	document.getElementById("clue").innerHTML = "Hint: " + hint;
  used_hint = true;
}

//calclates final points
function calculate_points()
{
  var life = lives;
  var points = 1 + life;
  if(!used_hint)
    points += 2;
  document.getElementById("points").setAttribute("value", points);
  console.log("Points: " + document.getElementById("points").value);
}

//enet listener to the page loading
document.addEventListener("DOMContentLoaded", load, false);