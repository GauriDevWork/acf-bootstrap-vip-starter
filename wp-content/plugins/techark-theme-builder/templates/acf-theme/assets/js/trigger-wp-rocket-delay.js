setTimeout(function () {
  const events = ['mouseover', 'keydown', 'touchmove', 'touchstart', 'mousedown', 'mousemove', 'scroll'];
  events.forEach(function (eventType) {
    const event = new Event(eventType, {
      bubbles: true,
      cancelable: true
    });
    document.dispatchEvent(event);
  });
}, 3500);

wow = new WOW(
  {
    boxClass: 'wow',
    animateClass: 'animated',
    offset: 50,
    mobile: true,
    live: false,
    resetAnimation: false,
    callback: function (el) {
      el.classList.add('wow-visible');
    }
  })
wow.init();

if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
  document.querySelectorAll('.wow').forEach(el => {
    el.style.animation = 'none';
    el.classList.add('wow-visible');
  });
}