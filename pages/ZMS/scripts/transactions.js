define(function () {
    var CallMethods = {};
    CallMethods.DirCalls = (dir) => {
        dirObj = {
            Filter: "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=filter",
            Update: "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=update",
            Export: "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=export",
            Upload: "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=upload"
        }
        ObjectKeys = Object.keys(dirObj);
        if (ObjectKeys.includes(dir)) {
            return dirObj[dir];
        } else {
            return false
        }
    }
    CallMethods.PHPREQUEST = async (APIDOCS, loaderBtn, AddEventMenuForm, validateKey, MainFormDel, location) => {
        if (location == 'Transaction') {
            loaderBtn.classList.add('play');
            loaderBtn.classList.remove('active');
            let data;
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
                        requestData = data
                        APIDOCS = "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=fetchlatest";
                        if (!validateKey) {
                            validateKey = "";
                        }
                        return PHPLIVEUPDATE(APIDOCS, validateKey, requestData, MainFormDel);

                    } else {
                        return false
                    }
                } else {
                    loaderBtn.classList.remove('play');
                    loaderBtn.classList.add('active');
                    loaderBtn.querySelector('.text p').textContent = "invalid link directory";
                    return false
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
        ResponseView = document.querySelector(".info_information.event_menu_add");
        ResponseView.innerText = "";
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
                data = data.toLowerCase();
                if (data == 'item deleted successfully') {
                    ResponseView.innerText = data;
                }
                return data
            } else {
                console.error("cannot find endpoint");
            }
        } catch (error) {
            console.error(error);
        }
        return false


    }
    CallMethods.PHPREQUESTFILTER = async (APIDOCS, data, ArrayTables, dn_message, loader_progress, ContentDom, SearchTrigger, numoffset, location) => {
        if (location == 'Transaction') {
            const SkeletonDom_list = document.querySelector(".skeleton_loader.list");
            const SkeletonDom_table = document.querySelector(".skeleton_loader.table");

            if (ArrayTables.includes(location)) {
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
                    account: document.querySelector('select[name="accfilter"]')
                        .value,
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
                        bodyDisplay = document.querySelector(".records_table #main_table tbody");
                        setTimeout(() => {
                            if (data == "" || data == 'Error Occurred' || data == 'Not Records Available') {
                                bodyDisplay.innerHTML = "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                            } else {
                                bodyDisplay.innerHTML = "";
                                dataDecode = data;
                                if (dataDecode['pages'] > 40) {
                                    ConvertPages = dataDecode['pages'];
                                    RestructurePages(ConvertPages);
                                } else {
                                    document.querySelector(".page_sys").classList.add('hide');
                                }
                                dataDecode = dataDecode['result'];
                                if (Object.keys(dataDecode).length > 0) {
                                    for (const key in dataDecode) {
                                        account = dataDecode[key]["account"];
                                        amount = dataDecode[key]["amount"];
                                        date = dataDecode[key]["Date"];
                                        category = dataDecode[key]["category"];
                                        Authorize = dataDecode[key]["Authorize"];
                                        Status = dataDecode[key]["Status"];
                                        id = dataDecode[key]["id"];
                                        ObjectData = dataDecode[key]["obj"];

                                        if (Status == 'terminated') {
                                            item = "<div class='out_btn'><div></div>" + Status + "</div>";
                                        } else
                                            if (Status == 'pending') {
                                                item = "<div class='in_btn blue'><div></div>" + Status + "</div>";
                                            } else {
                                                item = "<div class='in_btn'><div></div>" + Status + "</div>";
                                            }

                                        template = `<tr>
                          <td><div class='details'>

                          <div class='text'>
                          <p>${account}</p>
                          <p>${date}</p>
                          </div>

                          </div></td>
                          <td>${item}</td>
                          <td>${Authorize}</td>
                          <td>${amount}</td>
                          <td>${category}</td>
                          <td class='option'>
                              <div class='delete option'>
                                      <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                          width='30'>
                                          <path
                                              d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                      </svg>
                                      <div class='opt_element'>
                                          <p class='update_item' Update_item='${id}' data-information='${ObjectData}'>Update item <i></i></p>
                                          <p class='delete_item' delete_item='${id}' >Delete item <i></i></p>
                                      </div>
                              </div>
                          </td>
                      </tr>`;
                                        bodyDisplay.innerHTML += template;


                                    }
                                    SearchTrigger = true;
                                    var OptionElement_r = document.querySelectorAll(".option");
                                    OptionElements = document.querySelectorAll(".delete.option");
                                    OptionElement_r.forEach((element) => {
                                        element.addEventListener("click", function () {
                                            var ElementOptions = element.querySelector(".opt_element");
                                            if (ElementOptions != null) {
                                                ElementOptions.classList.add("active");
                                            }
                                        });
                                    });
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
    async function PHPLIVEUPDATE(APIDOCS, validateKey, requestData, MainFormDel) {
        let data;
        try {
            dataSend = {
                key: validateKey
            };
            controller = new AbortController();
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
                    CloneObject = document.querySelector('.cloneSearch').cloneNode(true);
                    for (const key in ObjectDataFrame) {

                        account = ObjectDataFrame[key]['account'];
                        amount = ObjectDataFrame[key]['amount'];
                        date = ObjectDataFrame[key]['Date'];
                        id = ObjectDataFrame[key]['id'];
                        Status = ObjectDataFrame[key]['Status'];
                        category = ObjectDataFrame[key]['category'];
                        Authorize = ObjectDataFrame[key]['Authorize'];
                        ObjectData = ObjectDataFrame[key]['obj'];
                        item = "";

                        if (Status == 'terminated') {
                            item = "<div class='out_btn'><div></div>" + Status + "</div>";
                        } else
                            if (Status == 'pending') {
                                item = "<div class='in_btn blue'><div></div>" + Status + "</div>";
                            } else {
                                item = "<div class='in_btn'><div></div>" + Status + "</div>";
                            }



                        if (CloneObject != '') {
                            CloneObject.querySelector('.Clonedate').innerText = date;
                            CloneObject.querySelector('.Clonename').innerText = account;
                            CloneObject.querySelector('.Cloneitem').innerHTML = item;
                            CloneObject.querySelector('.CloneAuthorize').innerText = Authorize;
                            CloneObject.querySelector('.Cloneamount').innerText = amount;
                            CloneObject.querySelector('.Clonecategory').innerText = category;
                            CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                            CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', id);
                            CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', id);
                            if (Template.querySelector('p.danger')) {
                                Template.innerHTML = "";
                            }
                            CloneObject.setAttribute('class', "");
                            CloneObject.querySelector('.Clonedate').setAttribute('class', "");
                            CloneObject.querySelector('.Clonename').setAttribute('class', "");
                            CloneObject.querySelector('.Cloneitem').setAttribute('class', "");
                            CloneObject.querySelector('.CloneAuthorize').setAttribute('class', "");
                            CloneObject.querySelector('.Cloneamount').setAttribute('class', "");
                            CloneObject.querySelector('.Clonecategory').setAttribute('class', "");
                            Template.prepend(CloneObject);

                            if (requestData == 'update success') {
                                const FormElement = MainFormDel;
                                FormElement.classList.add('hide');
                                return [true, CloneObject]
                            }

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
            }
        } catch (error) {
            console.error(error);
            return false
        }


    }

    CallMethods.UpdateItemFunction = (target) => {
        newObject = target.getAttribute("data-information");
        newObject = JSON.parse(newObject);
        if (typeof newObject == 'object') {
            document.querySelector(
                '.event_menu_add.form_data select[name="account"]'
            ).value = newObject["account"];
            document.querySelector(
                '.event_menu_add.form_data input[name="amount"]'
            ).value = newObject["amount"];
            document.querySelector(
                '.event_menu_add.form_data input[name="authorize"]'
            ).value = newObject["Authorize"];

            document.querySelector('.event_menu_add.form_data input[name="date"]').value =
                newObject["Date"];
            document.querySelector(
                '.event_menu_add.form_data select[name="status_information"]'
            ).value = newObject["Status"];
            document.querySelector(
                '.event_menu_add.form_data input[name="delete_key"]'
            ).value = newObject["id"];
            return true
        } else {
            return false
        }

    }
    CallMethods.DeleteItemFunction = (value, validateKey, ResponseView, MainFormDel, location) => {
        if (value == "true" && typeof validateKey == 'string' && validateKey.length > 4 && location == 'Transaction') {
            APIDOCS = "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=delete";
            return (PHPREQUESTDEL(APIDOCS, validateKey, ResponseView, MainFormDel).then(
                response => {
                    return response
                }
            ).catch(error => {
                return error
            }));




        }
    }
    return CallMethods;
});