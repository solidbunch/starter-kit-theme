/**
 * Theme Antispam - Vanilla JS Version
 */
window.themeAntispam = {
  /**
   * Constructor
   */
  initialize(){
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setupFormsAntispam());
    } else {
      this.setupFormsAntispam();
    }
  },

  /**
   * Setup Antispam Field
   */
  setupFormsAntispam(){
    // Select all forms on the page
    const forms = document.querySelectorAll('form');

    forms.forEach((form) => {
      // Check if method is POST (case-insensitive)
      if (form.method && form.method.toUpperCase() === 'POST') {
        try {
          const d = new Date();
          const code = /*(d.getUTCHours() + 1) * */ d.getUTCDate() * (d.getUTCMonth() + 1) * d.getUTCFullYear();
          const name = 'a' + 's' + String.fromCharCode(95) + 'co' + 'de';

          const insert = () => {
            // Check if input already exists
            if (!form.querySelector(`input[name="${name}"]`)) {
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = name;
              input.value = code;
              form.appendChild(input);
            }
          };

          // Use 'once: true' so the listener removes itself after the first interaction
          form.addEventListener('mousedown', insert, {once: true});
          form.addEventListener('keydown', insert, {once: true});

        } catch (e) {
          // eslint-disable-next-line no-console
          console.warn('Antispam error:', e);
        }
      }
    });
  },
};

// Initialize
window.themeAntispam.initialize();
