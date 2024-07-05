<?php
class Imprimir_Comprobante{
	public function Imprimir_Comprobante_($retornoID){ 
		require_once 'clases/conexion/bd.php';
		
		function Generar_QR($generaQR){
			include('phpqrcode/qrlib.php'); 
			$codesDir = "clases/imprimir/codes/";   
			$codeFile = $generaQR.'.png';
			$DestinoQR="https://www.fde.sistema-online.cl/guia=".$generaQR."";
			QRcode::png($DestinoQR,$codesDir.$codeFile, 'M', '10'); 
			return $codesDir.$codeFile;
		}
		
		//$logo ='../assets/images/logo-mr-envio.png';
		//DESDE ACA PARA ABAJO EL ORIGINAL
		$query = "SELECT idcliente,calle,ciudad,latitud,longitud,fecha_r,referencia,notas
				  FROM recoleccion
				  WHERE id=$retornoID";
		$resp      = metodoGET($query);
		$valores   = json_encode($resp);
		$valores   = json_decode($valores, true);
		$idcliente = $valores[0]['idcliente'];
		$calle     = $valores[0]['calle'];
		$ciudad    = $valores[0]['ciudad'];
		$lat       = $valores[0]['latitud'];
		$lon       = $valores[0]['longitud'];
		$fecha_r   = $valores[0]['fecha_r'];
		$ref       = $valores[0]['referencia'];
		$notas     = $valores[0]['notas'];

		$newDate_r = date("d-m-Y", strtotime($fecha_r));
		$fecha_r   = str_replace("-", "/", $newDate_r);

		$query2 = "SELECT codigo,nombre_cliente,telefono_cliente,celular,email_cliente,otrosdatos_cliente
				   FROM demo_clientes
				   WHERE idcliente=$idcliente";
		$resp2    = metodoGET($query2);
		$valores2 = json_encode($resp2);
		$valores2 = json_decode($valores2, true);
		$codigo   = $valores2[0]['codigo'];
		$cliente  = $valores2[0]['nombre_cliente'];
		$tel      = $valores2[0]['telefono_cliente'];
		$cel      = $valores2[0]['celular'];
		$email    = $valores2[0]['email_cliente'];
		$otrosC   = $valores2[0]['otrosdatos_cliente'];
		

		$query3 = "SELECT nombre,calle,ciudad,latitud,longitud,email,telefono,fecha_r,cobros,notas
				   FROM entregas
				   WHERE idrecoleccion=$retornoID";
		$resp3    = metodoGET($query3);
		$valores3 = json_encode($resp3);
		$valores3 = json_decode($valores3, true);
		$nombre_d = $valores3[0]['nombre'];
		$calle_d  = $valores3[0]['calle'];
		$ciudad_d = $valores3[0]['ciudad'];
		$lat_d    = $valores3[0]['latitud'];
		$lon_d    = $valores3[0]['longitud'];
		$email_d  = $valores3[0]['email'];
		$tel_d    = $valores3[0]['telefono'];
		$fecha_e  = $valores3[0]['fecha_r'];
		$cobros   = $valores3[0]['cobros'];
		$otrosE   = $valores3[0]['notas'];

		$newDate = date("d-m-Y", strtotime($fecha_e));
		$fecha_e = str_replace("-", "/", $newDate);

		$link="";
		$link_ver='http://www.fde.sistema-online.cl/public/img/logo_bienvenida.png';
		$generaQR=$ref.'-'.$retornoID;
		$QR = Generar_QR($generaQR);

			$html = '<table width="100%">
						<tr>
							<td width="50%" align="left">
								<img src="'.$link_ver.'" style="width:30%;">
							</td>
							<td width="50%" align="center">
								<img src="'.$QR.'" style="width:30%;">
							</td>
						</tr>
					</table>';
			
			$html .= '<table width="100%" border="0" >
						<tr>
							<td width="30%" align="left">
								Codigo de Rastreo
							</td>
							<td align="left"><h3>'.$ref.'-'.$retornoID.'</h3></td>
							<td align="center" rowspan="2" colspan="2"><h1>'.$codigo.'<h1></td>
						</tr>
						<tr>
							<td width="30%" align="left">
								Fecha de Recolección
							</td>
							<td align="left">'.$fecha_r.'</td>
						</tr>
					  </table><br>';
			
			$html .= '<table width="100%" border="1" style="border-collapse: collapse;">
						<tr>
							<th width="100%" align="center" colspan="3"><b>Origen</b></th>
						</tr>
						<tr>
							<th width="30%" align="left">REMITENTE</th>
							<th width="30%" align="left">CONTACTO</th>
							<th width="30%" align="left">E-MAIL</th>
						</tr>
					
						<tr>
							<td width="30%" align="left">
							<b> '.$cliente.' </b>
							</td>
							<td width="30%" align="left">
								'.$tel.'
								<br/>
								'.$cel.'
							</td>
							<td width="30%" align="left">
								'.$email.'
							</td>
						</tr>
					
						<tr>
							<td width="60%" align="left" colspan="2">
							<b> '.$calle.' </b>
							</td>
						
							<td width="60%" align="left">
								Latitud :'.$lat.'<br/>
								Longitud:'.$lon.'
							</td>
						</tr>
						<tr>
							<td width="100%" align="left" colspan="3">
							<b> '.$notas.' </b>
							</td>
						</tr>
					</table>';
			
			$html .= '<table width="100%" border="1" style="border-collapse: collapse;">
						<tr>
							<th width="100%" align="center" colspan="3"><b>Origen</b></th>
						</tr>
						<tr>
							<th width="30%" align="left">DESTINATARIO</th>
							<th width="30%" align="left">CONTACTO</th>
							<th width="30%" align="left">E-MAIL</th>
						</tr>
					
						<tr>
							<td width="30%" align="left">
							<b> '.$nombre_d.' </b>
							</td>
							<td width="30%" align="left">
								'.$tel_d.'
							</td>
							<td width="30%" align="left">
								'.$email_d.'
							</td>
						</tr>
					
						<tr>
							<td width="60%" align="left" colspan="2">
							<b> '.$calle_d.' </b>
							</td>
						
							<td width="60%" align="left">
								Latitud :'.$lat_d.'<br/>
								Longitud:'.$lon_d.'
							</td>
						</tr>
						<tr>
							<td width="100%" align="left" colspan="3">
							<b> '.$otrosE.' </b>
							</td>
						</tr>
					</table>';
					if($cobros>0){
						$html .= '<table width="100%" border="1" style="border-collapse: collapse;">
									<tr>
										<td width="100%" align="center">
											Cobrar
											<h1> $'.$cobros.'<h1>
										</td>
									</tr>
									<tr>
										<td width="100%" align="center">
											Fecha de Entrega
											<h4>'.$fecha_e.'</h4>
										</td>
									</tr>
								  </table>';
					}else{
						$html .= '<table width="100%" border="1" style="border-collapse: collapse;">
									<tr>
										<td width="100%" align="center">
											Fecha de Entrega
											<h4>'.$fecha_e.'</h4>
										</td>
									</tr>
								  </table>';
					}

		return $html;				
	}
}
?>
