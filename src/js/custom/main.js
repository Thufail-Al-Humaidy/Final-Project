$(document).ready(function(){
    $('.carrousel_post').slick({
        infinite: true,
        slidesToShow: 4,           // Default untuk layar besar (lg)
        slidesToScroll: 1,
        autoplay: false,
        responsive: [
            {
                breakpoint: 1024,   // Untuk layar medium (md)
                settings: {
                    slidesToShow: 2,   
                    slidesToScroll: 1,
                    infinite: true,
                    autoplay: false
                }
            },
            {
                breakpoint: 768,    // Untuk layar kecil (sm)
                settings: {
                    slidesToShow: 1,   
                    slidesToScroll: 1,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 4000
                }
            }
        ]
    });
    
    

    $('.slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        prevArrow: '#btn_left',
        nextArrow: '#btn_right'
    });
})


