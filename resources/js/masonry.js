import Masonry from 'masonry-layout';

window.onload = () => {
    const grid = document.querySelector('.grid');

    const masonry = new Masonry(grid, {
        itemSelector: '.card-image',
        gutter: 10,
    });


}
