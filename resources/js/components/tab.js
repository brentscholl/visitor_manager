// tab.js
export default function tab(defaultIndex = 0) {
    return {
        selected: false, // Indicates if this tab is currently selected

        // Initialize the tab component
        init() {
            // Get all tab elements within the same tabs container
            const tabs = Array.from(this.$el.closest('[x-data^="Components.tabs("]').querySelectorAll('[x-data^="Components.tab("]'));

            // Set `selected` to true if this tab's index matches the default index
            this.selected = tabs.indexOf(this.$el) === defaultIndex;

            // Watch for changes to `selected` to focus the tab when it becomes selected
            this.$watch("selected", (isSelected) => {
                if (isSelected) {
                    this.$el.focus();
                }
            });
        },

        // Handle click events to select the tab
        onClick() {
            // Dispatch a custom "tab-click" event to indicate this tab was clicked
            window.dispatchEvent(new CustomEvent("tab-click", { detail: this.$el }));
        },

        // Handle keyboard navigation for tabs
        onKeydown(event) {
            const navigationKeys = ["ArrowLeft", "ArrowRight", "Home", "PageUp", "End", "PageDown"];
            // Prevent default behavior for navigation keys to handle manually
            if (navigationKeys.includes(event.key)) {
                event.preventDefault();
            }
            // Dispatch a custom "tab-keydown" event with the tab element and key pressed
            window.dispatchEvent(new CustomEvent("tab-keydown", {
                detail: {
                    tab: this.$el,
                    key: event.key
                }
            }));
        },

        // Handle custom "tab-select" events to update `selected` state
        onTabSelect(event) {
            // Set `selected` to true if this tab matches the selected tab in the event detail
            this.selected = event.detail.tab === this.$el;
        }
    };
}
