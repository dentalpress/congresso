<?php

    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
    # Inclui funções e regras pre-determinadas
    #

    # inclui funções de tratamento e manipulação para conexão do banco de dados
    include 'phpSelectSQL.php';

    #
    # Fim de "Inclui funções e regras pre-determinadas"
    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # 


    # abre o arquivo e transforma em array
    $post = json_decode(file_get_contents("inscritos.json"), true);


    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores recebidos
    $return['backup'] = $post;

    # # # # # # # # 

    # adiciona em @return>result>length o valor 0
    $return['result']['new']['length'] = 0;

    # adiciona em @return>remove>length o valor 0
    $return['result']['remove']['length'] = 0;

    # adiciona em @return>update>length o valor 0
    $return['result']['update']['length'] = 0;

    # # configura os valores de retorno
    # # # # #


    # caso @post nao seja uma array
    if (!is_array($post)) {

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Houve algum probelma com a converão do arquivo, talvez a syntax do json esteja errada';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;
    }

    # caso @post seja array
    if (is_array($post)) {
        
        # # # 
        # valida os campos de vindos de @post para  inscritos

        # caso exista o campo login em @post
        if (array_key_exists('inscritos', $post)) {

            # valida se existe algum item em @post>inscritos
            if (is_array($post['inscritos'])) {

                # valida se os inscritos iniciam em 0
                if (array_key_exists('0', $post['inscritos'])) {

                    # adiciona em @post>inscritos>length o valor da função de count() para @post>inscritos
                    $post['inscritos']['length'] = count($post['inscritos']);


                    # # # #
                    # # inicia compilação dos valores de post

                    # inicia loop para tratamento de cada valor
                    for ($i=0; $i < $post['inscritos']['length']; $i++) { 


                        # caso exista o campo codigo em @post>inscritos>@~i
                        if (array_key_exists('codigo', $post['inscritos'][$i])) {

                            # caso exista o campo "nome" em @post>inscritos>@~i
                            if (array_key_exists('nome', $post['inscritos'][$i])) {

                                # caso exista o campo "endereco" em @post>inscritos>@~i
                                if (array_key_exists('endereco', $post['inscritos'][$i])) {

                                    # caso exista o campo "data" em @post>inscritos>@~i
                                    if (array_key_exists('data', $post['inscritos'][$i])) {

                                        # # #
                                        # # Inicia insersão no banco de dados
 
                                        # configurações de capturação de dados do banco, para validar se já existe no banco
                                        $temp['autenticacao']['select']['regra']['limit'] = '1';
                                        $temp['autenticacao']['select']['regra']['order']['to'] = 'index';
                                        $temp['autenticacao']['select']['regra']['order']['by'] = 'DESC';
                                        $temp['autenticacao']['select']['table'] = 'htmlGetSQL.congresso';
                                        $temp['autenticacao']['select']['where']['segmento'] = 'congressista';
                                        $temp['autenticacao']['select']['where']['type'] = $post['inscritos'][$i]['codigo'];
                                        $temp['autenticacao']['select']['return'] = 'values';
                                        $temp['autenticacao']['select']['change'] = select($temp['autenticacao']['select'], false);
                                        # configurações de capturação de dados do banco, para validar se já existe no banco
                                        # #

                                        # valida se não houve nem um erro no processo de verificação
                                        if ($temp['autenticacao']['select']['change']['error']['length'] == 0) {

                                            # valida se foi recebido algum item na consulta
                                            if ($temp['autenticacao']['select']['change']['result']['length'] > 0 ) {


                                                # valida se @post>inscritos>@~i possui algum comando
                                                if (array_key_exists('action', $post['inscritos'][$i])) {

                                                    # caso a acão seja para excluir o campo
                                                    if ($post['inscritos'][$i]['action'] == 'excluir') {

                                                        # # #
                                                        # trata os parametros para a remoção so item no banco
                                                        $temp['delete']['change'] = delete($temp['autenticacao']['select'], false);
                                                        # trata os parametros para a remoção so item no banco
                                                        # # #

                                                        # valida se não houve nem um problema com a exclusão
                                                        if ($temp['delete']['change']['error']['length'] == 0) {

                                                            # declara em @return>result>@~i o inscrito
                                                            $return['result']['remove'][$return['result']['remove']['length']] = $post['inscritos'][$i]["codigo"];

                                                            # declara em @return>sucess>@~i o inscrito
                                                            $return['result']['remove']['length']++;
                                                        }

                                                        # valida se a remoção teve algum problema
                                                        if ($temp['delete']['change']['error']['length'] > 0) {

                                                            # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                                            $return['warning'][$return['warning']['length']]['type'] = 'Não foi possivel excluir o cliente '.$post['inscritos'][$i]['codigo'];

                                                            # adiciona em @return>warning>[@~length]>sql_error o um relato do que houve na função de tratamento sql
                                                            $return['warning'][$return['warning']['length']]['sql_error'] = $temp['delete']['change']['process']['sql']['error']['error']['0'];

                                                            # adiciona +1 em $return>warning>length
                                                            $return['warning']['length']++;
                                                        }

                                                        # apaga @temp>delete
                                                        unset($temp['delete']);
                                                    }

                                                    # caso a acão seja para atualizar o campo
                                                    if ($post['inscritos'][$i]['action'] == 'update') {

                                                        # adiciona em @temp>update os valores de @temp>autenticacao
                                                        $temp['update'] = $temp['autenticacao']['select'];

                                                        # transforma array em json
                                                        $temp['update']['values']['values'] = json_decode($temp['autenticacao']['select']['change']['result']['0']['values'], true);

                                                        # # # #
                                                        # Atializa informações de values

                                                        # atualiza os valores de @temp>autenticacao>select>change>result>0>values 
                                                        $temp['update']['values']['values']["codigo"] = $post['inscritos'][$i]['codigo'];
                                                        $temp['update']['values']['values']['inscrito']['nome'] = $post['inscritos'][$i]['nome'];
                                                        $temp['update']['values']['values']['inscrito']['endereco'] = $post['inscritos'][$i]['endereco'];
                                                        $temp['update']['values']['values']['inscricao']['data'] = $post['inscritos'][$i]['data'];
                                                        $temp['update']['values']['values']['inscricao']['modalidade'] = $post['inscritos'][$i]['modalidade'];

                                                        # configura as informações de seleção do banco
                                                        $temp['update']['values']['values']["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["table"]= 'htmlGetSQL.congresso';
                                                        $temp['update']['values']['values']["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["segmento"]= 'congressista';
                                                        $temp['update']['values']['values']["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["grupo"]= $post['inscritos'][$i]['data'];
                                                        $temp['update']['values']['values']["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["type"] = $post['inscritos'][$i]['codigo'];
                                                        $temp['update']['values']['values']["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["sku"] = substr($post['inscritos'][$i]['codigo'], 0, 5) . substr($post['inscritos'][$i]['codigo'], -5);

                                                        # processa @update>update>values em json
                                                        $temp['update']['values']['values'] = json_encode($temp['update']['values']['values'], true);

                                                        # Atializa informações de values
                                                        # # # #

                                                        # configura grupo
                                                        $temp['update']['values']['grupo'] = $post['inscritos'][$i]['data'];

                                                        # # #
                                                        # trata os parametros para a remoção so item no banco
                                                        $temp['update']['change'] = update($temp['update'], false);
                                                        # trata os parametros para a remoção so item no banco
                                                        # # #


                                                        # valida se não houve nem um problema com a exclusão
                                                        if ($temp['update']['change']['error']['length'] == 0) {

                                                            # declara em @return>result>@~i o inscrito
                                                            $return['result']['update'][$return['result']['update']['length']] = $post['inscritos'][$i]["codigo"];

                                                            # declara em @return>sucess>@~i o inscrito
                                                            $return['result']['update']['length']++;
                                                        }

                                                        # valida se a remoção teve algum problema
                                                        if ($temp['update']['change']['error']['length'] > 0) {

                                                            # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                                            $return['warning'][$return['warning']['length']]['type'] = 'Não foi possivel atualizar o cliente '.$post['inscritos'][$i]['codigo'];

                                                            # adiciona em @return>warning>[@~length]>sql_error o um relato do que houve na função de tratamento sql
                                                            $return['warning'][$return['warning']['length']]['sql_error'] = $temp['update']['change'];

                                                            # adiciona +1 em $return>warning>length
                                                            $return['warning']['length']++;
                                                        }

                                                        # paga @temp>update
                                                        unset($post['update']);
                                                    }
                                                }

                                                # valida se @post>inscritos>@~i não possui algum comando
                                                if (!array_key_exists('action', $post['inscritos'][$i])) {

                                                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                                    $return['warning'][$return['warning']['length']]['type'] = 'O cliente '.$post['inscritos'][$i]['codigo'].' ja foi cadastrado';

                                                    # adiciona +1 em $return>warning>length
                                                    $return['warning']['length']++;
                                                }
                                            }


                                            # valida se não foi recebido algum item na consulta
                                            if ($temp['autenticacao']['select']['change']['result']['length'] == 0 ) {

                                                # # # #
                                                # # Constroi os valores para insersão no banco 
                                                
                                                # adiciona as informações do cliente
                                                $temp['inscritos']['lista'][$i]["codigo"] = $post['inscritos'][$i]['codigo'];
                                                $temp['inscritos']['lista'][$i]['inscrito']['nome'] = $post['inscritos'][$i]['nome'];
                                                $temp['inscritos']['lista'][$i]['inscrito']['endereco'] = $post['inscritos'][$i]['endereco'];
                                                $temp['inscritos']['lista'][$i]['inscricao']['data'] = $post['inscritos'][$i]['data'];
                                                $temp['inscritos']['lista'][$i]['inscricao']['modalidade'] = $post['inscritos'][$i]['modalidade'];

                                                # configura as informações de seleção do banco
                                                $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["table"]= 'htmlGetSQL.congresso';
                                                $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["segmento"]= 'congressista';
                                                $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["grupo"]= $post['inscritos'][$i]['data'];
                                                $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["type"] = $post['inscritos'][$i]['codigo'];
                                                $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["sku"] = substr($post['inscritos'][$i]['codigo'], 0, 5) . substr($post['inscritos'][$i]['codigo'], -5);


                                                # #
                                                # conecta ao banco para selecionar o ultimo index inserirdo
                                                $temp['autenticacao']['select']['where']['segmento'] = 'congressista';
                                                $temp['autenticacao']['select']['return'] = 'index';
                                                $temp['count']['select']['change'] = select($temp['autenticacao']['select'], false);
                                                # conecta ao banco para selecionar o ultimo index inserirdo
                                                # #

                                                print_r($temp['count']['select']['change']);

                                                # valida se em @$temp>count>select>change>result não encontrou nada
                                                if ($temp['count']['select']['change']['result']['length'] == 0) {

                                                    # declarara o ordem no index com "1"
                                                    $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["index"] = '1';
                                                }


                                                # valida se em @$temp>count>select>change>result foi encontrado algo
                                                if ($temp['count']['select']['change']['result']['length'] > 0) {

                                                    # adiciona em @temp>inscritos>lista>@~setings>index o valor de @temp>count>select>change>result>index +1
                                                    $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"]["index"] = $temp['count']['select']['change']['result']['index']++;
                                                }

                                                # # Constroi os valores para insersão no banco 
                                                # # # #


                                                # # # #
                                                # # Insere no banco o valor processado

                                                # insere no banco o valor processado em @temp>inscritos>ordena>lista
                                                $temp['insert']['table'] = $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["table"];
                                                $temp['insert']['values'] = $temp['inscritos']['lista'][$i]["htmlGetSQL.setings"]["htmlGetSQL.selectors"]["select"];
                                                $temp['insert']['values']['values'] = json_encode($temp['inscritos']['lista'][$i], true);
                                                $temp['insert']['change'] = insert($temp['insert'], false);

                                                # valida se houve erros na insersão
                                                if ($temp['insert']['change']['error']['length'] > 0) {

                                                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi possivel inserir o valor no banco, verifique em erro->sql_error';

                                                    # adiciona em @return>warning>[@~length]>sql_error o um relato do que houve na função de tratamento sql
                                                    $return['warning'][$return['warning']['length']]['sql_error'] = $temp['insert']['change']['process']['sql']['error']['error']['0'];

                                                    # adiciona +1 em $return>warning>length
                                                    $return['warning']['length']++;
                                                }

                                                # valida se não houve erros na insersão
                                                if ($temp['insert']['change']['error']['length'] == 0) {

                                                    # declara em @return>result>@~i o inscrito
                                                    $return['result']['new'][$return['result']['new']['length']] = $temp['inscritos']['lista'][$i]["codigo"];

                                                    # declara em @return>sucess>@~i o inscrito
                                                    $return['result']['new']['length']++;

                                                    # apaga todos os temps usados
                                                    unset($temp);
                                                }

                                                # # Insere no banco o valor processado
                                                # # # #
                                            }
                                        }

                                        # valida se não houve nem um erro ao selecionar
                                        if ($temp['autenticacao']['select']['change']['error']['length'] > 0) {

                                            # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                            $return['warning'][$return['warning']['length']]['type'] = 'Não foi possivel verificar se o cliente '.$post['inscritos'][$i]['codigo'].' existe, verifique a conexão';

                                            # adiciona +1 em $return>warning>length
                                            $return['warning']['length']++;
                                        }
                                        # # Inicia insersão no banco de dados
                                        # # #
                                    }

                                    # caso não exista o campo "data" em @post>inscritos>@~i
                                    if (!array_key_exists('data', $post['inscritos'][$i])) {

                                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                        $return['warning'][$return['warning']['length']]['type'] = 'O campo "data" esta ausente na posição '.$i.' com o código '.$post['inscritos'][$i]['codigo'].', assim o valor não sera processado';

                                        # adiciona +1 em $return>warning>length
                                        $return['warning']['length']++;
                                    }
                                }

                                # caso não exista o campo "endereco" em @post>inscritos>@~i
                                if (!array_key_exists('endereco', $post['inscritos'][$i])) {

                                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                    $return['warning'][$return['warning']['length']]['type'] = 'O campo "endereco" esta ausente na posição '.$i.' com o código '.$post['inscritos'][$i]['codigo'].', assim o valor não sera processado';

                                    # adiciona +1 em $return>warning>length
                                    $return['warning']['length']++;
                                }
                            }

                            # caso não exista o campo "nome" em @post>inscritos>@~i
                            if (!array_key_exists('nome', $post['inscritos'][$i])) {

                                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                $return['warning'][$return['warning']['length']]['type'] = 'O campo "nome" esta ausente na posição '.$i.' com o código '.$post['inscritos'][$i]['codigo'].', assim o valor não sera processado';

                                # adiciona +1 em $return>warning>length
                                $return['warning']['length']++;
                            }
                        }

                        # caso não exista o campo codigo em @post>inscritos>@~i
                        if (!array_key_exists('codigo', $post['inscritos'][$i])) {

                            # adiciona em @return>warning>[@~length]>type o um relato do que houve
                            $return['warning'][$return['warning']['length']]['type'] = 'O campo "codigo" esta ausente na posição '.$i.', assim o valor não sera processado';

                            # adiciona +1 em $return>warning>length
                            $return['warning']['length']++;
                        }
                    }

                    # apaga @i
                    unset($i);

                    # # inicia compilação dos valores de post
                    # # # #
                }

                # valida se os inscritos não iniciam em 0
                if (!array_key_exists('0', $post['inscritos'])) {

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['error'][$return['error']['length']]['type'] = 'Era esperado ao menos um item na como lista array';

                    # adiciona +1 em $return>error>length
                    $return['error']['length']++;
                }
            }

            # valida se não existe nem um item em @post>inscritos
            if (!is_array($post['inscritos'])) {

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Era esperado parametros array para inscritos';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }
        }

        # caso exista o campo login em @post
        if (!array_key_exists('inscritos', $post)) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['error'][$return['error']['length']]['type'] = 'Confira se o parametro para inscritos esta correto, ou se é valido';

            # adiciona +1 em $return>error>length
            $return['error']['length']++;
        }

        # valida se o existe usuario e senha
        # # # 
    }


    print_r($return);



    user_sing($post, true);



?>

