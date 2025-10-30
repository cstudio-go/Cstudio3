import { db } from "./firebase.js";
import {
  collection,
  addDoc,
  onSnapshot,
  orderBy,
  query,
  serverTimestamp
} from "https://www.gstatic.com/firebasejs/12.4.0/firebase-firestore.js";

// Use a unique ID for each post (you can change this dynamically)
const postId = "post1";

const commentList = document.getElementById("comment-list");
const form = document.getElementById("comment-form");

// Listen for new comments (real-time)
const q = query(
  collection(db, "posts", postId, "comments"),
  orderBy("timestamp", "asc")
);

onSnapshot(q, (snapshot) => {
  commentList.innerHTML = "";

  snapshot.forEach((doc) => {
    const c = doc.data();
    const time =
      c.timestamp?.toDate
        ? new Date(c.timestamp.toDate()).toLocaleString()
        : "Just now"; // Prevent crash if timestamp missing

    const div = document.createElement("div");
    div.innerHTML = `
      <p style="margin-bottom: 8px;">
        <strong>${c.author}</strong>: ${c.content} <br>
        <em style="font-size: small; color: gray;">${time}</em>
      </p>
      <hr>
    `;
    commentList.appendChild(div);
  });
});

// Add new comment
form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const author = document.getElementById("author").value.trim();
  const content = document.getElementById("content").value.trim();
  if (!author || !content) return alert("Please fill out all fields!");

  try {
    await addDoc(collection(db, "posts", postId, "comments"), {
      author,
      content,
      timestamp: serverTimestamp()
    });
    form.reset();
  } catch (err) {
    console.error("Error adding comment:", err);
    alert("Failed to post comment. Please try again.");
  }
});