<?php
// Inclua o autoloader do PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtendo o email do formulário
  $email = $_POST['email'];

  // Salvar o email em um arquivo .txt
  $file = 'emails.txt';
  file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX);

  // Configurando o PHPMailer
  $mail = new PHPMailer(true);
  try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp-relay.brevo.com';  // Servidor SMTP do Brevo
    $mail->SMTPAuth = true;
    $mail->Username = '7f9788001@smtp-brevo.com'; // Usuário SMTP fornecido pelo Brevo
    $mail->Password = 'GFyK63zxBJMhaHbO'; // Substitua por sua senha SMTP fornecida pelo Brevo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Usar STARTTLS
    $mail->Port = 587;  // Porta 587 para TLS, 465 para SSL

    // Configurações do email
    $mail->setFrom('investsmart.suporte.oficial@gmail.com', 'InvestSmart');  // Seu e-mail Brevo (ou e-mail verificado no Brevo)
    $mail->addAddress($email);  // Endereço do destinatário
    $mail->Subject = 'Obrigado por se inscrever na nossa Newsletter!';

    // Definindo a codificação do e-mail para UTF-8
    $mail->isHTML(true); // Habilita o envio de e-mail em HTML
    $mail->CharSet = 'UTF-8'; // Define a codificação de caracteres para UTF-8

    // Corpo do e-mail em HTML
    $mail->Body = '
      <html>
      <head>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  background-color: #f4f4f9;
                  color: #333;
                  padding: 20px;
              }
              .container {
                  max-width: 600px;
                  margin: 0 auto;
                  background-color: #ffffff;
                  border-radius: 10px;
                  padding: 20px;
                  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
              }
              .header {
                  text-align: center;
                  color: #4CAF50;
                  font-size: 24px;
                  margin-bottom: 20px;
              }
              .content {
                  font-size: 16px;
                  line-height: 1.5;
              }
              .footer {
                  text-align: center;
                  margin-top: 20px;
                  font-size: 14px;
                  color: #777;
              }
              .cta {
                  text-align: center;
                  margin-top: 30px;
              }
              .cta a {
                  background-color: #4CAF50;
                  color: #fff;
                  padding: 10px 20px;
                  text-decoration: none;
                  border-radius: 5px;
                  font-weight: bold;
              }
          </style>
      </head>
      <body>
          <div class="container">
              <div class="header">
                  <h1>Obrigado por se inscrever!</h1>
              </div>
              <div class="content">
                  <p>Olá, <strong>' . $email . '</strong>,</p>
                  <p>Estamos muito felizes por você ter se inscrito na nossa newsletter 🎉</p>
                  <p>Em breve, você receberá novidades, dicas e atualizações sobre finanças diretamente no seu e-mail.</p>
                  <p>Enquanto isso, aproveite para explorar nosso site e aprender mais sobre como gerenciar suas finanças de forma eficiente.</p>
              </div>
              <div class="footer">
                  <p>Se você tiver alguma dúvida, estamos à disposição! 😊</p>
                  <p><em>InvestSmart - Transformando seu futuro financeiro.</em></p>
              </div>
          </div>
      </body>
      </html>
    ';

    // Enviar o email
    if ($mail->send()) {
      echo json_encode(['status' => 'success', 'message' => 'Inscrição realizada com sucesso!']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Erro desconhecido ao enviar o e-mail.']);
    }
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo]);
  }
}
