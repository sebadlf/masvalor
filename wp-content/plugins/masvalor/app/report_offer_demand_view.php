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

<?php
 	function position_objects_array($buscado,$fuente) {
		for($i=0;$i<sizeof($fuente);$i++) 
			if($fuente[$i]->state == $buscado)
				return $i;	
		return -1;
	}
?>

<style>
#Exportar_a_Excel {
	background-color:#eeeeee;
	font-size:10px;
	text-align:center;
	width:100%;
}

.botonExcel{cursor:pointer;}

#Exportar_a_Excel th {
	background-color:#639CD3;
	vertical-align:middle;
}

#Exportar_a_Excel td {
	background-color:lightgrey;
}
</style>

<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery-1.3.2.min.js"></script>
 <script language="javascript" type="text/javascript">
    
   $(document).ready(function() {
		$(".botonExcel").click(function(event) {
			$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
			$("#FormularioExportacion").submit();
		});
	});
  
</script> 

<form action="" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
<?php 
echo '<h3>Reporte de Demanda de empresas VS Oferta de doctores segun  subdisciplina y provincia del lugar de trabajo:</h2></br>';
/* 	if($V->offer_data == null && $V->demand_data == null)
		echo 'No existen datos a mostrar.';
	else {
		echo '<table id="Exportar_a_Excel" name="Exportar_a_Excel" class="admintable" cellspacing="3">';
			echo '<tr>';
				echo '<thead>';
					echo '<th>Provincia</th>';
					echo '<th>Oferta</th>';
					echo '<th>Demanda</th>';
					echo '<th>Oferta/Demanda</th>';
				echo '</thead>';
			echo '</tr>';
			echo '<tbody>';
			
			$i=0;
			$j=0;
			$fixData = new stdClass();
			$fixData->state = "ZZ";
			$fixData->qty = 0;
			$V->offer_data[] = $fixData;
			$V->demand_data[] = $fixData;

			while( $V->offer_data[$i]->state != "ZZ" || $V->demand_data[$j]->state != "ZZ") {
				echo '<tr>';
				if ($V->offer_data[$i]->state > $V->demand_data[$j]->state) { 
					echo '<td>'.$V->demand_data[$j]->state.'</td>';
					echo '<td>0</td>';
					echo '<td>'.$V->demand_data[$j]->qty.'</td>';
					echo '<td>0/'.$V->demand_data[$j]->qty.'</td>';
					$j++;
				} elseif($V->offer_data[$i]->state < $V->demand_data[$j]->state) {
					echo '<td>'.$V->offer_data[$i]->state.'</td>';
					echo '<td>'.$V->offer_data[$i]->qty.'</td>';
					echo '<td>0</td>';
					echo '<td>'.$V->offer_data[$i]->qty.'/0</td>';
					$i++;
				} else {
					echo '<td>'.$V->offer_data[$i]->state.'</td>';
					echo '<td>'.$V->offer_data[$i]->qty.'</td>';
					echo '<td>'.$V->demand_data[$j]->qty.'</td>';
					echo '<td>'.$V->offer_data[$i]->qty.'/'.$V->demand_data[$j]->qty.'</td>';
					$i++;
					$j++;
				}
				echo '</tr>';
			}
				
				if($V->states_comb == "")
					foreach($V->all_states as $state) 
						if(position_objects_array($state->state,$V->offer_data) == -1 && position_objects_array($state->state,$V->demand_data) == -1) {
							echo '<tr>';
								echo '<td>'.$state->state.'</td>';
								echo '<td>0</td>';
								echo '<td>0</td>';
								echo '<td>0/0</td>';
							echo '</tr>';
						}
						
			echo '</tbody>';
		echo '</table></br>';
	} */
	
	echo '<div style="overflow-x:scroll;overflow-y:hidden;">';
		echo '<table id="Exportar_a_Excel" name="Exportar_a_Excel" class="admintable" cellspacing="3">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>Pcias/Subs</th>';
					foreach($V->all_subdisciplines as $sub) 
						echo '<th>'.$sub->name.'</th>';
					echo '<th style="background-color:white;">Total</th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				$last_state = '';
				foreach($V->all_datas as $data) {
					if($last_state != '' && $data->state != $last_state)
						echo '</tr>';
					if($data->state != $last_state) {
						$last_state = $data->state;
						echo '<tr>';
						echo '<td>'.$data->state.'</td>';
						echo '<td>'.$data->qty.'</td>';
					} else {
						$last_state = $data->state;
						if($V->is_end)
							echo '<td style="background-color:white;">'.$data->qty.'</td>';
						else
							echo '<td>'.$data->qty.'</td>';
					}
				}
				echo '<tr>';
					echo '<td style="background-color:white;">Total</td>';
					foreach($V->subs_total as $sub_total)
						echo '<td style="background-color:white;">'.$sub_total.'</td>';
					echo '<td style="background-color:white;">'.$V->sub_total.'</td>';
				echo '</tr>';
			echo '</tbody>';
		echo '</table>';
	echo '</div>';
	echo '</br>';
	
echo "Filtros: Provincia&nbsp;";
echo '<select id="states_comb" name="states_comb">';
	echo '<option value="">Todas</option>';
	foreach($V->all_states as $state)
		echo '<option value="'.$state->state.'">'.$state->state.'</option>';
echo '</select>&nbsp;';
echo '<input type="submit" value="Actualizar" id="actualize" name="actualize"/>'; 
?>
</form>

<form action="wp-content/plugins/masvalor/app/ficheroexcel.php" method="post" target="_blank" id="FormularioExportacion">
		<p> <?php echo __('Exportar a Excel') ?> <img src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
		<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
