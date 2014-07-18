## GLOBAL OBJECTS ##

temp = {} # define temporario

url = {} #define url
url.atual = window.location.hash # recebe valor atual de rash da base
url.hashtag = window.location.hash.replace(/\//g, '-').replace('--', '-') # recebe valor atual para a url

#manupula hastag
if url.hashtag.substr(-1) == '-'
    url.hashtag = url.hashtag.slice(0, -1)

url.data = '' #recebe data


### FUNCION ###
# funcion fefine posicao
f_define_posicao = (val) ->

    temp.scroll = {} # define em temp array scroll

    # define seletor data do destino removendo hashtag
    temp.scroll.destino = "[data-url-position=" + val.replace('#', '') + "]"

    # valida se foi encontrado algo
    if $(temp.scroll.destino).length is 1

        # define a posição no topo de destino
        temp.scroll.posicao = $(temp.scroll.destino).offset().top 

        # movimenta pagina no scroll com a posição passada
        $("html:not(:animated),body:not(:animated)").animate
            scrollTop: temp.scroll.posicao - 20
            , 1000

        f_define_url val

    #remove scoll de temp
    delete temp.scroll


#function define url no historico e na barra
f_define_url = (val) ->
    temp.url = {} # fedino uma array para url
    temp.url.hashtag = val # acrecento a hashtag o val

    #substituo "-" por "/"
    temp.url.caminho = temp.url.hashtag.replace(/\-/g, '/') + "/"

    # Acrecenta no historico e na url atual a posição solicitada quando ainda não visitado
    if temp.url.caminho != url.atual
        window.history.pushState "", "", temp.url.caminho 

        # atualizo url.atual
        url.atual = temp.url.caminho

        # console.log 'oi'

### ACOES ###

#Executa quando receber padrão de url
$("a[href^=#]").on 'click', $("a[href^=#]"), ->

    # $("a[href^=#]").click ->
    temp.href = $(this).attr("href") #selecino href

    # ativa função
    f_define_posicao temp.href

    false

# Defino a posicao atual quando carregar a pagina
f_define_posicao '#home' if url.atual is '' # define home quando url for vazia
f_define_posicao url.hashtag if url.atual != '' # paça posicao atual caso o url seja setado

# ativa função F_define_position quando o hash modificado
$(window).bind "hashchange", ->
    f_define_posicao window.location.hash
