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
			msg.push('<?php echo __('Debe ingresar un t\u00edtulo.');?>');
			error = true;
		  }
		  
		  if (jQuery("#post_ifr").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una descripci\u00f3n.');?>");
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
		if(confirm("Est\u00e1 seguro que quiere guardar los cambios?")) { 
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit(); 
		}	
	}	
}


function saveDelete(cid){
    if(confirm("Est\u00e1 seguro que quiere borrar la Empresa?")) {
	   document.forms['adminForm'].task.value = 'delete';
	   document.forms['adminForm'].cid.value = cid;
	   document.forms['adminForm'].submit(); 
	}   
}


function activadCompanies(){
    if(confirm("\u00BFEst\u00e1 seguro que quiere aceptar a las Empresas?")) {
		document.forms['adminForm'].task.value = 'activadCompanies';
		document.forms['adminForm'].submit();
    }		
}


function checkUncheckAll(cid) {
    input = document.getElementById('userid');
	input.value +=cid + ',';
	
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
		<div id="table_noticia" style="font-size: 14px;margin-left: -41px;width: 714px;">
			<form action="" method="post" name="tinymce" id="adminForm">	
			 <h2 style="margin-left:16px;"><?php echo __('Activaci&oacute;n Empresas/Instituciones') ?></h2>
			 <br/>	
   			 <table>
				<tr>
					 <td>
					
						<div>
							  <td  style="width:100%;padding-left: 7px;"><?php echo __('Filtro') ?>
								<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
								  <option value="name"?><?php echo __('Nombre') ?></option>
								  <!--option value="business_name"?><?php echo __('Razon Social') ?></option>
								  <option value="cuit_number";?><?php echo __('CUIT') ?></option-->
								</select>	
							   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
							  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						</div>	
						
						<div style="float: right; margin-top: -4px;">
							    <a href="#" title="Activar" onclick="activadCompanies()" > <img WIDTH="36" HEIGHT="36" src="wp-content/plugins/masvalor/app/includes/image/actived.png"></a> 
						</div>
							
						<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:683px;text-align:center;margin-bottom: 27px;">
						<div style="width:100%">
							<hr/>

						</div>
								<thead>
									<th><?php echo __('Nombre') ?></th>
									<th><?php echo __('Tipo de Empresa') ?></th>
									<th><?php echo __('Lugar Origen') ?></th>
									<th><?php echo __('Activado') ?></th>
								</thead>
								
										
								
								<tbody>
									
									<?php foreach ( $V->datas as $result ) 
										{?>
																								
										<tr style="background-color:#eeeeee;">
											<td><?php echo $result->name;?></td>
											<td><?php echo give_me_type($result);?></td>
											<td><?php echo $result->city.','.$result->state;?></td>
											<td align="center"> <input type="checkbox" name="actived" id="actived" onclick="checkUncheckAll('<?php echo $result->userid; ?>')"><br></td>
										</tr>
									<?php }?>
									
								</tbody>
						  </table>
					</td>
				</tr>		
				</table>
			   	
				<div class="paginator" style="margin-left:16px">
							<?php 
							$pages = ceil($V->count/$V->itemsPerPage);
							if ($pages > 1)
								for ($i=1;$i<=$pages;$i++){
									$pageLink = masvalor_getUrl().'/companies_activated/&limitstart='.(($i-1)*$V->itemsPerPage);
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
				<input type="hidden" name="userid" id="userid" value=""/>				
				<input type="hidden" name="task" value="" />
			
			</form>
		   
		
		</div>
		
