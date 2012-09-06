jQuery(document).ready(function() {

        //Cuando el sitio carga...

        jQuery(".tab_content").hide(); //Esconde todo el contenido

        jQuery("ul.tabs li:first").addClass("active").show(); //Activa la primera tab

        jQuery(".tab_content:first").show(); //Muestra el contenido de la primera tab

        //On Click Event
        
       

        jQuery("ul.tabs li").click(function() {

			//if (jQuery('#need_update').val() != '1') {
			if ( need_update != 1) {
				jQuery("ul.tabs li").removeClass("active"); //Elimina las clases activas

				jQuery(this).addClass("active"); //Agrega la clase activa a la tab seleccionada

				jQuery(".tab_content").hide(); //Esconde todo el contenido de la tab

				var activeTab = jQuery(this).find("a").attr("href"); //Encuentra el valor del atributo href para identificar la tab activa + el contenido

				jQuery(activeTab).fadeIn(); //Agrega efecto de transición (fade) en el contenido activo
			}
			else
				alert('Por favor, guarde los cambios antes de pasar la pestaña');
			

            return false;

        });
        
        
        
         /*jQuery(".Soporte").mouseenter(function() { //En hover...  
   
           img = jQuery(this).find("img").stop().animate({opacity: 1}, 300);
         });
         
          jQuery(".Soporte").mouseleave(function() { //En hover...  
   
           img = jQuery(this).find("img").stop().animate({opacity: 0}, 300);
         });*/
         
         jQuery(".EliminarMapa").fadeTo(1, 0);

         
         jQuery(".EliminarMapa").hover(function() { //En hover...  
   
           jQuery(this).fadeTo("fast", 1);
         },function() { //En hover...  
   
           jQuery(this).fadeTo("fast", 0);
         });
         
      

         
      
    });
    
    function Mostrar(id){
            jQuery("#"+id).toggle("slow");//Esta funcion hace que las el contenido del id desaparezca con un efecto piola!!!       
      }
      
     function VerMapa(idEvento){
       
       alert(idEvento);
     }
     
     function MostrarX(clase){
        jQuery("."+clase).toggle("slow");//Esta funcion hace que las el contenido del id desaparezca con un efecto piola!!!
     }
     
     