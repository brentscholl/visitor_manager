// popover.js
export default function popover({ open: initialOpen = false, focus: shouldFocus = false } = {}) {
    // Selectors for focusable elements within the popover
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

    return {
        __type: "popover",        // Type identifier for the component
        open: initialOpen,        // Initial state for whether the popover is open
        restoreEl: null,          // Element to restore focus to when popover closes

        // Initializes the popover component
        init() {
            // Watch for `open` changes to manage focus when popover opens
            if (shouldFocus) {
                this.$watch("open", (isOpen) => {
                    if (isOpen) {
                        this.$nextTick(() => {
                            // Focus on the first focusable element within the panel
                            focusFirstElement(this.$refs.panel);
                        });
                    }
                });
            }

            // Event handler for focus events outside the popover
            const handleFocusOutside = (event) => {
                // Stop listening if the popover element is removed from the DOM
                if (!document.body.contains(this.$el)) {
                    return window.removeEventListener("focus", handleFocusOutside, true);
                }

                const container = shouldFocus ? this.$refs.panel : this.$el;
                if (this.open && event.target instanceof Element && !container.contains(event.target)) {
                    let element = this.$el;
                    // Check if there is a containing popover or popover group that should stay open
                    while (element.parentNode) {
                        element = element.parentNode;
                        if (element.__x instanceof this.constructor) {
                            if (element.__x.$data.__type === "popoverGroup") return;
                            if (element.__x.$data.__type === "popover") break;
                        }
                    }
                    // Close the popover if no containing popover or group found
                    this.open = false;
                }
            };
            window.addEventListener("focus", handleFocusOutside, true);
        },

        // Handles the Escape key to close the popover and restore focus
        onEscape() {
            this.open = false;
            if (this.restoreEl) {
                this.restoreEl.focus();
            }
        },

        // Closes the popover if the popover group emits a close event
        onClosePopoverGroup(event) {
            if (event.detail.contains(this.$el)) {
                this.open = false;
            }
        },

        // Toggles the popover open or closed, saving the trigger element for focus restoration
        toggle(event) {
            this.open = !this.open;
            if (this.open) {
                this.restoreEl = event.currentTarget;
            } else if (this.restoreEl) {
                this.restoreEl.focus();
            }
        }
    };

    // Utility function to focus the first focusable element within a container
    function focusFirstElement(container) {
        const focusableElements = Array.from(container.querySelectorAll(focusableSelectors));

        function tryFocus(element) {
            if (element !== undefined) {
                element.focus({ preventScroll: true });
                if (document.activeElement !== element) {
                    tryFocus(focusableElements[focusableElements.indexOf(element) + 1]);
                }
            }
        }

        tryFocus(focusableElements[0]);
    }
}
