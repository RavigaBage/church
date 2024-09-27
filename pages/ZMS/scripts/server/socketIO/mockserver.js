// const io = require("socket.io")(5000, {
//   cors: {
//     origin: ["http://localhost:8080"],
//   },
// });
// console.log("connection success");
// io.on("connection", (socket) => {
//   console.log(socket.id);
// });

const express = require("express");
const app = express();
const port = 3000;

app.use(express.static("public"));
app.get("/api/message", (req, res) => {
  const message = req;
  res.json(message);
});
app.listen(port, () => {
  console.log("server is listening to port 3000");
});
