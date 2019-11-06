Oui je te la passe avec plaisir mais je il va falloir apprendre ce langage pour comprendre, je te le commenterais en bref. De plus, c'est une bibliothèque que j'utilise : jquery.



$(function() { // a la fin du chargement de la page
    $('#button').click(function() {
 
        //#button est un selecteur css, tu peux utiliser des sélecteurs css comme .monDiv ou #monDiv ou encore une balise
        //Cette ligne peut être traduite en français par : au click sur le sélecteur css #button
 
        $.post('pageCible.php',  //la page ou tu veux faire ta requête
        {
            pseudo: $("#pseudo").val(),            //ces variables sont les valeurs de chaques champs du formulaire
            password: $("#password").val()
        },
 
            function(data) //c'est la fonction qui gère le retour, le resultat
            {
                if(data == 'ok') //si le script retourne ok
                {
                    alert('ok'); //on affiche une boite de dialogue
                }
                else
                {
                    alert("erreur"); //on affiche une boite de dialogue avec une erreur
                }
            }
        );
    });
});



pageCible.php

<?php
if(isset($_POST['pseudo']) AND isset($_POST['password']))
{
    echo 'ok'; // la valeur de retour
}
else
{
    echo 'erreur'; //une autre valeur de retour
}
?>








j'ai résolue mon problème !!!!

j'explique au cas ou....

dans ma page player j'ai mis ce script :

<script>
function refresh_div()
{
var xhr_object = null;
if(window.XMLHttpRequest)
{ // Firefox
xhr_object = new XMLHttpRequest();
}
else if(window.ActiveXObject)
{ // Internet Explorer
xhr_object = new ActiveXObject('Microsoft.XMLHTTP');
}
var method = 'POST';
var filename = 'refresh.php';
xhr_object.open(method, filename, true);
xhr_object.onreadystatechange = function()
{
if(xhr_object.readyState == 4)
{
var tmp = xhr_object.responseText;
document.getElementById('refresh').innerHTML = tmp;
setTimeout(refresh_div, 10000);
}
}
xhr_object.send(null);
}
</script>


ensuite dans la page refresh.php j'ai mis mon code qui va chercher le xml :


<?php
  
$live = simplexml_load_file('http://www.***.fr/TITRE/1/title_123.xml');
  foreach ($live->current_song as $current_song) {
    print "Artiste : {$current_song->artist} <br />\n";
    print "Titre : {$current_song->title} <br />\n";
  
  }
  
   
   foreach ($live->Next_song as $Next_song) {
    print "Artiste : {$Next_song->artist} <br />\n";
    print "Titre : {$Next_song->title} <br />\n";
  
  }
 ?>

et de nouveau dans ma page player je met ceci :


<body onload='refresh_div();'>
    <div>
      <div id="refresh"></div>
       
    </div>






SOLUTION ULTIME ?

euh t'as pas besoin d'ajax pour recharger juste une div dans une page...

il te suffit de faire ça avec jQuery

exemple :

$(document).ready(function(){

    setInterval(function(){
        $('#taDiv');
    },3000); // ici toutes les 3 secondes

});



SUITE :

Eh bien en fait je veux rafraîchir ma <div> d'exemple afin qu'elle rappelle la fonction  : ~BattVoltage~. Cette fonction BattVoltage est appelée en C (Ne t'occupes pas de ça, pars du principe que cette fonction est correctement appelée et fonctionne).

En gros, lorsque j'actualise ma page, la div est actualisée aussi, permettant d'appeler cette fonction. Cette fonction renvoie une valeur qui change. Je veux donc rafraîchir la div afin de rafraîchir la valeur !

Là où le problème se pose c'est qu'elle n'est pas appelée périodiquement comme je le souhaite .




ah fallait le dire ^^

dans ce cas-là tu fais :

$(document).ready(function(){
    setInterval(function(){
        $('#taDiv').text('~BattVoltage~');
    },500);
});




d'accord et pourquoi un rechargement automatique toutes les demi-seconde ?




En gros pour t'expliquer, ma page web va afficher 4 schéma de systèmes qui sont connectés à mon microcontrôleur.

Je veux rafraîchir tout ça afin de ne voir que les systèmes connectés et en marche ! Si un système est éteint ou déconnecté, il ne s'affiche pas.



bah essaye de mettre une id ou une class à ton td et dans .text() tu mets :
$('taDiv').text('<td class="" (ou id)></td>');


