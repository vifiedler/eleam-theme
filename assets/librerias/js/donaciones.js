  document.querySelectorAll('.opciones-aporte').forEach(function (grupo) {
      grupo.addEventListener('click', function (e) {
        var boton = e.target.closest('button');
        if (!boton) return;
        grupo.querySelectorAll('button').forEach(function (b) {
          b.setAttribute('aria-pressed', b === boton ? 'true' : 'false');
        });
      });
    });