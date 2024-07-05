if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('./public/sw.js')
    .then(reg => console.log('Registro de SW exitoso', reg))
    .catch(err => console.warn('Error al tratar de registrar el sw', err))
}
//registrar sw firebae
/*
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('./public/firebase-messaging-sw.js')
    .then(reg => console.log('Registro de FB exitoso', reg))
    .catch(err => console.warn('Error al tratar de registrar el FB', err))
}
*/