// popoverGroup.js
export default function popoverGroup(e) {
    return {
        __type: "popoverGroup", // Identifies the component type as "popoverGroup"

        // Initialize the popover group component
        init() {
            // Event handler to detect focus events outside the popover group
            const handleFocusOutside = (event) => {
                // Check if the popover group is still part of the DOM
                if (document.body.contains(this.$el)) {
                    // If the focus event occurred outside this popover group, dispatch a close event
                    if (event.target instanceof Element && !this.$el.contains(event.target)) {
                        window.dispatchEvent(new CustomEvent("close-popover-group", { detail: this.$el }));
                    }
                } else {
                    // Remove the focus event listener if the popover group is no longer in the DOM
                    window.removeEventListener("focus", handleFocusOutside, true);
                }
            };

            // Attach the focus event listener to detect when focus moves outside the popover group
            window.addEventListener("focus", handleFocusOutside, true);
        }
    };
}
