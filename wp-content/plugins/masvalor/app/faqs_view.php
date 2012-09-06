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

<script language="javascript" type="text/javascript">

<?php require_once ('models/masvalor_utils.php'); ?>

function saveDelete(cid){
   document.forms['adminForm'].task.value = 'delete';
   document.forms['adminForm'].cid.value = cid;
   document.forms['adminForm'].submit(); 
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
	 
						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;">
			<form action="" method="post" name="tinymce" id="adminForm">
			<table>
			<tr>
				 <td>
				 <legend><h2><?php echo __('FAQS') ?></h2></legend>
					
					<?php /*?>				   
				   <br/>	
					
					<div>
					  <td align="left" width="50%"><?php echo __('Filtro') ?>
						<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="" class="text_area" title="Filtro"/>   
						<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;width: 88px;">
						  <option value=""> </option>
						  <option value=<?php //echo isSelect('p.anme',$var_search);?>><?php echo __('Nombre') ?></option>
						</select>	
					   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
					  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
					</div>	
					<?php */?>		
					
					<div style="float: right; margin-top: -22px;margin-right: -244px;">
						<a href="<?php echo masvalor_getUrl(); ?>/faq/"> <img src="wp-content/plugins/masvalor/app/includes/image/nuevo.png"></a> 
					</div>
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:180%;text-align:center;margin-bottom: 27px;">
					<div style="width:180%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Fecha') ?></th>
								<th><?php echo __('Borrar') ?></th>
								<th><?php echo __('Editar') ?></th>
							</thead>
							
							<tbody>

							<?php  foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
											<td><?php echo $data->post_title;?></td>
											<td><?php echo $data->post_date;?></td>
											<td><a href="#" onclick="saveDelete('<?php echo $data->ID;?>');"> X </a></td>
											<td><a href="<?php echo masvalor_getUrl(); ?>/faq/&cid=<?php echo $data->ID;?>">
												<img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" /> </a></td>
										</tr>
							<?php }?>
										
											
																				
						  </tbody>
					</table>
				</td>
			</tr>		
		    </table>
			<input type="hidden" name="cid" value="" />	
			<input type="hidden" name="task" value="" />
			
		   </form>
		   
		</div>
		
			
				
				
