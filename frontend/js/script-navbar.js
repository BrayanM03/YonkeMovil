let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");


closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class

 }else {
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
 }
}



var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    }else{
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}


//Animaciones en los iconos del navbar

$(".item-con-icono").hover(function() { 

    let icono = $(this).find("i");
    icono.addClass("bx-tada");

 }, function(){

    let icono = $(this).find("i");
    icono.removeClass("bx-tada");

 });



 //Traer yonkes de cliente
 
    user_id = $("#lista-yonkes-cliente-navbar").attr("id_sesion");

    $.ajax({
      type: "POST",
      url: "./backend/yonkes/traer-yonkes-cliente.php",
      data: {"user_id": user_id},
      dataType: "JSON",
      success: function (response) {
       
        response.forEach(element => {
            console.log(element.nombre);

            $("#lista-yonkes-cliente-navbar").append(`
        <li class="list-item">
                <a href="mis-vehiculos-cliente.php">
                  <i class='bx bx-car'></i>
                  <span class="links_name">${element.nombre}</span>
                </a>
                <span class="tooltip">${element.nombre}</span>
              </li>`)

        });
        
        
      }
    });


