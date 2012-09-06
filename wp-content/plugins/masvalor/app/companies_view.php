<?php  if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 

<head>
 <script language="javascript" type="text/javascript" src="wp-content/plugins/masvalor/app/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> 
 </script>
   <script language="javascript" type="text/javascript">
      tinyMCE.init({
         mode : "textareas",
         theme : "advanced",
		 theme_advanced_toolbar_location : "top"
      });
   </script>
</head> 
 
 
<script language="javascript" type="text/javascript">
function validateFields(){
			retorno = false;
			var msg = new Array();
		    var error = false;

		  if (jQuery("#post_title").val() == ""){
			msg.push('<?php echo __('Debe ingresar una t\u00edtulo.');?>');
			error = true;
		  }
		  
		  if (jQuery("#post_ifr").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un descripci\u00f3n.');?>");
		   error = true;
		   }
		   
		  if (error){
		  alert(msg.join('\n'));
		  return false;
		  }
		 else
		  return true;
		  
}

function saveForm(){
    if (validateFields()){
		if(confirm("¿Est\u00e1 seguro que quiere guardar los cambios?")) { 
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit(); 
		}	
	}	
}

function order_grid(column_name,dir) {
	document.getElementById("order").value = column_name;
	document.getElementById("adminForm").submit();
	if(dir == 'desc')
		document.getElementById("order_dir").value = 'asc';
	else
		document.getElementById("order_dir").value = 'desc';
}

function saveDelete(cid){
    if(confirm("¿Est\u00e1 seguro que quiere borrar la empresa?")) {
	   document.forms['adminForm'].task.value = 'delete';
	   document.forms['adminForm'].cid.value = cid;
	   document.forms['adminForm'].submit(); 
	}   
}

</script>  


<style>

#table_noticia thead{
  background-color: #adaeb2;
}

a{
 text-decoration: none;
 color:black;
}

#tableSelectedEducation th {
	cursor:pointer;
}

</style>

<?php
	function give_me_type($result) {
		if($result->type_industry == 1)
			return 'Industria';
		elseif($result->type_services == 1)
			return 'Servicios';
		elseif($result->type_education == 1)
			return 'Educacion';
		elseif($result->type_go == 1)
			return 'Organizacion gubernamental';
		elseif($result->type_ngo == 1)
			return 'Organizacion no gubernamental';
		else
			return 'Empleo por cuenta propia';
	}
?>
	 						
		<div id="table_noticia" style="font-size: 14px;margin-left: -46px;width: 714px;">
			<form action="" method="post" name="tinymce" id="adminForm">	
			 <h2 style="margin-left:16px;"><?php echo __('Empresas/Instituciones') ?></h2>
			 <br/>	
   			 <table>
				<tr>
					 <td>
					
						<div>
							  <td  style="width:100%;padding-left: 7px;"><?php echo __('Filtro') ?>
								<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
									  <option value="name"?><?php echo __('Nombre') ?></option>
									  <option value="business_name"?><?php echo __('Raz&oacute;n Social') ?></option>
									  <option value="cuit_number";?><?php echo __('CUIT') ?></option>
									  <option value="state";?><?php echo __('Provincia') ?></option>
									  <option value="main_contact_mail";?><?php echo __('Correo electronico') ?></option>
									  <option value="actived";?><?php echo __('Estado') ?></option>
								</select>	
							   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
							  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						</div>	
						
						<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:683px;text-align:center;margin-bottom: 27px;">
						<div style="width:100%">
							<hr/>

						</div>	
								<?php if($_GET["fastact"] == "true"){ ?>
								<thead>
									<th onclick="order_grid('name')"><?php echo __('Nombre') ?></th>
									<th><?php echo __('Tipo de Empresa') ?></th>
									<th onclick="order_grid('state')"><?php echo __('Lugar Origen') ?></th>
									<th><?php echo __('Activado') ?></th>
								</thead>
								<?php }else{ ?>
									<thead>
										<th onclick="order_grid('name')"><?php echo __('Nombre') ?></th>
										<th onclick="order_grid('business_name')"><?php echo __('Raz&oacute;n Social') ?></th>
										<th onclick="order_grid('cuit_number')"><?php echo __('CUIT') ?></th>
										<th><?php echo __('Tipo de Empresa') ?></th>
										<th onclick="order_grid('state')"><?php echo __('Lugar Origen') ?></th>
										<!---th onclick="order_grid('main_contact_mail')">< ? php echo __('E-mail') ? ></th-->
										<th onclick="order_grid('actived')"><?php echo __('Estado') ?></th>
										<th><?php echo __('Editar') ?></th>
									</thead>
								<?php } ?>
										
								<?php if($_GET["fastact"] == "true"){ ?>
								<tbody>
									
									<?php foreach ( $V->datas as $result ) 
										{?>

										<tr style="background-color:#eeeeee;">
											
											<td><?php echo $result->name;?></td>
											<td><?php echo give_me_type($result);?></td>
											<td><?php echo $result->city.','.$result->state;?></td>
											<td align="center"> <input type="checkbox" name="actived" value="actived" id="<?php echo $result->userid;?>"><br></td>
										</tr>
																					 
									<?php } ?>													
								</tbody>	
								<?php }else{ ?>
										
								
								<tbody>
									
									<?php foreach ( $V->datas as $result ) 
										{?>
																								
										<tr style="background-color:#eeeeee;">
											
											<td><?php echo $result->name;?></td>
											<td><?php echo $result->business_name;?></td>
											<td><?php echo $result->cuit_number;?></td>
											<td><?php echo give_me_type($result);?></td>
											<td><?php echo $result->city.','.$result->state;?></td>
											<!--td>< ?php echo $result->main_contact_mail ;?></td -->
											<td><?php echo $result->actived;?></td>

											<td><a href="<?php echo masvalor_getUrl(); ?>/company_profile/&cid=<?php echo $result->userid;?>">
											  <img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" /></a></a></td>

											<td style="font-size:14px;"><a href="#" title="Borrar" onclick="saveDelete('<?php echo $result->id;?>');"> X </a></td>
										</tr>
																					 
									<?php } ?>
																					
							  </tbody>
					<?php } ?>
						  </table>
					</td>
				</tr>		
				</table>
			   	
				<div class="paginator" style="margin-left:16px">
							<?php 
							$pages = ceil($V->count/$V->itemsPerPage);
							if ($pages > 1)
								for ($i=1;$i<=$pages;$i++){
									$pageLink = masvalor_getUrl().'/companies/&limitstart='.(($i-1)*$V->itemsPerPage);
									if ($V->currPage != $i)
										$href = '<a href='.$pageLink.'>'.$i.'</a>';
									else
										$href = $i;
									if ($i==1)
										echo $href;
									else
										echo ' - '.$href;
								}
							?>
					</div>
				
				
				
				<input type="hidden" name="cid" value="" />	
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="order" id="order" value="" />
				<input type="hidden" name="order_dir" id="order_dir" value="" />

			</form>
		   
		
		</div>
		
