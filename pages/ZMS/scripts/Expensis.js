define(function () {
    var CallMethods = {};
    CallMethods.DirCalls = (dir) => {
        dirObj = {
            Filter: "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=filter",
            Update: "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=update",
            Export: "../../API/finance/data_process.php?APICALL=expenses&&user=true&&submit=export",
            Upload: "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=upload"
        }
        ObjectKeys = Object.keys(dirObj);
        if (ObjectKeys.includes(dir)) {
            return dirObj[dir];
        } else {
            return false
        }
    }

    CallMethods.PHPREQUESTFILTER = async (APIDOCS, data, ArrayTables, dn_message, loader_progress, ContentDom, numoffset, location) => {
        if (location == 'Expenses') {
            const SkeletonDom_list = document.querySelector(".skeleton_loader.list");
            const SkeletonDom_table = document.querySelector(".skeleton_loader.table");

            if (ArrayTables.location == 'Expenses') {
                DomManipulationElement = SkeletonDom_table;
            } else {
                DomManipulationElement = SkeletonDom_list;
            }
            try {
                dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                    category: document.querySelector('select[name="catfilter"]')
                        .value,
                    year: document.querySelector('select[name="yearfilter"]').value,
                    numData: numoffset
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
                        loader_progress.classList.add("active");
                        ContentDom.classList.add("load");
                        DomManipulationElement.classList.add("load");
                        bodyDisplay = document.querySelector(".records_table tbody");
                        setTimeout(() => {
                            if (data == "" || data == 'Error Occurred' || data == 'Not Records Available' || data == 'no record found') {
                                bodyDisplay.innerHTML = "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                            } else {
                                bodyDisplay.innerHTML = "";
                                dataDecode = JSON.parse(data);
                                if (dataDecode['pages'] > 40) {
                                    RestructurePages(dataDecode['pages']);
                                }
                                dataDecode = dataDecode['result'];
                                for (const key in dataDecode) {
                                    category = dataDecode[key]["category"];
                                    type = dataDecode[key]["type"];
                                    details = dataDecode[key]["details"];
                                    date = dataDecode[key]["date"];
                                    year = dataDecode[key]["year"];
                                    month = dataDecode[key]["month"];
                                    amount = dataDecode[key]["amount"];
                                    recorded_by = dataDecode[key]["recorded_by"];
                                    unique_id = dataDecode[key]["id"];
                                    ObjExport = dataDecode[key]["obj"];


                                    template = `<tr class='${category}'>
                    <td title='${details}'>
                        <p>hover to view details</p>
                    <td>
                        <p>${date}</p>
                    </td>
                    <td>
                        <p>${type}</p>
                    </td>
                    <td>
                        <p>${recorded_by}</p>
                    </td>
                    </td>
                    <td>${amount}</td>
                    <td class='delete option'>
                        <svg xmlns='http://www.w3.org/2000/svg' height='30'
                            viewBox='0 -960 960 960' width='48'>
                            <path
                                d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                        </svg>
                        <div class='opt_element'>
                            <p delete_item='${unique_id}' class='delete_item'>Delete item <i></i></p>
                            <p Update_item='${unique_id}' class='Update_item' class='' data-information='${ObjExport}'>Update item <i></i></p>
                        </div>
                    </td>
                </tr>`;
                                    bodyDisplay.innerHTML += template;


                                }
                            }
                            loader_progress.classList.remove("active");
                            ContentDom.classList.remove("load");
                            DomManipulationElement.classList.remove("load");
                        }, 200);
                    }
                } else {
                    console.error("cannot find endpoint");
                }
            } catch (error) {
                console.error(error);
            }
        }
    }

    CallMethods.PHPREQUEST = async (APIDOCS, loaderBtn, AddEventMenuForm, requestData, validateKey, MainFormDel, location) => {
        if (location == 'Expenses') {
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
                    if (data == 'success' || data == 'update success') {
                        requestData = data;
                        if (!validateKey) {
                            validateKey = "";
                        }
                        APIDOCS =
                            "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=fetchlatest";
                        const mainBody = document.querySelector('#main_table tbody');
                        if (LIVEUPDATEAVAILABLE(mainBody)) {
                            return PHPLIVEUPDATE(APIDOCS, validateKey, requestData, MainFormDel)
                        } else {
                            UrlTrace();
                        }
                    } else {
                        return false;
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
                        const mainBody = document.querySelector('#main_table tbody');
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
                    Template = document.querySelector('#main_table tbody');
                    CloneObject = document.querySelector('#CloneSearch').cloneNode(true);
                    for (const key in ObjectDataFrame) {
                        category = ObjectDataFrame[key]['category'];
                        type = ObjectDataFrame[key]['type'];
                        details = ObjectDataFrame[key]['details'];
                        date = ObjectDataFrame[key]['date'];
                        year = ObjectDataFrame[key]['year'];
                        month = ObjectDataFrame[key]['month'];
                        amount = ObjectDataFrame[key]['amount'];
                        recorded_by = ObjectDataFrame[key]['recorded_by'];
                        unique_id = ObjectDataFrame[key]['id'];
                        ObjectData = ObjectDataFrame[key]['obj'];

                        if (CloneObject != '') {
                            CloneObject.classList.add(category)
                            CloneObject.querySelector('.Clonedate').innerText = date;
                            CloneObject.querySelector('.Clonedeatils').setAttribute('title', details);
                            CloneObject.querySelector('.Clonetype').innerHTML = type;
                            CloneObject.querySelector('.Cloneamount').innerText = amount;
                            CloneObject.querySelector('.Clonerecord').innerText = recorded_by;
                            CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                            CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', unique_id);
                            CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', unique_id);

                            Template.prepend(CloneObject);
                            if (requestData == 'update success') {
                                const FormElement = MainFormDel;
                                FormElement.classList.add('hide');
                                validateKey = '';
                                return [true, CloneObject];
                            }
                            OptionElements = document.querySelectorAll(".option");
                            const element = CloneObject.querySelector('.option');
                            element.addEventListener("click", function () {
                                var ElementOptions = element.querySelector(".opt_element");
                                ElementOptions.classList.add("active");
                            });
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


    CallMethods.UpdateItemExpensesFunction = async (value) => {
        AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);
        document.querySelector(
            '.event_menu_add select[name="category"]'
        ).value = newObject["category"];
        document.querySelector(
            '.event_menu_add input[name="Amount"]'
        ).value = newObject["amount"];

        document.querySelector('.event_menu_add input[name="Date"]').value =
            newObject["date"];
        document.querySelector(
            '.event_menu_add select[name="type"]'
        ).value = newObject["type"];
        document.querySelector(
            '.event_menu_add textarea[name="details"]'
        ).value = newObject["details"];
        document.querySelector(
            '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");

    }
    CallMethods.DeleteItemFunction = async (value, validateKey, ResponseView, MainFormDel, location) => {
        if (value == "true" && typeof validateKey == 'string' && validateKey.length > 4 && location == 'Expenses') {
            APIDOCS =
                "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=delete";
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
