importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js')

const firebaseConfig = {
    apiKey           : "AIzaSyD7QrrbSfbRvY-5E7XOhvhLL7xP98yBfYo",
    authDomain       : "sistemaonline-79c63.firebaseapp.com",
    projectId        : "sistemaonline-79c63",
    messagingSenderId: "980417301714",
    appId            : "1:980417301714:web:594c3043272dcddc31f10b"
};

const app       = firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();


messaging.onBackgroundMessage(function (payload) {
    if (!payload.hasOwnProperty('notification')) {
        const notificationTitle = payload.data.title;
        const notificationOptions = {
            body : payload.data.body,
            icon : payload.data.icon,
            image: payload.data.image
        }
        self.registration.showNotification(notificationTitle, notificationOptions);
    }
})
