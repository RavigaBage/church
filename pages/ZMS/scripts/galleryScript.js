////fixed do not touch 
Selectimages = {};
var Gal_APIDOCS = "";
let Gal_TempFiles = 1;
var Gal_validateKey = "";
var Gal_MainFormDel = "";
let MediaFilenames = [];
let Update_trigger = false;
let Gal_total = 1;
const Gal_dn_message = document.querySelector(".dn_message");

const Gal_confirmsBtns = document.querySelectorAll(".btn_confirm");
const Gal_AddEventBtn = document.querySelector(".add_event");
const Gal_SubmitForm = document.querySelector(".event_menu_add.form_data form");
const Gal_ResponseView = document.querySelector(".info_information.event_menu_add");
const Gal_Export_variables = document.querySelector('#ExportBtn');
const Gal_Export_variables_Dialogue = document.querySelector('.export_dialogue');
const Gal_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
const Gal_Export_variables_Dialogue_Form = Gal_Export_variables_Dialogue.querySelector("form");
const Gal_Loader = document.querySelector('#mainform_wrapper');
const Gal_AddEventMenu = document.querySelector(".event_menu_add.form_data");
const Gal_OptionElements = document.querySelectorAll(".option");

ArrayList = document.querySelectorAll('.event_menu_add select[name="category"] option');
ListFine = [];
ArrayList.forEach(element => {
    ListFine.push(element.innerHTML);
})
ListFine.sort();
document.querySelector('.event_menu_add select[name="category"]').innerHTML = "";

ListFine.forEach(element => {
    document.querySelector('.event_menu_add select[name="category"]').innerHTML += `<option>${element}</option>`;
})


if (location_updator() == "Gallery") {
    r.assignBrowse(document.getElementById('browseButton'));
    r.on('filesAdded', function (array) {
        document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
    });
    document.getElementById('browseButton').addEventListener('click', function () {
        r.cancel();
    });
}
Gal_AddEventBtn.addEventListener("click", function (e) {
    Gal_AddEventMenu.classList.add("active");
    document.querySelector('#browseButton span').textContent = "Select file to Upload";
});

Gal_OptionElements.forEach((element) => {
    element.addEventListener("click", function () {
        const Gal_ElementOptions = element.querySelector(".opt_element");
        if (Gal_ElementOptions != null) {
            Gal_ElementOptions.classList.add("active");
        }
    });
});
window.addEventListener("click", function (e) {
    if (location_updator() == 'Gallery') {
        var Gal_target = e.target;
        if (Gal_Export_variables_Dialogue.classList.contains('active') && !Gal_Export_variables.contains(Gal_target)) {
            if (!Gal_Export_variables_Dialogue.contains(Gal_target)) {
                Gal_Export_variables_Dialogue.classList.remove('active')
            }
        }
        if (!Gal_ResponseView.contains(Gal_target) && !Gal_target.classList.contains('btn_confirm')) {
            if (Gal_ResponseView.classList.contains('active')) {
                Gal_ResponseView.classList.remove('active');
                Gal_ResponseView.querySelector('header').textContent = "";
            }
        }
        const Gal_Pages = document.querySelectorAll(".pages div");
        var Gal_OptionElements = document.querySelectorAll(".option");
        if (Gal_AddEventMenu.classList.contains("active") && !Gal_AddEventBtn.contains(Gal_target)) {
            if (!Gal_AddEventMenu.contains(Gal_target)) {
                Gal_AddEventMenu.classList.remove("active");
                Gal_Loader.querySelector('.text p').textContent = "";
                Update_trigger = false;
            }
        }
        Gal_OptionElements.forEach((element) => {
            const ElementOptions = element.querySelector(".opt_element");
            if (ElementOptions != null) {
                if (ElementOptions.classList.contains("active") && !element.contains(Gal_target)) {
                    if (!ElementOptions.contains(Gal_target)) {
                        ElementOptions.classList.remove("active");
                    }
                } else {
                    Gal_MainBody = document.querySelectorAll('#main_table tbody tr');
                    if (Gal_MainBody) {
                        Gal_MainBody.forEach(element => {
                            if (element.contains(Gal_target)) {
                                Gal_MainFormDel = element;
                            }
                        })
                        if (Gal_target.classList.contains("Update_item") && element.contains(Gal_target)) {
                            Gal_validateKey = Gal_target.getAttribute("data-id");
                            Gal_UpdateItemFunction(Gal_target);
                            ElementOptions.classList.remove("active");
                        }
                        if (Gal_target.classList.contains("delete_item") && element.contains(Gal_target)) {
                            Gal_validateKey = Gal_target.getAttribute("data-id");
                            Gal_dn_message.classList.add('active');
                            ElementOptions.classList.remove("active");
                        }
                    }


                }
            }
        });
        Gal_Pages.forEach((element) => {
            if (element.contains(Gal_target)) {
                Gal_value = element.innerHTML;
                pagnationSystem(Gal_value);
            }
        });
    }
});

Gal_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
    e.preventDefault();
});
Gal_Export_variables.onclick = function () {
    Gal_Export_variables_Dialogue.classList.add("active");
};
Gal_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
    Gal_APIDOCS = "../../API/gallery/data_process.php?APICALL=true&&user=true&&submit=export";
    ExportData('GalleryExport', 'excel', Gal_APIDOCS)
});

Gal_confirmsBtns.forEach((element) => {
    element.addEventListener("click", (e) => {
        if (element.getAttribute("data-confirm") == "true") {
            if (Gal_validateKey != "") {
                Gal_DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    Gal_validateKey
                );
            }
        }
    });
});
acceptedExtension = ['jpg', 'png', 'jpeg'];
Gal_SubmitForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    Gal_Loader.classList.add('play');
    Gal_Loader.classList.remove('active');
    setTimeout(() => {
        permission = true;
        if (Update_trigger && r.files.length == 0) {
            Gal_PHPREQUEST(Gal_APIDOCS);
            document.querySelector('#browseButton span').textContent = `Select a file to upload`;
            r.cancel();
            MediaFilenames = [];
        } else {
            if (r.files.length > 0) {
                r.files.forEach(element => {
                    if (acceptedExtension.includes(element.file.name.split('.')[1].toLowerCase())) {
                        MediaFilenames.push(element.file.name);
                    } else {
                        permission = false;
                    }
                })
                Gal_total = MediaFilenames.length;
            } else {
                Gal_Loader.classList.add('active');
                Gal_Loader.querySelector('.text p').textContent = "Select a file to upload !!";

            }

            if (permission) {
                if (MediaFilenames.length > 0) {
                    if (MediaFilenames.length > 1 && Update_trigger) {
                        Gal_Loader.classList.add('active');
                        Gal_Loader.querySelector('.text p').textContent = "You can only upload a single file during update";

                    } else {
                        r.upload();
                        r.on('complete', function () {
                            Gal_PHPREQUEST(Gal_APIDOCS);
                            document.querySelector('#browseButton span').textContent = `Select a file to upload`;
                            r.cancel();
                            MediaFilenames = [];
                        });
                    }

                }
            } else {
                Gal_Loader.classList.add('active');
                Gal_Loader.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
            }
        }

    }, 400)




});
Gal_AddEventBtn.addEventListener("click", function (e) {
    Gal_APIDOCS = "../../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=true";
    Gal_validateKey = "";
});
function Gal_UpdateItemFunction(value) {
    const Gal_AddEventMenu = document.querySelector(".event_menu_add.form_data");
    let Gal_newObject = value.getAttribute("data-information");
    Gal_newObject = JSON.parse(Gal_newObject);

    document.querySelector(
        '.event_menu_add input[name="event_name"]'
    ).value = Gal_newObject["Eventname"];

    document.querySelector(
        '.event_menu_add input[name="date"]'
    ).value = Gal_newObject["date_uploaded"];
    document.querySelector(
        '.event_menu_add select[name="category"]'
    ).value = Gal_newObject["category"];
    document.querySelector(
        '.event_menu_add input[type="file"]'
    ).value = "";
    document.querySelector(
        '.event_menu_add input[name="delete_key"]'
    ).value = Gal_newObject["UniqueId"];
    setTimeout(() => {
        Gal_AddEventMenu.classList.add("active");
    }, 100);

    Gal_APIDOCS =
        "../../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=update_file";
    Update_trigger = true;
}
function Gal_DeleteItemFunction(value, Gal_validateKey) {
    if (value == "true" && location_updator() == 'Gallery') {
        Gal_API = "../../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=delete_file";
        Gal_PHPREQUESTDEL(Gal_API, Gal_validateKey);
    }
}

async function Gal_PHPREQUEST(Gal_APIDOCS) {
    if (location_updator() == 'Gallery') {
        let Gal_data;
        try {
            const formMain = new FormData(Gal_SubmitForm);
            formMain.append("fileNames", JSON.stringify(MediaFilenames));

            const Request = await fetch(Gal_APIDOCS, {
                method: "POST",
                body: formMain,
            });

            if (Request.status === 200) {
                Gal_data = await Request.json();
                if (Gal_data) {
                    Gal_data = Gal_data.toLowerCase();

                    Gal_Loader.querySelector('.text p').textContent = Gal_data;
                    if (Gal_data == 'upload was a success' || Gal_data == 'update was a success') {
                        Gal_Loader.querySelector('.text p').textContent = Gal_data;
                        Gal_APIDOCS = "../../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=fetchLatest";
                        if (!Gal_validateKey) {
                            Gal_validateKey = "";
                        }
                        Gal_PHPLIVEUPDATE(Gal_APIDOCS, Gal_validateKey, Gal_total, Gal_data);
                        r.cancel();
                        Gal_Loader.classList.remove('play');
                        Gal_Loader.classList.add('active');
                    } else {
                        Gal_Loader.classList.remove('play');
                        Gal_Loader.classList.add('active');
                    }
                }
            } else {
                Gal_Loader.classList.remove('play');
                Gal_Loader.classList.add('active');
                Gal_Loader.querySelector('.text p').textContent = 'An error occured please again later';
            }
        } catch (error) {
            Gal_Loader.classList.remove('play');
            Gal_Loader.classList.add('active');
            console.error(error);
        }
    }

}
async function Gal_PHPREQUESTDEL(Gal_APIDOCS, Gal_validateKey) {
    const Gal_loader_response = Gal_ResponseView.querySelector('.loader_wrapper');
    if (location_updator() == 'Gallery') {
        let Gal_data;
        Gal_loader_response.classList.add('play');
        Gal_loader_response.classList.remove('active');
        try {
            Gal_ResponseView.classList.add('active');
            dataSend = {
                key: Gal_validateKey,
            };
            const Request = await fetch(Gal_APIDOCS, {
                method: "POST",
                body: JSON.stringify(dataSend),
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (Request.status === 200) {
                Gal_data = await Request.json(Gal_data);

                if (Gal_data) {
                    if (Gal_data == 'Item Deleted Successfully') {
                        Gal_MainFormDel.classList.add('none')
                        Gal_ResponseView.querySelector('header').textContent = "Delete was a success";
                        Gal_validateKey = '';
                        Gal_loader_response.classList.remove('play');
                        Gal_loader_response.classList.add('active');
                    }
                } else {
                    Gal_loader_response.classList.add('play');
                    Gal_loader_response.classList.remove('active');
                }
            } else {
                Gal_loader_response.classList.add('play');
                Gal_loader_response.classList.remove('active');
                console.error("cannot find endpoint");
            }
        } catch (error) {
            console.error(error);
        }
    }

}
async function Gal_PHPLIVEUPDATE(Gal_APIDOCS, Gal_validateKey, Gal_total, resquest_response) {
    if (location_updator() == 'Gallery') {
        let Gal_data;
        if (!Gal_total >= 10) {
            alert('You have uploaded a large number of file, please stand by for manual refresh');
            location.href = 'http://localhost/database/church/pages/ZMS/#Gallery'
        }
        try {
            dataSend = {
                key: Gal_validateKey,
                limit: Gal_total
            };
            const Request = await fetch(Gal_APIDOCS, {
                method: "POST",
                body: JSON.stringify(dataSend),
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (Request.status === 200) {
                Gal_data = await Request.json(Gal_data);
                if (Gal_data) {
                    if (typeof Gal_data == 'object') {
                        ConvertJson = Gal_data;
                        const tableCell = document.querySelector('.membership_table table tbody');
                        for (const key in ConvertJson) {
                            const element = ConvertJson[key];
                            ElementCreate = document.createElement('tr');
                            unique_id = element['UniqueId'];
                            Eventname = element['Eventname'];
                            imageName = element['name'];
                            date_uploaded = element['date_uploaded'];
                            category = element['category'];
                            ObjectData = element['Obj'];
                            const CloneObject = document.querySelector('#livetemplate').cloneNode(true);
                            if (CloneObject != '') {
                                CloneObject.querySelector('.Clonefilename').innerText = imageName;
                                CloneObject.querySelector('.CloneEventname').innerText = Eventname;
                                CloneObject.querySelector('.CloneImage').setAttribute('src', `../../API/Images_folder/gallery/${imageName}`);
                                CloneObject.querySelector('.downloadp').setAttribute('href', `../../API/Images_folder/gallery/${imageName}`);
                                CloneObject.querySelector('.CloneDate').innerText = date_uploaded;
                                CloneObject.querySelector('.CloneCategory').innerText = category;
                                CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                                CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                                CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                                tableCell.prepend(CloneObject);
                                CloneObject.setAttribute('id', false);
                                OptionElements = document.querySelectorAll(".option");
                                const element = CloneObject.querySelector('.option');
                                element.addEventListener("click", function () {
                                    var ElementOptions = element.querySelector(".opt_element");
                                    ElementOptions.classList.add("active");
                                });
                                if (resquest_response == 'update was a success') {
                                    if (Gal_MainFormDel != null) {
                                        Gal_MainFormDel.classList.add('hide');
                                        Gal_MainFormDel = CloneObject;
                                    }
                                }

                            }
                        }

                    }
                }
            } else {
                console.error("cannot find endpoint");
            }
        } catch (error) {
            console.error(error);
        }
    }

}

function location_updator() {
    return (window.location.hash.replace("#", ""));
}