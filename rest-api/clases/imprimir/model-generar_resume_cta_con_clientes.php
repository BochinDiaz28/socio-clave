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
								Cedula N° : <br/>'.$cuit.'
							</td>
						</tr>
					</table>';
				$html .= '<br>';
				
				$query = "SELECT SUM(debe) as debe, SUM(haber) as haber, idcliente
						  FROM cuentas_con_clientes
						  WHERE idcliente=$id GROUP BY idcliente";
				$resp = metodoGET($query);
				$valores = json_encode($resp);
				$valores = json_decode($valores, true);
				$debe = $valores[0]['debe'];
				$haber = $valores[0]['haber'];
				$saldo = $debe-$haber;
				if($mcobros==1){
					$html .= '<table width="100%" border="1">
					<tr>
						<td width="100%" align="center" colspan="5">
							<h5>Resumen de cuenta cobros contraentrega | Saldo: $'.$saldo.'</h5>
						</td>
					</tr>
					<tr>
						<td width="20%" align="center">
							Entrega a
						</td>
						<td width="20%" align="center">
							Nota
						</td>
						<td width="20%" align="center">
							Fecha
						</td>
						<td width="20%" align="center">
							Debe $
						</td>
						<td width="20%" align="center">
							Haber $
						</td>
					</tr>';

				}else{
				$html .= '<table width="100%" border="1">
							<tr>
								<td width="100%" align="center" colspan="4">
									<h5>Resumen de Cuenta | Saldo: $'.$saldo.'</h5>
								</td>
							</tr>
							<tr>
								<td width="40%" align="center">
									Entrega a
								</td>
								<td width="20%" align="center">
									Fecha
								</td>
								<td width="20%" align="center">
									Debe $
								</td>
								<td width="20%" align="center">
									Haber $
								</td>
							</tr>';
				}
				$nom_ent="";
				$calle="";
				$ciudad="";
				$query1 = "SELECT COUNT(*) as Cantidad FROM cuentas_con_clientes a, entregas b 
						   WHERE a.idcliente=$id 
						   AND a.idrecoleccion=b.idrecoleccion";
				$resp1 = metodoGET($query1);
				$valores1 = json_encode($resp1);
				$valores1 = json_decode($valores1, true);
				$contador1 = $valores1[0]['Cantidad'];
				
				$query = "SELECT a.nota, a.fecha, a.debe, a.haber,  b.nombre, b.calle, b.ciudad
						  FROM cuentas_con_clientes a, entregas b 
						  WHERE a.idcliente=$id
						  AND a.idrecoleccion=b.idrecoleccion";
				$resp = metodoGET($query);
				$valores = json_encode($resp);
				$valores = json_decode($valores, true);
			
					if($mcobros==1){
						$vlts=0;
						for ($i = 1; $i <= $contador1; $i++) {
						$html .= '
							<tr>
								<td width="20%" align="left">
									'.$valores[$vlts]['nombre'].' <br> '.$valores[$vlts]['calle'].', '.$valores[$vlts]['ciudad'].'
								</td>
								<td width="20%" align="center">
									'.$valores[$vlts]['nota'].'
								</td>
								<td width="20%" align="center">
									'.$valores[$vlts]['fecha'].'
								</td>
								<td width="20%" align="right">
									'.$valores[$vlts]['debe'].'<br/>
								</td>
								<td width="20%" align="right">
									'.$valores[$vlts]['haber'].'<br/>
								</td>
							</tr>';	
						$vlts +=1;
						}
					}else{
						$vlts=0;
						for ($i = 1; $i <= $contador1; $i++) {
						$html .= '
							<tr>
								<td width="40%" align="left">
								'.$valores[$vlts]['nombre'].' <br> '.$valores[0]['calle'].', '.$valores[0]['ciudad'].'
								</td>
								<td width="20%" align="center">
									'.$valores[$vlts]['fecha'].'
								</td>
								<td width="20%" align="right">
									'.$valores[$vlts]['debe'].'<br/>
								</td>
								<td width="20%" align="right">
									'.$valores[$vlts]['haber'].'<br/>
								</td>
							</tr>';	
						$vlts +=1;
						}
					}
				
				$html .= '</table>';

				$html .= '<br>';
				$html .= '<table width="100%" border="1">
							<tr>
								<td width="100%" align="center" colspan="5">
									<h5>Resumen de transferencias contraentrega</h5>
								</td>
							</tr>
							<tr>
								<td width="20%" align="center">
									Empresa
								</td>
								<td width="20%" align="center">
									Nota
								</td>
								<td width="20%" align="center">
									Fecha
								</td>
								<td width="20%" align="center">
									Debe $
								</td>
								<td width="20%" align="center">
									Haber $
								</td>
							</tr>';


					$query1 = "SELECT COUNT(*) as Cantidad FROM cuentas_con_clientes a
							   WHERE a.idcliente=$id 
							   AND a.idrecoleccion=0";
					$resp1 = metodoGET($query1);
					$valores1 = json_encode($resp1);
					$valores1 = json_decode($valores1, true);
					$contador1 = $valores1[0]['Cantidad'];
		 
					$query = "SELECT a.nota, a.fecha, a.debe, a.haber
							  FROM cuentas_con_clientes a
							  WHERE a.idcliente=$id
							  AND a.idrecoleccion=0";
					$resp = metodoGET($query);
					$valores = json_encode($resp);
					$valores = json_decode($valores, true);
	 
					if($mcobros==1){
						$vlts=0;
						for ($i = 1; $i <= $contador1; $i++) {
						$html .= '
							<tr>
								<td width="20%" align="left">
									Mr. Envio
								</td>
								<td width="20%" align="center">
									'.$valores[$vlts]['nota'].'
								</td>
								<td width="20%" align="center">
									'.$valores[$vlts]['fecha'].'
								</td>
								<td width="20%" align="right">
									'.$valores[$vlts]['debe'].'<br/>
								</td>
								<td width="20%" align="right">
									'.$valores[$vlts]['haber'].'<br/>
								</td>
							</tr>';	
						$vlts +=1;
						}
					}
					$html .= '</table>';
				return $html;
	}
}
?>


