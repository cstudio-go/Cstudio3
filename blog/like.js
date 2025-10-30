import { db } from "./firebase.js";
import { doc, getDoc, updateDoc, setDoc, increment, onSnapshot } 
  from "https://www.gstatic.com/firebasejs/12.4.0/firebase-firestore.js";

// Get the post ID for this page
const postId = window.postId
if (!postId) throw new Error("window.postId is not defined before like.js runs!");

// Reference to this post in Firestore
const postRef = doc(db, "posts", postId);

// DOM elements
const likeBtn = document.getElementById("like-btn");
const likeCount = document.getElementById("like-count");

// Listen for real-time updates to like count
onSnapshot(postRef, (docSnap) => {
  if (docSnap.exists()) {
    likeCount.textContent = docSnap.data().likes || 0;
  } else {
    likeCount.textContent = 0;
  }
});

// When like button is clicked
likeBtn.addEventListener("click", async () => {
  const docSnap = await getDoc(postRef);
  if (docSnap.exists()) {
    await updateDoc(postRef, { likes: increment(1) });
  } else {
    await setDoc(postRef, { likes: 1 });
  }
});
