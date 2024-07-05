<?php
class Imprimir_Ficha{
	public function Imprimir_Ficha_($id){
		require_once 'clases/conexion/bd.php';
		/*
		$stmt_p = $this->connect()->query("SELECT * FROM proyecto WHERE id=1");
		$stmt_p->execute(); 
		while ($rowp = $stmt_p->fetch()) {
			$proyecto = $rowp['nombre'];
			$mcobros=$rowp['m_cobros'];
			$logo = $rowp['logo'];
			$link = $rowp['link'];
		}
		*/
		$mcobros=1;
		//DATOS DEL CLIENTE
		$query = "SELECT *
				  FROM demo_clientes
				  WHERE idcliente=$id";
		$resp = metodoGET($query);
		$valores = json_encode($resp);
		$valores = json_decode($valores, true);
		$idusuario = $valores[0]['idusuario_sys'];
		$cliente = $valores[0]['nombre_cliente'];
		$tel = $valores[0]['telefono_cliente'];
		$cel = $valores[0]['celular'];
		$email = $valores[0]['email_cliente'];
		$cuit = $valores[0]['cuit_cliente'];
		$otros = $valores[0]['otrosdatos_cliente'];
		$codigo = $valores[0]['codigo'];

		$link_ver='http://test.mrenvio.com.mx/assets/images/logo-mr-envio.png';
		$html = '<table width="100%">
					<tr>
						<td width="30%" align="left">
							<img src="'.$link_ver.'" style="width:30%;">
						</td>
						<td align="center"><h1>Ficha: '.$codigo.'</h1></td>
					</tr>
				</table>';	
		
			$html .= '<table width="100%" border="1">
						<tr>
							<td width="100%" align="center" colspan="3">
								<h5>Datos de Cliente</h5>
							</td>
						</tr>
						<tr>
							<td width="30%" align="left">
								Nombre Cliente: <br/>'.$cliente.'
							</td>
							<td width="30%" align="left">
								Telefono: <br/>'.$tel.'<br/>
								Celular: <br/>'.$cel.'
							</td>
							<td width="30%" align="left">
								E-Mail: <br/>'.$email.'<br/>
								RUT: <br/>'.$cuit.'
							</td>
						</tr>
						<tr>
							<td width="100%" align="left" colspan="3">
								Otros Datos: <br/>'.$otros.'
							</td>
						</tr>
					</table>';
				$html .= '<br>';
				$html .= '<table width="100%" border="1">
							<tr>
								<td width="100%" align="center" colspan="2">
									<h5>Direcciones</h5>
								</td>
							</tr>';

				$query1 = "SELECT COUNT(*) AS Cantidad FROM clientes_direccion WHERE idcliente=$idusuario";
				$resp1 = metodoGET($query1);
				$valores1 = json_encode($resp1);
				$valores1 = json_decode($valores1, true);
				$contador1 = $valores1[0]['Cantidad'];
				$query2 = "SELECT *
						  FROM clientes_direccion
				          WHERE idcliente=$idusuario";
				$resp2 = metodoGET($query2);
				$valores2 = json_encode($resp2);
				$valores2 = json_decode($valores2, true);
				if($contador1>0){
					$vlts=0;
					for ($i = 1; $i <= $contador1; $i++) {
						$html .= '<tr>
									<td width="100%" align="left" colspan="2">
										'.$valores2[$vlts]['direccion'].'
									</td>
								</tr>
								<tr>
									<td width="50%" align="left">
										Latitud: <br/>'.$valores2[$vlts]['lat'].'
									</td>
									<td width="50%" align="left">
										Longitud: <br/>'.$valores2[$vlts]['lon'].'<br/>
									</td>
								</tr>';	
								$vlts +=1;
					}
				}else{
					$html .= '<tr>
								<td width="100%" align="left" colspan="2">
									Dirección no registrada
								</td>
							</tr>
							<tr>
								<td width="50%" align="left">
									Latitud:
								</td>
								<td width="50%" align="left">
									Longitud:
								</td>
							</tr>';	
				}
				$html .= '</table>';

				if($mcobros==1){
					$html .= '<br>';
					$html .= '<table width="100%" border="1">
								<tr>
									<td width="100%" align="center" colspan="4">
										<h5>Datos Bancarios</h5>
									</td>
								</tr>';
								//DATOS BANCARIOS DEL CLIENTE 
								$query3 = "SELECT COUNT(*) AS Cantidad FROM demo_bancos_clientes WHERE idcliente=$id";
								$resp3 = metodoGET($query3);
								$valores3 = json_encode($resp3);
								$valores3 = json_decode($valores3, true);
								$contador3 = $valores3[0]['Cantidad'];
								$query4 = "SELECT *
										  FROM demo_bancos_clientes
										  WHERE idcliente=$id";
								$resp4 = metodoGET($query4);
								$valores4 = json_encode($resp4);
								$valores4 = json_decode($valores4, true);
								if($contador3>0){
									$vlts=0;
									for ($i = 1; $i <= $contador3; $i++) {
										$html .= '<tr>
												<td width="50%" align="center" colspan="2">
													'.$valores4[$vlts]['titular'].'
												</td>
												<td width="50%" align="center" colspan="2">
													'.$valores4[$vlts]['banco'].'
												</td>
											</tr>
											<tr>
												<td width="20%" align="left">
													Tipo de Cta: <br/>'.$valores4[$vlts]['tipo'].'
												</td>
												<td width="20%" align="left">
													Cuenta: <br/>'.$valores4[$vlts]['cuenta'].'<br/>
												</td>
												<td width="35%" align="left">
													CBU: <br/>'.$valores4[$vlts]['cbu'].'
												</td>
												<td width="25%" align="left">
													Cedula: <br/>'.$valores4[$vlts]['cuit'].'<br/>
												</td>
											</tr>';	
											$vlts +=1;
									}
								}else{
									$html .= '
											<tr>
												<td width="50%" align="center" colspan="2">
													No Registrado
												</td>
												<td width="50%" align="center" colspan="2">
													No Registrado
												</td>
											</tr>
											<tr>
												<td width="20%" align="left">
													Tipo de Cta:
												</td>
												<td width="20%" align="left">
													Cuenta: 
												</td>
												<td width="35%" align="left">
													CBU: 
												</td>
												<td width="25%" align="left">
													Cedula: 
												</td>
											</tr>';	
								}
									$html .= '</table>';
				}
				return $html;
	}
}
?>


