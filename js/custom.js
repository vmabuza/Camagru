// Navbar and dropdowns
var toggle = document.getElementsByClassName('navbar-toggle')[0],
    collapse = document.getElementsByClassName('navbar-collapse')[0],
    dropdowns = document.getElementsByClassName('dropdown');;

// Toggle if navbar menu is open or closed
function toggleMenu() {
    collapse.classList.toggle('collapse');
    collapse.classList.toggle('in');
}

// Close all dropdown menus
function closeMenus() {
    for (var j = 0; j < dropdowns.length; j++) {
        dropdowns[j].getElementsByClassName('dropdown-toggle')[0].classList.remove('dropdown-open');
        dropdowns[j].classList.remove('open');
    }
}

// Add click handling to dropdowns
for (var i = 0; i < dropdowns.length; i++) {
    dropdowns[i].addEventListener('click', function() {
        if (document.body.clientWidth < 768) {
            var open = this.classList.contains('open');
            closeMenus();
            if (!open) {
                this.getElementsByClassName('dropdown-toggle')[0].classList.toggle('dropdown-open');
                this.classList.toggle('open');
            }
        }
    });
}

// Close dropdowns when screen becomes big enough to switch to open by hover
function closeMenusOnResize() {
    if (document.body.clientWidth >= 768) {
        closeMenus();
        collapse.classList.add('collapse');
        collapse.classList.remove('in');
    }
}

// Event listeners
window.addEventListener('resize', closeMenusOnResize, false);
toggle.addEventListener('click', toggleMenu, false);


function hasClass(element, className) {
    return element.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(element.className);
}
document.addEventListener("click", function (e) {
  var level = 0;
  var clicked;
  for (var element = e.target; element; element = element.parentNode) {
    if (hasClass(element, 'dropdown')) {
      iterator = element.childNodes;
      for(var i = 0; i < iterator.length; i++) {
        var elem = iterator[i];
        if (hasClass(elem, 'dropdown-menu')) {
          var isVisible = elem.offsetWidth > 0 || elem.offsetHeight > 0;
          if (!(isVisible)) {
            elem.style.display = "block";
            element.className += " open";
            clicked = element;
          }
        }
      }
    }
    level++;
  }
  var iterator = document.getElementsByClassName('dropdown');
  for (var i = 0; i < iterator.length; i++) {
    var element = iterator[i];
    initerator = element.childNodes;
    for(var x = 0; x < initerator.length; x++) {
      var elem = initerator[x];
      if (hasClass(elem, 'dropdown-menu')) {
        var isVisible = elem.offsetWidth > 0 || elem.offsetHeight > 0;
        if (isVisible && clicked != element) {
          elem.style.display = "none";
          element.className = (element.className).replace(" open","");
        }
      }
    }
  }
});


(function(){
    document.addEventListener('click', function(event){
        if (event.target.matches('.pages')) {
            //event.preventDefault();
            //handle what happens when you go to another page.
        }
    }, false);
})();