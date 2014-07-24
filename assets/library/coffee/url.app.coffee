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


        # caso não seja o mesmo elemento
        if temp.link.url != $(temp.scroll.destino)

            # adiciona em temp>link>url o valor atual que esta na tela
            temp.link.url = $(temp.scroll.destino)

            # remove todas as classes dos outros "data-url-link"
            $('[data-url-link]').removeClass("actived")

            # adiciona classe activedo no link atual
            $(temp.link[temp.link.url]).addClass("actived")

            # define classe actived para os elementos superiores
            $(temp.link[temp.link.url]).closest("ul").find("li").removeClass("actived")

            # define classe actived para os elementos superiores
            $(temp.link[temp.link.url]).closest("li").addClass("actived")


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


### ACOES ###

# # #
# ENCONTRA LINKS DAS URLS
# cria object temp>link
temp.link  = {}
temp.link.url  = {}
# aciciona em temp>link>contents todos os links com o valor data "data-url-link"
temp.link.contents  = $('[data-url-link]')

# cria contador para a sequencia atual
temp.count = 0

# laço para aplicar regra para cada item de temp>link>contents
while temp.count < temp.link.contents.length

    # defino em temp>link um object com o nome do valor de seu data "data-url-link" e adiciono o html
    temp.link[$(temp.link.contents[temp.count]).data('url-link')] = temp.link.contents[temp.count]

    # acrecento em temp>count +1 para continuar o loop
    temp.count++


# #
# executa função para saber qual "data-url-link" deve estar ativo
$("[data-url-position]").hover ->

    # caso não seja o mesmo elemento
    if temp.link.url != $(this).data("url-position")

        # adiciona em temp>link>url o valor atual que esta na tela
        temp.link.url = $(this).data("url-position")

        # remove todas as classes dos outros "data-url-link"
        $('[data-url-link]').removeClass("actived")

        # adiciona classe activedo no link atual
        $(temp.link[temp.link.url]).addClass("actived")

        # define classe actived para os elementos superiores
        $(temp.link[temp.link.url]).closest("ul").find("li").removeClass("actived")

        # define classe actived para os elementos superiores
        $(temp.link[temp.link.url]).closest("li").addClass("actived")

        # define object com o valor da hashtag
        temp.link.rash = "#" + temp.link.url

        # redireciona link
        f_define_url temp.link.rash
# #

# #
# Executa quando receber padrão de url
$("a[href^=#]").on 'click', $("a[href^=#]"), ->

    # $("a[href^=#]").click ->
    temp.href = $(this).attr("href") #selecino href

    # ativa função
    f_define_posicao temp.href

    false

# Defino a posicao atual quando carregar a pagina
f_define_posicao '#abertura' if url.atual is '' # define home quando url for vazia
f_define_posicao url.hashtag if url.atual != '' # paça posicao atual caso o url seja setado

# ativa função F_define_position quando o hash modificado
$(window).bind "hashchange", ->
    f_define_posicao window.location.hash



