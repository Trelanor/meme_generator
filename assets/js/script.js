function live_view(){
    var def = "zone-texte1";
    var first = document.getElementById("first_paragraphe").value;
    var second = document.getElementById("second_paragraphe").value;
    if (first.length > 0){
        document.getElementById('first').innerHTML = first;
        document.getElementById('second').innerHTML = second;
    } else {
        document.getElementById('first').innerHTML = def;
        document.getElementById('second').innerHTML = second;
    }
}

document.addEventListener('keyup', live_view );
document.addEventListener('click', live_view );
