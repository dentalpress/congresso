<?php
// include_once('../../../../_assets/php/PHPMailer_v5.1/class.phpmailer.php');
include_once('../../../../../assets/php/PHPMailer_v5.1/class.phpmailer.php');

// padroniza
$post['origem']['origem'] = utf8_decode($post['origem']['origem']);
$post['origem']['nome'] = utf8_decode($post['origem']['nome']);
$post['nome'] = utf8_decode($post['nome']);
$post['phone'] = utf8_decode($post['phone']);
$post['email'] = utf8_decode($post['email']);
$post['msg'] = utf8_decode($post['msg']);

$body = '
    <html>
        <meta charset="utf-8" >
        <head>
            <style type="text/css">
                *{ margin:0; padding:0;}
            </style>
        </head>
        <body>

            <h4>Contato cursos: '.$post['origem']['nome'].' - '.$post['nome'].'</h4>

            <strong>Nome:</strong> '.$post['nome'].'<br>
            <strong>Telefone:</strong> '.$post['phone'].'<br>
            <strong>Email:</strong> '.$post['email'].'<br>
            <strong>Msg:</strong> '.$post['msg'].'<br>
            <br>
            <i style="color:#bebebe">Origem: '.$post['origem']['origem'].'</i><br>
        </body>
    </html>
';

$mail = new PHPMailer();

$mail->IsHTML(true);   
$mail->ContentType = "text/html";
$mail->SetLanguage("br");
//        $mail->SMTPSecure    = "ssl";
$mail->Host            = "smtp.dentalpress.com.br";
//$mail->Port            = 465;
$mail->CharSet        = "iso-8859-1";    

$mail->IsSMTP();                      
$mail->SMTPAuth = true;     
$mail->Username = 'site@dentalpress.com.br';
$mail->Password = 'site753';

$mail->IsSMTP();
$mail->SMTPAuth   = true; // enable SMTP authentication

$mail->From     = $mail->Username;
$mail->FromName = html_entity_decode( 'Contato: '.$post['origem']['nome'].' - '.$post['nome']);
$mail->Subject  = html_entity_decode( 'Contato: '.$post['origem']['nome'].' - '.$post['nome']);

$mail->AltBody    = $altBody; //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

$mail->AddReplyTo($post['email']);

$mail->AddAddress('dental@dentalpress.com.br');
$mail->AddAddress('congresso@dentalpress.com.br');
$mail->AddAddress('fernandoevangelista@dentalpress.com.br');

if(!$mail->Send()) {

    #adiciona como @return>mail>success igual a bolan(false), caso não enviado
    $return['mail']['success'] = false;

    $return['error']++;
}


else {

    $mail = new PHPMailer();

    // importa carta de resoista
    include_once('mail.contato.resposta.php');
    
    $mail->IsHTML(true);   
    $mail->ContentType = "text/html";
    $mail->SetLanguage("br");
    //        $mail->SMTPSecure    = "ssl";
    $mail->Host            = "smtp.dentalpress.com.br";
    //$mail->Port            = 465;
    $mail->CharSet        = "iso-8859-1";    
    
    $mail->IsSMTP();                      
    $mail->SMTPAuth = true;     
    $mail->Username = 'site@dentalpress.com.br';
    $mail->Password = 'site753';
    
    $mail->IsSMTP();
    $mail->SMTPAuth   = true; // enable SMTP authentication
    
    $mail->From     = $mail->Username;
    $mail->FromName = html_entity_decode( 'Contato: '.$post['origem']['nome'].' - '.$post['nome']);
    $mail->Subject  = html_entity_decode( 'Contato recebido');

    $mail->AltBody    = $altBody; //Text Body
    $mail->WordWrap   = 50; // set word wrap
    
    $mail->MsgHTML($body);
    
    $mail->AddReplyTo('congresso@dentalpress.com.br');

    $mail->AddAddress($post['email']);


    if(!$mail->Send()) {

        #adiciona como @return>mail>success igual a bolan(false), caso não enviado
        $return['mail']['success'] = false;

        $return['error']++;
    } 
    else {

        # adiciona @return>mail>success igual a bolean(true), caso tenha enviado com sucesso
        $return['mail']['success'] = true;
    }
}
?>
