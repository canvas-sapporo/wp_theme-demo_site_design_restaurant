import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/**
 * ブログ一覧: カードを DOM 順（グリッドでは左上→右、次行へ）で opacity 0 → 1。
 */
function initBlogGrid() {
  const section = document.querySelector<HTMLElement>(".js-blog-grid-section");
  if (!section) {
    return;
  }

  const items = section.querySelectorAll<HTMLElement>(".js-blog-grid-item");
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
      duration: 1,
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

document.addEventListener("DOMContentLoaded", initBlogGrid);
