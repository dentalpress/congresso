<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Inclui funções e regras pre-determinadas
#

# inclui classe de conexão ao banco de dados
include 'sql.connect.php';

# inclui funções de tratamento e manipulação para conexão do banco de dados
include 'sql.selector.php';

#
# Fim de "Inclui funções e regras pre-determinadas"
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


    # define que _POST deve ficar em @post
    $post = $_POST;

    # define em @return>success como verdadeiro
    $return['success'] = true;

    # define que @return>error está em 0
    $return['error'] = 0;


    # # # #
    # # Inicia validação do _POST
    # valida se existe @post>origem, com as informações básicas da origem do post
    if (array_key_exists('origem', $post)) {

        # valida se em @post>origem existe o campo 'origem', caso não adiciona erro em @return
        if (!array_key_exists('origem', $post['origem'])) {

            # adiciona +1 em @return>error
            $return['error']++;
        }

        # valida se em @post>origem existe o campo 'nome', caso não adiciona erro em @return
        if (!array_key_exists('nome', $post['origem'])) {

            # adiciona +1 em @return>error
            $return['error']++;
        }

        # valida se em @post>origem existe o campo 'tipo', caso não adiciona erro em @return
        if (!array_key_exists('tipo', $post['origem'])) {

            # adiciona +1 em @return>error
            $return['error']++;
        }

        # finaliza validação contando os erros, caso maior que 0 acrenta false em @return>success
        if ($return['error'] > 0) {

            # acrenta bolean false em @return>success
            $return['success'] = false;
        }
    }
    # # Fim de validação do _POST
    # # # #

    # # # #
    # # # inicia as funções caso @return>success seja valido
    if ($return['success']) {

        # # # 
        # Inicia tratamento dos valores de @post

        # caso os dados tenha sua origem em 'trabalho'
        if ($post['origem']['tipo'] == 'trabalho') {

            # reposiciona valores de @post>contato para raiz da array
            $post['nome'] = $post['contato']['nome'];
            $post['email'] = $post['contato']['email'];

            # remove @post>contato
            unset($post['contato']);

            # # # 
            # # Inicia submição dos dados ao servidor

            # # verifica se o trabalho já foi submetido

            # adiciona em @temp>trata as configurações da solicitação ao banco
            $temp['trata']['regra']['where'] = 'LIKE';
            $temp['trata']['regra']['limit'] = '1';
            $temp['trata']['regra']['order']['to'] = 'index';
            $temp['trata']['regra']['order']['by'] = 'ASC';

            # adiciona em @temp>trata os valores de consulta, sendo do segmento trabalho com os valores 'titulo' em `grupo` e 'autor' em `type`
            $temp['trata']['select']['segmento'] = 'trabalho';
            $temp['trata']['select']['grupo'] = $post['trabalho']['titulo'];
            $temp['trata']['select']['type'] = $post['trabalho']['autor'];

            # adiciona em @temp>connect>regra os valores de seleção tratados
            $temp['connect']['regra'] = f_json_where($temp['trata']);

            # adicoina em @temp>connect>tabela a tabela para seleção
            $temp['connect']['tabela'] = '`htmlGetSQL.congresso`'; 

            # adiciona em @temp>connect>campos o campo a ser retornado pela solicitação
            $temp['connect']['campos'] = array('' => '`values`');

            # adiciona em @temp>connect>select o resultado do banco
            $temp['connect']['select'] = select($temp['connect']['tabela'], $temp['connect']['campos'], $temp['connect']['regra']);


            # #
            # valida a seleção
            # #

            # caso já exista o item no banco, retornado em @temp>connect>select
            if ($temp['connect']['select'] != 'Empty') {

                # adiciona +1 em @return>error
                $return['error']++;

                # define @return>save>success com bolean(false)
                $return['save']['success'] = false;

                # adiciona em @return>save>reurn os detalhes do erros
                $return['save']['result'] = 'Não foi possivel salvar, já existe um trabalho com esse título e autor.';
            }

            # caso não exista ainda este trabalho no banco, retornado em @temp>connect>select
            if ($temp['connect']['select'] == 'Empty') {

                # # #
                # inicia seleção do banco para contagem de itens

                # #
                # redefine alguns parametros

                # define ordem do final para o começo
                $temp['trata']['regra']['order']['by'] = 'DESC';

                # redefine @temp>trata>select com apenas o valor de "segmento" apentando para "trabalho"
                $temp['trata']['select'] = array('segmento' => 'trabalho');
                # #

                # adiciona em @temp>connect>regra os valores de seleção tratados
                $temp['connect']['regra'] = f_json_where($temp['trata']);

                # adiciona em @temp>connect>campos o campo a ser retornado pela solicitação
                $temp['connect']['campos'] = array('' => '`index`');

                # adiciona em @temp>connect>select o resultado do banco
                $temp['connect']['select'] = select($temp['connect']['tabela'], $temp['connect']['campos'], $temp['connect']['regra']);

                # valida se existe algum trabalho no banco retornado em @temp>connect>select
                if ($temp['connect']['select'] != 'Empty') {

                    # adiciona em @temp>values>htmlGetSQL.setings>htmlGetSQL.selectors>select>index o resultado em $temp>connect>select>index +1
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['index'] = $temp['connect']['select']['index']+1;
                }

                # valida não existe nem um trabalho no banco retornado em @temp>connect>select
                if ($temp['connect']['select'] == 'Empty') {

                    # adiciona em @temp>values>htmlGetSQL.setings>htmlGetSQL.selectors>select>index o valor "1"
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['index'] = "1";
                }

                # inicia seleção do banco para contagem de itens
                # # #


                # # # #
                # # Trata os valores para a insersão no banco

                # adiciona em @temp>values>trabalho os valores do trabalho
                $temp['values']['trabalho'] = $post['trabalho'];

                # adiciona em @temp>values>contato as informações do contato
                $temp['values']['contato']['nome'] = $post['nome'];
                $temp['values']['contato']['email'] = $post['email'];

                # adiciona as informações da origem
                $temp['values']['origem'] = $post['origem']['origem'];
                $temp['values']['origem'] = $post['origem']['origem'];

                # configura htmlGetSQL>setings>selectors para table
                $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['table'] = 'htmlGetSQL.congresso';

                # # #
                # configura htmlGetSQL>setings>selectors para select, redefinindo outros valores
                $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['segmento'] = 'trabalho';
                $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['grupo'] = $post['trabalho']['titulo'];
                $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['type'] = $post['trabalho']['autor'];

                # acrecenta em @temp>new>history>montagem>date a string '0000-00-00 00:00:00'
                $temp['new']['montagem']['date'] = date('Y-m-d').' '.date('h:i:s');

                #adiciona data em values
                $temp['values']['data de submissao'] = $temp['new']['montagem']['date'];

                # acrecenta em @temp>new>history>montagem>md5 o valor do md5 dade + sku do select + o sku do registro
                $temp['new']['montagem']['md5'] = md5(
                    $temp['new']['montagem']['date'].
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['table'].
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['index'].
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['segmento'].
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['grupo'].
                    $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['type']
                );

                # acrecenta montagem de sku em htmlGetSQL.setings
                $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['sku'] = substr($temp['new']['montagem']['md5'], 0, 5) . substr($temp['new']['montagem']['md5'], -5);;

                # monta tabela para @temp>insert
                $temp['insert']['table'] = $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['table'];

                # monta dados para @temp>insert
                $temp['insert']['dados']['index'] = $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['index'];
                $temp['insert']['dados']['segmento'] = $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['segmento'];
                $temp['insert']['dados']['grupo'] = $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['grupo'];
                $temp['insert']['dados']['type'] = $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['type'];
                $temp['insert']['dados']['values'] = json_encode($temp['values'], true);
                $temp['insert']['dados']['sku'] = $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['sku'];

                # # Trata os valores para a insersão no banco
                # # # #


                # #
                # Envia ao banco os dados tratados

                # envia para a função insert()
                insert($temp['insert']['table'], $temp['insert']['dados']);

                # Envia ao banco os dados tratados
                # #

                # # # #

                # # # #
                # valida se foi adicionado o trabalho

                # adiciona em @temp>trata as configurações da solicitação ao banco
                $temp['trata']['regra']['order']['by'] = 'ASC';

                # redefine em @temp>trata>select um array para "sku" apontando pra o valor @temp>values>htmlGetSQL.setings>htmlGetSQL.selectors>select>sku montado antes da insersão
                $temp['trata']['select'] = array( "sku" => $temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['sku']);

                # adiciona em @temp>connect>regra os valores de seleção tratados
                $temp['valida']['connect']['regra'] = f_json_where($temp['trata']);

                # adicoina em @temp>connect>tabela a tabela para seleção
                $temp['valida']['connect']['tabela'] = '`htmlGetSQL.congresso`'; 

                # adiciona em @temp>connect>campos o campo a ser retornado pela solicitação
                $temp['valida']['connect']['campos'] = array('' => '`values`');

                # adiciona em @temp>connect>select o resultado do banco
                $temp['valida']['connect']['select'] = select($temp['valida']['connect']['tabela'], $temp['valida']['connect']['campos'], $temp['valida']['connect']['regra']);

                # caso não tenha encontrado a inseção retorna erro
                if ($temp['valida']['connect']['select'] == 'Empty') {

                    # adiciona +1 em @return>error
                    $return['error']++;
                    $return['save']['success'] = false;
                    $return['save']['result'] = 'Não foi possivel inserir no banco';
                }

                # caso o código não tenha recebido nada adiciona em @return erro
                if ($temp['valida']['connect']['select'] != 'Empty') {

                    # adiciona informações do status do processo
                    $return['save']['success'] = true;
                    $return['save']['result'] = 'Trabalho salvo no banco de dados - SKU='.$temp['values']['htmlGetSQL.setings']['htmlGetSQL.selectors']['select']['sku'];
                }
                # valida se foi adicionado o trabalho
                # # # #
            }

            # # Fim de submição dos dados ao servidor
            # # # 


            # # # 
            # # Inicia envio de emails de resposta

            include 'mail.trabalho.php';

            # # Inicia envio de emails de resposta
            # # #
        }
        
        # caso os dados tenham sua origem em 'contato'
        if ($post['origem']['tipo'] == 'contato') {

            # # # 
            # # Inicia envio de emails de resposta

            include 'mail.contato.php';

            # # Inicia envio de emails de resposta
            # # #
        }

        # Inicia tratamento dos valores de @post
        # # # 


        # #
        # finaliza validação, verificando se hove algum erro
        if ($return['error'] > 0) {

            # adiciona em @return>success o valor bolan(false)
            $return['success'] = false;
        }
        # #

        if ($return['success'] == true) {

            # retorna a solicitação ao formulário, em forma de json
            // echo '[{"success":true}]';
            echo '['.json_encode($return).']';
        }

        if ($return['success'] == false) {

            # retorna a solicitação ao formulário, em forma de json
            // echo '[{"success":false}]';
            echo '['.json_encode($return).']';
        }
    }
    # # # inicia as funções caso @return>success seja valido
    # # # #


?>
