function Show_Slip_start(given_method) {
        console.log("Show_Slip_start view payment >>", given_method)
        const body = document.querySelector("body");

          const paymentFormContainer = document.createElement('div');
            paymentFormContainer.style.fontSize = "small";
            paymentFormContainer.style.width = "100%";
            paymentFormContainer.style.height = "100vh";
            paymentFormContainer.style.background = "rgba(0,0,0,.3)";
            paymentFormContainer.style.padding = "18px";
            paymentFormContainer.style.overflow = "hidden";
            paymentFormContainer.style.position = "fixed";
            paymentFormContainer.style.top = "0";
            paymentFormContainer.style.left = "0";
            paymentFormContainer.style.display = "flex";
            paymentFormContainer.style.alignItems = "center";
            paymentFormContainer.style.justifyContent = "center";
            paymentFormContainer.style.zIndex = "1000";
            body.appendChild(paymentFormContainer);

            const form = document.createElement('form');
            form.style.backgroundColor = "#fafafa";
            form.style.padding = "20px";
            form.style.borderRadius = "10px";
            form.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
            //form.style.maxWidth = "400px";
            form.style.width = "100%";
            form.style.margin = "auto";
          
            const paymentDetailsContainer = document.createElement('div');
          paymentDetailsContainer.style.display = "flex";
            form.appendChild(paymentDetailsContainer);
          
           let Slip_Lists = localStorage.getItem('Slip_Lists');
           Slip_Lists = Slip_Lists ? JSON.parse(Slip_Lists) : [];
          
           function next_slip(slip_id) {
                const slip = document.createElement('label');
                slip.textContent = Slip_Lists[slip_id][1];
                       slip.style.whiteSpace = "pre-wrap";
                       slip.style.display = "block";
                       slip.style.fontFamily = "Arial, sans-serif";
                       slip.style.fontSize = "16px";
                       slip.style.margin = "10px 0";
                slip.htmlFor = "cardNumber";
               slip.style.overflow = "scroll";
                     slip.style.width = "50%";
                paymentDetailsContainer.appendChild(slip);
                       
            const editeContainer = document.createElement('div');
            editeContainer.style.display = "flex";
            editeContainer.style.justifyContent = "space-around";
            editeContainer.style.flexDirection = "row";
            editeContainer.style.flexWrap = "wrap";
            editeContainer.style.alignContent = "flex-start";
                     editeContainer.style.width = "50%";
                     
            paymentDetailsContainer.appendChild(editeContainer);

            const paymentMethodLabel = document.createElement('label');
            paymentMethodLabel.textContent = "How Willd Coustumet like there resept:";
            paymentMethodLabel.htmlFor = "paymentMethod";
            editeContainer.appendChild(paymentMethodLabel);

                     
            const buttonContainer = document.createElement('div');
            buttonContainer.style.display = "flex";
            buttonContainer.style.justifyContent = "space-around";
            buttonContainer.style.flexDirection = "row";
            buttonContainer.style.flexWrap = "wrap";
            buttonContainer.style.alignContent = "stretch";
            buttonContainer.style.alignItems = "flex-end";
                     buttonContainer.style.width = "50%";
            buttonContainer.style.justifyItems = "stretch";
                     
            editeContainer.appendChild(buttonContainer);
                     
            const cancelButton = document.createElement('button');
            cancelButton.textContent = "Cancel";
            cancelButton.style.backgroundColor = "#dc3545";
            cancelButton.style.color = "#fff";
            cancelButton.style.padding = "10px 20px";
            cancelButton.style.border = "none";
            cancelButton.style.borderRadius = "5px";
            cancelButton.style.cursor = "pointer";
            cancelButton.addEventListener('click', (e) => {
                e.preventDefault();
                paymentFormContainer.remove();
            });
            buttonContainer.appendChild(cancelButton);

            const clearallpaymentButton = document.createElement('button');
            clearallpaymentButton.textContent = "Clear All Payments";
            clearallpaymentButton.style.backgroundColor = "#007bff";
            clearallpaymentButton.style.color = "#fff";
            clearallpaymentButton.style.padding = "10px 20px";
            clearallpaymentButton.style.border = "none";
            clearallpaymentButton.style.borderRadius = "5px";
            clearallpaymentButton.style.cursor = "pointer";
            clearallpaymentButton.addEventListener('click', (e) => {
                e.preventDefault();
                        // Store empty into local storage
                        localStorage.setItem('Payment_Lists', JSON.stringify([]));
                updatePaymentForm("Show", paymentDetailsContainer, submitButton);
            });
            buttonContainer.appendChild(clearallpaymentButton);
          

            paymentFormContainer.appendChild(form);

            
          
                       
                const prev_slip_Button = document.createElement('button');
                      prev_slip_Button.textContent = "<<";
                      prev_slip_Button.style.backgroundColor = "#dc3545";
                      prev_slip_Button.style.color = "#fff";
                      prev_slip_Button.style.padding = "10px 20px";
                      prev_slip_Button.style.border = "none";
                      prev_slip_Button.style.borderRadius = "5px";
                      prev_slip_Button.style.cursor = "pointer";
                      prev_slip_Button.addEventListener('click', (e) => {
                          e.preventDefault();
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(prev_slip_Button);
          
                       
                const next_slip_Button = document.createElement('button');
                      next_slip_Button.textContent = ">>";
                      next_slip_Button.style.backgroundColor = "#dc3545";
                      next_slip_Button.style.color = "#fff";
                      next_slip_Button.style.padding = "10px 20px";
                      next_slip_Button.style.border = "none";
                      next_slip_Button.style.borderRadius = "5px";
                      next_slip_Button.style.cursor = "pointer";
                      next_slip_Button.addEventListener('click', (e) => {
                          e.preventDefault();
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(next_slip_Button);
          
                       const print_slip_Button = document.createElement('button');
                      print_slip_Button.textContent = "Print";
                      print_slip_Button.style.backgroundColor = "#dc3545";
                      print_slip_Button.style.color = "#fff";
                      print_slip_Button.style.padding = "10px 20px";
                      print_slip_Button.style.border = "none";
                      print_slip_Button.style.borderRadius = "5px";
                      print_slip_Button.style.cursor = "pointer";
                      print_slip_Button.addEventListener('click', (e) => {
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(print_slip_Button);
          
                       
                       const Email_slip_Button = document.createElement('button');
                      Email_slip_Button.textContent = "Email";
                      Email_slip_Button.style.backgroundColor = "#dc3545";
                      Email_slip_Button.style.color = "#fff";
                      Email_slip_Button.style.padding = "10px 20px";
                      Email_slip_Button.style.border = "none";
                      Email_slip_Button.style.borderRadius = "5px";
                      Email_slip_Button.style.cursor = "pointer";
                      Email_slip_Button.addEventListener('click', (e) => {
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(Email_slip_Button);
          
                       const Undo_slip_Button = document.createElement('button');
                      Undo_slip_Button.textContent = "Undo";
                      Undo_slip_Button.style.backgroundColor = "#dc3545";
                      Undo_slip_Button.style.color = "#fff";
                      Undo_slip_Button.style.padding = "10px 20px";
                      Undo_slip_Button.style.border = "none";
                      Undo_slip_Button.style.borderRadius = "5px";
                      Undo_slip_Button.style.cursor = "pointer";
                      Undo_slip_Button.addEventListener('click', (e) => {
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(Undo_slip_Button);
                       
                       const Fax_slip_Button = document.createElement('button');
                      Fax_slip_Button.textContent = "Fax";
                      Fax_slip_Button.style.backgroundColor = "#dc3545";
                      Fax_slip_Button.style.color = "#fff";
                      Fax_slip_Button.style.padding = "10px 20px";
                      Fax_slip_Button.style.border = "none";
                      Fax_slip_Button.style.borderRadius = "5px";
                      Fax_slip_Button.style.cursor = "pointer";
                      Fax_slip_Button.addEventListener('click', (e) => {
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(Fax_slip_Button);
          
                       
                       const Save_slip_Button = document.createElement('button');
                      Save_slip_Button.textContent = "Save";
                      Save_slip_Button.style.backgroundColor = "#dc3545";
                      Save_slip_Button.style.color = "#fff";
                      Save_slip_Button.style.padding = "10px 20px";
                      Save_slip_Button.style.border = "none";
                      Save_slip_Button.style.borderRadius = "5px";
                      Save_slip_Button.style.cursor = "pointer";
                      Save_slip_Button.addEventListener('click', (e) => {
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(Save_slip_Button);
          
                       
                       const Done_slip_Button = document.createElement('button');
                      Done_slip_Button.textContent = "Done With Slip";
                      Done_slip_Button.style.backgroundColor = "#dc3545";
                      Done_slip_Button.style.color = "#fff";
                      Done_slip_Button.style.padding = "10px 20px";
                      Done_slip_Button.style.border = "none";
                      Done_slip_Button.style.borderRadius = "5px";
                      Done_slip_Button.style.cursor = "pointer";
                      Done_slip_Button.addEventListener('click', (e) => {
                          paymentFormContainer.remove();
                      });
                      buttonContainer.appendChild(Done_slip_Button);
                       
             }       
             next_slip(Slip_Lists.length-1);
        }
