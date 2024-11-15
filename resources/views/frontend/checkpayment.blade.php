<body>
  <div id='threedsChallengeRedirect' style='height: 100vh'>
      <form id='threedsChallengeRedirectForm' method='POST' action=''>
          <input type='hidden' name='creq' id="creq" value=''/>
      </form>
  </div>

  <script>
      const cardNumber = "4012000033330026"; // Card Number
      const expiryMonth = "01"; // Card Expiry Month
      const expiryYear = "39"; // Card Expiry Year
      const securityCode = "100"; // Card Security Code
    
      var myHeaders = new Headers();
      myHeaders.append("Authorization", "Payaza " + "{{env('PAYAZA_API')}}");
      myHeaders.append("Content-Type", "application/json");

      var raw = JSON.stringify({
          "service_payload": {
              "first_name": "Fasanya2", 
              "last_name": "Oluwapelumi2",
              "email_address": "fasanyafemi@gmail.com",
              "phone_number": "09058744483",
              "amount": 100,
              "transaction_reference": "PL-1KBPSCJCRD" + Math.floor((Math.random() * 10000000) + 1),
            //   "transaction_reference": "PL-1KBPSCJCRD-PELPO",
              "currency": "NGN",
              "description": "Testing Payment Pel",
              "card": {
                  "expiryMonth": expiryMonth,
                  "expiryYear": expiryYear,
                  "securityCode": securityCode,
                  "cardNumber": cardNumber
              },
              "callback_url": "https://e-coop.cthostel.com/api/payment/webhook"
          }
      });

      var requestOptions = {
          method: 'POST',
          headers: myHeaders,
          body: raw,
          redirect: 'follow'
      };

      fetch("https://cards-live.78financials.com/card_charge/", requestOptions)
          .then(response => response.text())
          .then(result => {
              console.log("RAW RESULT: ", result);
              result = JSON.parse(result);

              if (result.statusOk) {
                  if (result.do3dsAuth) {
                      if (result.formData && result.threeDsUrl) {
                          const creq = document.getElementById("creq");
                          creq.value = result.formData;
                          const form = document.getElementById("threedsChallengeRedirectForm");
                          form.setAttribute("action", result.threeDsUrl);
                          form.submit();
                      } else {
                          console.log("Missing 3DS data:", result);
                          alert("3DS Authentication data missing. Please try again.");
                      }
                  } else {
                      console.log("Payment Process Journey Completed");
                      alert("Payment completed successfully without 3DS authentication.");
                  }
              } else {
                  console.log("Error found:", result.debugMessage);
                  alert("Payment Failed: " + result.debugMessage);
              }
          })
          .catch(error => {
              console.log("Error:", error);
              alert("Exception Error: " + (error.debugMessage || error.message || "Unknown error"));
          });

      window.addEventListener("message", (event) => {
          console.log("Message Event Received");
          try {
              const response = JSON.parse(event.data);
              console.log("Payment Notification", response);
              if (response.statusOk === true && response.paymentCompleted === true) {
                  alert("Payment Successful");
              } else {
                  alert("Payment Failed");
              }
          } catch (e) {
              console.log("Failed to parse message event data:", e);
          }
      });
  </script>
</body>
