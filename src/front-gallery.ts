import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/**
 * フロント「ギャラリー」: 画像のみ、DOM 順（グリッドでは左上→右上、次行左下→右下）で opacity 0 → 1。
 */
function initFrontGallery() {
  const section = document.querySelector<HTMLElement>(".js-front-gallery");
  if (!section) {
    return;
  }

  const items = section.querySelectorAll<HTMLElement>(".js-front-gallery-item");
  if (items.length === 0) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    gsap.set(items, { opacity: 1 });
    return;
  }

  gsap.fromTo(
    items,
    { opacity: 0 },
    {
      opacity: 1,
      duration: 2,
      ease: "power2.inOut",
      stagger: 0.25,
      scrollTrigger: {
        trigger: section,
        start: "top 88%",
        once: true,
      },
    },
  );
}

document.addEventListener("DOMContentLoaded", initFrontGallery);
