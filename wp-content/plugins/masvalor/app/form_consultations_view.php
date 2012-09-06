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

<!--
    <script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">-->
	
	
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.css">

<script language="javascript" type="text/javascript">
function saveDelete(cid){
	if(confirm("¿Est\u00e1 seguro que quiere borrar la consulta?")) { 
		document.forms['adminForm'].task.value = 'delete';
		document.forms['adminForm'].cid.value = cid;
		document.forms['adminForm'].submit(); 
	}
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
  
function order_grid(column_name,dir) {
	document.getElementById("order").value = column_name;
	document.getElementById("adminForm").submit();
	if(dir == 'desc')
		document.getElementById("order_dir").value = 'asc';
	else
		document.getElementById("order_dir").value = 'desc';
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

.admintable th {
	cursor:pointer;
}
</style>
         					
		<div id="table_noticia" style="font-size: 14px;margin-left: -22px;width: 769px;">
			<h2 style="margin-left: 13px;"><?php echo __('Consultas'); ?></h2>
			 <br/>	
			<form action="" method="post" name="tinymce" id="adminForm">	
				<table>
				<tr>
					 <td>
					
						<div>
							  <td style="width: 547px;"><?php echo __('Filtro'); ?>
								<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
								    <option value="con.name"><?php echo __('Nombre'); ?></option>
								    <option value="user.user_login"><?php echo __('Administrador'); ?></option>
									<option value="con.creation_date"><?php echo __('Rango entre fechas'); ?></option>
								</select>	
							   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar'); ?></button> 
							  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						       <a href="javascript:filterAdvanced()" title="Filtro Fechas" style=" margin-left: -55px;"><img src ="wp-content/plugins/masvalor/app/includes/image/dates.png" style="position: absolute; margin-left: 60px;" alt="Filtro fechas"></a>
							        
								<div id="filter_date" style="visibility: hidden; height: 0px;">
									  <?php echo __('Entre Fechas:') ?>
									<input class="tcal" type="text"  name="filter_date_from" id="filter_date_from" value="" title="<?php echo __('Fecha desde'); ?>"/>
																		
									<input class="tcal" type="text"  name="filter_date_to" id="filter_date_to" value="" title="<?php echo __('Fecha hasta'); ?>"/>
								    
								</div>
								
								<script> if(document.getElementById('filter_date_from').value != '') { showDateFilter(); } </script>
						</div>	 
						
						<div style="float: right; margin-top: -22px;">
							<a href="<?php echo masvalor_getUrl(); ?>/form_consultation/"> <img src="wp-content/plugins/masvalor/app/includes/image/nuevo.png"></a> 
						</div>
						
						<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:683px;text-align:center;margin-bottom: 27px;">
						<div style="width:100%">
							<hr/>
						</div>	
								<thead>
									<th onclick="order_grid('con.name')"><?php echo __('Nombre'); ?></th>
									<th onclick="order_grid('con.creation_date')"><?php echo __('Fecha'); ?></th>
									<th onclick="order_grid('user.user_login')"><?php echo __('Administrador'); ?></th>
									<th><?php echo __('Borrar'); ?></th>
									<th><?php echo __('Editar'); ?></th>
								</thead>
																
								<tbody>
																		
									<?php foreach ( $V->datas as $result ) 
										{?>
																								
										<tr style="background-color: #eeeeee">
											<td><?php echo $result->name;?></td>
											<td><?php echo $result->creation_date;?></td>
											<td><?php echo $result->user_login;?></td>
											<td><a href="#" onclick="saveDelete('<?php echo $result->id;?>');"> X </a></td>
											<td>
											   <a href="<?php echo masvalor_getUrl(); ?>/form_consultation/&cid=<?php echo $result->id;?>">
											        <img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
												</a>
											</td>
											
										</tr>
																					 
									<?php } ?>
																					
							  </tbody>
						  </table>
					</td>
				 </tr>		
			    </table>
				<input type="hidden" name="cid" value="" />	
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="order" id="order" value="" />
				<input type="hidden" name="order_dir" id="order_dir" value="" />
			</form>
		
	
	</div>
		