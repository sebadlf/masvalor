<?php
/**
* Template File: The users dashboard
*
* @package    Tina-MVC
* @subpackage Tina-Core-Views
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery-1.3.2.min.js"></script>
 <!--
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">-->
	
	
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


</script>  

  
<style>

.botonExcel{cursor:pointer;}

#table_noticia thead{
  background-color: #adaeb2;
}

a{
 text-decoration: none;
 color:black;
}
</style>
	   						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;width:100%">
			<form action="" method="post" name="tinymce" id="adminForm" style="width:94%">
			<h2  style="margin-left: 5px;"><?php echo __('Reportes Busquedas Satisfechas/Insatisfechas') ?></h2>
			<br/>	
			<table>
			 <tr>
				 <td>
				
					
					 <div>
     					<div id="filter_date" style="float:left;">
						  <?php echo __('Fechas:') ?>
	    					<input class="tcal" type="text" name="filter_date_from" id="filter_date_from" value="" title="Fecha desde"/>
							<input class="tcal" type="text" name="filter_date_to" id="filter_date_to" value="" title="Fecha hasta"/>
							
						</div>
											
						
						<button onclick="this.form.submit();" style="float:left;padding-top: 2px;margin-left: 3px;margin-right: 8px;"><?php echo __('Buscar'); ?></button> 
						<button style="float:left;padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						<script> if(document.getElementById('filter_date_from').value != '') { showDateFilter(); } </script>
					</div>	 
															
					<table id="Exportar_a_Excel" class="admintable" style="font-size:11px;width:103%;text-align:center;margin-top: 8px;text-align: center;">
					<div style="width:103%;margin-top: 39px;">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('Nro') ?></th>
								<th><?php echo __('Fecha Inicio') ?></th>
								<th><?php echo __('Fecha Fin') ?></th>
								<th><?php echo __('Cargo') ?></th>
								<th><?php echo __('Empresa/Institucion') ?></th>
								<th><?php echo __('Lugar') ?></th>
								<th><?php echo __('Editar') ?></th>
							</thead>
							
							<tbody>

							<?php  
							    if($V->datas != ""){								   
								   foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
										   <td><?php echo $data->id;?></td>
											<td><?php echo $data->start_date;?></td>
											<td><?php echo $data->end_date;?></td>
											<td><?php echo $data->job_title;?></td>
											<td><?php echo $data->company;?></td>
											<td><?php echo $data->city.','.$data->state?></td>
											<td><?php echo $data->status;?></td>
											<td><a href="<?php echo masvalor_getUrl(); ?>/searche/&cid=<?php echo $data->id;?>">
												   <img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
											</a></td>
										</tr>
								<?php }?>
							<?php }?>			
							                           									
																				
						  </tbody>
					</table>
				</td>
			 </tr>	
			
		    </table>
			<input type="hidden" name="cid" value="" />	
			<input type="hidden" name="task" value="" />
			
				<div style="width:40%;margin-top: 10px;">
					<hr/>
				</div>
			 
				<div style="color:">
				  <?php echo __('Cantidad de B&uacute;squedas') ?> : <?php echo $V->total;?>
				</div>
								
				<div style="width:40%;margin-top: 10px;">
							<hr/>
				</div>	
			
			    <div style="color:">
				  <?php echo __('Cantidad de Busquedas Satifechas') ?> : <?php echo $V->total_satisfied;?>
				</div> 
				
				<div style="width:40%;margin-top: 10px;">
							<hr/>
				</div>	
				
				<div style="color:">
				  <?php echo __('Cantidad de Busquedas Insatisfechas') ?> : <?php echo $V->total_unmet;?>
				</div> 
				
				<div style="width:40%;margin-top: 10px;">
							<hr/>
				</div>	
			
		   </form>
		   
		  
		   <form action="wp-content/plugins/masvalor/app/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
					<p> <?php echo __('Exportar a Excel') ?> <img src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
					<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			</form>
		    
			
		  	
		</div>
		
			
				
				
