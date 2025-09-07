 const video = document.getElementById("bg-video");
  video.addEventListener("loadedmetadata", () => {
    video.currentTime = 8; // ⏩ Start at 8 seconds
  });