document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.confirm_delete').forEach(element => {
        element.addEventListener('click', (e) => {
            if(! confirm('Etes vous sûr de vouloir supprimer cet utilisateur ?')) {
                e.preventDefault();
            }
        });
    });
});