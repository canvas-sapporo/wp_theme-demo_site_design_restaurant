import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/**
 * メニューアーカイブ: カテゴリーごとのグリッドで、DOM 順（行ごと左→右）に opacity 0 → 1。
 * リストレイアウトのセクションには .js-menu-grid-item が無いため対象外。
 */
function initMenuArchiveGrid() {
  const sections = document.querySelectorAll<HTMLElement>(
    ".js-menu-archive-section",
  );
  if (sections.length === 0) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    sections.forEach((section) => {
      const items = section.querySelectorAll<HTMLElement>(".js-menu-grid-item");
      if (items.length > 0) {
        gsap.set(items, { opacity: 1 });
      }
    });
    return;
  }

  sections.forEach((section) => {
    const items = section.querySelectorAll<HTMLElement>(".js-menu-grid-item");
    if (items.length === 0) {
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
  });
}

document.addEventListener("DOMContentLoaded", initMenuArchiveGrid);
