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



function saveApplicat(cid){
   document.forms['adminForm'].task.value = 'saveApplicat';
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
               									
	<form action="" method="post" name="tinymce" id="adminForm">		
				<h2 style="margin-left: -28px;"><?php echo __('Mis Postulaciones') ?></h2>
				<table style="font-size:11px;width:100%;margin-bottom: 27px; margin-left: -32px;">
				 <tr>
					 <td>
					 	
						<table id="tableSelectedEducation" class="admintable" style="width:650px;text-align:center">
						<div style="width:100%">
							<hr/>
						</div>	
								<thead style="background-color: #adaeb2;">
									<th><?php echo __('Nro') ?></th>
									<th><?php echo __('Fecha Inicio') ?></th>
									<th><?php echo __('Fecha Fin') ?></th>
									<th><?php echo __('Puesto') ?></th>
									<th><?php echo __('Empresa/Institucion') ?></th>
									<th><?php echo __('Lugar') ?></th>
									<th><?php echo __('Fecha Postulacion') ?></th>									
								</thead>
																
								<tbody>
																	
									
									<?php if($V->datas != null){
									      foreach ( $V->datas as $result ){?>
																								
												<tr style="background-color:#eeeeee;">
													<td><?php echo $result->id;?></td>
													<td><?php echo $result->start_date;?></td>
													<td><?php echo $result->end_date;?></td>
													<td><?php echo $result->job_title;?></td>
													<td><?php echo $result->company;?></td>
													<td><?php echo $result->city.','.$result->state;?></td>
													
													<?php
													   $date2 = explode("-",$result->date);
													   $dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
													?>
											
													
													<td><?php echo $dateend;?></td>
													
												</tr>
																							 
										<?php } ?>
										
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
							$pageLink = masvalor_getUrl().'/searches_doctor/&limitstart='.(($i-1)*$V->itemsPerPage);
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
			
		
