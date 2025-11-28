(function () {
  /* ========= Preloader ======== */
  const preloader = document.querySelectorAll('#preloader')

  window.addEventListener('load', function () {
    if (preloader.length) {
      this.document.getElementById('preloader').style.display = 'none'
    }
  })

  /* ========= Add Box Shadow in Header on Scroll ======== */
  window.addEventListener('scroll', function () {
    const header = document.querySelector('.header')
    if (window.scrollY > 0) {
      header.style.boxShadow = '0px 0px 30px 0px rgba(200, 208, 216, 0.30)'
    } else {
      header.style.boxShadow = 'none'
    }
  })

  /* ========= sidebar toggle ======== */
  const sidebarNavWrapper = document.querySelector(".sidebar-nav-wrapper");
  const mainWrapper = document.querySelector(".main-wrapper");
  const menuToggleButton = document.querySelector("#menu-toggle");
  const menuToggleButtonIcon = document.querySelector("#menu-toggle i");
  const overlay = document.querySelector(".overlay");

  menuToggleButton.addEventListener("click", () => {
    sidebarNavWrapper.classList.toggle("active");
    overlay.classList.add("active");
    mainWrapper.classList.toggle("active");

    if (document.body.clientWidth > 1200) {
      if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
        menuToggleButtonIcon.classList.remove("lni-chevron-left");
        menuToggleButtonIcon.classList.add("lni-menu");
      } else {
        menuToggleButtonIcon.classList.remove("lni-menu");
        menuToggleButtonIcon.classList.add("lni-chevron-left");
      }
    } else {
      if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
        menuToggleButtonIcon.classList.remove("lni-chevron-left");
        menuToggleButtonIcon.classList.add("lni-menu");
      }
    }
  });
  overlay.addEventListener("click", () => {
    sidebarNavWrapper.classList.remove("active");
    overlay.classList.remove("active");
    mainWrapper.classList.remove("active");
  });

  /* ========= Dark Mode Toggle ======== */
  const themeToggleButton = document.querySelector('#theme-toggle');
  const htmlElement = document.documentElement;
  const body = document.body;
  const darkModeKey = 'akadeaAppDarkMode';

  // Check for saved theme preference or default to light mode
  const isDarkMode = localStorage.getItem(darkModeKey) === 'true';
  
  // Apply saved theme on page load
  if (isDarkMode) {
    body.classList.add('darkTheme');
    htmlElement.setAttribute('data-theme', 'dark');
  }

  // Toggle dark mode
  if (themeToggleButton) {
    themeToggleButton.addEventListener('click', () => {
      const isCurrentlyDark = body.classList.contains('darkTheme');
      
      if (isCurrentlyDark) {
        body.classList.remove('darkTheme');
        htmlElement.setAttribute('data-theme', 'light');
        localStorage.setItem(darkModeKey, 'false');
      } else {
        body.classList.add('darkTheme');
        htmlElement.setAttribute('data-theme', 'dark');
        localStorage.setItem(darkModeKey, 'true');
      }
    });
  }
})();
