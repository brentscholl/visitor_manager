// tabs.js
export default function tabs(defaultIndex) {
    return {
        selectedIndex: defaultIndex || 0, // The index of the currently selected tab

        // Handle click events on a tab
        onTabClick(event) {
            // Ensure the event originated from within this tabs component
            if (!this.$el.contains(event.detail)) return;

            // Get all tabs and panels within this tabs component
            const tabs = Array.from(this.$el.querySelectorAll('[x-data^="Components.tab("]'));
            const panels = Array.from(this.$el.querySelectorAll('[x-data^="Components.tabPanel("]'));

            // Determine the index of the clicked tab
            const clickedTabIndex = tabs.indexOf(event.detail);

            // Update the selected index to the clicked tab's index
            this.selectedIndex = clickedTabIndex;

            // Dispatch a custom "tab-select" event to show the corresponding panel
            window.dispatchEvent(new CustomEvent("tab-select", {
                detail: {
                    tab: event.detail,
                    panel: panels[clickedTabIndex]
                }
            }));
        },

        // Handle keyboard navigation for tabs
        onTabKeydown(event) {
            // Ensure the event originated from a tab within this tabs component
            if (!this.$el.contains(event.detail.tab)) return;

            // Get all tabs within this tabs component
            const tabs = Array.from(this.$el.querySelectorAll('[x-data^="Components.tab("]'));
            const currentTabIndex = tabs.indexOf(event.detail.tab);

            // Handle navigation keys to move between tabs
            switch (event.detail.key) {
                case "ArrowLeft":
                    // Select the previous tab, wrapping around to the last tab if necessary
                    this.onTabClick({ detail: tabs[(currentTabIndex - 1 + tabs.length) % tabs.length] });
                    break;
                case "ArrowRight":
                    // Select the next tab, wrapping around to the first tab if necessary
                    this.onTabClick({ detail: tabs[(currentTabIndex + 1) % tabs.length] });
                    break;
                case "Home":
                case "PageUp":
                    // Select the first tab
                    this.onTabClick({ detail: tabs[0] });
                    break;
                case "End":
                case "PageDown":
                    // Select the last tab
                    this.onTabClick({ detail: tabs[tabs.length - 1] });
                    break;
            }
        }
    };
}
