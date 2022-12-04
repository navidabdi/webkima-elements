(function(){
  const carouselItems = document.querySelectorAll('.webkima-el-carousel-item'),
    moveRight = document.querySelector('#moveRight'),
    moveLeft = document.querySelector('#moveLeft');

  carouselItems[0].classList.add('active');
  let total = carouselItems.length;
  let current = 0;

  moveRight.addEventListener('click', function(){
    let next=current;
    current= current+1;
    setSlide(next, current);
  });
  moveLeft.addEventListener('click', function(){
    let prev=current;
    current = current- 1;
    setSlide(prev, current);
  });
  function setSlide(prev, next){
    let slide= current;
    if(next>total-1){
      slide=0;
      current=0;
    }
    if(next<0){
      slide=total - 1;
      current=total - 1;
    }
    carouselItems[prev].classList.remove('active');
    carouselItems[slide].classList.add('active');
  }
})();