define(["resumable"],function (resumable) {
  const ContentDom = document.querySelector(".profile_container_main");
  const SkeletonDom_list = document.querySelector(".skeleton");
  const menu_trigger = document.querySelector('.sidemenu_trigger');
  const sideMenu = document.querySelector('aside')
  const sideMenuList = document.querySelectorAll('.items_list');
  menu_trigger.addEventListener('click', function () {
    menu_trigger.classList.toggle('active');
    sideMenu.classList.toggle('active')
  })

  sideMenuList.forEach(element => {
    element.addEventListener('click', () => {
      menu_trigger.classList.remove('active');
      sideMenu.classList.remove('active');
    })
  })
  const MainElement = document.querySelector('main')
  window.addEventListener('scroll', function () {
    if (scrollY > 30) {
      MainElement.classList.add('animate')
    } else {
      MainElement.classList.remove('animate')
    }
  })
  window.addEventListener('click', function () {
    const Pages = document.querySelectorAll(".pages div");
    Pages.forEach((element) => {
      if (element.contains(target)) {
        value = element.innerHTML;
        pagnationSystem(value);
      }
    });

  })
  async function pagnationSystem(value) {
    const rootElement = document.documentElement;
    rootElement.scrollTo({
      top: 40,
      behavior: "smooth",
    });
    const route = Urlroutes[location] || Urlroutes[404];
    if (route) {
      request = route.template + "?page=" + value;
      if (request) {
        ContentDom.classList.add("load");
        SkeletonDom_list.classList.add("load");
        setTimeout(() => {
          ProgressLoader(true);
        }, 100);

        locationHandler(request, location).then((data) => {
          SkeletonDom_list.classList.remove("load");
          ContentDom.classList.remove("load");
          setTimeout(() => {
            ProgressLoader(false);
          }, 100);
        });
      }
    }
  }


  const Urlroutes = {
    404: {
      template: "../pages/404.html",
      title: "404 | page not found",
      description: "404 page directions",
    },
    "/": {
      template: "home.php",
      title: "this is the home page",
      description: "",
    },
    notification: {
      template: "notification.php",
      title: "This is the notification page",
      description: "",
    },
    payment: {
      template: "payment.php",
      title: "Payment page",
      description: "This is the payment page",
    },
    transaction: {
      template: "transaction.php",
      title: "Transactions age",
      description: "",
    },
    tithe: {
      template: "tithe_book.php",
      title: "tithe page",
      description: "",
    },
    password: {
      template: "password.php",
      title: "password settings",
      description: "",
    },
    access: {
      template: "access.php",
      title: "history settings",
      description: "",
    },
  };
  const locationHandler = async (value, location) => {
    loader_status = false;
    const html = await fetch(value)
      .then((response) => response.text())
      .catch((error) => {
        loader_status = true;
      });
    if (html) {
      ContentDom.innerHTML = html;
    }
    if (!loader_status) {
      if (location == '/') {
        var ProfileDisplay = document.querySelector('#cover_profile');
        const AddEventMenu = document.querySelector(".event_menu_add");
        var EditFiles = document.querySelectorAll('.fa-edit');
        const SubmitForm = document.querySelector(".event_menu_add form");
        const ResponseView = document.querySelector(".error_information");
        const Membership_loaderBtn = document.querySelector('.loader_btn');
        permission = false;
        MembershipMediaFilenames = [];
        SubmitForm.addEventListener("submit", async function (e) {
          APIDOCS = API = "../API/userpage-api/data_process.php?submit=true&&request=uploadData&&user=true";
          ResponseView.innerText = "loading...";
          e.preventDefault();
          PHPREQUEST(APIDOCS);
        });
        var r = new resumable({
          target: "../API/userpage-api/data_process.php?upload_submit=true",
          query: { 
            upload_token: document.querySelector('.event_menu_add input[name="delete_key"]').value
           }
        });
        r.assignBrowse(document.getElementById('browseButton'));
        r.on('filesAdded', function (array) {
          acceptedExtension = ['jpg', 'png', 'jpeg'];
          permission = true;
            if (r.files.length > 0) {
              if (r.files.length == 1) {
                Membership_loaderBtn.classList.add('active');
              }
              MembershipMediaFilenames = [];
              if (acceptedExtension.includes(r.files[0].file.name.split('.')[1].toLowerCase())) {
                MembershipMediaFilenames.push(r.files[0].file.name);
              } else {
                permission = false;
              }  
            if (permission) {
              if (MembershipMediaFilenames.length > 0) {
                if (MembershipMediaFilenames.length == 1) {
                  r.upload();
                  Membership_loaderBtn.classList.remove('active');
                  UrlTrace();
                } else {
                  alert("Only one file is allowed by update")
                  r.cancel();
                  Membership_loaderBtn.classList.remove('active');
                }

              }else{
                alert('Select a file to upload');
                r.cancel();
                Membership_loaderBtn.classList.remove('active');
              }
            } else {
              Membership_loaderBtn.classList.remove('active');
              alert("Files should be an image either JPG,PNG,JPEG");
            }
          }
        });
        r.on('complete', function () {
          console.log('complete');
          r.cancel();
          MembershipMediaFilenames = [];
        });

          
        
        async function PHPREQUEST(APIDOCS) {
          let data;
          try {
            const formMain = new FormData(SubmitForm);
            const Request = await fetch(APIDOCS, {
              method: "POST",
              body: formMain,
            });

            if (Request.status === 200) {
              data = await Request.json();
              if (data) {
                ResponseView.innerText = data;
              }
            } else {
              console.log("cannot find endpoint");
            }
          } catch (error) {
            console.error(error);
          }
        }
        
        window.addEventListener("click", function (e) {
          var target = e.target;
          EditFiles.forEach(element => {
            if (element == target) {
              if (
                AddEventMenu.classList.contains("active")
              ) {
                if (!AddEventMenu.contains(target) && !element.contains(target)) {
                  AddEventMenu.classList.remove("active");
                }
              } else if (element.contains(target)) {
                AddEventMenu.classList.add("active");
              }
            }
            if (!AddEventMenu.contains(target) && !element.contains(target) && !target.classList.contains('fa-edit')) {
              AddEventMenu.classList.remove("active");
            }
          });
        });

      }
      if (location == 'password') {
        const EmailInput = document.querySelector('input[type="email"]')
        var RequestBtn = document.querySelector('#request_btn');
        // document.getElementById('contact-form').addEventListener('submit', function (event) {
        //   event.preventDefault();
        //   let Email = document.querySelector('#email').value;
        //   emailjs.sendForm('service_sffdk0b', 'template_jihe9xi', this, { recipientEmail: Email })
        //     .then(() => {
        //       console.log('SUCCESS!');
        //     }, (error) => {
        //       console.log('FAILED...', error);
        //     });
        // });
        RequestBtn.addEventListener('click', async function () {
          let data;
          APIDOCS = '../API/userpage-api/data_process.php?submit=true&&request=password&&user=true';
          dataSend = {
            Email: EmailInput.value,
            unique_id: RequestBtn.getAttribute('data-value')
          }
          try {
            const Request = await fetch(APIDOCS, {
              method: "POST",
              body: JSON.stringify(dataSend),
              headers: {
                "Content-Type": "application/json",
              },
            });

            if (Request.status === 200) {
              data = await Request.json();
              if (data) {
                console.log(data)
              }
            } else {
              console.log("cannot find endpoint");
            }
          } catch (error) {
            console.error(error);
          }
        })

          (function () {
            emailjs.init({
              publicKey: 'RtfFLq0ZUtE5gn-AE',
            });
          })();

      }

    }
  };

  function UrlTrace() {
    location_main = window.location.hash.replace("#", "");
    console.log(location);
    if (location_main.length == 0) {
      location_main = "/";
    }
    const route = Urlroutes[location_main] || Urlroutes[404];

    ContentDom.classList.add("load");
    SkeletonDom_list.classList.add("load");
    locationHandler(route.template, location_main)
      .then((data) => {
        SkeletonDom_list.classList.remove("load");
        ContentDom.classList.remove("load");
      })
      .catch((error) => {
        SkeletonDom_list.classList.remove("load");
        ContentDom.classList.remove("load");
      });
  }
  const location_updator = () => {
    location = window.location.hash.replace("#", "")
    return (location);
  }
  window.addEventListener("hashchange", function (e) {
    document.documentElement.scrollTo({
      top: 0,
      behavior: "smooth",
    });
    UrlTrace();
  });
  UrlTrace();

});
