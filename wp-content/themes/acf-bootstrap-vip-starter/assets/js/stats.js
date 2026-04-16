document.addEventListener('DOMContentLoaded', function () {

    const counters = document.querySelectorAll('.stat-number');

    const animateCount = (el) => {

        const target = parseInt(el.getAttribute('data-target'));
        const countEl = el.querySelector('.count');

        let current = 0;
        const duration = 1500; // total animation time
        const increment = target / (duration / 16); // ~60fps

        const update = () => {
            current += increment;

            if (current < target) {
                countEl.textContent = Math.floor(current);
                requestAnimationFrame(update);
            } else {
                countEl.textContent = target;
            }
        };

        update();
    };

    // Intersection Observer
    const observer = new IntersectionObserver((entries, obs) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                animateCount(entry.target);

                // run only once
                obs.unobserve(entry.target);
            }

        });

    }, {
        threshold: 0.5
    });

    counters.forEach(counter => {
        observer.observe(counter);
    });

});