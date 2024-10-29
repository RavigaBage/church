define(function () {
    var CallMethods = {};
    CallMethods.DirCalls = (dir) => {
        dirObj = {
            Filter: "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=filter",
            Update: "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=update",
            Export: "../../API/finance/data_process.php?APICALL=Tithe&&user=true&&submit=export",
            Upload: "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=upload",
            Search: "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=search"
        }
        ObjectKeys = Object.keys(dirObj);
        if (ObjectKeys.includes(dir)) {
            return dirObj[dir];
        } else {
            return false
        }
    }
    CallMethods.PHPREQUEST = async (APIDOCS, loaderBtn, AddEventMenuForm, requestData, validateKey, MainFormDel, location) => {
        if (location == 'Tithe') {
            let data;
            loaderBtn.classList.add('play');
            loaderBtn.classList.remove('active');
            try {
                const formMain = new FormData(AddEventMenuForm);

                const Request = await fetch(APIDOCS, {
                    method: "POST",
                    body: formMain,
                });

                if (Request.status === 200) {
                    data = await Request.json();
                    loaderBtn.classList.remove('play');
                    loaderBtn.classList.add('active');
                    loaderBtn.querySelector('.text p').textContent = data;
                    data = data.toLowerCase();
                    requestData = data;
                    if (data == 'success' || data == 'update success') {
                        APIDOCS =
                            "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=fetchlatest";
                        if (!validateKey) {
                            validateKey = "";
                        }

                        const mainBody = document.querySelector('.records_table tbody');
                        if (LIVEUPDATEAVAILABLE(mainBody)) {
                            return PHPLIVEUPDATE(APIDOCS, validateKey, requestData, MainFormDel)
                        } else {
                            UrlTrace();
                        }
                    }
                } else {
                    loaderBtn.classList.remove('play');
                    loaderBtn.classList.add('active');
                    loaderBtn.querySelector('.text p').textContent = "invalid link directory";
                }
            } catch (error) {
                loaderBtn.classList.remove('play');
                loaderBtn.classList.add('active');
                loaderBtn.querySelector('.text p').textContent = error;
                return false
            }
        }
    }
    async function PHPREQUESTDEL(APIDOCS, validateKey, ResponseView, MainFormDel) {
        let data;

        try {
            ResponseView.classList.add('active');
            dataSend = {
                key: validateKey,
            };
            const Request = await fetch(APIDOCS, {
                method: "POST",
                body: JSON.stringify(dataSend),
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (Request.status === 200) {
                data = await Request.json(data);
                if (data) {
                    if (data == 'Item Deleted Successfully') {
                        if (MainFormDel.tagName == 'TR') {
                            MainFormDel.classList.remove('cloneSearch');
                            MainFormDel.classList.add('hide');
                            ResponseView.innerText = data;
                            MainFormDel = "";
                            validateKey = '';
                        }
                        const mainBody = document.querySelector('.records_table tbody');
                        if (!LIVEUPDATEAVAILABLE(mainBody)) {
                            UrlTrace();
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
    async function PHPLIVEUPDATE(APIDOCS, validateKey, requestData, MainFormDel) {
        let data;
        try {
            dataSend = {
                key: validateKey
            };
            const Request = await fetch(APIDOCS, {
                method: "POST",
                body: JSON.stringify(dataSend),
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (Request.status === 200) {
                data = await Request.json(data);

                if (data != '' || data != ' ' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = document.querySelector('.records_table table tbody');
                    CloneObject = document.querySelector('.CloneSearch').cloneNode(true);
                    for (const key in ObjectDataFrame) {
                        namer = ObjectDataFrame[key]['Name'];
                        amount = ObjectDataFrame[key]['Amount'];
                        Date = ObjectDataFrame[key]['Date'];
                        namer = ObjectDataFrame[key]['id'];
                        medium = ObjectDataFrame[key]['medium'];
                        detais = ObjectDataFrame[key]['details'];
                        gender = ObjectDataFrame[key]['gender'];
                        contact = ObjectDataFrame[key]['contact'];
                        Email = ObjectDataFrame[key]['Email'];
                        ObjectData = ObjectDataFrame[key]['Obj'];

                        const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                        if (CloneObject != '') {
                            const ElementDivCone = document.createElement('tr');
                            ElementDivCone.classList.add('SearchItem');

                            CloneObject.querySelector('.Cloneemail').innerText = Email;
                            CloneObject.querySelector('.Clonedate').innerText = Date;
                            CloneObject.querySelector('.Clonegender').innerText = gender;
                            CloneObject.querySelector('.Clonecontact').innerText = contact;
                            CloneObject.querySelector('.Cloneamount').innerText = amount;
                            CloneObject.querySelector('.Clonemedium').innerText = medium;
                            CloneObject.querySelector('.Clonecontact').innerText = contact;
                            CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                            CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', namer);
                            CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', namer);
                            ElementDivCone.innerHTML = CloneObject.innerHTML;
                            Template.prepend(ElementDivCone);
                            if (requestData == 'update success') {
                                const FormElement = MainFormDel;
                                FormElement.classList.add('hide');
                                return [true, ElementDivCone]
                            }
                            OptionElements = document.querySelectorAll(".option");
                            const element = ElementDivCone.querySelector('.option');
                            element.addEventListener("click", function () {
                                var ElementOptions = element.querySelector(".opt_element");
                                ElementOptions.classList.add("active");

                            });
                        } else {
                            return false;
                        }
                    }

                }

            } else {
                console.error("cannot find endpoint");
                return false
            }
        } catch (error) {
            console.error(error);
            return false
        }
    }
    CallMethods.UpdateItemFunction = async (value) => {
        Tithe_AddEventMenu = document.querySelector(".event_menu_add.form_data");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);
        console.log(newObject);
        document.querySelector(
            '.event_menu_add select[name="Name"]'
        ).value = newObject["Name"];
        document.querySelector(
            '.event_menu_add input[name="amount"]'
        ).value = newObject["Amount"];
        document.querySelector(
            '.event_menu_add select[name="medium"]'
        ).value = newObject["medium"];
        document.querySelector(
            '.event_menu_add textarea[name="details"]'
        ).value = newObject["details"];

        document.querySelector('.event_menu_add input[name="Date"]').value =
            newObject["Date"];
        document.querySelector(
            '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        APIDOCS =
            "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=update";
        Tithe_AddEventMenu.classList.add("active");

    }
    CallMethods.DeleteItemFunction = async (value, validateKey, ResponseView, MainFormDel, location) => {
        if (value == "true" && typeof validateKey == 'string' && validateKey.length > 4 && location == 'Tithe') {
            APIDOCS =
                "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=delete";
            PHPREQUESTDEL(APIDOCS, validateKey, ResponseView, MainFormDel);
        }
    }

    function LIVEUPDATEAVAILABLE(mainBody) {
        clearance = false;
        const ChildrenNodes = mainBody.querySelectorAll('tr');
        if (ChildrenNodes.length > 1) {
            ChildrenNodes.forEach(element => {
                if (element.classList.contains('none')) {
                    clearance = false

                } else {
                    clearance = true
                    return clearance
                }
            })
        }

        return clearance
    }
    return CallMethods;
});
