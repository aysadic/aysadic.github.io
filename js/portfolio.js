(() => {
  const toggle = document.querySelector(".menu-toggle");
  const navigation = document.querySelector("#navigation");
  const mobile = window.matchMedia("(max-width: 800px)");
  const setMenu = (open) => {
    toggle.setAttribute("aria-expanded", String(open));
    navigation.hidden = mobile.matches && !open;
  };
  toggle.hidden = false;
  setMenu(false);
  mobile.addEventListener("change", () => setMenu(false));
  toggle.addEventListener("click", () =>
    setMenu(toggle.getAttribute("aria-expanded") !== "true"),
  );
  navigation.addEventListener("click", (event) => {
    if (event.target.closest("a")) setMenu(false);
  });
  document.addEventListener("keydown", (event) => {
    if (
      event.key === "Escape" &&
      mobile.matches &&
      toggle.getAttribute("aria-expanded") === "true"
    ) {
      setMenu(false);
      toggle.focus();
    }
  });
  if ("IntersectionObserver" in window) {
    const links = [...navigation.querySelectorAll('a[href^="#"]')];
    const observer = new IntersectionObserver(
      (entries) => {
        const visible = entries.filter((entry) => entry.isIntersecting);
        if (!visible.length) return;
        const id = visible[0].target.id;
        links.forEach((link) => {
          if (link.hash === "#" + id)
            link.setAttribute("aria-current", "location");
          else link.removeAttribute("aria-current");
        });
      },
      { rootMargin: "-15% 0px -60% 0px" },
    );
    document
      .querySelectorAll("main section[id]")
      .forEach((section) => observer.observe(section));
  }
  document.querySelector("#year").textContent = new Date().getFullYear();
})();
