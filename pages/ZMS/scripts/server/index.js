import * as UpChunk from "/node_modules/@mux/upchunk/dist/upchunk";

// const webSocket = require("ws");

// const wss = new webSocket.Server({ port: 8082 });

// wss.on("connection", (ws) => {
//   console.log("Client connected to websocket");
//   ws.on("message", (data) => {
//     Message = data.toString();
//     console.log(`client has sent message: ${Message}`);
//     ws.send(Message.toUpperCase());
//   });

//   ws.on("close", () => {
//     console.log("Connection close");
//   })
// });

// Pretend you have an HTML page with an input like: <input id="picker" type="file" />
const picker = document.getElementById("picker");

picker.onchange = (e) => {
  var Reader = new FileReader();
  var filePath = "../../Membership/membership.txt";
  console.log(picker.files[0], filePath);
  const getUploadUrl = () =>
    fetch(filePath).then((res) =>
      res.ok ? res.text() : new Error("Error getting an upload URL :(")
    );

  const upload = UpChunk.createUpload({
    endpoint: getUploadUrl,
    file: picker.files[0],
    chunkSize: 30720, // Uploads the file in ~30 MB chunks
  });

  // subscribe to events
  upload.on("error", (err) => {
    console.error("💥 🙀", err.detail);
  });

  upload.on("progress", (progress) => {
    // Calc = progress.detail / 100;
    // document.querySelector("progress").value = Calc;
    console.log(`So far we've uploaded ${progress.detail}% of this file.`);
  });

  upload.on("success", () => {
    console.log("Wrap it up, we're done here. 👋");
  });
};
