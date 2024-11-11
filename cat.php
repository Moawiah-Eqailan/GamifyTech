<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Centering flex utility */
        .flex-center { 
          display: flex; 
          justify-content: center; 
          align-items: center; 
        }

        /* General styling */
        html, body { 
          padding: 0; 
          margin: 0; 
          height: 100%; 
        }
        body { 
          position: relative; 
          display: flex;
          justify-content: center;
          align-items: center;
          background-color: #0093E9;
          background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);
        }
        
        /* Glass Box Styling */
        .glassBox {
          width: 100%;
          height: 400px;
          max-width: 300px;
          border-radius: 5px;
          background: rgba(255, 255, 255, 0.05);
          backdrop-filter: blur(2px);
          border: 1px solid rgba(255, 255, 255, 0.2);
          border-right-color: rgba(255, 255, 255, 0.1);
          border-bottom-color: rgba(255, 255, 255, 0.1);
          box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
          padding: 15px;
          position: relative;
          display: flex;
          flex-direction: column;
          align-items: center;
          transition: 400ms;
        }
        
        .glassBox__imgBox {
          transition: 400ms;
        }
        
        .glassBox__imgBox img {
          display: block;
          width: 100%;
          height: auto;
          transition: 400ms;
        }
        
        .glassBox__title {
          text-align: center;
          /* margin-top: 15px; */
          color: #FFF;
          font-size: 20px;
          font-weight: 400;
          font-family: "Lato";
        }
        
        .glassBox__content {
          position: absolute;
          right: 15px;
          bottom: 15px;
          left: 15px;
          text-align: center;
          color: #FFF;
          font-size: 14px;
          font-family: "Lato";
          letter-spacing: .1em;
          opacity: 0;
          transition: 400ms;
        }
        
        /* Hover Effects */
        .glassBox:hover .glassBox__imgBox {
          transform: translateY(-50px);
        }
        
        .glassBox:hover .glassBox__imgBox img {
          transform: translate(-20px, -40px) rotate(-15deg) scale(1.4);
        }
        
        .glassBox:hover .glassBox__content {
          opacity: 1;
        }
    </style>
</head>
<body>
    <div class="glassBox">
        <div class="glassBox__imgBox">
          <img src="https://i.ibb.co/s5phbkg/shoe-golden.png" alt="">
          <h3 class="glassBox__title">Golden Shoe</h3>
        </div>
        <div class="glassBox__content">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae sunt veniam adipisci fugit qui quaerat!</div>
      </div>
</body>
</html>
