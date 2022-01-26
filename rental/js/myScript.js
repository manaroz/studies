function smoothScroll(element){
    document.querySelector(element).scrollIntoView ({
        behavior: 'smooth'
    });
}
window.onscroll = function() {
    scroll();
};
function scroll(){
    console.log('x');
    if(document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
        document.getElementById('up-button').style.display = "block";
    } else {
        document.getElementById('up-button').style.display = "none";
    }
}
function reserve(tool){
    var select = document.getElementById('tool');
    var options_selected = select.querySelectorAll('option[selected]');
    options_selected.forEach(function(option){
        option.removeAttribute("selected");
    });
    var option = select.querySelector('option[value="'+tool+'"]');
    option.setAttribute("selected","selected");
    smoothScroll('#reservation');
}