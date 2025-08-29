// Show initial screen
document.addEventListener("DOMContentLoaded", function () {
  showScreen("homeScreen");
  initCharts();
  setupConditionButtons();
  setupSeverityButtons();
});

// Screen navigation
function showScreen(screenId) {
  // Hide all screens
  document.querySelectorAll("#contentArea > div").forEach((div) => {
    div.classList.add("hidden");
    div.classList.remove("slide-in");
  });

  // Show selected screen
  const screen = document.getElementById(screenId);
  screen.classList.remove("hidden");
  screen.classList.add("slide-in");

  // Update active nav item
  document.querySelectorAll(".nav-item").forEach((item) => {
    item.classList.remove("active", "text-blue-600");
    item.classList.add("text-gray-500");
  });

  // Set active based on screen
  let activeIcon = "";
  switch (screenId) {
    case "homeScreen":
      activeIcon = "fa-home";
      break;
    case "reportScreen":
      activeIcon = "fa-plus-circle";
      break;
    case "mapScreen":
      activeIcon = "fa-map-marked-alt";
      break;
    case "analyticsScreen":
      activeIcon = "fa-chart-bar";
      break;
  }

  document.querySelectorAll(".nav-item").forEach((item) => {
    if (item.querySelector(`.${activeIcon}`)) {
      item.classList.add("active", "text-blue-600");
      item.classList.remove("text-gray-500");
    }
  });
}

// Submit report function
function submitReport() {
  showScreen("successScreen");
}

// Initialize charts
function initCharts() {
  // Severity Chart
  const severityCtx = document.getElementById("severityChart").getContext("2d");
  new Chart(severityCtx, {
    type: "doughnut",
    data: {
      labels: ["Low Risk", "Medium Risk", "High Risk"],
      datasets: [
        {
          data: [12, 8, 5],
          backgroundColor: ["#10B981", "#F59E0B", "#EF4444"],
          borderWidth: 0,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: "bottom" },
      },
    },
  });

  // Hazard Chart
  const hazardCtx = document.getElementById("hazardChart").getContext("2d");
  new Chart(hazardCtx, {
    type: "bar",
    data: {
      labels: [
        "Exposed Wires",
        "Blocking Sidewalk",
        "Near School",
        "Near Hospital",
        "Other",
      ],
      datasets: [
        {
          label: "Reports",
          data: [8, 5, 3, 2, 4],
          backgroundColor: "#3B82F6",
          borderRadius: 4,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 2 },
        },
      },
      plugins: { legend: { display: false } },
    },
  });
}

// Setup condition buttons
function setupConditionButtons() {
  const buttons = document.querySelectorAll(".condition-btn");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      buttons.forEach((btn) =>
        btn.classList.remove("border-blue-500", "bg-blue-50")
      );
      this.classList.add("border-blue-500", "bg-blue-50");
    });
  });
}

// Setup severity buttons
function setupSeverityButtons() {
  const buttons = document.querySelectorAll(".severity-btn");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      buttons.forEach((btn) => {
        btn.classList.remove("ring-2", "ring-offset-2", "ring-blue-500");
      });
      this.classList.add("ring-2", "ring-offset-2", "ring-blue-500");
    });
  });
}
