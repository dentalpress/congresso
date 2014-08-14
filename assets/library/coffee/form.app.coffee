# função enviar para php #
$.submt_post = (value) ->
    
    # ativa enviar no botão
    btn.button('loading');
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
        btn.addClass('hidden');

        console.log data
        # caso enviada a mensagem
        if data is 'enviado'
            $('.form-success').removeClass('hidden') 

        # caso não tenha sido enviada a mensagem
        if data != 'enviado'
            $('.form-erro').removeClass('hidden') 


# explicita o botão do enviar
btn = $('form').find('#send')

# quando o formulario for submetido
$("form").on "submit", ->
    # captura a url base e aplica no hidden origem
    $(this).find("#origem").val($(this)["context"]["baseURI"])

    # envia ao php o valor de this com serialize
    $.submt_post $(this).serialize()

    # btn.button('reset')
    return false
