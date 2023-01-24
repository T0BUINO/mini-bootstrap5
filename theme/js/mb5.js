/*!
 * mini-bootstrap5 JS
 */

// 返回顶部
//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// TOC 折叠
document.querySelectorAll('.table-of-contents .toggle-toc, .table-of-contents .toc-headline').forEach(toggler => {
    toggler.addEventListener('click', function() {
        let tocList = document.querySelectorAll('.table-of-contents ul')[0];
        let toggler = document.querySelectorAll('.table-of-contents .toggle-toc')[0];
        if(tocList.style.display == 'none') {
            tocList.style.display = 'block';
            toggler.innerHTML = ' [折叠]';
        } else {
            tocList.style.display = 'none';
            toggler.innerHTML = ' [展开]';
        }
    });
});