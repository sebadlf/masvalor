<?php
/**
 * The users dashboard
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Page-Controllers
 * @author     Francis Crossen <francis@crossen.org>
*/

/**
 * The users dashboard
 *
 * Users with Subscriber role are directed here. Link to
 * change personal details page
 *
 * @package    Tina-MVC
 * @todo       add a Wordpress action hook to direct the user here after login
 */
class report_statistical_indicatorsModel {
    
    public function getData($filter_date_from,$filter_date_to){
		global $wpdb;
		$data = "";
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
		$sql = 'SELECT id,start_date,end_date,job_title,company,state,country,city,actived
					     FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.' AND status = "'.$filter_sel.'"';
		
		 $data = $wpdb->get_results($sql);	
					
		}		
				  
		return $data;	
    }
    
	
	public function getEffectivenessPild($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
		$data_re = 0;
		
		if($filter_date_from != "" && $filter_date_to != ""){
		    
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND
								end_date >= '.$filter_date_to.' AND
						        status LIKE "Satisfecha" ';
				    			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
						
			$count_doctor = $this->getDataCountDoctor($filter_date_from,$filter_date_to);
						
			if($count_doctor >0)			
				$data_re = ($count * 100)/ $count_doctor;		
			
		}
		
		return $data_re;	

    }
		
	
	public function getInsertion($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
		$data = 0;
		
		if($filter_date_from != "" && $filter_date_to != ""){
		   $count_search = $this->getDataCount($filter_date_from,$filter_date_to,$filter_sel);
																		
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND
								end_date >= '.$filter_date_to.' AND
						        status LIKE "Satisfecha" AND selected_profile != "null"';
				    			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		    endforeach;
           
		  /* if($count_search >0)	
			  $data = ($count * 100)/ $count_search;*/		
		}
		
		//return $data;	
        return $count;
    }
	
	
	public function getInsertionSector($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
		$data = 0;
		
		if($filter_date_from != "" && $filter_date_to != ""){
		   $count_search = $this->getDataCount($filter_date_from,$filter_date_to,$filter_sel);
																		
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND
								end_date >= '.$filter_date_to.' AND
						        status LIKE "Satisfecha" AND selected_profile != "null"';
				    			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
           
           if($count_search >0)		   
			 $data = ($count * 100)/ $count_search;		
		
		}
		
		return $data;	

    }
	
	   
	public function getDataCount($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.'';
				    			
			$data = $wpdb->get_results($sql);	
			
				
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
		
		}
		
		return $count;	
		
    }
   
   
   
   public function getVolume_of_the_Offer($filter_date_from,$filter_date_to){
	  global $wpdb;
	   $count = 0;
	 
	 if($filter_date_from != "" && $filter_date_to != ""){	
	  
		  $sql = 'SELECT  COUNT(*) as count	FROM '.$wpdb->prefix.'masvalor_profiles,'.$wpdb->prefix.'users u
							WHERE u.ID = userid AND actived = 1' ;  
		
		  $data = $wpdb->get_results($sql);
		  
		 			
		  foreach ($data as $aData):
				$count = $aData->count;
		  endforeach; 	
	  }
		
      return $count;	
		
	}
	
	public function getDemand_volume($filter_date_from,$filter_date_to){
	  global $wpdb;
	   $count = 0;
	 
	  
	 
	 if($filter_date_from != "" && $filter_date_to != ""){	
	  
		  		 
		  $sql = 'SELECT COUNT(*) AS count  FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.' AND actived=1';
						  
		  $data = $wpdb->get_results($sql);
		  
		 			
		  foreach ($data as $aData):
				$count = $aData->count;
		  endforeach; 	
	  }
		
      return $count;	
		
	}
	
    public function getDataCountDoctor($filter_date_from,$filter_date_to){
	  global $wpdb;
	   $count = 0;
	 
	    $date2 = explode("-", $filter_date_from);
		$filter_date_from_conv  = $date2[2].'-'.$date2[1].'-'.$date2[0];	   

	    $date2 = explode("-", $filter_date_to);
		$filter_date_to_conv  = $date2[2].'-'.$date2[1].'-'.$date2[0];	
	 
	 if($filter_date_from != "" && $filter_date_to != ""){	
	  
		  /*$sql = 'SELECT  COUNT(*) as count	FROM '.$wpdb->prefix.'masvalor_profiles,'.$wpdb->prefix.'users u
							WHERE u.ID = userid AND actived = 1 AND u.user_registered < = '.$filter_date_from_conv.''; */ 
							
		  $sql = 'SELECT  COUNT(*) as count	FROM '.$wpdb->prefix.'masvalor_profiles,'.$wpdb->prefix.'users u
							WHERE u.ID = userid AND actived = 1 ';					
		
		  $data = $wpdb->get_results($sql);
		  
		 			
		  foreach ($data as $aData):
				$count = $aData->count;
		  endforeach; 	
	  }
		
      return $count;	
		
	}
    
	
	public function getIntegration_SectorUniversity($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs 
						   WHERE status LIKE "Satisfecha" AND type_education = 1';
					
			$data = $wpdb->get_results($sql);	
			
			foreach ($data as $aData):
					$count++;
			endforeach; 		
	
		}		
				  
		return $count;	
    }
	
	
	public function getIntegration_SectorIndustry($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs 
						   WHERE status LIKE "Satisfecha" AND type_industry = 1';
					
			$data = $wpdb->get_results($sql);	
			
			foreach ($data as $aData):
					$count++;
			endforeach; 		
	
		}		
				  
		return $count;	
    }
	
	public function getIntegration_SectorServices($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs 
						   WHERE status LIKE "Satisfecha" AND type_services = 1';
					
			$data = $wpdb->get_results($sql);	
			
			foreach ($data as $aData):
					$count++;
			endforeach; 		
	
		}		
				  
		return $count;	
    }
	
	public function getIntegration_SectorGo($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs 
						   WHERE status LIKE "Satisfecha" AND type_go = 1';
					
			$data = $wpdb->get_results($sql);	
			
			foreach ($data as $aData):
					$count++;
			endforeach; 		
	
		}		
				  
		return $count;	
    }
	
	public function getIntegration_SectorNGo($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs 
						   WHERE status LIKE "Satisfecha" AND type_ngo = 1';
					
			$data = $wpdb->get_results($sql);	
			
			foreach ($data as $aData):
					$count++;
			endforeach; 		
	
		}		
				  
		return $count;	
    }
	
	
	
	public function getFederal_outreach($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
		$sql = 'SELECT DISTINCT(state)FROM '.$wpdb->prefix.'masvalor_companysearchs 
				       WHERE status LIKE "Satisfecha" ';
				
		$data = $wpdb->get_results($sql);	
		
		foreach ($data as $aData):
				$count++;
		endforeach; 		

		
		}		
				  
		return $count;	
    }
	
	public function getState($filter_date_from,$filter_date_to){
		global $wpdb;
								
																	
		$sql = 'SELECT state,COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				         WHERE status LIKE "Satisfecha" GROUP BY state';
		
		$data = $wpdb->get_results($sql);	
		
	
				  
		return $data;	
    }
	
	
	public function getDisciplines($filter_date_from,$filter_date_to){
		global $wpdb;
																		
		$sql = 'SELECT dis.name,COUNT(*) AS count  FROM '.$wpdb->prefix.'masvalor_companysearchs c,
													'.$wpdb->prefix.'masvalor_profiles doc,
													'.$wpdb->prefix.'masvalor_rel_user_disciplines doc_d,
													'.$wpdb->prefix.'masvalor_disciplines dis
						WHERE c.status LIKE "Satisfecha" AND 
							  doc.userid = c.selected_profile AND
							  doc_d.userid = doc.userid AND
							  doc_d.disciplineid = dis.id GROUP BY dis.name';
		
		
		$data = $wpdb->get_results($sql);	
		  
		return $data;	
    }
	
	
	
	public function getDemand_response($filter_date_from,$filter_date_to){
		global $wpdb;
		$count = 0;
						
		if($filter_date_from != "" && $filter_date_to != ""){	
			
					 
			$sql = 'SELECT searr.searchid,COUNT(*) as count,sear.status FROM '.$wpdb->prefix.'masvalor_searchresults searr,'.$wpdb->prefix.'masvalor_companysearchs sear
						   WHERE searr.date >= '.$filter_date_from.' AND
								 searr.date >= '.$filter_date_to.' AND
								 searr.searchid = sear.id GROUP BY searr.searchid ';					 
			
			
			
			$data = $wpdb->get_results($sql);	
			$count_satis = 0;
			$satis=0;
			$count_insatis = 0;
			$insatis=0;
			foreach ($data as $result):
				if($result->status == "Pendiente"){
				  $count_satis = $count_satis + $result->count;
			      $satis++;
				}
				$count_insatis = $count_insatis + $result->count;
			    $insatis++;
				
			endforeach; 		
            						
			$total= ($count_satis*100)/$count_insatis;
		     
		}		
				  
		return $total;	
    }
	
	
	
	 public function getDemand_satisfaction($filter_date_from,$filter_date_to){
			  global $wpdb;
			  $count = 0;
				  
			  if($filter_date_from != "" && $filter_date_to != ""){     
			   
			   $sql = 'select status from wp_masvalor_companysearchs where actived=1';
			   
			   $data = $wpdb->get_results($sql); 
			   $satis=0;
			   $total=0;
			   foreach ($data as $result):
				if($result->status == "Satisfecha")
					 $satis++;
				   $total++;
			   endforeach;   
			   
			   $percent= ($satis*100)/$total;
				   
			  }  
				  
			  return $percent; 
    }
	
	
	
	public function getPermanence($filter_date_from,$filter_date_to){
		global $wpdb;
	   $count = 0;
       
		$date2 = explode("-", $filter_date_from);
		$filter_date_from_conv  = $date2[2].'-'.$date2[1].'-'.$date2[0];	   

	    $date2 = explode("-", $filter_date_to);
		$filter_date_to_conv  = $date2[2].'-'.$date2[1].'-'.$date2[0];	
	    
	 
	 if($filter_date_from != "" && $filter_date_to != ""){	
	      
		  $insertDoct=$this->getInsertion($filter_date_from,$filter_date_to,$filter_sel);
		  
		     $sql = 'SELECT  COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_profiles,'.$wpdb->prefix.'users u
				WHERE u.ID = userid AND actived = 1 AND 
             u.user_registered <= "'.$filter_date_from_conv.'" ';
		
		  
		  $data = $wpdb->get_results($sql);
		  
		 			
		  foreach ($data as $aData):
				$count = $aData->count;
		  endforeach; 	
		  
		  
		

	  }
	  	
		
      return $count;	
	  
    }
	
	
	function getPermanence2($filter_date_from,$filter_date_to){
	
	
	
		$sql = ' SELECT u.user_registered as entro, mvs.last_status_date as salio, DATEDIFF(mvs.last_status_date, u.user_registered) as permanencia FROM wp_masvalor_profiles mvp, wp_masvalor_companysearchs mvs, wp_users u 
			WHERE 
			u.id = mvp.userid 
			AND 
			u.user_registered <= '.$filter_date_to_conv.'
			AND
			u.user_registered >= '.$filter_date_from_conv.'
			AND
			mvp.actived = 1
			AND
			mvs.selected_profile = mvp.userid
			ORDER BY permanencia';
		
		$data = $wpdb->get_results($sql);	  
		  
		//var_dump($sql);	
		 
		$sql = 'SELECT u.user_registered as entro, periodo_fin as salio,DATEDIFF(periodo_fin,u.user_registered ) as permanencia FROM wp_masvalor_profiles mvp, wp_users u 
			WHERE 
			u.id = mvp.userid 
			AND 
			u.user_registered <= '.$filter_date_to_conv.'
			AND
			u.user_registered >= '.$filter_date_from_conv.'
			AND
			mvp.actived = 1
			AND
			(SELECT COUNT(id) FROM wp_masvalor_companysearchs WHERE mvp.userid = selected_profile) = 0
			ORDER BY permanencia ';
	
        $data2 = $wpdb->get_results($sql);
	    
		//var_dump($sql);	
	  
	
	}
	
	function satisfacionDemanda($filter_date_from,$filter_date_to){
	   global $wpdb;
		
		//Cuento todas las busquedas que caen en el periodo
		$sql = 'SELECT COUNT(id) as busquedas FROM '.$wpdb->prefix.'masvalor_companysearchs
					WHERE start_date >= '.$filter_date_from.' AND
						  start_date <= '.$filter_date_to.'   AND
 						  actived = 1';
						  
	    $data = $wpdb->get_results($sql);
		 
		//Cuento todas las busquedas que caen en el periodo que esten finalizadas en el plazo estipulado
		$sql = 'SELECT COUNT(id) as busquedas_finalizadas FROM '.$wpdb->prefix.'masvalor_companysearchs
						WHERE start_date >= '.$filter_date_from.' AND
							  start_date <= '.$filter_date_to.' 	AND
		                      selected_profile IS NOT NULL		AND
		                      last_status_date <= DATE_ADD(start_date,INTERVAL plazo DAY) AND
		                      actived = 1';
							 
	    $data2 = $wpdb->get_results($sql);
		$date3= ($date2*100)/$data ;
	    //Ahora solamente queda hacer la cuenta de " busquedas_finalizadas*100/busquedas " y obtenemos el porcentaje.
		return date3;
		
	}
	
	
	
	function respuestaDemanda($filter_date_from,$filter_date_to){
	
		//Cuento todas las busquedas que caen en el periodo
		$sql = 'SELECT COUNT(id) as busquedas FROM wp_masvalor_companysearchs
						WHERE start_date >= '.$filter_date_from.' AND
							  start_date <= '.$filter_date_to.'   AND
							  actived = 1';
							  
		$data = $wpdb->get_results($sql);
	
		//Cuento todas las busquedas que caen en el periodo que esten respondidas en el plazo estipulado
		$sql = 'SELECT COUNT(mvs.id) as busquedas_respondidas FROM '.$wpdb->prefix.'masvalor_companysearchs mvs
						WHERE
						mvs.start_date >= '.$filter_date_from.'	AND
						mvs.start_date <= '.$filter_date_to.'	AND
						(SELECT COUNT(id) FROM wp_masvalor_searchresults 
							WHERE searchid = mvs.id 
							AND date <= DATE_ADD(mvs.start_date,INTERVAL plazo DAY)
							AND type = 0) >= 1	AND
							actived = 1';
	
		$data2 = $wpdb->get_results($sql);
	
	    $date3= ($date2*100)/$data ;
		
		return $date3;
	  /*Ahora solamente queda hacer la cuenta de " busquedas_respondidas*100/busquedas " y obtenemos el porcentaje.
	  Se esta considerando a una busqueda como respondida si algun administrador le asigno un candidato dentro del plazo (indicado con type = 0),
	  si se deseara considerar como respondida una busqueda cuando se candidatea un doctor por si mismo se deberia agregar (type = 0 OR type =2),
	  de la misma forma si se deseara considerar como respondida una busqueda cuando agrega candidatos la compania (type = 0 OR type =1)*/
	
	}
	
	
}
?>