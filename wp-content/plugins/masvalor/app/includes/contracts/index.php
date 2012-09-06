<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Contrato</title>
</head>


<body style="margin: 0px auto; width: 600px;">
<br>

<?php 
	  $date= date("d-m-Y");
      $date2 = explode("-",$date);																		
	  $dia = $date2[0];
	  $mes = $date2[1];
	  $anio = $date2[2];
	  
	  $mesret = "";
	  if($mes == "01")
	    $mesret = "Enero";
	  if($mes == "02")
		$mesret = "Febrero";
	  if($mes == "03")	  
	    $mesret = "Marzo";
	  if($mes == "04")
		$mesret = "Abril";
	  if($mes == "05")
		$mesret = "Mayo";
	  if($mes == "06")
		$mesret = "Junio";
	  if($mes == "07")
	     $mesret = "Julio";
	  if($mes == "08")
	      $mesret = "Agosto";
	  if($mes == "09")
	      $mesret = "Septiembre";
	  if($mes == "10")
	      $mesret = "Octubre";
	  if($mes == "11")
	    $mesret = "Noviembre";
	  if($mes == "12")
	    $mesret = "Diciembre"; 	
	  ?>

			<p style="text-align: center; ">
<img src="img/logo_convenio.jpg"/> </p>

			<p style="text-align: center; ">

			<strong>CONVENIO DE ADHESI&Oacute;N</strong></p>
			<p style="text-align: justify; ">
			Entre el Consejo Nacional de Investigaciones Cient&iacute;ficas y T&eacute;cnicas, en adelante CONICET y <?php echo $_GET["business_name"]; ?>, en adelante USUARIO, en el marco del Programa +VALOR.Doc del CONICET &ldquo;Sumando Doctores al Desarrollo de Argentina&rdquo;, acuerdan celebrar el presente convenio de adhesi&oacute;n.</p>
		<p style="text-align: justify; ">
			A tal efecto, el CONICET, con domicilio legal en Av. Rivadavia 1917, Ciudad Aut&oacute;noma de Buenos Aires y <?php echo $_GET["business_name"]; ?>, con domicilio legal en <?php echo $_GET["company_address"]; ?> ,<?php echo $_GET["city"]; ?>, <?php echo $_GET["state"]; ?>,&nbsp;</a></u>representados respectivamente por su Presidente Dr. Roberto C. SALVAREZZA y su <?php echo $_GET["job_charge"]; ?>, <?php echo $_GET["company_owner"]; ?>, acuerdan:</p>
		<p style="text-align: justify; ">
			PRIMERA: El Programa +VALOR.Doc &ldquo;Sumando Doctores al Desarrollo de Argentina&rdquo; tiene como objetivo principal incrementar el aprovechamiento social del conocimiento, promocionando y facilitando la inserci&oacute;n de doctores en el sector productivo y de servicios, las universidades, la gesti&oacute;n p&uacute;blica y otros &aacute;mbitos de la sociedad.</p>
		<p style="text-align: justify; ">
			SEGUNDA: A trav&eacute;s de su sitio Web el Programa +VALOR.Doc facilita el acceso y la utilizaci&oacute;n de servicios y contenidos&nbsp; relacionados con la b&uacute;squeda de empleo&nbsp; de doctores, publicando ofertas de trabajo suministradas por empresas e instituciones&nbsp; que deseen iniciar un proceso de selecci&oacute;n e incorporaci&oacute;n de tales recursos humanos.</p>
		<p style="text-align: justify; ">
			TERCERA: El Programa +VALOR.Doc no interviene en la transacci&oacute;n entre las empresas/instituciones y los doctores. Por ello no puede garantizar la aptitud y capacidad de los doctores para cubrir las vacantes. Ni tampoco asumir&aacute; responsabilidad sobre la autenticidad y actualidad de los datos consignados por los doctores registrados en el Programa.</p>
		<p style="text-align: justify; ">
			CUARTA: La informaci&oacute;n que las empresas e instituciones oferentes de trabajo registran en el sistema tiene car&aacute;cter de declaraci&oacute;n jurada.</p>
		<p style="text-align: justify; ">
			QUINTA: La empresa/instituci&oacute;n registrada autoriza expresamente al CONICET a incorporar en el Sitio Web, a exclusivo criterio de este &uacute;ltimo, su logo/marca de titularidad con el &uacute;nico fin de referenciar a dicho Usuario como participante del Programa y usuario del sitio Web.</p>
		<p style="text-align: justify; ">
			SEXTA: A partir de la suscripci&oacute;n al presente convenio de adhesi&oacute;n la empresa/instituci&oacute;n oferente de trabajo se compromete a informar de manera fehaciente a los responsables del Programa en un t&eacute;rmino de treinta (30) d&iacute;as&nbsp; sobre el avance de la b&uacute;squeda,&nbsp; el resultado de las entrevistas, o&nbsp; la eventual firma de un contrato de trabajo. Espec&iacute;ficamente, se deber&aacute; informar: 1) la cantidad de postulantes que fueron entrevistados, del total de postulantes ofrecidos por el Programa +VALOR.Doc; y 2) el resultado de dichas entrevistas, indicando si alguno de los entrevistados ha obtenido el puesto, y quien.</p>
		<p style="text-align: justify; ">
			SEPTIMA: El Programa +VALOR.Doc podr&aacute; utilizar la informaci&oacute;n indicada en la cl&aacute;usula quinta para dar publicidad/difusi&oacute;n y hacer p&uacute;blico el accionar y resultados del Programa.</p>
		<p style="text-align: justify; ">
			OCTAVA: La utilizaci&oacute;n del servicio es gratuita, no correspondiendo percibir ni de la empresa/instituci&oacute;n oferentes de trabajo, ni de los doctores demandantes de trabajo, retribuci&oacute;n o costo alguno.</p>
		<p style="text-align: justify; ">
			NOVENA: El presente convenio entrar&aacute; en vigor a partir de la fecha de su firma y tendr&aacute; vigencia indefinida, salvo que una de las partes comunicara a la otra su decisi&oacute;n de rescindirlo. En tal caso, deber&aacute; notificarlo en forma fehaciente con treinta (30) d&iacute;as anticipaci&oacute;n a la fecha en que se pretende darle t&eacute;rmino.</p>
		<p style="text-align: justify; ">
			DECIMA: Cualquier cuesti&oacute;n no prevista en el presente convenio o diferencia entre las partes que surja de su aplicaci&oacute;n, ser&aacute; resuelta por consenso entre las partes. En caso de no ser posible arribar a un acuerdo, las partes se someter&aacute;n voluntariamente a la competencia de los Tribunales Federales de la Capital Federal.</p>
		<p style="text-align: justify; ">
			En prueba de conformidad se firman dos ejemplares de una mismo tenor y a un s&oacute;lo efecto, en la Ciudad de Buenos Aires a los <?php echo  $dia; ?> d&iacute;as del mes de <?php echo  $mesret; ?> del <?php echo  $anio; ?>.</p>  <!--dos mil doce-->
	</body>
</html>