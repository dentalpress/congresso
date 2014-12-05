<?php

# # # # # # # # # # #
# Função: para autenticação do usuario
/**
A função esta incompleta, falta inserir a criação de logs no banco, autenticação de computador, verificação de sing-in e sing-out
**/
function user_sing($post, $print) {

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

    # # configura os valores de retorno
    # # # # #


    # # # # #
    # # Valida os valores de @post

    # caso exista usuario
    if (array_key_exists('user', $post['login'])) {

        # caso exista senha
        if (array_key_exists('senha', $post['login'])) {

            # # # # #
            # # configura os valores de retorno

            # # #
            # define valores em @return>process>autenticacao para autenticacao

            # define @return>process>autenticacao>success com false, a espera de autenticacao
            $return['process']['autenticacao']['success'] = false;

            # define @return>process>autenticacao>error como NULL para sem erros
            $return['process']['autenticacao']['error']['length'] = 0;

            # # configura os valores de retorno
            # # # # #


            # # #
            # trata dados de @post, de acordo com a estrutura do banco

            # trata valores para validação de usuario
            $temp['autenticacao']['user'] = $post['login']['user'];
            $temp['autenticacao']['password'] = substr(md5($post['login']['senha']), 0, 5) . substr(md5($post['login']['senha']), -5);
            $temp['autenticacao']['registry'] = substr(md5($temp['autenticacao']['password'].$post['login']['senha']), 0, 5) . substr(md5($temp['autenticacao']['password'].$post['login']['senha']), -5);

            # #
            # seleciona o usuario pelo banco

            # valida se a função para selecionar existe

            if (function_exists('select')) {

                # #
                # configurações de capturação de dados do banco
                $temp['autenticacao']['select']['regra']['limit'] = '1';
                $temp['autenticacao']['select']['regra']['order']['to'] = 'index';
                $temp['autenticacao']['select']['regra']['order']['by'] = 'DESC';
                $temp['autenticacao']['select']['table'] = 'htmlGetSQL.congresso';
                $temp['autenticacao']['select']['where']['grupo'] = $temp['autenticacao']['registry'];
                $temp['autenticacao']['select']['return'] = 'values';
                $temp['autenticacao']['select']['change'] = select($temp['autenticacao']['select'], false);
                # configurações de capturação de dados do banco

                # valida se hove algum erro
                if ($temp['autenticacao']['select']['change']['error']['length'] == 0) {

                    # valida se foi recebido algo, para iniciar o tratamento dos valores
                    if ($temp['autenticacao']['select']['change']['result']['length'] > 0) {

                        # converte @...>values em array
                        $temp['autenticacao']['values'] = json_decode($temp['autenticacao']['select']['change']['result']['0']['values'], true);


                        # # # # 
                        # # Validação do login

                        # valida se o usuario do  banco é diferente do usuario passado pelo json
                        if ($temp['autenticacao']['values']['login']['user']['._.this'] != $temp['autenticacao']['user']) {

                            # adiciona em @return>error>[@~length]>type o um relato do que houve
                            $return['process']['autenticacao']['error'][$return['process']['autenticacao']['error']['length']]['type'] = 'Verifique se o usuario e a senha estão corretos.';

                            # adiciona +1 em $return>error>length
                            $return['process']['autenticacao']['error']['length']++;
                        }

                        # valida se o usuario do  banco é igual o usuario passado pelo json
                        if ($temp['autenticacao']['values']['login']['user']['._.this'] == $temp['autenticacao']['user']) {

                            # valida se a senha do banco é diferente da senha passado pelo json
                            if ($temp['autenticacao']['values']['login']['password']['._.this'] != $temp['autenticacao']['password']) {

                                # adiciona em @return>error>[@~length]>type o um relato do que houve
                                $return['process']['autenticacao']['error'][$return['process']['autenticacao']['error']['length']]['type'] = 'Verifique se a senha e o usuario estão corretos.';

                                # adiciona +1 em $return>error>length
                                $return['process']['autenticacao']['error']['length']++;
                            }
                        }

                        # # Validação do login
                        # # # #
                    }

                    # valida se não foi recebido nada da seleção
                    if ($temp['autenticacao']['select']['change']['result']['length'] == 0) {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['process']['autenticacao']['error'][$return['process']['autenticacao']['error']['length']]['type'] = $temp['autenticacao']['select']['change']['warning']['0']['type'];

                        # adiciona +1 em $return>error>length
                        $return['process']['autenticacao']['error']['length']++;
                    }
                }

                # valida se hove algum erro
                if ($temp['autenticacao']['select']['change']['error']['length'] > 0) {

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['process']['autenticacao']['error'][$return['process']['autenticacao']['error']['length']]['type'] = 'Houve algum erro para selecinar o banco';

                    # adiciona +1 em $return>error>length
                    $return['process']['autenticacao']['error']['length']++;
                }


                # # # #
                # # finaliza tratamentos

                # valida se nao houve erros
                if ($return['process']['autenticacao']['error']['length'] == 0) {

                    # define @return>process>autenticacao>success como "true", para concluido
                    $return['process']['autenticacao']['success'] = true;

                    # adiciona em @return>result o valor verdadeiro para a autenticação
                    $return['result'] = true;
                }

                # valida se houve erros, e adiciona o erro a matriz
                if ($return['process']['autenticacao']['error']['length'] > 0) {

                    # adiciona em @return>result o valor falso para a autenticação
                    $return['result'] = false;

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['error'][$return['error']['length']]['type'] = 'Halgo ocorreu no processo de valiadção, verifique em process os logs de erros';

                    # adiciona +1 em $return>error>length
                    $return['error']['length']++;
                }

                # apaga @temp>autenticacao
                unset($temp['autenticacao']);

                # # finaliza tratamentos
                # # # #
            }

            # valida se a função nao existir
            if (!function_exists('select')) {

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Houve um probelma com as funções de seleção confira se elas estão devidamente listadas';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }
        }

        # caso nao exista senha
        if (!array_key_exists('senha', $post['login'])) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['error'][$return['error']['length']]['type'] = 'Confira se o os parametros para autenticação do json estão corretos, para senha ou usuario';

            # adiciona +1 em $return>error>length
            $return['error']['length']++;
        }
    }

    # caso nao exista usuario
    if (!array_key_exists('login', $post)) {

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Confira se o os parametros para autenticação do json estão corretos, para usuario e senha';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;
    }

    # # Valida os valores de @post
    # # # # #

    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #


    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if($print == true){

        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if($print == false){

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
/**
A função esta incompleta, falta inserir a criação de logs no banco, autenticação de computador, verificação de sing-in e sing-out
**/
# Função: para autenticação do usuario
# # # # # # # # # # #

?>