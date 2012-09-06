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
 	/* function position_objects_array_for_subbranchs($buscado,$fuente) {
		for($i=0;$i<sizeof($fuente);$i++) 
			if($fuente[$i]->subbranch_name == $buscado)
				return $i;	
		return -1;
	}
	
 	function position_objects_array($buscado,$fuente) {
		for($i=0;$i<sizeof($fuente);$i++) 
			if($fuente[$i]->name == $buscado)
				return $i;	
		return -1;
	}
	
 	function how_many_pixels($branch,$array) {
		$cont = 0;
		$result = 0;
		while($cont<sizeof($array)) {
			if($branch == $array[$cont]->branch_name)
				$result++;
			$cont++;
		}
		return ($result+1)*24.3;
	}	  */
	
	/*function how_many_doctors_can_move($id_subbranch,$name_state) {
		if($_POST["moving"] != null) {
			global $wpdb;
			
			$sql = 'SELECT COUNT(*) FROM wp_masvalor_profiles 
					WHERE state <> "'.$name_state.'" 
					AND availability_move_state = 1
					AND (SELECT COUNT(*) FROM wp_masvalor_rel_user_disciplines rud JOIN wp_masvalor_disciplines d ON rud.disciplineid = d.id WHERE d.id_subbranch = '.$id_subbranch.' and rud.ppal=1) > 0';
			$result = $wpdb->get_var($sql);
		} else
			$result = 0;
			
		return $result;
	}*/
?>
<style>
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
echo '<h3>Oferta Efectiva de Doctores Conicet, seg&uacute;n Comisi&oacute;n Asesora y Zona del lugar de trabajo:</h3></br>';
		// echo '<div style="overflow-x:scroll;overflow-y:hidden;">';
		/* echo '<table style="margin-left:64px;" id="headers_table" name="headers_table" class="admintable" cellspacing="3">';
			echo '<tr>';
			$last_title_loaded = "";
				foreach($V->branchs_with_subbranchs as $bws) 
					if($bws->branch_name != $last_title_loaded) {
						echo '<td style="background-color:lightgrey;border:1px solid;vertical-align:middle;"><div style="width:'.how_many_pixels($bws->branch_name,$V->branchs_with_subbranchs).'px;text-align:center;"><strong>'.$bws->branch_name.'</strong></div></td>';
						$last_title_loaded = $bws->branch_name;
					}
			echo '</tr>';
		echo '</table>';
			echo '<table id="Exportar_a_Excel" name="Exportar_a_Excel" class="admintable" cellspacing="3">';
				echo '<thead>';
					echo '<tr>';
						echo '<th id="th_states" name="th_states" style="background-color:lightgrey !important;">Provincias</th>';
						
						$last_branch = "";
						$first_access = true;
						$color = '#'.dechex(rand(125,255)).dechex(rand(125,255)).dechex(rand(125,255));
						
						foreach($V->loaded_subbranchs as $data) {
							if($V->branchs_with_subbranchs[position_objects_array_for_subbranchs($data,$V->branchs_with_subbranchs)]->branch_name != $last_branch && !$first_access) {
								echo '<th style="background-color:'.$color.'"><div id="div_for_subbranch_th">TOTAL '.substr($V->branchs_with_subbranchs[position_objects_array_for_subbranchs($data,$V->branchs_with_subbranchs)-1]->branch_name,0,15).'...</div></th>';
								$color = '#'.dechex(rand(125,255)).dechex(rand(125,255)).dechex(rand(125,255)); 
							}
							$first_access = false;
							echo '<th style="background-color:'.$color.'"><div id="div_for_subbranch_th">'.substr($data,0,24).'...</div></th>';
							$last_branch = $V->branchs_with_subbranchs[position_objects_array_for_subbranchs($data,$V->branchs_with_subbranchs)]->branch_name;
						}
						echo '<th style="background-color:'.$color.'"><div id="div_for_subbranch_th">TOTAL '.substr($V->branchs_with_subbranchs[position_objects_array_for_subbranchs($data,$V->branchs_with_subbranchs)-1]->branch_name,0,15).'...</div></th>';
						echo '<th><div id="div_for_subbranch_th">Total por provincia</div></th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				$total = 0;
				
				foreach($V->loaded_states as $prov) {
					echo "<tr>";
					echo "<td>".$prov->name."</td>";
					$total_per_state = 0;
					$total_per_state_aux = 0;
					$cont = 0;
					$k = 0;
					$h = 0;
					foreach($prov->dis as $dis) {
						echo "<td>".$dis."</td>";
						$total_per_state = $total_per_state+$dis;
						$total_per_state_aux = $total_per_state_aux+$dis;
						$cont++;
						$h++;
						if($V->subbranchs_for_branch[$k] == $cont) {
							echo '<td style="background-color:white;border:1px solid;">'.$total_per_state_aux.'</td>';
							$cont = 0;
							$total_per_state_aux = 0;
							$k++;
						}
					}
 					echo '<td style="background-color:white;border:1px solid;">'.$total_per_state.'</td>';
					echo "</tr>";
					$total = $total+$total_per_state; 
				}

				if($V->states_comb == "")
					foreach($V->all_states as $state) 
						if(position_objects_array($state->state,$V->loaded_states) == -1) :
							echo '<tr>';
							echo '<td>'.$state->state.'</td>';
							$k = 0;
							$cont = 0;
							$j = 0;
							while($k<sizeof($V->loaded_subbranchs)+$V->branchs_quantity) :							
								echo '<td>0</td>';
								$k++;
								$cont++;
								if($V->subbranchs_for_branch[$j] == $cont) {
									echo '<td style="background-color:white;border:1px solid;">0</td>';
									$cont = 0;
									$k++;
									$j++;
								}

							endwhile;
							echo '<td style="background-color:white;border:1px solid;">0</td>';
							echo '</tr>';	
						endif;
				
				$V->subbranchs_quantity[] = $total;
				echo '<tr>';
					echo '<td style="background-color:white;border:1px solid;">Total por subrama</td>';
					$cont = 0;
					$k = 0;
					$total_per_state=0;
					foreach($V->subbranchs_quantity as $total_dis) {
						echo '<td style="background-color:white;border:1px solid;">'.$total_dis.'</td>';
						$cont++;
						$total_per_state2 = $total_dis + $total_per_state2;
						if($V->subbranchs_for_branch[$k] == $cont) {
							echo '<td style="background-color:white;border:1px solid;">'.$total_per_state2.'</td>';
							$cont = 0;
							$k++;
							$total_per_state2=0;
						}
					}
				echo '</tr>';
				echo "</tbody>";
			echo '</table>' */;

	echo '<div style="overflow-x:scroll;overflow-y:hidden;">';
		echo '<table id="Exportar_a_Excel" name="Exportar_a_Excel" class="admintable" cellspacing="3">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>Pcias/Subs</th>';
					foreach($V->all_committees as $sub) 
						echo '<th>'.$sub->name.'</th>';
					if($V->states_comb == '')
						echo '<th style="background-color:white;">Total</th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				$last_zone = '';
				foreach($V->all_datas as $data) {
					if($last_zone != '' && $data->state != $last_zone)
						echo '</tr>';
					if($data->state != $last_zone) {
						$last_zone = $data->state;
						echo '<tr>';
						echo '<td>'.$data->state.'</td>';
						echo '<td>'.$data->qty.'</td>';
					} else {
						$last_zone = $data->state;
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
	
		echo 'Filtros: Zonas&nbsp;';
		echo '<select id="zones_comb" name="zones_comb">';
			echo '<option value="">Todas</option>';
			foreach($V->all_zones_for_comb as $state)
				echo '<option value="'.$state->id.'">'.$state->name.'</option>';
		echo '</select>&nbsp;';
		echo '<input type="submit" value="Actualizar" id="actualize" name="actualize"/>'; 
?>
</form>

<form action="wp-content/plugins/masvalor/app/ficheroexcel.php" method="post" target="_blank" id="FormularioExportacion">
		<p> <?php echo __('Exportar a Excel') ?> <img src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
		<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
