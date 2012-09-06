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

<script language="javascript" type="text/javascript">
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



function saveDelete(cid){
   document.forms['adminForm'].task.value = 'delete';
   document.forms['adminForm'].cid.value = cid;
   document.forms['adminForm'].submit(); 
}


</script>  


<style>

#table_noticia thead{
  background-color: #aaaaaa;
}

a{
 text-decoration: none;
 color:black;
}
</style>
               										
            <?php if(masvalor_StateCompany() != 1) {?>
			    <div style="color:red;margin-bottom: 15px;margin-top: -14px;font-style:italic;margin-left: -16px;width: 684px;"> 
				    <?php echo __('No es posible realizar b&uacute;squedas, su Usuario Empresa no esta activado.Consulte con el Administrador.') ?>
				</div>
			<?php }?> 
										 
	<form action="" method="post" name="tinymce" id="adminForm">		
				<h2 style="margin-left:-19px;"><?php echo __('B&uacute;squedas') ?></h2>
				 <br/>
				<table style="font-size:11px;width:100%;margin-bottom: 27px; margin-left: -32px;">
				<tr>
					 <td>		  
						<div>
							  <td style="width:100%;padding-left: 11px;"><?php echo __('Filtro') ?>
								<input type="text" name="search" style="height: 13px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 25px;padding-top: 4px;">
								  <option value=""> </option>
								    <option value="activate"><?php echo __('Estado') ?></option>
								    <option value="start_date"><?php echo __('Rango entre fechas') ?></option>
								</select>	
								
								<select id="search_situation" name="search_situation" style="height: 25px;padding-top: 4px;" >
									<option value="Pendiente"><?php echo __('Pendiente') ?></option>
									<option value="En curso"><?php echo __('En curso') ?>  </option>
									<option value="Satisfecha"><?php echo __('Satisfecha') ?>  </option>
									<option value="Insatisfecha"><?php echo __('Insatisfecha') ?> </option>
								</select>
																
							   <button onclick="this.form.submit();" style="padding-top: 2px;">Buscar</button> 
							   <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						       <a href="javascript:filterAdvanced()" title="Filtro Fechas" style=" margin-left: -55px;"><img src ="wp-content/plugins/masvalor/app/includes/image/dates.png" style="position: absolute; margin-left: 60px;margin-top: 3px;" alt="Filtro fechas"></a>
							        
								<div id="filter_date" style="visibility: hidden; height: 0px;">
									  <?php echo __('Entre Fechas:') ?>
									<input type="text"  name="filter_date_from" id="filter_date_from" value="" title="Fecha desde"/>
									<input type="text"  name="filter_date_to" id="filter_date_to" value="" title="Fecha hasta"/>
								</div>
								
								<script> if(document.getElementById('filter_date_from').value != '') { showDateFilter(); } </script>
						
						</div>	 
						
					<?php if(masvalor_StateCompany() == 1) {?>
						<div style="float: right; margin-top: -22px; ">
							<a href="<?php echo masvalor_getUrl(); ?>/searche/"> <img src="wp-content/plugins/masvalor/app/includes/image/nuevo.png"></a> 
						</div>
					<?php }?>
					
						<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:650px;text-align:center;margin-bottom: 27px;">
						<div style="width:104%">
							<hr/>
						</div>	
								<thead style="background-color: #adaeb2;">
									<th><?php echo __('Nro') ?></th>
									<th><?php echo __('Fecha Inicio') ?></th>
									<th><?php echo __('Fecha Fin') ?></th>
									<th><?php echo __('Puesto') ?></th>
									<th><?php echo __('Instituci&oacute;n') ?></th>
									<th><?php echo __('Lugar') ?></th>
									<th><?php echo __('Estado') ?></th>
									<th><?php echo __('Editar') ?></th>
									<th><?php echo __('Consulta') ?></th>
								</thead>
																
								<tbody>
																	
									
									<?php foreach ( $V->datas as $result ) 
										{?>
																								
										<tr style="background-color:#eeeeee;">
											<td><?php echo $result->id;?></td>
											<td><?php echo $result->start_date;?></td>
											<td><?php echo $result->end_date;?></td>
											<td><?php echo $result->job_title;?></td>
											<td><?php echo $result->company;?></td>
											<td><?php echo $result->city.','.$result->state.','.$result->country ;?></td>
											<td><?php echo $result->actived;?></td>
											
											<td><a href="<?php echo masvalor_getUrl(); ?>/searche/&cid=<?php echo $result->id;?>">
											   <img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
											</a></td>
										    
											<td><a href="<?php echo masvalor_getUrl(); ?>/form_consultation/&searchid=<?php echo $result->id;?>">
												<img alt="<?php echo __('Consultar') ?>" title="<?php echo __('Consultar') ?>" src="wp-content/plugins/masvalor/app/includes/image/consultation.png" />
											</a></td>
										</tr>
																					 
									<?php } ?>
																					
							  </tbody>
						  </table>
					</td>
				</tr>
				</table>
				<div class="paginator">
					<?php 
					$pages = ceil($V->count/$V->itemsPerPage);
					if ($pages > 1)
						for ($i=1;$i<=$pages;$i++){
							$pageLink = masvalor_getUrl().'/searches_company/&limitstart='.(($i-1)*$V->itemsPerPage);
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
	</form>
	
		