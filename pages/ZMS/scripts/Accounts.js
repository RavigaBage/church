let Account_validateKey = false
const Account_loaderBtn = document.querySelector(".event_menu_add.form_data .loader");
const Account_AddEventMenu = document.querySelector(".event_menu_add.form_data");
const Account_AddEventMenu_far = document.querySelector(".event_menu_add.form_data.acc_delete");
const Account_ResponseView = document.querySelector(".info_information.event_menu_add");
const Account_AddEventMenuForm = Account_AddEventMenu.querySelector("form");
const Account_AddEventMenu_Btn = document.querySelector(".event_menu_add.form_data Button");
const Account_confirmsBtns = document.querySelectorAll(".btn_confirm");
const Account_dn_message = document.querySelector(".dn_message");

const Account_AddEventBtn = document.querySelector(".add_event");
const Account_AddEventBtn_far = document.querySelector(".add_event.far");
var OptionElements = document.querySelectorAll(".option");
Account_AddEventBtn.addEventListener("click", function (e) {
    Account_AddEventMenu.classList.add("active");
});
Account_AddEventBtn_far.addEventListener("click", function (e) {
    Account_AddEventMenu_far.classList.add("active");
});

OptionElements.forEach((element) => {
    element.addEventListener("click", function () {
        var ElementOptions = element.querySelector(".opt_element");
        if (ElementOptions != null) {
            ElementOptions.classList.add("active");
        }
    });
});
Account_confirmsBtns.forEach((element) => {
    element.addEventListener("click", (e) => {
        if (element.getAttribute("data-confirm") == "true") {
            if (Account_validateKey != "") {
                Account_DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    Account_validateKey
                );
            }
        }
    });
});

window.addEventListener("click", function (e) {
    if (location_updator() == "FinanceAccount") {
        var target = e.target;
        const Pages = document.querySelectorAll(".pages div");
        var OptionElements = document.querySelectorAll(".option");
        if (Account_AddEventMenu.classList.contains("active") && !Account_AddEventBtn.contains(target)) {
            if (!Account_AddEventMenu.contains(target)) {
                Account_AddEventMenu.classList.remove("active");
            }
        }
        if (Account_AddEventMenu_far.classList.contains("active") && !Account_AddEventBtn_far.contains(target)) {
            if (!Account_AddEventMenu_far.contains(target)) {
                Account_AddEventMenu_far.classList.remove("active");
            }
        }
        if (target.tagName == 'I') {
            if (target.hasAttribute('delete_acc')) {
                Account_validateKey = target.getAttribute('delete_acc');
                Account_dn_message.classList.add('active');
            }
        }
        OptionElements.forEach((element) => {
            var ElementOptions = element.querySelector(".opt_element");

            if (ElementOptions != null) {
                if (
                    ElementOptions.classList.contains("active") &&
                    !element.contains(target)
                ) {

                    if (!ElementOptions.contains(target)) {
                        ElementOptions.classList.remove("active");
                    }
                } else {
                    MainBody = document.querySelectorAll('#main_table tbody tr');
                    if (MainBody) {
                        MainBody.forEach(element => {
                            if (element.contains(target)) {
                                MainFormDel = element;
                            }
                        })
                        if (
                            target.classList.contains("Update_item") &&
                            element.contains(target)
                        ) {
                            validateKey = target.getAttribute("data-id");
                            UpdateItemFunction(target);
                            ElementOptions.classList.remove("active");
                        }
                        if (
                            target.classList.contains("delete_item") &&
                            element.contains(target)
                        ) {
                            validateKey = target.getAttribute("data-id");
                            dn_message.classList.add('active');
                            ElementOptions.classList.remove("active");
                        }
                    }


                }
            }
        });
        Pages.forEach((element) => {
            if (element.contains(target)) {
                value = element.innerHTML;
                pagnationSystem(value);
            }
        });
    }
});

Account_AddEventMenuForm.addEventListener("submit", function (e) {
    e.preventDefault();
});
Account_AddEventMenu_Btn.onclick = function () {
    Account_AddEventMenu.classList.add("active");
    var Account_formCondiions = document.querySelectorAll(".form_condition");
    Account_loaderBtn.classList.add("active");
    if (ConditionFeilds(Account_formCondiions) != false) {
        Account_APIDOCS = "../../API/finance/data_process.php?APICALL=account&&user=true&&submit=true";
        Account_PHPREQUEST(Account_APIDOCS);
    } else {
        Account_loaderBtn.innerText = "All feilds are required";
    }
};
async function Account_PHPREQUEST(Account_APIDOCS) {
    if (location_updator() == "FinanceAccount") {
        let data;
        try {
            const formMain = new FormData(Account_AddEventMenuForm);

            const Request = await fetch(Account_APIDOCS, {
                method: "POST",
                body: formMain,
            });

            if (Request.status === 200) {
                data = await Request.json();
                Account_loaderBtn.innerText = data;
                if (data == 'Upload was a success') {
                    requestData = data;

                    if (!Account_validateKey) {
                        Account_validateKey = "";
                    }
                }
            }
        } catch (error) {
            console.error(error);
        }
    }
}
function Account_DeleteItemFunction(value, Account_validateKey) {
    if (value == "true" && location_updator() == "FinanceAccount") {
        Account_API = "../../API/Finance/data_process.php?APICALL=account&&user=true&&submit=delete";
        Account_PHPREQUESTDEL(Account_API, Account_validateKey);
    }
}
async function Account_PHPREQUESTDEL(Account_APIDOCS, Account_validateKey) {
    if (location_updator() == "FinanceAccount") {
        let Account_data;
        try {
            Account_ResponseView.classList.add('active');
            dataSend = {
                account: Account_validateKey,
            };
            const Request = await fetch(Account_APIDOCS, {
                method: "POST",
                body: JSON.stringify(dataSend),
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (Request.status === 200) {
                Account_data = await Request.json(Account_data);

                if (Account_data) {
                    if (Account_data == 'Item Deleted Successfully') {
                        UrlTrace();
                        Account_validateKey = '';
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