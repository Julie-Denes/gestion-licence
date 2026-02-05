document.addEventListener('DOMContentLoaded', () => {
    const filterSelect = document.getElementById('filterModule');
    const table = document.getElementById('interventionTable');
    if (!filterSelect || !table) return;

    const rows = table.querySelectorAll('tbody tr');

    // Supprime les doublons du select
    const uniqueModules = [...new Set(
        Array.from(rows).map(row => row.dataset.module)
    )];
    filterSelect.innerHTML = '<option value="all">Tous les modules</option>';
    uniqueModules.forEach(module => {
        const option = document.createElement('option');
        option.value = module;
        option.textContent = module;
        filterSelect.appendChild(option);
    });

    filterSelect.addEventListener('change', () => {
        const selectedModule = filterSelect.value;
        rows.forEach(row => {
            const module = row.dataset.module;
            row.style.display =
                selectedModule === 'all' || module === selectedModule ? '' : 'none';
        });
    });
});
