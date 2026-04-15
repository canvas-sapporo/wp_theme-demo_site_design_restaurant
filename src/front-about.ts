import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/**
 * フロント「当店について」セクション: ビューポートに入ったら opacity 0 → 1。
 */
function initFrontAbout() {
  const section = document.querySelector<HTMLElement>(".js-front-about");
  if (!section) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    gsap.set(section, { opacity: 1 });
    return;
  }

  gsap.fromTo(
    section,
    { opacity: 0 },
    {
      opacity: 1,
      duration: 2,
      ease: "power2.inOut",
      scrollTrigger: {
        trigger: section,
        start: "top 88%",
        once: true,
      },
    },
  );
}

document.addEventListener("DOMContentLoaded", initFrontAbout);
