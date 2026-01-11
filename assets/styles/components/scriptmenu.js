
document.querySelectorAll('.menu-link img').forEach(icon => {
    const original = icon.src;
    const hover = icon.dataset.hover;

    icon.parentElement.addEventListener('mouseenter', () => {
        icon.src = hover;
    });

    icon.parentElement.addEventListener('mouseleave', () => {
        icon.src = original;
    });
});

