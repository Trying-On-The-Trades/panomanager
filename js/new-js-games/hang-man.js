window.onload = function () {

  var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y', 'z'];
  
  var categories;         // Array of topics
  var chosenCategory;     // Selected catagory
  var getHint ;          // Word getHint
  var word ;              // Selected word
  var guess ;             // Geuss
  var geusses = [ ];      // Stored geusses
  var lives ;             // Lives
  var counter ;           // Count correct geusses
  var space;              // Number of spaces in word '-'

  // Get elements
  var showLives = document.getElementById("mylives");
  var showCatagory = document.getElementById("scatagory");
  var getHint = document.getElementById("hint");
  var showClue = document.getElementById("clue");
    
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
  winner.setAttribute("src", "images/hat-smiley-cap.png");
  winner.setAttribute("alt", "WINNER!");
    
  var rightAnswer = document.createElement("img");
  rightAnswer.setAttribute("src", "images/right.png");
  rightAnswer.setAttribute("alt", "Right!");
    
  var gameOver = document.createElement("img");
  gameOver.setAttribute("src", "images/gameOver.png");
  gameOver.setAttribute("alt", "Game Over!");


  // create alphabet ul
  var buttons = function () {
    myButtons = document.getElementById('buttons');
    letters = document.createElement('ul');

    for (var i = 0; i < alphabet.length; i++) {
      letters.id = 'alphabet';
      list = document.createElement('li');
      list.innerHTML = alphabet[i];
      check();
      myButtons.appendChild(letters);
      letters.appendChild(list);
    }
  }
    
  
  // Select Catagory
  var selectCat = function () {
    if (chosenCategory === categories[0]) {
      catagoryName.innerHTML = "The Chosen Category Is Premier League Football Teams";
    } else if (chosenCategory === categories[1]) {
      catagoryName.innerHTML = "The Chosen Category Is Films";
    } else if (chosenCategory === categories[2]) {
      catagoryName.innerHTML = "The Chosen Category Is Cities";
    }
  }

  // Create geusses ul
   result = function () {
    wordHolder = document.getElementById('hold');
    correct = document.createElement('ul');

    for (var i = 0; i < word.length; i++) {
      correct.setAttribute('id', 'my-word');
      guess = document.createElement('li');
      guess.setAttribute('class', 'guess');
      if (word[i] === "-") {
        guess.innerHTML = "-";
        space = 1;
      } else {
        guess.innerHTML = "_";
      }

      geusses.push(guess);
      wordHolder.appendChild(correct);
      correct.appendChild(guess);
    }
  }
  
  // Show lives
   comments = function () {
    showLives.innerHTML = "You have " + lives + " lives";
    if (lives < 1) {
        smileImage.innerHTML = "";
        showLives.innerHTML = "Game Over!";
        smileImage.appendChild(gameOver);
    }
    for (var i = 0; i < geusses.length; i++) {
      if (counter + space === geusses.length) {
        smileImage.innerHTML = "";
        showLives.innerHTML = "Winner!!!!";
        smileImage.appendChild(winner);
      }
    }
  }
   
  function animate(result){
      var live = lives;
      smileImage = document.getElementById("smileImage");
      if (result == false) {
          switch (live) {
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
      } else{
          smileImage.innerHTML = "";
          smileImage.appendChild(rightAnswer);
      }
  }


  // OnClick Function
   check = function () {
    list.onclick = function () {
      var geuss = (this.innerHTML);
      this.setAttribute("class", "active");
      this.onclick = null;
      for (var i = 0; i < word.length; i++) {
        if (word[i] === geuss) {
          geusses[i].innerHTML = geuss;
          counter += 1;
        } 
      }
      var j = (word.indexOf(geuss));
      if (j === -1) {
        lives -= 1;
        comments();
        animate(false);
      } else {
        animate(true);
        comments();
      }
    }
  }
  
    
  // Play
  play = function () {
    categories = [
        ["everton", "liverpool", "swansea", "chelsea", "hull", "manchester-city", "newcastle-united"],
        ["alien", "dirty-harry", "gladiator", "finding-nemo", "jaws"],
        ["manchester", "milan", "madrid", "amsterdam", "prague"]
    ];

    chosenCategory = categories[Math.floor(Math.random() * categories.length)];
    word = chosenCategory[Math.floor(Math.random() * chosenCategory.length)];
    word = word.replace(/\s/g, "-");
    console.log(word);
    buttons();

    geusses = [ ];
    lives = 7;
    counter = 0;
    space = 0;
    result();
    comments();
    selectCat();
  }

  play();
  
  // Hint

    hint.onclick = function() {

      hints = [
        ["Based in Mersyside", "Based in Mersyside", "First Welsh team to reach the Premier Leauge", "Owned by A russian Billionaire", "Once managed by Phil Brown", "2013 FA Cup runners up", "Gazza's first club"],
        ["Science-Fiction horror film", "1971 American action film", "Historical drama", "Anamated Fish", "Giant great white shark"],
        ["Northern city in the UK", "Home of AC and Inter", "Spanish capital", "Netherlands capital", "Czech Republic capital"]
    ];

    var catagoryIndex = categories.indexOf(chosenCategory);
    var hintIndex = chosenCategory.indexOf(word);
    showClue.innerHTML = "Clue:  " +  hints [catagoryIndex][hintIndex];
  };

   // Reset

  document.getElementById('reset').onclick = function() {
    correct.parentNode.removeChild(correct);
    letters.parentNode.removeChild(letters);
    showClue.innerHTML = "";
    context.clearRect(0, 0, 400, 400);
    play();
  }
}


