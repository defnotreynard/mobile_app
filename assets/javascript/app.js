// ========================
// PoleWatch App JS
// ========================

document.addEventListener("DOMContentLoaded", initApp);

// Screen DOM elements
const homeScreen = document.getElementById("homeScreen");
const reportsScreen = document.getElementById("reportsScreen");
const reportDetailsScreen = document.getElementById("reportDetailsScreen");
const infoScreen = document.getElementById("infoScreen");
const accountScreen = document.getElementById("accountScreen");

// Nav buttons
const homeNav = document.getElementById("homeNav");
const reportsNav = document.getElementById("reportsNav");
const infoNav = document.getElementById("infoNav");
const accountNav = document.getElementById("accountNav");

// Other DOM elements
const newReportBtn = document.getElementById("newReportBtn");
const backToReportsBtn = document.getElementById("backToReportsBtn");
const reportForm = document.getElementById("reportForm");
const captureBtn = document.getElementById("captureBtn");
const photoUpload = document.getElementById("photoUpload");
const previewImage = document.getElementById("previewImage");

// Account states
const guestAccount = document.getElementById("guestAccount");
const userAccount = document.getElementById("userAccount");

// ========================
// INIT
// ========================
function initApp() {
  // Navigation
  homeNav.addEventListener("click", showHomeScreen);
  reportsNav.addEventListener("click", showReportsScreen);
  infoNav.addEventListener("click", showInfoScreen);
  accountNav.addEventListener("click", showAccountScreen);

  // Other actions
  if (newReportBtn) newReportBtn.addEventListener("click", showHomeScreen);
  if (backToReportsBtn) backToReportsBtn.addEventListener("click", showReportsScreen);
  if (reportForm) reportForm.addEventListener("submit", handleReportSubmit);
  if (captureBtn) captureBtn.addEventListener("click", () => photoUpload.click());
  if (photoUpload) photoUpload.addEventListener("change", handlePhotoUpload);

  // Account login/logout toggle
  setupAccountButtons();

  // Try to get location
  getLocation();

  // Start on Home
  showHomeScreen();
}

// ========================
// SCREEN HANDLING
// ========================
function resetScreens() {
  homeScreen.classList.add("hidden");
  reportsScreen.classList.add("hidden");
  reportDetailsScreen.classList.add("hidden");
  infoScreen.classList.add("hidden");
  accountScreen.classList.add("hidden");

  // Reset nav colors
  [homeNav, reportsNav, infoNav, accountNav].forEach((nav) => {
    nav.querySelector("i").classList.add("text-gray-500");
    nav.querySelector("i").classList.remove("text-blue-600");
    nav.querySelector("span").classList.add("text-gray-500");
    nav.querySelector("span").classList.remove("text-blue-600");
  });
}

function showHomeScreen() {
  resetScreens();
  homeScreen.classList.remove("hidden");
  setActiveNav(homeNav);
}

function showReportsScreen() {
  resetScreens();
  reportsScreen.classList.remove("hidden");
  setActiveNav(reportsNav);
}

function showInfoScreen() {
  resetScreens();
  infoScreen.classList.remove("hidden");
  setActiveNav(infoNav);
}

function showAccountScreen() {
  resetScreens();
  accountScreen.classList.remove("hidden");
  setActiveNav(accountNav);
}

function setActiveNav(nav) {
  nav.querySelector("i").classList.replace("text-gray-500", "text-blue-600");
  nav.querySelector("span").classList.replace("text-gray-500", "text-blue-600");
}

// ========================
// REPORT HANDLING
// ========================
function handleReportSubmit(e) {
  e.preventDefault();
  alert("Report submitted successfully!");
  showReportsScreen();
}

function handlePhotoUpload(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.src = e.target.result;
      previewImage.classList.remove("hidden");
    };
    reader.readAsDataURL(file);
  }
}

// ========================
// LOCATION HANDLING
// ========================
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        console.log("Latitude:", position.coords.latitude);
        console.log("Longitude:", position.coords.longitude);
      },
      (error) => {
        console.warn("Location error:", error.message);
      }
    );
  }
}

// ========================
// ACCOUNT HANDLING
// ========================
function setupAccountButtons() {
  // Guest → Sign In
  const signInBtn = guestAccount?.querySelector("button");
  if (signInBtn) {
    signInBtn.addEventListener("click", () => {
      guestAccount.classList.add("hidden");
      userAccount.classList.remove("hidden");
    });
  }

  // User → Sign Out
  const signOutBtn = userAccount?.querySelector("button");
  if (signOutBtn) {
    signOutBtn.addEventListener("click", () => {
      userAccount.classList.add("hidden");
      guestAccount.classList.remove("hidden");
    });
  }
}
