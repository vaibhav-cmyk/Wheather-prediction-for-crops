<?php
// Start the session
session_start();

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Crop Recommendation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 30px;
      background: linear-gradient(135deg, #a8edea, #fed6e3);
    }

    .container {
      background: white;
      padding: 25px 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      margin: auto;
      position: relative;
    }

    h2 {
      margin-bottom: 25px;
      color: #2c3e50;
      font-size: 28px;
    }

    .crop-list {
      font-weight: bold;
      color: #145a32;
      padding: 25px;
      font-size: 20px;
      background: linear-gradient(to right, #d4efdf, #a9dfbf);
      border: 2px dashed #27ae60;
      border-radius: 12px;
      margin-top: 30px;
      transition: all 0.3s ease-in-out;
    }

    .crop-list:hover {
      background: linear-gradient(to right, #a9dfbf, #d4efdf);
      box-shadow: 0 4px 12px rgba(0, 128, 0, 0.2);
    }

    .back-btn, .logout-btn {
      display: inline-block;
      padding: 10px 18px;
      background: #3498db;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s ease-in-out;
    }

    .username {
      display: inline-block;
      padding: 10px 18px;
      background: #3498db;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s ease-in-out;
    }

    .back-btn:hover, .logout-btn:hover {
      background: #2e86c1;
    }

    .back-btn {
      margin-top: 30px;
    }

    .logout-btn {
      position: absolute;
      top: 20px;
      right: 30px;
      background: #e74c3c;
    }

    .logout-btn:hover {
      background: #c0392b;
    }

    .label {
      font-size: 18px;
      margin-bottom: 8px;
    }

    .emoji {
      font-size: 28px;
      margin-right: 8px;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="index.php" class="logout-btn">🔒 Logout</a>
    
    <span id="usernameDisplay" class="user-name">
      <?php
        echo 'User : ' . htmlspecialchars($_SESSION['user_email']);
      ?>
    </span>

    <h2>🌾Crop Recommendation</h2>

    <div class="crop-list">
      <div class="label"><span class="emoji">🌱</span>Recommended Crops:</div>
      <div id="recommendedCrops"></div>

      <div class="label" style="margin-top: 20px;"><span class="emoji">🧪</span>Recommended Pesticides:</div>
      <div id="recommendedPesticides"></div>
    </div>

    <a href="wheather.php" class="back-btn">⬅ Back to Dashboard</a>
  </div>

  <script>
    const weatherData = [
      { temperature: 30, humidity: 70, rainfall: 200, weather: "Rainy", crops: ["Rice", "Maize", "Sugarcane"], pesticides: ["Carbofuran", "Chlorpyrifos", "Monocrotophos"] },
      { temperature: 25, humidity: 60, rainfall: 50, weather: "Cloudy", crops: ["Wheat", "Barley", "Chickpeas"], pesticides: ["Malathion", "Endosulfan", "Dimethoate"] },
      { temperature: 35, humidity: 40, rainfall: 20, weather: "Sunny", crops: ["Cotton", "Groundnut", "Sorghum"], pesticides: ["Imidacloprid", "Cypermethrin", "Quinalphos"] },
      { temperature: 20, humidity: 85, rainfall: 150, weather: "Humid", crops: ["Paddy", "Jute", "Banana"], pesticides: ["Buprofezin", "Acephate", "Carbendazim"] },
      { temperature: 28, humidity: 50, rainfall: 100, weather: "Normal", crops: ["Corn", "Soybean", "Mustard"], pesticides: ["Thiamethoxam", "Mancozeb", "Fipronil"] },
      { temperature: 32, humidity: 65, rainfall: 180, weather: "Rainy", crops: ["Rice", "Tea", "Rubber"], pesticides: ["Tricyclazole", "Hexaconazole", "Captan"] },
      { temperature: 27, humidity: 55, rainfall: 90, weather: "Mild", crops: ["Lentils", "Peas", "Flax"], pesticides: ["Metalaxyl", "Maneb", "Pendimethalin"] },
      { temperature: 29, humidity: 60, rainfall: 110, weather: "Partly Cloudy", crops: ["Millet", "Soya", "Sesame"], pesticides: ["Propiconazole", "Lambda-cyhalothrin", "Fenvalerate"] },
      { temperature: 33, humidity: 45, rainfall: 30, weather: "Dry", crops: ["Tobacco", "Castor", "Sunflower"], pesticides: ["Emamectin", "Tebuconazole", "Oxydemeton"] },
      { temperature: 22, humidity: 75, rainfall: 170, weather: "Wet", crops: ["Green Gram", "Black Gram", "Cucumber"], pesticides: ["Zineb", "Chlorothalonil", "Profenofos"] },
      { temperature: 24, humidity: 65, rainfall: 140, weather: "Cool", crops: ["Tomato", "Brinjal", "Okra"], pesticides: ["Bifenthrin", "Metribuzin", "Pyraclostrobin"] },
      { temperature: 26, humidity: 58, rainfall: 70, weather: "Warm", crops: ["Pumpkin", "Carrot", "Radish"], pesticides: ["Spirotetramat", "Prochloraz", "Thiram"] },
      { temperature: 21, humidity: 82, rainfall: 160, weather: "Moist", crops: ["Cabbage", "Cauliflower", "Onion"], pesticides: ["Deltamethrin", "Carfentrazone", "Sulphur"] },
      { temperature: 30, humidity: 72, rainfall: 190, weather: "Rainy", crops: ["Papaya", "Mango", "Pineapple"], pesticides: ["Copper Oxychloride", "Carbendazim", "Dimethoate"] },
      { temperature: 31, humidity: 67, rainfall: 150, weather: "Showery", crops: ["Guava", "Litchi", "Sapota"], pesticides: ["Malathion", "Indoxacarb", "Fipronil"] },
      { temperature: 34, humidity: 50, rainfall: 40, weather: "Hot", crops: ["Cashew", "Date Palm", "Agave"], pesticides: ["Clothianidin", "Spirotetramat", "Ziram"] },
      { temperature: 19, humidity: 90, rainfall: 200, weather: "Stormy", crops: ["Turmeric", "Ginger", "Taro"], pesticides: ["Streptomycin", "Tebuconazole", "Carboxin"] },
      { temperature: 36, humidity: 42, rainfall: 15, weather: "Scorching", crops: ["Cactus", "Aloe Vera", "Opuntia"], pesticides: ["Imidacloprid", "Abamectin", "Pendimethalin"] },
      { temperature: 23, humidity: 78, rainfall: 130, weather: "Foggy", crops: ["Spinach", "Lettuce", "Celery"], pesticides: ["Copper Hydroxide", "Dazomet", "Diazinon"] },
      { temperature: 27, humidity: 62, rainfall: 85, weather: "Pleasant", crops: ["Beetroot", "Turnip", "Kale"], pesticides: ["Fosetyl-Al", "Flubendiamide", "Maneb"] },
      { temperature: 20, humidity: 88, rainfall: 175, weather: "Chilly", crops: ["Mint", "Coriander", "Parsley"], pesticides: ["Chlorantraniliprole", "Bordeaux Mixture", "Azoxystrobin"] },
      { temperature: 28, humidity: 53, rainfall: 95, weather: "Moderate", crops: ["Zucchini", "Beans", "Garlic"], pesticides: ["Mefenoxam", "Pyrethrin", "Trifloxystrobin"] },
      { temperature: 32, humidity: 47, rainfall: 60, weather: "Blazing", crops: ["Fennel", "Fenugreek", "Thyme"], pesticides: ["Thiacloprid", "Tolfenpyrad", "Paraquat"] },
      { temperature: 18, humidity: 92, rainfall: 220, weather: "Drizzling", crops: ["Mustard Greens", "Broccoli", "Leek"], pesticides: ["Tebuconazole", "Captan", "Pymetrozine"] },
      { temperature: 26, humidity: 66, rainfall: 105, weather: "Windy", crops: ["Basil", "Oregano", "Dill"], pesticides: ["Tridemorph", "Acequinocyl", "Pyriproxyfen"] }
    ];

    function showRecommendation() {
      const random = Math.floor(Math.random() * weatherData.length);
      const data = weatherData[random];
      document.getElementById("recommendedCrops").textContent = data.crops.join(", ");
      document.getElementById("recommendedPesticides").textContent = data.pesticides.join(", ");
    }

    window.onload = showRecommendation;
  </script>
</body>
</html>
