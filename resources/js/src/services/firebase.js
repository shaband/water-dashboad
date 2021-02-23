import firebase from 'firebase/app'
import 'firebase/messaging'

const firebaseConfig = {
    apiKey: process.env.MIX_FCM_KEY,
    authDomain: `${process.env.MIX_FCM_PROJECT_ID}.firebaseapp.com`,
    databaseURL: `https://${process.env.MIX_FCM_PROJECT_ID}.firebaseio.com`,
    projectId: process.env.MIX_FCM_PROJECT_ID,
    storageBucket: `${process.env.MIX_FCM_PROJECT_ID}.appspot.com`,
    messagingSenderId: process.env.MIX_FCM_SENDER_ID,
    appId: process.env.MIX_FCM_APP_ID,
    measurementId: process.env.MIX_FCM_MEASUREMENT_ID
}


firebase.initializeApp(firebaseConfig)
export const messeging = firebase.messaging()

export function  generateToken(){
 return  messaging.getToken(process.env.MIX_FCM_VOIP)
}
