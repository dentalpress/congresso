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
