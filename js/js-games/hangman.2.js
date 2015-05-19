var answer="",currentword="";
var gamestatus=0;
function gameHelp() {
    alert("Click on a blue letter to guess that letter. Guess correctly: the letter turns green and you are closer to earning your hardhat. Guess incorrectly: the letter turns red and you are closer to losing. You are allowed seven incorrect guesses.");
}
function Setup() {
  if (!document.getElementById) return;
  DrawAlphabet();
  ChoosePhrase();
  dispword=document.getElementById("aphrase");
  ChooseWord();
  dispword=document.getElementById("theword");
  for (i=0;i<answer.length;i++) {
    currentword += "_";
  }
  dispword.innerHTML=currentword;
}
function DrawAlphabet() {
  document.getElementById("alphabet").innerHTML = "";
  alpha=document.getElementById("alphabet");
  for (i=65;i<91;i++) {
    letter=String.fromCharCode(i);
    node=document.createElement("A");
    node.id=letter;
    quoted="\"" + letter + "\"";
    node.setAttribute("href","javascript:Guess("+quoted+");");
    node.className="letter";
    node.innerHTML=letter;
    alpha.appendChild(node);
  }
}
function ChoosePhrase() {
  num=Math.floor(Math.random()*phrases.length);
}
function ChooseWord() {
  num=Math.floor(Math.random()*words.length);
  answer=words[num].toUpperCase();
}
function Guess(letter) {
  stat=document.getElementById("status");
  alpha=document.getElementById("alphabet");
  displetter=document.getElementById(letter);
  node=document.createElement("span");
  node.innerHTML=letter;
  node.id=letter;
  if (answer.indexOf(letter) != -1) {
    AddLetter(letter);
    newsrc="hardhat-smiley-smile.png";
    document.images["hangman"].src=newsrc;
    stat.innerHTML="Correct!  Guess another letter.";
    node.style.color="green";
    alpha.replaceChild(node,displetter);
    if (currentword==answer) {
        GameOver("You have earned a hardhat! ");
        newsrc="hardhat-smiley8.png";
        document.images["hangman"].src=newsrc;
    }
  } else {
    stat.innerHTML="Incorrect!  Guess again!";
    node.style.color="red";
    alpha.replaceChild(node,displetter);
    Hang();
  }
}
function AddLetter(letter) {
  dispword=document.getElementById("theword");
  newword="";
  for (i=0;i<answer.length;i++) {
    if (answer.charAt(i)==letter)  newword += letter;
      else newword += currentword.charAt(i);
  }
  currentword=newword;
  dispword.innerHTML=currentword;
}
function Hang() {
  gamestatus++;
  newsrc="hardhat-smiley" + gamestatus + ".png";
  document.images["hangman"].src=newsrc;
  if (gamestatus==7) GameOver("Sorry! ");
}
function GameOver(text) {
  stat=document.getElementById("status");
  alpha=document.getElementById("alphabet");
  dispword=document.getElementById("theword");
//  newlink=" <a href='javascript:location.reload();'>Click Here</a>";
//  newlink+=" to start a new game.";
//  stat.innerHTML="<b ID='gameover'>GAME OVER - </b> - " + text + newlink;
  stat.innerHTML="GAME OVER - " + text;
  
  dispword.innerHTML=answer;
  for (i=65;i<91;i++) {
    letter=String.fromCharCode(i);
    oldnode=document.getElementById(letter);
    if (oldnode.nodeName=="A") {
      node=document.createElement("span");
      node.innerHTML=letter;
      node.className="letter";
      alpha.replaceChild(node,oldnode);
    } // end if
  } // end for
}