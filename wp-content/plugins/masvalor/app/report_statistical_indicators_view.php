<?php

if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery-1.3.2.min.js"></script>
	
	
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.css">


<script language="javascript" type="text/javascript">
    
   $(document).ready(function() {
		$(".botonExcel").click(function(event) {
			$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
			$("#FormularioExportacion").submit();
		});
	});
     
</script>  


	
<script language="javascript" type="text/javascript">

function saveDelete(cid){
   document.forms['adminForm'].task.value = 'delete';
   document.forms['adminForm'].cid.value = cid;
   document.forms['adminForm'].submit(); 
}

function resetFilter() {
    document.getElementById('search').value='';
    document.getElementById('filter_sel').value='';
    hiddenDateFilter();
    document.getElementById('filter_date_from').value='';
    document.getElementById('filter_date_to').value='';
    submitbutton();
  }
  
  function showDateFilter() {
    document.getElementById('filter_date').style.margin ='5px';
    document.getElementById('filter_date').style.visibility ='visible';
    document.getElementById('filter_date').style.height ='auto';
  }
  
  function hiddenDateFilter() {
    document.getElementById('filter_date').style.margin ='0px';
    document.getElementById('filter_date').style.visibility ='hidden';
    document.getElementById('filter_date').style.height ='0px';
  }
  
  function filterAdvanced() {
    if(document.getElementById('filter_date').style.visibility == 'hidden')
      showDateFilter();
    else hiddenDateFilter();
  }
  
  function showDisciplines(){  
  
   if(document.getElementById('disciplines').style.display == "none"){	
		document.getElementById('disciplines').style.display ='block'; 
		document.getElementById('disciplinesLine').style.display ='none';
	}
   else{
		document.getElementById('disciplines').style.display ='none';
		document.getElementById('disciplinesLine').style.display ='block';
	}
    	
 }
 
  function showStates(){  
  
   if(document.getElementById('states').style.display == "none"){	
		document.getElementById('states').style.display ='block'; 
		document.getElementById('statesLine').style.display ='none';
	}
   else{
		document.getElementById('states').style.display ='none';
		document.getElementById('statesLine').style.display ='block';
	}
    	
 }
 
 function showSector(){  
  
   if(document.getElementById('sector').style.display == "none"){	
		document.getElementById('sector').style.display ='block'; 
		
	}
   else{
		document.getElementById('sector').style.display ='none';
		
	}
    	
 }
 
</script>  

  
<style>

#indicators2{
 background-color: #ADAEB2;
 margin-left:127px;
 color:black;
}

#indicators{
	background-color: #eeeeee;
}
#table_noticia thead{
  background-color: #adaeb2;
}

a{
 text-decoration: none;
 color:black;
}
</style>
	     
<?php    $countDis=0;
        $countStates=0;
       $total_sector = $V->total_insertion_university + $V->total_insertion_industry +$V->total_insertion_services +$V->total_insertion_go+$V->total_insertion_ngo?>

						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;">
			<form action="" method="post" name="tinymce" id="adminForm">
			<h2  style="margin-left: 5px;"><?php echo __('Indicadores Estadisticos') ?></h2>
			<br/>	
			<table>
			 <tr>
				 <td>
				
					
					 <div>
     					
						<div id="filter_date" style="float:left;">
						  <?php echo __('Entre Fechas:') ?>
	    					<input class="tcal" type="text"  name="filter_date_from" id="filter_date_from" value="" title="Fecha desde"/>
							<input class="tcal" type="text"  name="filter_date_to" id="filter_date_to" value="" title="Fecha hasta"/>
						</div>
						
						<button onclick="this.form.submit();" style="float:left;padding-top: 2px;margin-left: 3px;margin-right: 8px;"><?php echo __('Buscar'); ?></button> 
						<button style="float:left;padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						<script> if(document.getElementById('filter_date_from').value != '') { showDateFilter(); } </script>
					</div>	 
					
					
					<table id="Exportar_a_Excel" class="admintable" style="display:none;font-size:11px;width:107%;text-align:center;margin-top: 8px;">
								
							
							<thead>
								
								<th><?php echo __('Indicador') ?></th> 
								<th> <?php echo __('Valor Indicador') ?></th> 							
								
							</thead>
							
							<tbody>

								<tr>
								    <td><?php echo __('Busquedas Resultantes') ?></td>
								    <td><?php echo $V->total_search;?></td>
								</tr>	
								
								<tr>
								    <td> <?php echo __('Efectividad del programa') ?></td>								
									<td><?php echo $V->total_effectiveness;?>%</td>
								</tr>	
								
								<tr>
								    <td><?php echo __('Inserci&oacute;n') ?></td>								
									<td><?php echo $V->total_insertion;?>%</td>
								</tr>

								<tr>
									<td><?php echo __('Inserci&oacute;n-Sector') ?></td>		
									<td><?php echo $total_sector;?></td>	
								</tr>
								
								<tr>
									<td><?php echo __('Inserci&oacute;n-Sector Universidad') ?></td>
									<td><?php echo $V->total_insertion_university;?></td>	
								</tr>	
									
								<tr>
									<td><?php echo __('Inserci&oacute;n-Sector Industria') ?></td>	
									<td><?php echo $V->total_insertion_industry;?></td>	
								</tr>
								
								<tr>
									<td> <?php echo __('Inserci&oacute;n-Sector Servicios') ?></td>		
									<td><?php echo $V->total_insertion_services;?></td>	
								</tr>	
								
								<tr>
								    <td><?php echo __('Inserci&oacute;n-Sector Gobierno') ?></td>	
									<td><?php echo $V->total_insertion_go;?></td>	
								</tr>	
								
								<tr>
								    <td><?php echo __('Inserci&oacute;n-Sector ONGs') ?></td>
									<td><?php echo $V->total_insertion_ngo;?></td>
								</tr>
								
								<tr>
									
									<?php foreach($V->total_states as $data) {?>
										<td><?php echo __('Inserci&oacute;n Provincia') ?>:<?php echo iconv("ISO-8859-1", "UTF-8", $data->state); ?></td> 
										<td><?php echo $data->count;?></td>
										<?php $countStates=$countStates + $data->count;?>
									<?php } ?>
								
								</tr>
								
								<tr>
								    <td><?php echo __('Inserci&oacute;n Provincia Total') ?></td>
									<td><?php echo $countStates?></td>	
								</tr>	
								
								<tr>
									<?php foreach($V->total_disciplines as $dataDis) {?>
					                    <td><?php echo __('Inserci&oacute;n Disciplina') ?>:<?php echo utf8_decode($dataDis->name); ?></td> 
										<td><?php echo $dataDis->count; ?></td> 
							            <?php $countDis=$countDis + $dataDis->count;?>
								     <?php } ?>
								</tr>
								
								<tr>
								    <td><?php echo __('Inserci&oacute;n Disciplina Total') ?></td>
									<td><?php echo $countDis;?></td>	
								</tr>	
								
								<tr>
								    <td><?php echo __('Volumen de la Oferta') ?></td> 	
									<td><?php echo $V->total_volumeoftheOffer;?></td>
								</tr>	
								
								<tr>
								    <td><?php echo __('Volumen de la Demanda') ?></td> 	
									<td><?php echo $V->total_demand_volume;?></td>
								</tr>	
								
								<tr>
									<td><?php echo __('Respuesta a la Demanda') ?></td> 
									<td><?php echo $V->total_demand_response;?> %</td>
								</tr>	
								
								<tr>
								    <td><?php echo __('Satisfaccion de la Demanda') ?></td> 	
									<td><?php echo $V->total_demand_satisfaction;?> % </td>
								</tr>	
								
								<tr>
								    <td><?php echo __('Permanencia') ?></td> 	
									<td><?php echo $V->total_permanence;?> %</td>
								</tr>	
								
								<tr>
								    <td><?php echo __('Alcance Federal') ?></td>	
									<td><?php echo $V->total_federal_outreach;?></td>
								</tr>
																										
						  </tbody>
					</table>
				
				</td>
			 </tr>		
		    </table>
						
		   </form>
		  	
			<?php /*?>
			<div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
		    <div id="indicators" >
			  <?php echo __('Busquedas Resultantes') ?> : <?php echo $V->total_search;?>
			</div>
			<?php */?>
			<div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<?php /* ?>
			<div id="indicators" >
			  <?php echo __('Cantidad Doctores') ?> : <?php echo $V->total_doctor;?>
			</div>
			
			
			<div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			<?php */ ?>
		 
		    <div id="indicators" >
			  <?php echo __('Efectividad del programa') ?> : <?php echo $V->total_effectiveness;?>%
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Inserci&oacute;n') ?> : <?php echo $V->total_insertion;?>
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			
			
			<div id="indicators">
			  <?php echo __('Inserci&oacute;n-Sector') ?> : <?php echo $total_sector;?>
			  <a href="#" onclick="showSector()" title="<?php echo __('Todas los sectores') ?> "> <img  style="float:right;height: 19px;width: 19px;" src="wp-content/plugins/masvalor/app/includes/image/mas.gif" alt="<?php echo __('Todas los sectores') ?> "/></a>
			</div>
			
			    <div id="sector" style="display:none" name="sector">
					
					<div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
					
					<div id="indicators2">
					  <?php echo __('Inserci&oacute;n Universidad') ?> : <?php echo $V->total_insertion_university;?>
					</div>
					
					<div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
					
					<div id="indicators2">
					  <?php echo __('Inserci&oacute;n Industria') ?> : <?php echo $V->total_insertion_industry;?>
					</div>
					
					<div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
					
					<div id="indicators2">
					  <?php echo __('Inserci&oacute;n Servicios') ?> : <?php echo $V->total_insertion_services;?>
					</div>
					
					<div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
					
					<div id="indicators2">
					  <?php echo __('Inserci&oacute;n Gobierno') ?> : <?php echo $V->total_insertion_go;?>
					</div>
					
					<div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
					
					<div id="indicators2">
					  <?php echo __('Inserci&oacute;n ONGs') ?> : <?php echo $V->total_insertion_ngo;?>
					</div>
			    
				</div>	
               	
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Inserci&oacute;n Disciplina') ?> : <?php echo $V->total;?>
			  <a href="#" onclick="showDisciplines();" title="<?php echo __('Todas las disciplinas') ?>" > <img  style="float:right;height: 19px;width: 19px;" src="wp-content/plugins/masvalor/app/includes/image/mas.gif" alt="<?php echo __('Todas las disciplinas') ?>"/></a>

			</div>
							
				<div id="disciplines" name="disciplines" style="display:none" >
				
				   <div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
			       
				    				   
						<?php foreach($V->total_disciplines as $dataDis) {?>
						
							<div id="indicators2">
							  <?php echo __('Inserci&oacute;n') ?> <?php echo $dataDis->name; ?>: <?php echo $dataDis->count;?>
							</div>
							
							<div style="width:100%;margin-top: 10px;">
								<hr/>
							</div>
							
						<?php } ?>
													
					
				</div>	

                <div id="disciplinesLine" style="width:100%;margin-top: 10px;display:block">
							<hr/>
				</div> 				
			 
			<div id="indicators">
			  <?php echo __('Inserci&oacute;n-Provincia') ?> : <?php echo $V->total;?>
			  <a href="#" onclick="showStates()" title="<?php echo __('Todas las Todas las provincias') ?> "> <img  style="float:right;height: 19px;width: 19px;" src="wp-content/plugins/masvalor/app/includes/image/mas.gif" alt="<?php echo __('Todas las provincias') ?> "/></a>
			</div>
			
				<div id="states" style="display:none" name="states">	
					
					<div style="width:100%;margin-top: 10px;">
						<hr/>
			        </div>
					
					<?php foreach($V->total_states as $data) {?>
						
							<div id="indicators2">
							  <?php echo __('Inserci&oacute;n') ?> <?php echo $data->state; ?>: <?php echo $data->count;?>
							</div>
							
							<div style="width:100%;margin-top: 10px;">
								<hr/>
							</div>
					<?php } ?>
									
						
			    </div>
				
				<div id="statesLine" style="width:100%;margin-top: 10px;display:block">
							<hr/>
				</div> 
			
			<div id="indicators">
			  <?php echo __('Volumen de la Oferta') ?> : <?php echo $V->total_volumeoftheOffer;?>
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Volumen de la Demanda') ?> : <?php echo $V->total_demand_volume;?>
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Respuesta a la Demanda') ?> : <?php echo $V->total_demand_response;?> %&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input class="tcal" type="text"  name="filter_date_from" id="filter_date_from" value="" title="Fecha desde"/>
			  <input class="tcal" type="text"  name="filter_date_to" id="filter_date_to" value="" title="Fecha hasta"/>
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Satisfacci&oacute;n de la Demanda') ?> : <?php echo $V->total_demand_satisfaction;?> % 
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
				<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Permanencia') ?> : <?php echo $V->total_permanence;?> %
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>
			
			<div id="indicators">
			  <?php echo __('Alcance Federal') ?> : <?php echo $V->total_federal_outreach;?>
			</div>
			
		    <div style="width:100%;margin-top: 10px;">
						<hr/>
			</div>

	</div>
		
	<form action="wp-content/plugins/masvalor/app/ficheroexcel.php" method="post" target="_blank" id="FormularioExportacion">
		<p> <?php echo __('Exportar a Excel') ?> <img src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
		<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
	</form>		
				
				
