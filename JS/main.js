// var btn = document.querySelector('#topdf');
//scroll 
const scroll = ScrollReveal ({
    origin: 'right',
    distance: '40px',
    duration: 2000,
    scale : 0.9,
    reset: false
 });
 
scroll.reveal(` .box, .home-text, 
                .home-img, .menu>img, #recherche-menu, #addprodform,
                #addcatform, .cat-container, #addcliform, 
                .cli-container, #addcomform, #addfourform,
                #piechart, table`, { 
    interval: 200
});


