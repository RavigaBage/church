const express = require("express");
const router = express.Router();
const XLSX = require('xlsx');



router.post("/ExportExcel",  (req, res) => {
  try {
    filename = req.filename
    ConvertData = req.filedata;
    
    
  } catch (error) {
    res.status(500).json({ error: "Registration failed" });
  }




});


module.exports = router;
