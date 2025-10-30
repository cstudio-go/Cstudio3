// firebase.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-app.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-firestore.js";

const firebaseConfig = {
  apiKey: "AIzaSyDvTWO_Y_HexnByUFhMCmdHwdLxU2WNkUo",
  authDomain: "cstudio-comment.firebaseapp.com",
  projectId: "cstudio-comment",
  storageBucket: "cstudio-comment.firebasestorage.app",
  messagingSenderId: "613826664005",
  appId: "1:613826664005:web:8ddb0b6f86c9a03ccf352c",
  measurementId: "G-3H07QFV5LJ"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
export const db = getFirestore(app);