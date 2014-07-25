# # # # 
# TOOGLE SHOW MENU-APP

# configura itens para botão
menu = {}
menu.this = $('.menu-group')
menu.buttom = menu.this.find('.btn-menu')
menu.menu   = menu.this.find('.menu-group-nav .menu-group-nav-list a')


# remove caso click em algum link
menu.menu.click ->
    menu.this.removeClass('app-actived')
    $("body").css("overflow-y":"scroll")

# quando clicar no botão 
menu.buttom.click ->

    if menu.this.hasClass('app-actived')
        menu.this.removeClass('app-actived')
        $("body").css("overflow-y":"scroll")

    else
        $("body").css("overflow":"hidden")
        menu.this.addClass('app-actived')

# TOOGLE SHOW MENU-APP
# # # # 



# # # # 
# TOOGLE SHOW THUMBNAIL FOTOS

# figure-group
# figure-group-short

# cria [object Object] figure para conter todos os valores trabalhados
figure = {} 

# adiciona em figure>buttom o botão de exibir mais imagens
figure.buttom = $('.figure-group-item-mais')

# adiciona em figure>group todos os grupos de galeria de fotos
figure.group = $('.figure-group')

# cria [object Object] figure>contents, se não houver
figure.content = {}


# #
# inicia ação quando clicar no botão
figure.buttom.click ->

    # #
    # Configura elementos

    # localiza grupo das imagens, e adiciona em figure>contents caso ela não seja do tipo "short"
    figure.content = figure.buttom.closest('.figure-group')

    # verifica se existe a classe no contents
    if $(figure.content).hasClass('figure-group-short')

        # adiciona em figure>show figure>content
        figure.show = figure.content

    # caso não já esteja visivel
    else 
        # cria span em figure
        figure.show = '<span></span>'


    # #
    # inicia toogle de status

    # esconte as thumbs de todas as galerias
    $(figure.group).addClass('figure-group-short')

    # adiciona em contents a classe 
    $(figure.show).removeClass('figure-group-short')


    # #
    # retorna a posição

    figure.scroll = {}

    # define a posição no topo de destino
    figure.scroll.posicao = $(figure.content).offset().top 

    # movimenta pagina no scroll com a posição passada
    $("html:not(:animated),body:not(:animated)").animate
        scrollTop: figure.scroll.posicao - 200
        , 1000
