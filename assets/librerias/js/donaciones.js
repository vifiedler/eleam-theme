/**
 * Formulario de aporte (página Contribuye).
 * - Botones de frecuencia y monto: solo uno activo por grupo (aria-pressed).
 * - Guarda la elección en los campos ocultos "frecuencia" y "monto".
 * - "Otro monto" muestra un campo numérico.
 */
document.querySelectorAll('.formulario-aporte').forEach(function (formulario) {
  var campoOtro = formulario.querySelector('#campo-otro-monto');
  var inputOtro = formulario.querySelector('#otro-monto');

  formulario.querySelectorAll('[data-grupo]').forEach(function (grupo) {
    var nombre = grupo.getAttribute('data-grupo');
    var oculto = formulario.querySelector('input[type="hidden"][name="' + nombre + '"]');

    grupo.addEventListener('click', function (e) {
      var boton = e.target.closest('button[data-valor]');
      if (!boton) return;

      grupo.querySelectorAll('button[data-valor]').forEach(function (b) {
        b.setAttribute('aria-pressed', b === boton ? 'true' : 'false');
      });

      var valor = boton.getAttribute('data-valor');
      if (oculto) oculto.value = valor;

      if (nombre === 'monto' && campoOtro && inputOtro) {
        var esOtro = valor === 'otro';
        campoOtro.hidden = !esOtro;
        inputOtro.required = esOtro;
        if (esOtro) inputOtro.focus();
      }
    });
  });
});
