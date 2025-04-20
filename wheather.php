<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Weather App Project</title>
  <link rel="stylesheet" href="wheather.css?v=1.0"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
</head>
<body>
  <?php session_start(); ?>
  <h1>Weather Dashboard - Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

  <div class="container">
    <h1>Weather Dashboard</h1>
    <div class="user-email">
      <?php
      if (isset($_SESSION['user_email'])) {
          echo 'Email: ' . htmlspecialchars($_SESSION['user_email']);
      } else {
          echo 'Email not set.';
      }
      ?>
    </div>

    <div class="weather-input">
      <h3>Enter a City Name</h3>
      <input class="city-input" type="text" placeholder="E.g., Belgaum, Pune, Mumbai">
      <button class="search-btn">Search</button>
      <div class="separator"></div>
      <button class="location-btn">Use Current Location</button>
    </div>

    <div class="weather-data">
      <div class="current-weather">
        <div class="details">
          <h2 id="city-name">_______ ( ______ )</h2>
          <h6 id="temp">Temperature: __°C</h6>
          <h6 id="wind">Wind: __ M/S</h6>
          <h6 id="humidity">Humidity: __%</h6>
        </div>
      </div>

      <div class="days-forecast">
        <h2>5-Day Forecast</h2>
        <ul class="weather-cards" id="forecastCards">
          <!-- Forecast cards here, populated dynamically -->
        </ul>
      </div>
    </div>
  </div>

  <!-- 🟢 Crop Recommendation Section -->
  <div class="recommendation-section" id="cropSection">
    <h2></h2>
    <div class="weather-data-extra">
      <!-- Weather, temperature, and other extra data -->
    </div>
    <div class="crop-list"><span id="recommendedCrops"></span>
    </div>
  </div>

  <!-- 🔻 Footer Section - Move the Next button here -->
  <footer style="margin-top: 40px; padding: 20px; background: #f4f4f4; text-align: center; border-top: 1px solid #ddd;">
    <a href="rcmd.php" class="next-btn" id="nextButton" style="display: none;">Next</a>
  </footer>

  <script>
    const weatherData = [
      { temperature: 30, humidity: 70, rainfall: 200, weather: "Rainy", crops: ["Rice", "Maize", "Sugarcane"] },
      { temperature: 25, humidity: 60, rainfall: 50, weather: "Cloudy", crops: ["Wheat", "Barley", "Chickpeas"] },
      { temperature: 35, humidity: 40, rainfall: 20, weather: "Sunny", crops: ["Cotton", "Groundnut", "Sorghum"] },
      { temperature: 20, humidity: 85, rainfall: 150, weather: "Humid", crops: ["Paddy", "Jute", "Banana"] },
      { temperature: 28, humidity: 50, rainfall: 100, weather: "Normal", crops: ["Corn", "Soybean", "Mustard"] },
      { temperature: 32, humidity: 55, rainfall: 70, weather: "Partly Cloudy", crops: ["Tomato", "Pepper", "Cucumber"] },
      { temperature: 18, humidity: 90, rainfall: 180, weather: "Wet", crops: ["Rice", "Sugarcane", "Coconut"] },
      { temperature: 22, humidity: 80, rainfall: 120, weather: "Misty", crops: ["Oats", "Peas", "Lettuce"] },
      { temperature: 40, humidity: 30, rainfall: 10, weather: "Hot", crops: ["Millets", "Chili", "Cabbage"] },
      { temperature: 27, humidity: 65, rainfall: 50, weather: "Warm", crops: ["Potato", "Garlic", "Carrot"] },
      { temperature: 21, humidity: 75, rainfall: 130, weather: "Cool", crops: ["Cauliflower", "Spinach", "Onion"] },
      { temperature: 34, humidity: 45, rainfall: 30, weather: "Dry", crops: ["Barley", "Sorghum", "Sesame"] },
      { temperature: 29, humidity: 50, rainfall: 90, weather: "Mild", crops: ["Cabbage", "Zucchini", "Beans"] },
      { temperature: 23, humidity: 78, rainfall: 110, weather: "Showery", crops: ["Peas", "Cucumbers", "Pumpkin"] },
      { temperature: 33, humidity: 60, rainfall: 40, weather: "Hot & Dry", crops: ["Chili", "Sunflower", "Watermelon"] },
      { temperature: 25, humidity: 85, rainfall: 160, weather: "Wet & Humid", crops: ["Rice", "Coconut", "Banana"] }
    ];

    const searchBtn = document.querySelector('.search-btn');
    const cityInput = document.querySelector('.city-input');
    const weatherSection = document.querySelector('.weather-data');
    const recommendationSection = document.getElementById('cropSection');
    const forecastCards = document.getElementById('forecastCards');
    const nextButton = document.getElementById('nextButton'); // 🔹 Get reference to Next button

    searchBtn.addEventListener('click', function() {
      const city = cityInput.value;
      
      // Display weather data
      const random = Math.floor(Math.random() * weatherData.length);
      const data = weatherData[random];

      document.getElementById("city-name").textContent = `${city} (${data.weather})`;
      document.getElementById("temp").textContent = `Temperature: ${data.temperature}°C`;
      document.getElementById("wind").textContent = `Wind: ${Math.random().toFixed(2)} M/S`;
      document.getElementById("humidity").textContent = `Humidity: ${data.humidity}%`;

      // Populate the 5-day forecast with random data
      const forecastHTML = weatherData.slice(0, 5).map((forecast) => {
        return `
          <li class="card">
            <h3>${forecast.weather}</h3>
            <h6>Temp: ${forecast.temperature}°C</h6>
            <h6>Wind: ${Math.random().toFixed(2)} M/S</h6>
            <h6>Humidity: ${forecast.humidity}%</h6>
          </li>
        `;
      }).join('');
      forecastCards.innerHTML = forecastHTML;

      // Show weather section and hide recommendation section
      weatherSection.style.display = 'block';
      recommendationSection.style.display = 'none';

      // 🔹 Show the "Next" button in footer
      nextButton.style.display = 'inline-block';
    });
  </script>
</body>
</html>
