    <footer>
      <p>© 2025 La Urciu – Toate drepturile rezervate.</p>
    </footer>
  </div>

  <a href="#top" class="to-top">⬆️ Mergi sus</a>

  <script>
    const selector = document.getElementById('theme-selector');
    const body = document.body;
    const savedTheme = localStorage.getItem('tema') || 'light';
    body.classList.remove('light', 'dark', 'camo');
    body.classList.add(savedTheme);
    if (selector) selector.value = savedTheme;

    if (selector) {
      selector.addEventListener('change', () => {
        body.classList.remove('light', 'dark', 'camo');
        body.classList.add(selector.value);
        localStorage.setItem('tema', selector.value);
      });
    }

    const btnTop = document.querySelector('.to-top');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) btnTop.classList.add('show');
      else btnTop.classList.remove('show');
    });
  </script>
</body>
</html>
