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

function order_grid(column_name,dir) {
	document.getElementById("order").value = column_name;
	document.getElementById("adminForm").submit();
	if(dir == 'desc')
		document.getElementById("order_dir").value = 'asc';
	else
		document.getElementById("order_dir").value = 'desc';
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

.admintable th {
	cursor:pointer;
}

a{
 text-decoration: none;
 color:black;
}
</style>
               										
	<form action="" method="post" name="tinymce" id="adminForm">		
	   <h2 style="margin-left: -28px;"><?php echo __('B&uacute;squedas Abiertas') ?></h2>
	   <br/>
				<table style="font-size:10px;width:96%;margin-bottom: 27px; margin-left: -32px;">	
     		<tr>
				 <td>
				 
						<div>
						  <td style="width:100%;padding-left:0px;"><?php echo __('Filtro') ?>
							<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
							<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
							 	 <option value="job_title"><?php echo __('Puesto') ?> </option>
								 <option value="company"><?php echo __('Empresa') ?> </option>
								 <option value="state"><?php echo __('Lugar') ?></option>
							</select>	
						   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
						  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						</div>	
						<table id="tableSelectedEducation" class="admintable" style="font-size:10px;width:683px;text-align:center;margin-bottom: 27px;">
						<div style="width:100%">
							<hr/>
						</div>	
								<thead style="background-color: #adaeb2;">
									<th><?php echo __('Nro') ?></th>
									<th onclick="order_grid('job_title')"><?php echo __('Puesto') ?></th>

									<th onclick="order_grid('company')"><?php echo __('Empresa/Instituci&oacute;n') ?></th>
									<th onclick="order_grid('state')"><?php echo __('Lugar') ?></th>
								</thead>
																
								<tbody>
																	
									
									<?php foreach ( $V->datas as $result ) 
										{?>
																								
										<tr style="background-color:#eeeeee;">
											<td><?php echo $result->id;?></td>
											<td>
											    <a href="<?php echo masvalor_getUrl(); ?>/searche_public/&cid=<?php echo $result->id;?>" title="<?php echo __('Ver Busqueda Completa') ?>">
													<?php echo $result->job_title;?>
												</a>
											</td>
											<td><?php echo $result->company;?></td>
											<td><?php echo $result->city.','.$result->state;?></td>
											
											<?php /* ?>
											<td><a href="<?php echo masvalor_getUrl(); ?>/searche_public/&cid=<?php echo $result->id;?>">
												   <img alt="<?php echo __('Ver Busqueda') ?>" title="<?php echo __('Ver Busqueda') ?>" WIDTH="16" HEIGHT="16" src="wp-content/plugins/masvalor/app/includes/image/nuevo.png" />
												</a>
											</td>
											<?php */ ?>
											
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
							$pageLink = masvalor_getUrl().'/searches_public/&limitstart='.(($i-1)*$V->itemsPerPage);
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
	
		