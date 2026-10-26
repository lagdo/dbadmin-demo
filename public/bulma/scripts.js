document.addEventListener('DOMContentLoaded', () => {
    // Dropdown button
    const active = { dropdown: null };
    document.addEventListener('click', (e) => {
        const button = e.target.closest('button');
        const trigger = button?.parentNode;
        if (trigger?.localName === 'div' && trigger?.matches('.dropdown-trigger')) {
            const dropdown = trigger.parentNode;
            if (dropdown?.localName === 'div' && dropdown?.matches('.dropdown')) {
                // Hide the previously displayed dropdown, if any.
                if (active.dropdown !== null && active.dropdown !== dropdown) {
                    active.dropdown.classList.remove('is-active');
                }

                dropdown.classList.toggle('is-active');
                // Save the current dropdown.
                active.dropdown = dropdown.matches('.is-active') ? dropdown : null;
                // It is important to exit the function here.
                return;
            }
        }

        // Hide the dropdown if the user clicks elsewhere.
        if (active.dropdown !== null) {
            active.dropdown.classList.remove('is-active');
            active.dropdown = null;
        }
    });

    // Tabs
    document.addEventListener('click', (e) => {
        const tabLink = e.target;
        if (tabLink.localName !== 'a' || !tabLink.matches('.tab-nav-item')) {
            return;
        }

        const activeNav = tabLink.parentNode;
        const tabNav = activeNav?.parentNode;
        if (!tabNav || !activeNav) {
            return;
        }

        Array.from(tabNav.children).forEach(function (navItem) {
            navItem.classList.remove('is-active');
        });
        activeNav.classList.add('is-active');

        const activeContentId = activeNav.getAttribute('data-target');
        const activeContent = !activeContentId ? null :
            document.getElementById(activeContentId);
        const tabContent = activeContent?.parentNode;
        if (!activeContent || !tabContent) {
            return;
        }

        Array.from(tabContent.children).forEach(function (tabItem) {
            tabItem.style.display =
                tabItem.getAttribute('id') === activeContentId ? 'block' : 'none';
        });
    });
});
