import io from "socket.io-client";

console.log("HELLO WORLD TEST JS");
const socket = io("http://localhost:5000");
socket.on("connect", () => {
  console.log(`Connection was a success here is your id: ${socket.id}`);
});
