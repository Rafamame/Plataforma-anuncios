document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-custom');
    const categoryLinks = document.querySelectorAll('.category-list a');
    const mascote = document.querySelector('.mascote');
    const scrollToTopButton = document.querySelector('.scroll-to-top');
    const navbarToggler = document.querySelector('.navbar-toggler');
    
    // Suavização de tempo para hover e animações
    const hoverTransitionTime = '0.3s';
    const scrollTransitionTime = 500; // Tempo para scroll suave

    // Efeito de hover nos botões
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = `transform ${hoverTransitionTime}`;
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.transition = `transform ${hoverTransitionTime}`;
        });
    });

    // Efeito de hover nas categorias
    categoryLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.color = '#ddd';
            this.style.transition = `color ${hoverTransitionTime}`;
        });

        link.addEventListener('mouseleave', function() {
            this.style.color = '#fff';
            this.style.transition = `color ${hoverTransitionTime}`;
        });
    });

    // Animação do mascote ao passar o mouse
    if (mascote) {
        mascote.addEventListener('mouseover', function() {
            this.style.transform = 'scale(1.1)';
            this.style.transition = `transform ${hoverTransitionTime}`;
        });

        mascote.addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
            this.style.transition = `transform ${hoverTransitionTime}`;
        });
    }

    // Função para abrir e fechar o menu de navegação em telas menores
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            const menu = document.getElementById('navbarNav');
            if (menu) {
                menu.classList.toggle('show'); // Alterna a visibilidade do menu
            }
        });
    }

    // Scroll suave para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Função de rolagem para o botão "Voltar ao topo"
    if (scrollToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollToTopButton.style.display = 'block';
            } else {
                scrollToTopButton.style.display = 'none';
            }
        });

        scrollToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Aviso de navegação sem salvar (opcional)
    let formChanged = false;
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('input', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            const confirmationMessage = 'Você tem alterações não salvas. Tem certeza que deseja sair?';
            e.returnValue = confirmationMessage; // Para alguns navegadores antigos
            return confirmationMessage;
        }
    });
});
