<?php if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

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
	     
						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;width:100%">
			<form action="" method="post" name="tinymce" id="adminForm" style="width:94%">
			<h2  style="margin-left: 5px;"><?php echo __('Busquedas Pendientes') ?></h2>
			<table>
			 <tr>
				 <td>
									
					
					<table id="Exportar_a_Excel" class="admintable" style="font-size:11px;width:103%;text-align:center;margin-top: 8px;">
					<div style="width:103%;">
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
										<tr style="background-color: #eeeeee">
										    <td><?php echo $data->id;?></td>
											<td><?php echo $data->start_date;?></td>
											<td><?php echo $data->end_date;?></td>
											<td><?php echo $data->job_title;?></td>
											<td><?php echo $data->company;?></td>
											<td><?php echo $data->city.','.$data->state.','.$data->country ;?></td>
											
											<td><a href="<?php echo masvalor_getUrl(); ?>/searche/&cid=<?php echo $data->id;?>">
												   <img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
												</a>
											</td>
											
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
				  <?php echo __('Cantidad de Busquedas') ?> : <?php echo $V->total;?>
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
		
			
				
				
