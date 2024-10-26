
<body>
  <div id='threedsChallengeRedirect' xmlns='http://www.w3.org/1999/html' style=' height: 100vh'>
      <form id='threedsChallengeRedirectForm' method='POST' action=''>
          <input type='hidden' name='creq' id="creq" value=''/>
      </form>
      <!-- <iframe id='challengeFrame' name='challengeFrame' width='100%' height='100%'></iframe> -->
  </div>

  <script>
      const cardNumber = "4187451844054629"; // Card Number
      const expiryMonth = "07"; // Card Expiry Month
      const expiryYear = "23"; // Card Expiry Year
      const securityCode = "100"; // Card Security Code

      

      var myHeaders = new Headers();
      myHeaders.append("Authorization", "Bearer " +btoa('PZ78-PKTEST-F9D350FC-8D1A-43A7-877B-0BE5858EADFC'));
      myHeaders.append("Content-Type", "application/json");

      

      var raw = JSON.stringify({
          "service_payload": {
              "first_name": "John", 
              "last_name": "Doe",
              "email_address": "johndoe@gmail.com",
              "phone_number": "01234567890",
              "amount": 0.01,
              "transaction_reference": "PL-1KBPSCJCRDkkk"+Math.floor((Math.random() * 10000000) + 1),
              "currency": "USD",
              "description": "Test for 3DS",
              "card": {
                  "expiryMonth": expiryMonth,
                  "expiryYear": expiryYear,
                  "securityCode": securityCode,
                  "cardNumber": cardNumber
              },
              "callback_url":"https://cthostel.com"             }
      });

      var requestOptions = {
          method: 'POST',
          headers: myHeaders,
          body: raw,
          redirect: 'follow'
      };

      
      fetch("https://cards-live.78financials.com/card_charge/", requestOptions).then(response => response.text()).then(result => {
          console.log("RAW RESULT: ", result)
          result = JSON.parse(result);
          if (result.statusOk) { // ///Handle Success Response
              if (result.do3dsAuth) {
                  const creq = document.getElementById("creq");
                  creq.value = result.formData;
                  const form = document.getElementById("threedsChallengeRedirectForm");
                  form.setAttribute("action", result.threeDsUrl);
                  form.submit();
              } else {
                  console.log("Payment Process Journey Completed")
              }
          } else { // ///Handle Error
              console.log("Error found", result.debugMessage)
              alert("Payment Failed: " + result.debugMessage)
          }
      }).catch(error => {
          console.log("::::::::::Error::::::::::", error)
          alert("Exception Error: " + error.debugMessage)
      });

      // ///////////Internal Payment Notification
      window.addEventListener("message", (event) => {
          console.log("::::::::::::::::::MESSAGE EVENT GOT BACK FROM BACK-END::::::::::::::::::::::")
          const response = JSON.parse(event.data);
          console.log("Payment Notification", response)
          if (response.statusOk === true && response.paymentCompleted === true) { // ////Handle payment successful, do business logic
              alert("Payment Successful")
          } else { // ///Handle Failed payment
              alert("Payment Failed")
          }
      });
  </script>
</body>
  

      