const typedLine = document.querySelector("#typed-line");
const year = document.querySelector("#year");
const navLinks = [...document.querySelectorAll(".site-nav a")];
const statValues = [...document.querySelectorAll(".about__facts span")];
const sections = navLinks
  .map((link) => document.querySelector(link.getAttribute("href")))
  .filter(Boolean);

let messageIndex = 0;
let charIndex = 0;
let deleting = false;

function typeNextFrame() {
  if (!typedLine) return;

  const messages =
    Array.isArray(window.PORTFOLIO_TYPING_MESSAGES) && window.PORTFOLIO_TYPING_MESSAGES.length
      ? window.PORTFOLIO_TYPING_MESSAGES
      : ["shipping thoughtful web experiences"];
  const current = messages[messageIndex % messages.length];
  typedLine.textContent = current.slice(0, charIndex);

  if (!deleting && charIndex < current.length) {
    charIndex += 1;
    window.setTimeout(typeNextFrame, 58);
    return;
  }

  if (!deleting && charIndex === current.length) {
    deleting = true;
    window.setTimeout(typeNextFrame, 1300);
    return;
  }

  if (deleting && charIndex > 0) {
    charIndex -= 1;
    window.setTimeout(typeNextFrame, 30);
    return;
  }

  deleting = false;
  messageIndex = (messageIndex + 1) % messages.length;
  window.setTimeout(typeNextFrame, 250);
}

function setupReveal() {
  if (!("IntersectionObserver" in window)) {
    document.querySelectorAll("[data-reveal]").forEach((element) => {
      element.classList.add("is-visible");
    });
    return;
  }

  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.14 },
  );

  document.querySelectorAll("[data-reveal]").forEach((element) => {
    revealObserver.observe(element);
  });
}

function setupActiveNavigation() {
  if (!("IntersectionObserver" in window)) return;

  const navObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        navLinks.forEach((link) => {
          link.classList.toggle("is-active", link.getAttribute("href") === `#${entry.target.id}`);
        });
      });
    },
    { rootMargin: "-40% 0px -55% 0px" },
  );

  sections.forEach((section) => navObserver.observe(section));
}

function setupStatCounters() {
  if (!statValues.length) return;

  const counters = statValues
    .map((element) => {
      const rawValue = element.textContent.trim();
      const numberMatch = rawValue.match(/-?[\d,]+(?:\.\d+)?/);

      if (!numberMatch) return null;

      const numberText = numberMatch[0];
      const target = Number(numberText.replaceAll(",", ""));

      if (!Number.isFinite(target)) return null;

      return {
        element,
        target,
        finalText: rawValue,
        prefix: rawValue.slice(0, numberMatch.index),
        suffix: rawValue.slice((numberMatch.index ?? 0) + numberText.length),
        decimals: numberText.includes(".") ? numberText.split(".")[1].length : 0,
      };
    })
    .filter(Boolean);

  if (!counters.length) return;

  const animateCounter = (counter) => {
    const duration = 1200;
    const startedAt = performance.now();

    const draw = (now) => {
      const progress = Math.min((now - startedAt) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const value = counter.target * eased;
      const formatted = value.toLocaleString(undefined, {
        maximumFractionDigits: counter.decimals,
        minimumFractionDigits: counter.decimals,
      });

      counter.element.textContent = `${counter.prefix}${formatted}${counter.suffix}`;

      if (progress < 1) {
        window.requestAnimationFrame(draw);
        return;
      }

      counter.element.textContent = counter.finalText;
    };

    window.requestAnimationFrame(draw);
  };

  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  if (prefersReducedMotion || !("IntersectionObserver" in window)) {
    counters.forEach((counter) => {
      counter.element.textContent = counter.finalText;
    });
    return;
  }

  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        const counter = counters.find((item) => item.element === entry.target);

        if (counter) {
          animateCounter(counter);
        }

        counterObserver.unobserve(entry.target);
      });
    },
    { threshold: 0.55 },
  );

  counters.forEach((counter) => {
    counter.element.textContent = `${counter.prefix}0${counter.suffix}`;
    counterObserver.observe(counter.element);
  });
}

if (year) {
  year.textContent = new Date().getFullYear();
}

if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
  typeNextFrame();
}

setupReveal();
setupActiveNavigation();
setupStatCounters();
