document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-alugar');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Para alugar um veículo, faça login ou cadastre-se!');
        });
    });
});
