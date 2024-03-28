export default {
    mounted(el) {
        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                el.src = el.dataset.src;
                observer.unobserve(el);
            }
        });

        observer.observe(el);
    }
};
