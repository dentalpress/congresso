# função enviar para php #
$.submt_post = (value) ->

    # # #
    # value = valores para conexao e busca no banco
    # # #

    console.log 'oi';

    # Função ajax
    $.ajax(
        type: "post"
        url: "../congresso/assets/library/php/submit.php" #local no php
        cache: false
        data: value
        async: false
    )

    # resultado de retorno
    .done (data) -> 
        # console.log data # exibe valor de data
        value = data

    # retorna value a solicitação com 'eval()'
    return eval(value)


# # # # # # #
# # Trata formulários

# # #
# define [objects Object] globais

# define @temp
temp = {};

# define @temp.form
temp.form = {}

# define @trabalho
trabalho = {}

# define @trabalho.origem
trabalho.origem = {}

# define @trabalho.trabalho
trabalho.trabalho = {}

# define @trabalho.contato
trabalho.contato = {}


# define [objects Object] globais
# # #

# # #
# Inicia tratamento do form

# quando o formulario for submetido
$("form").on "submit", ->
    # captura a url base e aplica no hidden origem
    $(this).find("#origem").val($(this)["context"]["baseURI"])

    # define o botão
    btn = $(this).find('#send')

    # add loading em btn
    btn.addClass('hidden')

    # verifica se a solicitação vem do fomumlário trabalho
    if $(this).find("#origem-tipo").val() is 'trabalho'

        # monta [object Object] para enviar em post
        temp.form.array = $(this).serializeArray()

        # define em @temp.count 0
        temp.count = 0

        # # inicia laço para selecionar cada item de select
        while temp.count < temp.form.array.length

            # reserva cada valor conforme o seu campo
            switch temp.form.array[temp.count].name

                when 'origem'
                    trabalho.origem.origem = temp.form.array[temp.count].value

                when 'origem-nome'
                    trabalho.origem.nome = temp.form.array[temp.count].value

                when 'origem-tipo'
                    trabalho.origem.tipo = temp.form.array[temp.count].value

                when 'nome'
                    trabalho.contato.nome = temp.form.array[temp.count].value

                when 'email'
                    trabalho.contato.email = temp.form.array[temp.count].value

                else
                    trabalho.trabalho[temp.form.array[temp.count].name] = temp.form.array[temp.count].value

            # adiciona +1 em @temp.count
            temp.count++

        # envia a função post
        success = $($.submt_post trabalho)['0'].success


    # verifica se a solicitação vem do fomulário contato
    if $(this).find("#curso-tipo").val() is 'contato'

        # envia ao php o valor de this com serialize
        success = $($.submt_post $(this).serialize())['0'].success

    if success is true
        $(this).find('.form-success').removeClass('hidden')

    if success is false
        $(this).find('.form-erro').removeClass('hidden')


    # btn.button('reset')
    return false

# Inicia tratamento do form
# # #

# console.log 'oi'
