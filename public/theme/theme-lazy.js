document.addEventListener("DOMContentLoaded", function () {
  const transparentPixel =
    "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";

  const images = Array.from(document.querySelectorAll("img[src]"));
  images.forEach((img) => {
    const src = img.getAttribute("src");
    if (!src || src.startsWith("data:")) return;

    if (!img.hasAttribute("loading")) {
      img.setAttribute("loading", "lazy");
    }
    img.setAttribute("decoding", "async");

    if (
      img.closest(".banner-swiper-two") ||
      img.closest("header") ||
      img.classList.contains("logo")
    ) {
      return;
    }

    img.setAttribute("data-src", src);
    img.setAttribute("src", transparentPixel);
    img.classList.add("is-lazy");
  });

  const lazyImages = Array.from(document.querySelectorAll("img.is-lazy"));
  if (!("IntersectionObserver" in window)) {
    lazyImages.forEach((img) => {
      const original = img.getAttribute("data-src");
      if (original) img.src = original;
      img.classList.remove("is-lazy");
    });
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const img = entry.target;
        const original = img.getAttribute("data-src");
        if (original) img.src = original;
        img.classList.remove("is-lazy");
        observer.unobserve(img);
      });
    },
    { rootMargin: "200px 0px 200px 0px", threshold: 0.01 }
  );

  lazyImages.forEach((img) => observer.observe(img));
});

document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("site-search-input");
  const list = document.getElementById("site-search-suggestions");
  const dataTag = document.getElementById("site-search-data");
  if (!input || !list || !dataTag) return;

  let items = [];
  try {
    items = JSON.parse(dataTag.textContent || "[]");
  } catch (_e) {
    items = [];
  }

  const norm = (v) =>
    (v || "")
      .toString()
      .toLowerCase()
      .replace(/\s+/g, " ")
      .trim();
  const escapeHtml = (v) =>
    (v || "")
      .toString()
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  const escapeRegex = (v) => v.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
  const typeOrder = (type) => (type === "service" ? 0 : 1);
  const highlight = (text, q) => {
    if (!q) return escapeHtml(text);
    const tokens = norm(q).split(" ").filter(Boolean).slice(0, 5);
    if (!tokens.length) return escapeHtml(text);
    const rx = new RegExp("(" + tokens.map(escapeRegex).join("|") + ")", "ig");
    return escapeHtml(text).replace(rx, "<mark>$1</mark>");
  };
  const scoreItem = (item, q) => {
    const nq = norm(q);
    if (!nq) return 0;
    const title = norm(item.title);
    const summary = norm(item.summary);
    if (title === nq) return 1000;
    if (title.startsWith(nq)) return 700;
    if (title.includes(nq)) return 550;
    const qTokens = nq.split(" ").filter(Boolean);
    let tokenHits = 0;
    qTokens.forEach((t) => {
      if (title.includes(t) || summary.includes(t)) tokenHits += 1;
    });
    if (tokenHits) return 280 + tokenHits * 40;
    return 0;
  };

  let activeIndex = -1;
  let latestResults = [];
  const closeList = () => {
    list.classList.remove("is-open");
    list.innerHTML = "";
    activeIndex = -1;
    latestResults = [];
  };
  const render = (results, q) => {
    latestResults = results;
    if (!results.length) {
      list.innerHTML = '<div class="hildes-search-empty">No matching results</div>';
      list.classList.add("is-open");
      activeIndex = -1;
      return;
    }
    list.innerHTML = results
      .map((item, idx) => {
        const summary = (item.summary || "").slice(0, 90);
        return (
          '<a href="' +
          escapeHtml(item.url) +
          '" class="hildes-search-item" role="option" data-idx="' +
          idx +
          '">' +
          '<div class="hildes-search-item-top">' +
          '<span class="hildes-search-item-title">' +
          highlight(item.title, q) +
          "</span>" +
          '<span class="hildes-search-item-type" data-type="' +
          escapeHtml(item.type) +
          '">' +
          escapeHtml(item.type) +
          "</span>" +
          "</div>" +
          (summary
            ? '<div class="hildes-search-item-summary">' + highlight(summary, q) + "</div>"
            : "") +
          "</a>"
        );
      })
      .join("");
    list.classList.add("is-open");
    activeIndex = -1;
  };
  const runSearch = (q) => {
    const nq = norm(q);
    if (q.includes("#")) {
      const allItems = items
        .slice()
        .sort((a, b) => {
          const tDiff = typeOrder(a.type) - typeOrder(b.type);
          if (tDiff !== 0) return tDiff;
          if (a.type === b.type) {
            return norm(a.title).localeCompare(norm(b.title));
          }
          return 0;
        });
      render(allItems, "");
      return;
    }
    if (nq.length < 2) {
      closeList();
      return;
    }
    const ranked = items
      .map((item) => ({ item, score: scoreItem(item, nq) }))
      .filter((x) => x.score > 0)
      .sort((a, b) => {
        if (b.score !== a.score) return b.score - a.score;
        const tDiff = typeOrder(a.item.type) - typeOrder(b.item.type);
        if (tDiff !== 0) return tDiff;
        return norm(a.item.title).localeCompare(norm(b.item.title));
      })
      .slice(0, 8)
      .map((x) => x.item);
    render(ranked, nq);
  };

  let timer = null;
  input.addEventListener("input", function () {
    const q = input.value;
    clearTimeout(timer);
    timer = window.setTimeout(function () {
      runSearch(q);
    }, 80);
  });

  input.addEventListener("keydown", function (e) {
    if (!latestResults.length || !list.classList.contains("is-open")) return;
    const links = Array.from(list.querySelectorAll(".hildes-search-item"));
    if (!links.length) return;
    if (e.key === "ArrowDown") {
      e.preventDefault();
      activeIndex = (activeIndex + 1) % links.length;
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      activeIndex = (activeIndex - 1 + links.length) % links.length;
    } else if (e.key === "Enter") {
      if (activeIndex >= 0 && links[activeIndex]) {
        e.preventDefault();
        window.location.href = links[activeIndex].getAttribute("href");
      }
      return;
    } else if (e.key === "Escape") {
      closeList();
      return;
    } else {
      return;
    }
    links.forEach((l) => l.classList.remove("is-active"));
    if (links[activeIndex]) links[activeIndex].classList.add("is-active");
  });

  list.addEventListener("mousemove", function (e) {
    const el = e.target.closest(".hildes-search-item");
    if (!el) return;
    const idx = Number(el.getAttribute("data-idx"));
    if (Number.isNaN(idx)) return;
    activeIndex = idx;
    list.querySelectorAll(".hildes-search-item").forEach((x) => x.classList.remove("is-active"));
    el.classList.add("is-active");
  });

  document.addEventListener("click", function (e) {
    if (!e.target.closest(".search-input-inner")) {
      closeList();
    }
  });
});

