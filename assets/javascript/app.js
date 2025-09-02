      // Initialize AOS
      AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
      });

      // Initialize Feather Icons
      feather.replace();

      // Particle animation for hero section
      document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById("particles-container");
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
          const particle = document.createElement("div");
          particle.classList.add("particle");

          const size = Math.random() * 10 + 5;
          particle.style.width = `${size}px`;
          particle.style.height = `${size}px`;

          particle.style.left = `${Math.random() * 100}%`;
          particle.style.top = `${Math.random() * 100}%`;

          container.appendChild(particle);

          anime({
            targets: particle,
            translateX: () => anime.random(-100, 100),
            translateY: () => anime.random(-100, 100),
            duration: () => anime.random(5000, 15000),
            easing: "easeInOutQuad",
            loop: true,
            direction: "alternate",
          });
        }

        // Counter animation
        const counters = document.querySelectorAll(".counter");
        counters.forEach((counter) => {
          const target = parseInt(counter.getAttribute("data-count"));
          let count = 0;
          const duration = 2000;
          const increment = target / (duration / 16);

          const updateCount = () => {
            if (count < target) {
              count += increment;
              counter.innerText = Math.ceil(count);
              setTimeout(updateCount, 16);
            } else {
              counter.innerText = target;
            }
          };

          // Start counter when in viewport
          const observer = new IntersectionObserver(
            (entries) => {
              entries.forEach((entry) => {
                if (entry.isIntersecting) {
                  updateCount();
                  observer.unobserve(entry.target);
                }
              });
            },
            { threshold: 0.5 }
          );

          observer.observe(counter);
        });

        // Testimonial slider
        const testimonialSlider = document.querySelector(".testimonial-slides");
        const testimonialSlides =
          document.querySelectorAll(".testimonial-slide");
        const prevButton = document.querySelector(".testimonial-prev");
        const nextButton = document.querySelector(".testimonial-next");
        let currentSlide = 0;

        function showSlide(index) {
          testimonialSlider.style.transform = `translateX(-${index * 100}%)`;
        }

        prevButton.addEventListener("click", () => {
          currentSlide =
            currentSlide > 0 ? currentSlide - 1 : testimonialSlides.length - 1;
          showSlide(currentSlide);
        });

        nextButton.addEventListener("click", () => {
          currentSlide =
            currentSlide < testimonialSlides.length - 1 ? currentSlide + 1 : 0;
          showSlide(currentSlide);
        });

        // Auto slide testimonials
        setInterval(() => {
          currentSlide =
            currentSlide < testimonialSlides.length - 1 ? currentSlide + 1 : 0;
          showSlide(currentSlide);
        }, 5000);

        // Navbar scroll effect
        const navbar = document.querySelector("nav");
        window.addEventListener("scroll", () => {
          if (window.scrollY > 50) {
            navbar.classList.add("py-2", "bg-opacity-90", "backdrop-blur-sm");
          } else {
            navbar.classList.remove(
              "py-2",
              "bg-opacity-90",
              "backdrop-blur-sm"
            );
          }
        });

        // Form validation
        const form = document.querySelector("form");
        form.addEventListener("submit", (e) => {
          e.preventDefault();
          // Simple validation
          let isValid = true;
          const inputs = form.querySelectorAll(
            "input[required], select[required]"
          );

          inputs.forEach((input) => {
            if (!input.value) {
              input.classList.add("border-red-500");
              isValid = false;
            } else {
              input.classList.remove("border-red-500");
            }
          });

          if (isValid) {
            // Form is valid, you would typically send data to a server here
            alert(
              "Thank you for your booking request! We will contact you shortly."
            );
            form.reset();
          }
        });
      });
