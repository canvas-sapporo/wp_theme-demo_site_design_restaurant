import gsap from "gsap";

/**
 * animation-website-youtube と同系のヒーロー演出（開閉 → グラデーションスライド → テキスト）。
 * front-page.php の .js-front-hero のみで動作。
 */
function initFrontHero() {
  const root = document.querySelector<HTMLElement>(".js-front-hero");
  if (!root) {
    return;
  }

  const heroReveal = root.querySelector<HTMLElement>(".js-hero-reveal");
  const slider = root.querySelector<HTMLElement>(".js-hero-slider");
  const content = root.querySelector<HTMLElement>(".js-hero-content");
  if (!heroReveal || !slider || !content) {
    return;
  }

  const items = content.querySelectorAll<HTMLElement>(":scope > *");

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    gsap.set(heroReveal, { height: "80%", width: "80%" });
    gsap.set(slider, { yPercent: 0 });
    gsap.set(items, { opacity: 1, x: 0 });
    return;
  }

  gsap.set(slider, { yPercent: -100 });

  const tl = gsap.timeline({ defaults: { ease: "power2.inOut" } });
  tl.fromTo(heroReveal, { height: "0%" }, { height: "80%", duration: 1 })
    .fromTo(heroReveal, { width: "100%" }, { width: "80%", duration: 1.2 })
    .fromTo(
      slider,
      { yPercent: -100 },
      { yPercent: 0, duration: 1.2 },
      "-=1.2",
    )
    .fromTo(
      items,
      { opacity: 0, x: 0 },
      { opacity: 1, x: 30, duration: 0.5, stagger: 0.12 },
      "-=0.5",
    );
}

window.addEventListener("load", () => {
  // ページローダー（main.ts）と同タイミングの load をずらし、ヒーローがローダー下で動き始めるのを防ぐ
  window.setTimeout(() => {
    requestAnimationFrame(() => initFrontHero());
  }, 200);
});
