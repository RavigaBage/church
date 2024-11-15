try {
  (function () {
    emailjs.init({
      publicKey: "RtfFLq0ZUtE5gn-AE",
    });
  })();
  const formData = document.querySelector('form');
  let EmailAddress = document.querySelector('input[type="email"]');
  let textArea = document.querySelector('textarea');

  function EmailSend(Address, textArea) {
    Values = [Address, textArea];
    Values.forEach(element => {
      if (element == '' || element == ' ') {
        return "All fields are required !!";
      } else {
        let Email = document.querySelector('#email').value;
        emailjs.sendForm('service_sffdk0b', 'template_jihe9xi', this, { recipientEmail: Email })
          .then(() => {
            return 'SUCCESS!';
          }, (error) => {
            return 'FAILED...', error;
          });

      }
    });
  }
  formData.addEventListener('submit', function (e) {
    e.preventDefault();
    ValueData = EmailSend(EmailAddress.value, textArea.value);
    alert(ValueData);
  });
  (function () {
    emailjs.init({
      publicKey: 'RtfFLq0ZUtE5gn-AE',
    });
  })();
} catch (error) {
  console.log(error);
}
