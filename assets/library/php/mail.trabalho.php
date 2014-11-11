<?php


// include_once('../../../../_assets/php/PHPMailer_v5.1/class.phpmailer.php');
include_once('../../../../../assets/php/PHPMailer_v5.1/class.phpmailer.php');


$post['nome'] = utf8_decode($post['nome']);
$post['email'] = utf8_decode($post['email']);
$post['trabalho']['tipo'] = utf8_decode($post['trabalho']['tipo']);
$post['trabalho']['titulo'] = utf8_decode($post['trabalho']['titulo']);
$post['trabalho']['autor'] = utf8_decode($post['trabalho']['autor']);
$post['trabalho']['co-autor'] = utf8_decode($post['trabalho']['co-autor']);
$post['trabalho']['instituicao'] = utf8_decode($post['trabalho']['instituicao']);
$post['trabalho']['resumo'] = utf8_decode($post['trabalho']['resumo']);
$post['trabalho']['palavras-chave'] = utf8_decode($post['trabalho']['palavras-chave']);
$post['origem']['origem'] = utf8_decode($post['origem']['origem']);
$post['origem']['nome'] = utf8_decode($post['origem']['nome']);


$body = '
    <html>
        <meta charset="utf-8" >
        <head>
            <style type="text/css">
                *{ margin:0; padding:0;}
            </style>
        </head>
        <body>

            <h4>Trabalho: '.$post['origem']['nome'].' - '.$post['nome'].'</h4>
            <br>
            <strong>Nome:</strong> '.$post['nome'].'<br>
            <strong>Email:</strong> '.$post['email'].'<br>
            <br>
            <strong>Tipo:</strong> '.$post['trabalho']['tipo'].'<br>
            <strong>Título:</strong> '.$post['trabalho']['titulo'].'<br>
            <strong>Autor:</strong> '.$post['trabalho']['autor'].'<br>
            <strong>Co-Autor:</strong> '.$post['trabalho']['co-autor'].'<br>
            <strong>Instituição:</strong> '.$post['trabalho']['instituicao'].'<br>
            <strong>Resumo:</strong> '.$post['trabalho']['resumo'].'<br>
            <strong>Palavra-chave:</strong> '.$post['trabalho']['palavras-chave'].'<br>
            <br>
            <i style="color:#bebebe">Origem: '.$post['origem']['origem'].'</i><br>
            <i style="color:#bebebe">Status: '.$return['save']['result'].'</i><br>
            <i style="color:#bebebe">jeva a lista de trabalhos em <a href="http://www.dentalpress.com.br/congresso/trabalhos.html">dentalpress.com.br/congresso/trabalhos.html</a></i><br>
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
$mail->FromName = html_entity_decode( 'Mostra Científica: '.$post['origem']['nome'].' - '.$post['nome']);
$mail->Subject  = html_entity_decode( 'Mostra Científica: '.$post['trabalho']['titulo'].' - '.$post['nome']);

$mail->AltBody    = $altBody; //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

$mail->AddReplyTo($post['email']);

$mail->AddAddress('fernandoevangelista@dentalpress.com.br');
$mail->AddAddress('congresso@dentalpress.com.br');
$mail->AddAddress('dental@dentalpress.com.br');
// $mail->AddAddress('brunofurquim@dentalpress.com.br');
// $mail->AddAddress('rachelfurquim@dentalpress.com.br');

# caso o email não tenha sido enviado
if(!$mail->Send()) {

    #adiciona como @return>mail>success igual a bolan(false), caso não enviado
    $return['mail']['success'] = false;

    $return['error']++;
} 

# caso o email tenha sido enviado
else {

    # adiciona @return>mail>success igual a bolean(true), caso tenha enviado com sucesso
    $return['mail']['success'] = true;
}




?>