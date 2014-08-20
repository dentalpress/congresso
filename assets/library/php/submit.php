<?php
    header('Content-Type: text/plain; charset=utf-8');

    ini_set('display_errors', 1);

    // $post['origem'] = 'http://192.168.10.106/cursos/excelencia/implantodontia/';
    // $post['curso']['nome'] = '8º Congresso Dental Press';
    // $post['Name'] = 'Fernando';
    // $post['Phone'] = '11 1111-1111';
    // $post['Email'] = 'webmaster@dentalpress.com.br';
    // $post['Msg'] = 'mensagem escrita';

    $post = $_POST;


    // processo o titulo para um html especial
    // $post['curso']['nome'] = htmlspecialchars($post['curso']['nome']);

    // include_once('../../../../_assets/php/PHPMailer_v5.1/class.phpmailer.php');

    // Valida a origem do post
    if ($post['origem'] != '') {
        include_once('../../../../_assets/php/PHPMailer_v5.1/class.phpmailer.php');
        // include_once('../../../../../assets/php/PHPMailer_v5.1/class.phpmailer.php');

        // padroniza
        $post['origem'] = utf8_decode($post['origem']);
        $post['curso']['nome'] = utf8_decode($post['curso']['nome']);
        $post['Name'] = utf8_decode($post['Name']);
        $post['Phone'] = utf8_decode($post['Phone']);
        $post['Email'] = utf8_decode($post['Email']);
        $post['Msg'] = utf8_decode($post['Msg']);

        $body = '
            <html>
                <meta charset="utf-8" >
                <head>
                    <style type="text/css">
                        *{ margin:0; padding:0;}
                    </style>
                </head>
                <body>

                    <h4>Contato cursos: '.$post['curso']['nome'].' - '.$post['Name'].'</h4>

                    <strong>Nome:</strong> '.$post['Name'].'<br>
                    <strong>Telefone:</strong> '.$post['Phone'].'<br>
                    <strong>Email:</strong> '.$post['Email'].'<br>
                    <strong>Msg:</strong> '.$post['Msg'].'<br>
                    <br>
                    <i style="color:#bebebe">Origem: '.$post['origem'].'</i><br>
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
        $mail->FromName = html_entity_decode( 'Contato: '.$post['curso']['nome'].' - '.$post['Name']);
        $mail->Subject  = html_entity_decode( 'Contato: '.$post['curso']['nome'].' - '.$post['Name']);

        $mail->AltBody    = $altBody; //Text Body
        $mail->WordWrap   = 50; // set word wrap
        
        $mail->MsgHTML($body);
        
        $mail->AddReplyTo($post['Email']);

        $mail->AddAddress('dental@dentalpress.com.br');
        $mail->AddAddress('congresso@dentalpress.com.br');
        $mail->AddAddress('fernandoevangelista@dentalpress.com.br');

        if(!$mail->Send()) {

            #não enviado
            $return = 'não enviado';
        } 
        else {

            # envia resposta ao usuario
            envia_resposta($post);
        }
    }

    // Funçnao para enviar resposta ao usuario
    function envia_resposta ($post) {

        include_once('../../../../_assets/php/PHPMailer_v5.1/class.phpmailer.php');;
        // include_once('../../../../../assets/php/PHPMailer_v5.1/class.phpmailer.php');

        $mail = new PHPMailer();

        // importa carta de resoista
        include_once('submit.resposta.php');
        
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
        $mail->FromName = html_entity_decode( 'Contato: '.$post['curso']['nome'].' - '.$post['Name']);
        $mail->Subject  = html_entity_decode( 'Contato recebido');

        $mail->AltBody    = $altBody; //Text Body
        $mail->WordWrap   = 50; // set word wrap
        
        $mail->MsgHTML($body);
        
        $mail->AddReplyTo('congresso@dentalpress.com.br');

        $mail->AddAddress($post['Email']);

        if(!$mail->Send()) {

            #não enviado
            $return = 'não enviado';
        } 
        else {

            #enviado
            $return = 'enviado';
        }

        //  retorna ao json
        echo $return;
    }
?>
