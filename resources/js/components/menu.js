// menu.js
export default function menu(e) {
    return {
        // Initialize the menu component
        init() {
            // Select all menu items and store them in `items`
            this.items = Array.from(this.$el.querySelectorAll('[role="menuitem"]'));
            // Watch for changes to `open` to reset `activeIndex` when the menu opens
            this.$watch("open", () => {
                if (this.open) this.activeIndex = -1;
            });
        },

        // Properties to manage the menu state
        activeDescendant: null, // The ID of the currently active menu item
        activeIndex: null,      // Index of the currently highlighted menu item
        items: null,            // Array of menu item elements
        open: e.open,           // Controls whether the menu is open or closed

        // Focuses the button that opens the menu
        focusButton() {
            this.$refs.button.focus();
        },

        // Toggles the menu open on button click
        onButtonClick() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    this.$refs["menu-items"].focus();
                });
            }
        },

        // Opens the menu and focuses the first menu item on Enter key
        onButtonEnter() {
            this.open = !this.open;
            if (this.open) {
                this.activeIndex = 0;
                this.activeDescendant = this.items[this.activeIndex].id;
                this.$nextTick(() => {
                    this.$refs["menu-items"].focus();
                });
            }
        },

        // Navigates up through menu items, wrapping to the end if at the beginning
        onArrowUp() {
            if (!this.open) {
                this.open = true;
                this.activeIndex = this.items.length - 1;
                this.activeDescendant = this.items[this.activeIndex].id;
                return;
            }
            if (this.activeIndex !== 0) {
                this.activeIndex = this.activeIndex === -1 ? this.items.length - 1 : this.activeIndex - 1;
                this.activeDescendant = this.items[this.activeIndex].id;
            }
        },

        // Navigates down through menu items, wrapping to the start if at the end
        onArrowDown() {
            if (!this.open) {
                this.open = true;
                this.activeIndex = 0;
                this.activeDescendant = this.items[this.activeIndex].id;
                return;
            }
            if (this.activeIndex !== this.items.length - 1) {
                this.activeIndex += 1;
                this.activeDescendant = this.items[this.activeIndex].id;
            }
        },

        // Closes the menu when clicking outside, unless the target is focusable
        onClickAway(event) {
            if (this.open) {
                const focusableSelectors = [
                    "[contentEditable=true]",
                    "[tabindex]",
                    "a[href]",
                    "area[href]",
                    "button:not([disabled])",
                    "iframe",
                    "input:not([disabled])",
                    "select:not([disabled])",
                    "textarea:not([disabled])"
                ].map(selector => `${selector}:not([tabindex='-1'])`).join(",");

                this.open = false;
                if (!event.target.closest(focusableSelectors)) {
                    this.focusButton();
                }
            }
        }
    };
}
