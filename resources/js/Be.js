//
const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId);

    // Validate that all variables exist
    if (toggle && nav && bodypd && headerpd) {
        toggle.addEventListener("click", () => {
            // show navbar
            nav.classList.toggle("Expander");
            // change icon
            // add padding to body
            bodypd.classList.toggle("body-pd");
            // add padding to header
            headerpd.classList.toggle("body-pd");
        });
    }
};

showNavbar("sideToggle", "sidebar", "body-pd", "Header");

// SideBarLink
const currentLocation = location.href;
const menuItem = document.querySelectorAll(".navList");
const menuLenght = menuItem.length;
for (let i = 0; i < menuLenght; i++) {
    if (menuItem[i].href === currentLocation) {
        menuItem[i].className = "navActive";
    }
}
