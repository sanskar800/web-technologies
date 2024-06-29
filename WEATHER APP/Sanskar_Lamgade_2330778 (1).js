let myWeather = {
    apiKey: "eee482b6b1c85071a865e477e4634edc",
    fetchWeather: function(city) {
      fetch(
        "https://api.openweathermap.org/data/2.5/weather?q=" +
          city +
          "&units=metric&appid=" +
          this.apiKey
      )
        .then(response => {
          if (!response.ok) {
            alert("No weather found.");
            throw new Error("No weather found.");
          }
          return response.json();
        })
        .then(data => this.displayWeather(data));
    },
    displayWeather: function(data) {
      const { name } = data;
      const { icon, description } = data.weather[0];
      const { temp, humidity } = data.main;
      const { speed } = data.wind;
      document.querySelector(".Location").innerText = name;
      document.querySelector(".weatherIcon").src =
        "https://openweathermap.org/img/wn/" + icon + ".png";
      document.querySelector(".Description").innerText = description;
      document.querySelector(".Temperature").innerText = temp + "°C";
      document.querySelector(".Value-humidity").innerText = "Humidity: " + humidity + "%";
      document.querySelector(".Value-wind-speed").innerText = "Wind speed: " + speed + " km/h";
      document.querySelector(".weatherBox").classList.remove("loading");
  
      // Add date and time
      function showDateTime() {
        const date = new Date();
        const dateOptions = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
        const timeOptions = { hour: "numeric", minute: "numeric", hour12: true };
        const dateString = date.toLocaleDateString("en-US", dateOptions);
        const timeString = date.toLocaleTimeString("en-US", timeOptions);
        document.querySelector(".Date").innerText = dateString;
        document.querySelector(".Time").innerText = timeString;
      }
      showDateTime();
    },
    search: function() {
      this.fetchWeather(document.querySelector(".searchInput").value);
    }
  };
  
  document.querySelector(".searchBtn").addEventListener("click", function() {
    myWeather.search();
  });
  
  document.querySelector(".searchInput").addEventListener("keyup", function(event) {
    if (event.key == "Enter") {
      myWeather.search();
    }
  });
  
  myWeather.fetchWeather("roseville");
  