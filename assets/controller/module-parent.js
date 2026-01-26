document.addEventListener('DOMContentLoaded', () => {
    const blocSelect = document.querySelector('#module_blocEnseignement');
    const parentSelect = document.querySelector('#module_parent');

    if (!blocSelect || !parentSelect) return;

    // Désactive le champ parent au début
    parentSelect.disabled = true;

    blocSelect.addEventListener('change', async () => {
        const blocId = blocSelect.value;
        parentSelect.innerHTML = '<option value="">Chargement...</option>';

        if (!blocId) {
            parentSelect.innerHTML = '<option value="">Sélectionnez d’abord un bloc</option>';
            parentSelect.disabled = true;
            return;
        }

        try {
            const response = await fetch(`/module/parents-by-bloc/${blocId}`);
            const modules = await response.json();

            parentSelect.innerHTML = '<option value="">Aucun parent</option>';

            modules.forEach(m => {
                const option = document.createElement('option');
                option.value = m.id;
                option.textContent = m.nom;
                parentSelect.appendChild(option);
            });

            parentSelect.disabled = false;
        } catch (error) {
            console.error('Erreur lors du chargement des modules parents :', error);
            parentSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        }
    });
});
