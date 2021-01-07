<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	include_once("phpmailer/src/Exception.php");
	include_once("phpmailer/src/PHPMailer.php");
	include_once("phpmailer/src/SMTP.php");

	$nome = $_POST['name'];
	$email = $_POST['email'];
	$mensagem = $_POST['message'];

	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set('America/Sao_Paulo');
	$data = date('d-m-Y H:i:s');

	$corpo = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td style="padding: 20px 0 30px 0;">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
							<!--logotipo-->
							<tr style="">
								<td align="center" style="padding: 15px 0px;">
									<img src="http://www.superteia.com.br/images/logo.png" alt="logotipo" style="display: block; width: 200px; height: auto;" />
								</td>
							</tr>
						</table>
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 2px solid #333333">
							<!--conteudo-->
							<tr>
								<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;" >
									<table border="0" cellpadding="0" cellspacing="0" width="100%" >
										<!--assunto-->
										<tr>
											<td colspan="2" style="color: #3B3B3B; font-family: Arial, sans-serif; font-size: 24px; text-align:center">
												<b>Novo Contato de '.$nome.' - Tray - Superteia</b>
											</td>
										</tr>
										<!--Mensagem corpo-->
										<tr>
											<td style="padding: 20px 0 30px 0; color: #3B3B3B; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;border-bottom: 1px solid #3B3B3B;" colspan="3">
												<!--b>Mensagem</b-->
												<p><b>Mensagem:</b> '.$mensagem.'</p>
												<br /><b>De: </b>'.$nome.'
											</td>
										</tr>
										<!--Informações Gerais-->
										<!--table border="0" cellpadding="0" cellspacing="0" width="100%">		</table-->
										 <tr>
											<td width="300" valign="top" style="color: #3B3B3B; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding-top: 30px;">
												<b>Email: </b><p>'.$email.'</p>
											</td>
										 </tr>
									</table>
								</td>
							</tr>
							<!--rodapé-->
							<tr>
								<td bgcolor="#333333" style="padding: 30px 30px 30px 30px;border: 2px solid #CCC;border-top: 0;">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td style="color: #ffffff; font-family: Arial, sans-serif;">
												<small><b>Horário do servidor:</b> <span style="color:#76baff">'. date('d/m/Y H:i:s') .' </span><b>- IP: </b><span style="color:#76baff">'.$ip.'</span></small>
											</td>
										</tr>
										<tr>
											<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
											<b>Superteia</b> <small>&reg;</small> '.date('Y').' | Todos os direitos reservados. <br/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>';

			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->CharSet = 'UTF-8';

			//Server settings
			$mail->SMTPDebug = 1;                                        // Enable verbose debug output
			$mail->SMTPAuth = 'true';                      // Enable SMTP authentication
			$mail->SMTPSecure = 'ssl';
			$mail->Port = '465';                               // TCP port to connect to
			$mail->SMTPAutoTLS = false;

			// $mail->Host = 'smtp.scimagem.com.br';    // Specify main and backup SMTP servers
			// $mail->Username = 'teste@scimagem.com.br';                     // SMTP username
			// $mail->Password = 'alterar123';                    // SMTP password

			$mail->Host = 'smtp.gmail.com';    				// Specify main and backup SMTP servers
			$mail->Username = 'no-reply@superteia.com.br';      // SMTP username
			$mail->Password = 'no.adm.98';                // SMTP password

			//Recipients
			//$mail->setFrom($email, $nome);
			$mail->setFrom('no-reply@superteia.com.br', 'Novo Contato');

			$mail->AddAddress('atendimento@superteia.com.br', 'Contato Via Site');

			// Define a mensagem (Texto e Assunto)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->Subject  = 'Contato por Formulário da Tray'; // Assunto da mensagem
			$mail->Body = $corpo;

			try
			{
				if (!$mail->Send())
				{
					$retorno['msg'] = 0;
					$retorno['erro'] = "Seu e-mail não pode ser enviado no momento. Erro: " . $mail->ErrorInfo;
				}
				else
				{
					$retorno['msg'] = 1;
					$retorno['erro'] = "E-mail enviado com Sucesso!";
				}

				// Limpa os destinatários e os anexos
				$mail->ClearAllRecipients();

				echo json_encode($retorno);
			}
			catch(Exception $e)
			{
				$retorno['msg'] = 0;
				$retorno['erro'] = "Seu e-mail não pode ser enviado. Erro: " . $mail->ErrorInfo;
			}

			?>
