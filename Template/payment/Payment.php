
  <style>
        body {
            font-family: Arial, sans-serif;
        }
        .hidden {
            display: none;
        }
        .calculator-input {
            display: flex;
            flex-direction: column;
        }
        .calculator-input input {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
        .number-pad {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .number-pad button {
            width: 30%;
            margin: 5px 0;
            padding: 15px;
            font-size: 20px;
            cursor: pointer;
            background-color: #f1f1f1;
            border: none;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    .Payment {
      width: 'auto';
      height: auto;
      position: absolute;
      margin: 3%;
      left: 15%;
      background: rgba(0, 0, 0, 0.3);
      padding: 10px;
      display: none;
   }

    .Payment .Payment-container {
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .Payment .Payment-container h1 {
        text-align: center;
    }

    .Payment .Payment-container label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="tel"],
    .Payment .Payment-container textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .Payment .Payment-container .button-container {
        text-align: center;
    }

    .Payment .Payment-container .button-container button {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .Payment .Payment-container .button-container button:hover {
        background-color: #45a049;
    }

    .Payment .Payment-container .success-message {
        text-align: center;
        font-size: 24px;
        color: #4CAF50;
        margin-top: 20px;
    }

    .Payment .Payment-container .error-message {
        text-align: center;
        font-size: 24px;
        color: #e53935;
        margin-top: 20px;
    }

   /* media queries  */
   
   @media (max-width:1500px){
      .Payment{
         width: 'auto';
         height: 'auto';
         position: absolute;
         margin: 3%;
         left: 15rem;
         background: rgba(0, 0, 0, 0.3);
         padding: 10px;
         overflow: hidden;
         display: none;
      }
   }
   
   @media (max-width:991px){
      .Payment{
         width: 'auto';
         height: 'auto';
         position: absolute;
         margin: 3%;
         left: 0;
         background: rgba(0, 0, 0, 0.3);
         padding: 10px;
         overflow: hidden;
         display: none;
      }
   }
   
   @media (max-width:768px){
      .Payment{
         width: 'auto';
         height: auto;
         position: absolute;
         margin: 3%;
         left: 0;
         background: rgba(0, 0, 0, 0.3);
         padding: 10px;
         overflow: hidden;
         display: none;
      }
   }
   
   @media (max-width:450px){
      .Payment{
         width: 'auto';
         height: auto;
         position: absolute;
         margin: 3%;
         left: 0;
         background: rgba(0, 0, 0, 0.3);
         padding: 10px;
         overflow: hidden;
         display: none;
      }
   }
 


</style>
