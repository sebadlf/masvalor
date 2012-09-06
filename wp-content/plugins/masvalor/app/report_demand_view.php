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
/* #Exportar_a_Excel {
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
} */

#Exportar_a_Excel {
	background-color:#eeeeee;
	font-size:10px;
	text-align:center;
	width:100%;
}

#Exportar_a_Excel td {
	background-color:lightgrey;
}

.botonExcel{cursor:pointer;}

#div_for_subbranch_th {
	width:20px;
	height:20px;
	white-space:nowrap;
	-webkit-transform:rotate(-90deg);
	-moz-transform:rotate(-90deg);
	-o-transform: rotate(-90deg);
}

#th_states {
	vertical-align:middle !important;
}

#Exportar_a_Excel th {
	border:1px solid;
	background-color:#EEEEEE;
	vertical-align:middle;
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
echo '<h3>Busquedas de Doctores Conicet, seg&uacute;n Subdisciplina y Provincia del Lugar de Trabajo:</h2></br>';
/* 		echo '<table id="Exportar_a_Excel" name="Exportar_a_Excel" class="admintable" cellspacing="3">';
			echo '<tr>';
				echo '<thead>';
					echo '<th>Provincia/Sector</th>';
					echo '<th>Industria</th>';
					echo '<th>Servicios</th>';
					echo '<th>Educaci&oacute;n</th>';
					echo '<th>Organizaci&oacute;n no gubernamental</th>';
					echo '<th>Organizaci&oacute;n gubernamental</th>';
					echo '<th>Auto-empleo</th>';
					echo '<th style="background-color:white;border:1px solid;">Total por provincia</th>';
				echo '</thead>';
			echo '</tr>';
			echo '<tbody>';
			
				$total_per_sector->industria = 0;
				$total_per_sector->servicios = 0;
				$total_per_sector->educacion = 0;
				$total_per_sector->ngo = 0;
				$total_per_sector->go = 0;
				$total_per_sector->self = 0;
				foreach($V->data as $data) {
					echo '<tr>';
						echo '<td>'.$data->state.'</td>';
						echo '<td>'.$data->industria.'</td>';
						$total_per_sector->industria = $total_per_sector->industria+$data->industria;
						echo '<td>'.$data->servicios.'</td>';
						$total_per_sector->servicios = $total_per_sector->servicios+$data->servicios;
						echo '<td>'.$data->educacion.'</td>';
						$total_per_sector->educacion = $total_per_sector->educacion+$data->educacion;
						echo '<td>'.$data->ngo.'</td>';
						$total_per_sector->ngo = $total_per_sector->ngo+$data->ngo;
						echo '<td>'.$data->go.'</td>';
						$total_per_sector->go = $total_per_sector->go+$data->go;
						echo '<td>'.$data->self.'</td>';
						$total_per_sector->self = $total_per_sector->self+$data->self;
						$total_per_state = $data->industria+$data->servicios+$data->educacion+$data->ngo+$data->go+$data->self;
						echo '<td style="background-color:white;border:1px solid;">'.($total_per_state).'</td>';
						$i++;
					echo '</tr>';
				}
				
				if($V->states_comb == "")
					foreach($V->all_states as $state) 
						if(position_objects_array($state->state,$V->data) == -1) {
							echo '<tr>';
								echo '<td>'.$state->state.'</td>';
								echo '<td>0</td>';
								echo '<td>0</td>';
								echo '<td>0</td>';
								echo '<td>0</td>';
								echo '<td>0</td>';
								echo '<td>0</td>';
								echo '<td style="background-color:white;border:1px solid;">0</td>';
							echo '</tr>';
						}
						
				echo '<tr>';
					echo '<td style="background-color:white;border:1px solid;">Total por sector</td>';
					echo '<td style="background-color:white;border:1px solid;">'.$total_per_sector->industria.'</td>';
					echo '<td style="background-color:white;border:1px solid;">'.$total_per_sector->servicios.'</td>';
					echo '<td style="background-color:white;border:1px solid;">'.$total_per_sector->educacion.'</td>';
					echo '<td style="background-color:white;border:1px solid;">'.$total_per_sector->ngo.'</td>';
					echo '<td style="background-color:white;border:1px solid;">'.$total_per_sector->go.'</td>';
					echo '<td style="background-color:white;border:1px solid;">'.$total_per_sector->self.'</td>';
					$total = $total_per_sector->industria+$total_per_sector->servicios+$total_per_sector->educacion+$total_per_sector->ngo+$total_per_sector->go+$total_per_sector->self;
					echo '<td style="background-color:white;border:1px solid;">'.$total.'</td>';
				echo '</tr>';
			echo '</tbody>';
		echo '</table></br>'; */
		
	echo '<div style="overflow-x:scroll;overflow-y:hidden;">';
		echo '<table id="Exportar_a_Excel" name="Exportar_a_Excel" class="admintable" cellspacing="3">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>Pcias/Subs</th>';
					foreach($V->all_subdisciplines as $sub) 
						echo '<th>'.$sub->name.'</th>';
					if($V->states_comb == '')
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
						if($data->is_end)
							echo '<td style="background-color:white;">'.$data->qty.'</td>';
						else
							echo '<td>'.$data->qty.'</td>';
					}
				}

				if($V->states_comb == '') {
					echo '<tr>';
						echo '<td style="background-color:white;">Total</td>';
						foreach($V->subs_total as $sub_total)
							echo '<td style="background-color:white;">'.$sub_total.'</td>';
						echo '<td style="background-color:white;">'.$V->sub_total.'</td>';
					echo '</tr>';
				}
				
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
