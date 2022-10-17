function GoTo(vol) {
    location = vol
}
function DoYou(vol) {
    var ok = confirm("!?")
    if (ok)
        location = vol
}
function strlen(string) {
    return string.length;
}
// 1. Фиксация <body>
function bodyFixPosition() {

    setTimeout(function () {
        /* Ставим необходимую задержку, чтобы не было «конфликта» в случае, если функция фиксации вызывается сразу после расфиксации (расфиксация отменяет действия расфиксации из-за одновременного действия) */

        if (!document.body.hasAttribute('data-body-scroll-fix')) {

            // Получаем позицию прокрутки
            let scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

            // Ставим нужные стили
            document.body.setAttribute('data-body-scroll-fix', scrollPosition); // Cтавим атрибут со значением прокрутки
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + scrollPosition + 'px';
            document.body.style.left = '0';
            document.body.style.width = '100%';

        }

    }, 15); /* Можно задержку ещё меньше, но у меня работало хорошо именно с этим значением на всех устройствах и браузерах */

}

// 2. Расфиксация <body>
function bodyUnfixPosition() {

    if (document.body.hasAttribute('data-body-scroll-fix')) {

        // Получаем позицию прокрутки из атрибута
        let scrollPosition = document.body.getAttribute('data-body-scroll-fix');

        // Удаляем атрибут
        document.body.removeAttribute('data-body-scroll-fix');

        // Удаляем ненужные стили
        document.body.style.overflow = '';
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.width = '';

        // Прокручиваем страницу на полученное из атрибута значение
        window.scroll(0, scrollPosition);

    }

}



function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

function escapeHtml(string) {
    return String(string).replace(/[&<>"'`=\/]/g, function (s) {
        return entityMap[s];
    });
}

function goPage(newUrl) {
    setTimeout(function () {
        window.location.href = newUrl
    }, 100);
    // $("a.o-link, a.o-preload").click(function (event) {
    //     event.preventDefault();
    //     $("#preloader").fadeIn('110');
    //     let newUrl = $(this).attr('href');
    //     goPage(newUrl);
    // });
    // $("#preloader").delay(1200).fadeOut('200');
}













export {GoTo, strlen, bodyFixPosition, bodyUnfixPosition, DoYou,escapeHtml };


















// require('webpack-jquery-ui');
// require('webpack-jquery-ui/slider');
// require('webpack-jquery-ui/css');  //ommit, if you don't want to load basic css theme
//
//  import "font-awesome/scss/fontawesome.scss";
// var $ = require('jquery');

//


//methods
// fullpage_api.setAllowScrolling(false);


// require('../css/catalog.css');
// require('../css/bootstrap.min.css');
// require('../css/new.css'


//     if ($('section').hasClass('b-catalog')) {
//         $(".b-catalog article img").each(function () {
//             if ($(window).scrollTop() + $(window).height() + 200 > $(this).offset().top) {
//                 var this_img = $(this).attr("data-id");
//                 if (this_img != 'noimage' && this_img != 'undefined' && this_img != '') {
//                     $(this).attr("src", siteUrl + "/pages/catalog/" + this_img + ".jpg");
//                 }
//             }
//         });
//     }
// });


// import * as AOS from 'aos/dist/aos.js';
// import 'aos/dist/aos.css';
//
// require('webpack-jquery-ui');
// require('webpack-jquery-ui/css');


// jQuery("body").prepend('<div id="preloader"></div>');

// $(document).mousemove(function(e) {
//     window.x = e.pageX;
//     window.y = e.pageY;
// });


// import { NamedExport } from './other-module.js';

