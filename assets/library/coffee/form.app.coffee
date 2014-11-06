# função enviar para php #
$.submt_post = (value) ->
    
    # ativa enviar no botão
    # btn.button('loading');
    $.ajax(
        type: "post"
        url: "../congresso/assets/library/php/submit.php"
        cache: false
        #dataType: "json"
        data: value
        async: false
    )
    # quando pronto
    .done (data) ->
        #remove o load no botão
        # btn.addClass('hidden');

        console.log data
        # caso enviada a mensagem
        if data is 'enviado'
            $('.form-success').removeClass('hidden') 

        # caso não tenha sido enviada a mensagem
        if data != 'enviado'
            $('.form-erro').removeClass('hidden') 


# # # # # # #
# # Função trata json
trataString = (str)->
    # substiu valores
    str = str.replace('\\', '\\\\').replace('{', '\\{').replace('}', '\\}').replace('"', '\\"').replace('"', '\\"').replace(':', '\\:')

    #rerotna a solicitação
    return str

# # Função trata json
# # # # # # #




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
                    trabalho.origem.origem = trataString(temp.form.array[temp.count].value)

                when 'origem-nome'
                    trabalho.origem.nome = trataString(temp.form.array[temp.count].value)

                when 'origem-tipo'
                    trabalho.origem.tipo = trataString(temp.form.array[temp.count].value)

                when 'nome'
                    trabalho.contato.nome = trataString(temp.form.array[temp.count].value)

                when 'email'
                    trabalho.contato.email = trataString(temp.form.array[temp.count].value)

                else
                    trabalho.trabalho[temp.form.array[temp.count].name] = trataString(temp.form.array[temp.count].value)

            # adiciona +1 em @temp.count
            temp.count++

        # envia a função post
        $.submit_post trabalho

    # verifica se a solicitação vem do fomulário contato
    if $(this).find("#origem-type").val() is 'contato'

        # envia ao php o valor de this com serialize
        $.submt_post $(this).serialize()

    # btn.button('reset')
    return false

# Inicia tratamento do form
# # #

# console.log 'oi'
