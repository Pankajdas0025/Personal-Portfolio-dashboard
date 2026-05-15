/**
 * Portfolio Pro - Main JavaScript
 */

$(document).ready(function () {

  /* ---- Page Loader ---- */
  $(window).on('load', function () {
    setTimeout(function () {
      $('#page-loader').addClass('hidden');
    }, 600);
  });

  /* ---- AOS Init ---- */
  AOS.init({
    duration: 700,
    once: true,
    offset: 60,
    easing: 'ease-out-cubic'
  });

  /* ---- Dark/Light Theme Toggle ---- */
  const savedTheme = localStorage.getItem('theme') || 'dark';
  $('html').attr('data-theme', savedTheme);
  updateThemeIcon(savedTheme);

  $('#themeToggle').on('click', function () {
    const current = $('html').attr('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    $('html').attr('data-theme', next);
    localStorage.setItem('theme', next);
    updateThemeIcon(next);
  });

  function updateThemeIcon(theme) {
    if (theme === 'dark') {
      $('#themeToggle').html('<i class="fas fa-sun"></i>');
    } else {
      $('#themeToggle').html('<i class="fas fa-moon"></i>');
    }
  }

  /* ---- Navbar Scroll ---- */
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 80) {
      $('#mainNav').addClass('scrolled');
      $('#scrollTop').addClass('visible');
    } else {
      $('#mainNav').removeClass('scrolled');
      $('#scrollTop').removeClass('visible');
    }
  });

  /* ---- Scroll to Top ---- */
  $('#scrollTop').on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 500);
  });

  /* ---- Typed.js ---- */
  if ($('#heroTyped').length) {
    new Typed('#heroTyped', {
      strings: [
        'Full Stack Developer',
        'PHP Expert',
        'Freelancer',
        'Problem Solver',
        'Founder of CampusXchange',
        'Open Source Contributor'
      ],
      typeSpeed: 60,
      backSpeed: 40,
      backDelay: 2000,
      loop: true,
      showCursor: true,
      cursorChar: '.'
    });
  }

  /* ---- Skill Bars Animation ---- */
  function animateSkills() {
    $('.skill-fill').each(function () {
      const pct = $(this).data('pct');
      $(this).css('width', pct + '%');
    });
  }

  // Trigger when skills section visible
  const $skillsSection = $('.skills-section');
  let skillsAnimated = false;

  if ($skillsSection.length) {
    $(window).on('scroll', function () {
      if (!skillsAnimated) {
        const top = $skillsSection.offset().top;
        const viewBottom = $(window).scrollTop() + $(window).height();
        if (viewBottom > top + 100) {
          animateSkills();
          skillsAnimated = true;
        }
      }
    });
    // Also trigger on load if already in view
    setTimeout(function () {
      const top = $skillsSection.offset().top;
      const viewBottom = $(window).scrollTop() + $(window).height();
      if (viewBottom > top + 100 && !skillsAnimated) {
        animateSkills();
        skillsAnimated = true;
      }
    }, 800);
  }

  /* ---- Skills Category Filter ---- */
  $('.category-tab').on('click', function () {
    const cat = $(this).data('cat');
    $('.category-tab').removeClass('active');
    $(this).addClass('active');

    if (cat === 'all') {
      $('.skill-card-wrap').show(200);
    } else {
      $('.skill-card-wrap').hide(100).filter('[data-cat="' + cat + '"]').show(200);
    }

    // Re-animate after filter
    setTimeout(animateSkills, 250);
  });

  /* ---- Project Filter ---- */
  $('.filter-btn').on('click', function () {
    const filter = $(this).data('filter');
    $('.filter-btn').removeClass('active');
    $(this).addClass('active');

    if (filter === 'all') {
      $('.project-item').show(300);
    } else {
      $('.project-item').hide(200).filter('[data-cat="' + filter + '"]').show(300);
    }
  });

  /* ---- Counter Animation ---- */
  function animateCounters() {
    $('.stat-num[data-target]').each(function () {
      const $el = $(this);
      const target = parseInt($el.data('target'));
      $({ val: 0 }).animate({ val: target }, {
        duration: 1500,
        easing: 'swing',
        step: function () { $el.text(Math.floor(this.val) + ($el.data('suffix') || '')); },
        complete: function () { $el.text(target + ($el.data('suffix') || '')); }
      });
    });
  }

  let countersDone = false;
  $(window).on('scroll', function () {
    if (!countersDone && $('.stat-num[data-target]').length) {
      const top = $('.hero-stats').offset().top;
      if ($(window).scrollTop() + $(window).height() > top) {
        animateCounters();
        countersDone = true;
      }
    }
  });
  // Trigger if page loads with stats visible
  setTimeout(function () {
    if (!countersDone && $('.stat-num[data-target]').length) {
      animateCounters();
      countersDone = true;
    }
  }, 800);

  /* ---- Contact Form AJAX ---- */
  $('#contactForm').on('submit', function (e) {
    e.preventDefault();
    const $btn = $(this).find('[type="submit"]');
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');

    $.ajax({
      url: window.SITE_URL + '/contact.php',
      method: 'POST',
      data: $(this).serialize() + '&ajax=1',
      dataType: 'json',
      success: function (res) {
        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Send Message');
        if (res.success) {
          $('#formMsg').html('<div class="alert-success-custom"><i class="fas fa-check-circle me-2"></i>' + res.message + '</div>');
          $('#contactForm')[0].reset();
        } else {
          $('#formMsg').html('<div class="alert-error-custom"><i class="fas fa-exclamation-circle me-2"></i>' + res.message + '</div>');
        }
        setTimeout(function () { $('#formMsg').html(''); }, 5000);
      },
      error: function () {
        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Send Message');
        $('#formMsg').html('<div class="alert-error-custom">Something went wrong. Please try again.</div>');
      }
    });
  });

  /* ---- Smooth anchor links ---- */
  $('a[href^="#"]').on('click', function (e) {
    const target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: target.offset().top - 80 }, 500);
    }
  });

  /* ---- Lazy loading images ---- */
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const img = entry.target;
          if (img.dataset.src) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
          }
          observer.unobserve(img);
        }
      });
    });
    document.querySelectorAll('img[data-src]').forEach(function (img) {
      observer.observe(img);
    });
  }

});
