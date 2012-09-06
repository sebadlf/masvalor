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

	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery-1.3.2.min.js"></script>

 <script language="javascript" type="text/javascript">
    
   $(document).ready(function() {
		$(".botonExcel").click(function(event) {
			$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
			$("#FormularioExportacion").submit();
		});
	});
     
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
	     
		
						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;">
			<form action="" method="post" name="tinymce" id="adminForm">
			<h2  style="margin-left: 5px;"><?php echo __('Reportes Actividades de Bitacora') ?></h2>
			<br/>	
			<table>
			 <tr>
				 <td>
				
					
					 <div>
     					<div id="filter_date" style="float:left;">
						  <?php echo __('Entre Fechas:') ?>
	    					<input type="text"  name="filter_date_from" id="filter_date_from" value="" title="Fecha desde"/>
							<script language="JavaScript">
											new tcal ({
											'formname': 'adminForm',
											'controlname': 'filter_date_from',                      
											});
							</script>
							<input type="text"  name="filter_date_to" id="filter_date_to" value="" title="Fecha hasta"/>
							<script language="JavaScript">
											new tcal ({
											'formname': 'adminForm',
											'controlname': 'filter_date_to',                      
											});
							</script>
									
						</div>
						<button onclick="this.form.submit();" style="float:left;padding-top: 2px;margin-left: 3px;margin-right: 8px;"><?php echo __('Buscar'); ?></button> 
						<button style="float:left;padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						<script> if(document.getElementById('filter_date_from').value != '') { showDateFilter(); } </script>
					</div>	 
															
					<table id="Exportar_a_Excel" class="admintable" style="font-size:11px;width:107%;text-align:center;margin-top: 8px;">
					<div style="width:107%;margin-top: 39px;">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('Fecha') ?></th>
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Descripci&oacute;n') ?></th>
							</thead>
							
							<tbody>

							<?php  
							    if($V->datas != ""){								   
								   foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
										    								
											<?php   		   
												$date2 =$data->post_date;
												$date = explode(' ',$date2);
												$date2 = explode("-",$date[0]);
												$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
											 ?>
											
											<td><?php echo $dateend;?></td>
																						
											<td><?php echo $data->post_title;?></td>
											<td><?php echo $data->post_content;?></td>
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
			
		   </form>
		  	<div style="width:105%;margin-top: 10px;">
						<hr/>
			</div>
         
		    <div style="color:">
			  <?php echo __('Cantidad de Activades') ?> : <?php echo $V->total;?>
			</div>
			
		    <div style="width:105%;margin-top: 10px;">
						<hr/>
			</div>
			
			<form action="wp-content/plugins/masvalor/app/ficheroexcel.php" method="post" target="_blank" id="FormularioExportacion">
					<p> <?php echo __('Exportar a Excel') ?> <img src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
					<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			</form>
			
			 <?php /* ?>
			<form action="wp-content/plugins/masvalor/app/ficheroword.php" method="post" target="_blank" id="FormularioExportacionWord">
					<p> <?php echo __('Exportar a Word') ?> <img src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
					<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			</form>
			<?php */ ?>
			
		</div>
		
			
				
				
