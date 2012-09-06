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


<?php require_once ('models/masvalor_utils.php'); 
	  global $current_user;
	  get_currentuserinfo();
	
?>
<!--
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">-->
	
	
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.css">

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
	if(confirm("¿Est\u00e1 seguro que quiere borrar?")) { 
		   document.forms['adminForm'].task.value = 'delete';
		   document.forms['adminForm'].cid.value = cid;
		   document.forms['adminForm'].submit(); 
    }
}

function activadSearches(){
    if(confirm("¿Est\u00e1 seguro que quiere aceptar a las B\u00fasquedas?")) {
		document.forms['adminForm'].task.value = 'activadSearches';
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
  background-color: #aaaaaa;
}

a{
 text-decoration: none;
 color:black;
}
</style>
               										
		<div id="table_noticia" style="font-size: 14px;margin-left: -35px;">
				<form action="" method="post" name="tinymce" id="adminForm">		
				 <h2 style="margin-left:13px;"><?php echo __('Activaci&oacute;n B&uacute;squedas') ?></h2>
				 <br/>
				<table> 
				 <tr>
					 <td>
									  
						<div>
							  <td style="width:100%;padding-left: 11px;"><?php echo __('Filtro') ?>
								<input type="text" name="search" style="height: 13px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
								    <!--option value="status"><?php echo __('Estado') ?></option-->
								    <option value="job_title"><?php echo __('Puesto') ?></option>
									<option value="company"><?php echo __('Instituci&oacute;n') ?></option>
								
								</select>	
								
								<!--
								<select id="filter_sel" name="filter_sel" style="height: 26px;padding-top: 2px;" >
									<option value="Pendiente"><?php echo __('Pendiente') ?></option>
									<option value="En curso"><?php echo __('En curso') ?>  </option>
									<option value="Satisfecha"><?php echo __('Satisfecha') ?>  </option>
									<option value="Insatisfecha"><?php echo __('Insatisfecha') ?> </option>
								</select>
								-->
																
							   <button onclick="this.form.submit();" style="padding-top: 2px;">Buscar</button> 
							   <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						       <a href="javascript:filterAdvanced()" title="Filtro Fechas" style=" margin-left: -55px;"><img src ="wp-content/plugins/masvalor/app/includes/image/dates.png" style="position: absolute; margin-left: 60px;" alt="Filtro fechas"></a>
							        
								<div id="filter_date" style="visibility: hidden; height: 0px;">
									  <?php echo __('Entre Fechas:') ?>
									
									<input class="tcal" type="text"  name="filter_date_from" id="filter_date_from" value="" title="Fecha desde"/>
									<input class="tcal" type="text"  name="filter_date_to" id="filter_date_to" value="" title="Fecha hasta"/>
																	
								</div>
								
								<script> if(document.getElementById('filter_date_from').value != '') { showDateFilter(); } </script>
						
						</div>	 
						
						<div style="float: right; margin-top: -34px;">
							    <a href="#" title="Activar" onclick="activadSearches()" > <img WIDTH="36" HEIGHT="36" src="wp-content/plugins/masvalor/app/includes/image/actived.png"></a> 
						</div>
						
						<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:683px;text-align:center;margin-bottom: 27px;">
						<div style="width:100%">
							<hr/>
						</div>	
							
								<thead>
									<th><?php echo __('Nro') ?></th>
									<th><?php echo __('Fecha Inicio') ?></th>
									<th><?php echo __('Fecha Fin') ?></th>
									<th><?php echo __('Puesto') ?></th>
									<th><?php echo __('Instituci&oacute;n') ?></th>
									<th><?php echo __('Lugar') ?></th>
							 		<th><?php echo __('Activado') ?></th>
							  	</thead>
																	
							
								<tbody>
																	
									
									<?php foreach ( $V->datas as $result ) {?>
																																		
										<tr style="background-color:#eeeeee;">
											<td><?php echo $result->id;?></td>
											<td><?php echo $result->start_date;?></td>
											<td><?php echo $result->end_date;?></td>
											<td><?php echo $result->job_title;?></td>
											<td><?php echo $result->company;?></td>
											<td><?php echo $result->city.','.$result->state;?></td>
											<td align="center"> <input type="checkbox" name="actived" id="actived" onclick="checkUncheckAll('<?php echo $result->id; ?>')" ><br></td>
										
										</tr>
																					 
								  	<?php } ?>
																					
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
							$pageLink = masvalor_getUrl().'/searches_activated/&limitstart='.(($i-1)*$V->itemsPerPage);
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
		